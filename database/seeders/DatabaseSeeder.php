<?php

namespace Database\Seeders;

use App\Models\OpeningHour;
use App\Models\Restaurant;
use App\Models\RestaurantImage;
use App\Models\RestaurantInformation;
use App\Models\RestaurantTable;
use App\Models\Reservation;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        $users = User::factory()->count(10)->create();

        Restaurant::factory()
            ->count(5)
            ->create()
            ->each(function ($restaurant) use ($users) {
                RestaurantInformation::factory()->create([
                    'restaurant_id' => $restaurant->id,
                ]);

                RestaurantImage::factory()->count(3)->create([
                    'restaurant_id' => $restaurant->id,
                ]);

                foreach (range(0, 6) as $day) {
                    OpeningHour::factory()->create([
                        'restaurant_id' => $restaurant->id,
                        'day_of_week' => $day,
                    ]);
                }

                RestaurantTable::factory()->count(10)->create([
                    'restaurant_id' => $restaurant->id,
                ]);

                $managerRole = Role::where('name', 'restaurant_manager')->first();

                UserRole::factory()->create([
                    'user_id' => $users->random()->id,
                    'role_id' => $managerRole->id,
                    'restaurant_id' => $restaurant->id,
                ]);

                $tables = $restaurant->tables()->take(2)->pluck('id');

                $reservation = Reservation::factory()->create([
                    'restaurant_id' => $restaurant->id,
                    'created_by_user_id' => $users->random()->id,
                ]);

                $reservation->tables()->attach($tables);
            });
    }
}
