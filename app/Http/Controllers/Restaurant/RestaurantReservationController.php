<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RestaurantReservationController extends Controller
{
    public function index(Request $request, Restaurant $restaurant)
    {
        $this->checkAccess($request, $restaurant);

        $date = $request->input('date', today()->toDateString());

        $selectedDate = Carbon::parse($date)->toDateString();

        $reservations = $restaurant->reservations()
            ->whereDate('start_datetime', $selectedDate)
            ->orderBy('start_datetime')
            ->get();

        return view('restaurant.reservations.index', compact(
            'restaurant',
            'reservations',
            'selectedDate'
        ));
    }


    public function updateStatus(Request $request, Restaurant $restaurant, Reservation $reservation)
    {
        $this->checkAccess($request, $restaurant);
        $this->ensureReservationBelongsToRestaurant($restaurant, $reservation);

        $validated = $request->validate([
            'status' => ['required', 'in:pending,confirmed,completed,cancelled,no_show'],
        ]);

        $reservation->update($validated);

        return back()->with('success', 'Reserveringsstatus aangepast.');
    }

    public function destroy(Request $request, Restaurant $restaurant, Reservation $reservation)
    {
        $this->checkAccess($request, $restaurant);
        $this->ensureReservationBelongsToRestaurant($restaurant, $reservation);

        $reservation->delete();

        return back()->with('success', 'Reservering verwijderd.');
    }

    public function edit(Request $request, Restaurant $restaurant, Reservation $reservation)
    {
        $this->checkAccess($request, $restaurant);

        abort_unless($reservation->restaurant_id === $restaurant->id, 404);

        return view('restaurant.reservations.edit', compact('restaurant', 'reservation'));
    }

    public function update(Request $request, Restaurant $restaurant, Reservation $reservation)
    {
        $this->checkAccess($request, $restaurant);

        abort_unless($reservation->restaurant_id === $restaurant->id, 404);

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'time' => ['required'],
            'number_of_people' => ['required', 'integer', 'min:1'],
        ]);

        $start = Carbon::parse($validated['date'] . ' ' . $validated['time']);

        $reservation->update([
            'start_datetime' => $start->format('Y-m-d H:i:s'),
            'end_datetime' => $start->copy()->addHours(2)->format('Y-m-d H:i:s'),
            'number_of_people' => $validated['number_of_people'],
        ]);

        return redirect()
            ->route('restaurant.reservations.index', [
                'restaurant' => $restaurant,
                'date' => $start->toDateString(),
            ])
            ->with('success', 'Reservering aangepast.');
    }

    private function checkAccess(Request $request, Restaurant $restaurant): void
    {
        if (! $request->user()->hasRestaurantRole($restaurant->id, [
            'restaurant_owner',
            'restaurant_manager',
            'restaurant_staff',
        ])) {
            abort(403);
        }
    }

    private function ensureReservationBelongsToRestaurant(Restaurant $restaurant, Reservation $reservation): void
    {
        if ($reservation->restaurant_id !== $restaurant->id) {
            abort(404);
        }
    }

    public function confirm(Request $request, Restaurant $restaurant, Reservation $reservation)
    {
        $this->checkAccess($request, $restaurant);

        abort_unless($reservation->restaurant_id === $restaurant->id, 404);

        $reservation->update([
            'status' => 'confirmed',
        ]);

        return back()->with('success', 'Reservering bevestigd.');
    }
}
