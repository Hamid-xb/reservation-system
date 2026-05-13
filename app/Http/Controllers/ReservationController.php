<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use Carbon\Carbon;

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
        $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'guests' => 'required|integer|min:1',
            'phone' => 'required|numeric|digits:10',
            'special_requests' => 'nullable|string|max:600',
        ]);

        $start = Carbon::parse($request->date . ' ' . $request->time);

        $reservation = new \App\Models\Reservation();
        $reservation->created_by_user_id = auth()->id();
        $reservation->name = auth()->user()->name;
        $reservation->restaurant_id = $restaurantId;
        $reservation->start_datetime = $request->date . ' ' . $request->time;
        $reservation->end_datetime = $start->copy()->addHours(2)->format('Y-m-d H:i:s');
        $reservation->number_of_people = $request->guests;
        $reservation->phone_number = $request->phone;
        $reservation->reservation_note = $request->special_requests;
        $reservation->save();

        return redirect()->route('home')->with('success', 'Reservation made successfully!');
    }
}
