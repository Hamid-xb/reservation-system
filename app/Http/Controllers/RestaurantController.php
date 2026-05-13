<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function show($id)
    {
        $restaurant = \App\Models\Restaurant::findOrFail($id);

        return view('restaurant', compact('restaurant'));
    }
}
