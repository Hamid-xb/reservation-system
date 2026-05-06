<?php

namespace Database\Factories;

use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

class OpeningHourFactory extends Factory
{
    public function definition(): array
    {
        return [
            'restaurant_id' => Restaurant::factory(),
            'day_of_week' => fake()->numberBetween(0, 6),
            'open_time' => '09:00:00',
            'close_time' => '22:00:00',
        ];
    }
}
