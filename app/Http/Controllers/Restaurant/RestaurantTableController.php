<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\RestaurantTable;
use Illuminate\Http\Request;

class RestaurantTableController extends Controller
{
    public function index(Request $request, Restaurant $restaurant)
    {
        $this->checkAccess($request, $restaurant);

        $tables = $restaurant->tables()
            ->orderBy('table_number')
            ->get();

        return view('restaurant.tables.index', compact('restaurant', 'tables'));
    }

    public function store(Request $request, Restaurant $restaurant)
    {
        $this->checkAccess($request, $restaurant);

        $validated = $request->validate([
            'table_number' => [
                'required',
                'integer',
                'min:1',
                'unique:restaurant_tables,table_number,NULL,id,restaurant_id,' . $restaurant->id,
            ],

            'seats' => [
                'required',
                'integer',
                'min:1',
                'max:50',
            ],
        ], [
            'table_number.unique' => 'Dit tafelnummer bestaat al.',
        ]);

        $restaurant->tables()->create($validated);

        return redirect()
            ->route('restaurant.tables.index', $restaurant)
            ->with('success', 'Tafel toegevoegd.');
    }

    public function update(Request $request, Restaurant $restaurant, RestaurantTable $table)
    {
        $this->checkAccess($request, $restaurant);
        $this->ensureTableBelongsToRestaurant($restaurant, $table);

        $validated = $request->validate([
            'table_number' => [
                'required',
                'integer',
                'min:1',
                'unique:restaurant_tables,table_number,' . $table->id . ',id,restaurant_id,' . $restaurant->id,
            ],

            'seats' => [
                'required',
                'integer',
                'min:1',
                'max:50',
            ],
        ], [
            'table_number.unique' => 'Dit tafelnummer bestaat al.',
        ]);

        $table->update($validated);

        return redirect()
            ->route('restaurant.tables.index', $restaurant)
            ->with('success', 'Tafel aangepast.');
    }

    public function destroy(Request $request, Restaurant $restaurant, RestaurantTable $table)
    {
        $this->checkAccess($request, $restaurant);
        $this->ensureTableBelongsToRestaurant($restaurant, $table);

        $table->delete();

        return redirect()
            ->route('restaurant.tables.index', $restaurant)
            ->with('success', 'Tafel verwijderd.');
    }

    private function checkAccess(Request $request, Restaurant $restaurant): void
    {
        $allowed = $request->user()->hasRestaurantRole($restaurant->id, [
            'restaurant_owner',
            'restaurant_manager',
        ]);

        if (! $allowed) {
            abort(403);
        }
    }

    private function ensureTableBelongsToRestaurant(Restaurant $restaurant, RestaurantTable $table): void
    {
        if ($table->restaurant_id !== $restaurant->id) {
            abort(404);
        }
    }
}
