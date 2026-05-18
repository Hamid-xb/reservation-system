<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = auth()->user()
            ->reservations()
            ->with('restaurant')
            ->get();

        return view('user.reservations.index', compact('reservations'));
    }

    public function destroy($id)
    {
        $reservation = auth()->user()
            ->reservations()
            ->findOrFail($id);

        $reservation->Status = 'cancelled';
        $reservation->save();

        return redirect()->route('user.reservations.index')
            ->with('success', 'Reservation cancelled successfully.');
    }
}
