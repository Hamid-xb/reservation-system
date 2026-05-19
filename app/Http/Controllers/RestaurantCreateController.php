<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\RestaurantInformation;
use App\Models\RestaurantType;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RestaurantCreateController extends Controller
{
    public function create()
    {
        $restaurantTypes = RestaurantType::orderBy('name')->get();

        return view('restaurants.create', compact('restaurantTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'restaurant_type_id' => ['nullable', 'exists:restaurant_types,id'],

            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone_number' => ['required', 'string', 'max:255'],
        ]);

        $restaurant = DB::transaction(function () use ($validated) {
            $restaurant = Restaurant::create([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'restaurant_type_id' => $validated['restaurant_type_id'] ?? null,
                'status' => 'active',
            ]);

            RestaurantInformation::create([
                'restaurant_id' => $restaurant->id,
                'address' => $validated['address'],
                'email' => $validated['email'],
                'phone_number' => $validated['phone_number'],
            ]);

            $ownerRole = Role::where('name', 'restaurant_owner')->firstOrFail();

            auth()->user()->userRoles()->create([
                'restaurant_id' => $restaurant->id,
                'role_id' => $ownerRole->id,
            ]);

            return $restaurant;
        });

        return redirect()
            ->route('restaurant.dashboard', $restaurant)
            ->with('success', 'Restaurant aangemaakt.');
    }
}
