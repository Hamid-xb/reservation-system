<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantDashboardController extends Controller
{
    public function index(Request $request, Restaurant $restaurant)
    {
        $hasAccess = $request->user()
            ->userRoles()
            ->where('restaurant_id', $restaurant->id)
            ->exists();

        if (! $hasAccess) {
            abort(403);
        }

        $totalReservations = $restaurant
            ->reservations()
            ->count();

        $todayReservations = $restaurant
            ->reservations()
            ->whereDate('start_datetime', today())
            ->count();

        $pendingReservations = $restaurant
            ->reservations()
            ->where('status', 'pending')
            ->count();

        $confirmedReservations = $restaurant
            ->reservations()
            ->where('status', 'confirmed')
            ->count();

        $recentReservations = $restaurant
            ->reservations()
            ->latest('start_datetime')
            ->take(5)
            ->get();

        return view('restaurant.dashboard', [
            'restaurant' => $restaurant,
            'totalReservations' => $totalReservations,
            'todayReservations' => $todayReservations,
            'pendingReservations' => $pendingReservations,
            'confirmedReservations' => $confirmedReservations,
            'recentReservations' => $recentReservations,
        ]);
    }
}
