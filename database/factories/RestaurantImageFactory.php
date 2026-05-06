<?php

namespace Database\Factories;

use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

class RestaurantImageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'restaurant_id' => Restaurant::factory(),
            'image_url' => fake()->imageUrl(),
            'image_type' => fake()->randomElement([
                'logo',
                'banner',
                'gallery'
                ,
            ]),
        ];
    }
}
