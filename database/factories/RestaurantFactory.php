<?php

namespace Database\Factories;

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
            'restaurant_type' => fake()->randomElement([
                'Yemeni',
                'Italian',
                'Japanese',
                'Fast Food',
                'Steakhouse',
            ]),
        ];
    }
}
