<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    public function definition(): array
    {
        $start = fake()->dateTimeBetween('+1 day', '+1 month');
        $end = (clone $start)->modify('+2 hours');

        return [
            'created_by_user_id' => User::factory(),
            'restaurant_id' => Restaurant::factory(),
            'name' => fake()->name(),
            'phone_number' => fake()->phoneNumber(),
            'number_of_people' => fake()->numberBetween(1, 8),
            'start_datetime' => $start,
            'end_datetime' => $end,
            'status' => fake()->randomElement([
                'pending',
                'confirmed',
                'cancelled',
            ]),
            'reservation_type' => fake()->randomElement([
                'user_created',
                'staff_created',
            ]),
            'reservation_note' => fake()->optional()->sentence(),
        ];
    }
}
