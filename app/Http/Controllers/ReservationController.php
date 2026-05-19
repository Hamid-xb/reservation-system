<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function create(Restaurant $restaurant)
    {
        $openeningHours = $restaurant->openingHours()->get();
        $tables = $restaurant->tables()->get();

        return view('reservations', compact('restaurant', 'openeningHours', 'tables'));
    }

    public function store(Request $request, $restaurantId)
    {
        $validated = $request->validate([
            'name' => ['required_if:reservation_type,staff_created', 'nullable', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'time' => ['required'],
            'guests' => ['required', 'integer', 'min:1'],
            'phone' => ['required', 'numeric', 'digits:10'],
            'special_requests' => ['nullable', 'string', 'max:600'],
            'reservation_type' => ['nullable', 'in:staff_created,user_created'],
        ]);

        $restaurant = Restaurant::findOrFail($restaurantId);

        $isStaffCreated = ($validated['reservation_type'] ?? null) === 'staff_created';

        if ($isStaffCreated) {
            $this->checkAccess($request, $restaurant);
        }

        $start = Carbon::parse($validated['date'] . ' ' . $validated['time']);

        $reservation = new Reservation();
        $reservation->created_by_user_id = auth()->id();
        $reservation->name = $isStaffCreated
            ? $validated['name']
            : auth()->user()->name;
        $reservation->restaurant_id = $restaurant->id;
        $reservation->start_datetime = $start->format('Y-m-d H:i:s');
        $reservation->end_datetime = $start->copy()->addHours(2)->format('Y-m-d H:i:s');
        $reservation->number_of_people = $validated['guests'];
        $reservation->phone_number = $validated['phone'];
        $reservation->reservation_note = $validated['special_requests'] ?? null;
        $reservation->reservation_type = $validated['reservation_type'] ?? 'user_created';

        if ($isStaffCreated) {
            $reservation->status = 'confirmed';
        } elseif ($validated['guests'] >= 6) {
            $reservation->status = 'pending';
        } else {
            $reservation->status = 'confirmed';
        }

        $reservation->save();

        if ($isStaffCreated) {
            return redirect()
                ->route('restaurant.reservations.index', [
                    'restaurant' => $restaurant,
                    'date' => $start->toDateString(),
                ])
                ->with('success', 'Reservering toegevoegd.');
        }

        return redirect()
            ->route('home')
            ->with('success', 'Reservation made successfully!');
    }

    private function checkAccess(Request $request, Restaurant $restaurant): void
    {
        abort_unless(
            $request->user()->hasRestaurantRole($restaurant->id, [
                'restaurant_owner',
                'restaurant_manager',
                'restaurant_staff',
            ]),
            403
        );
    }
}
