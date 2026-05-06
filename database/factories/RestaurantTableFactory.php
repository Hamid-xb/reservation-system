<?php

namespace Database\Factories;

use App\Models\RestaurantTable;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

class RestaurantTableFactory extends Factory
{
    public function definition(): array
    {
        return [
            'restaurant_id' => Restaurant::factory(),
            'table_number' => fake()->unique()->numberBetween(1, 50),
            'seats' => fake()->randomElement([2, 2, 2, 4, 4, 6, 8]),
        ];
    }
}
