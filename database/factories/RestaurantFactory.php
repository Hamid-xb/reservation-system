<?php

namespace Database\Factories;

use App\Models\RestaurantType;
use Illuminate\Database\Eloquent\Factories\Factory;

class RestaurantFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'description' => fake()->sentence(),
            'status' => fake()->randomElement([
                'active',
                'inactive',
            ]),
            'restaurant_type_id' => RestaurantType::query()->inRandomOrder()->value('id'),
        ];
    }
}
