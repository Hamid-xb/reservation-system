<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function show(Request $request, $restaurantId)
    {
        $restaurant = \App\Models\Restaurant::findOrFail($restaurantId);

        $canOpenDashboard = $this->checkAccess($request, $restaurant);

        return view('restaurant', compact('restaurant', 'canOpenDashboard'));
    }

    public function checkAccess(Request $request, $restaurant)
    {
        return
        $request->user()->hasRestaurantRole($restaurant->id, [
            'restaurant_owner',
            'restaurant_manager',
            'restaurant_staff',
        ]);
    }


}
