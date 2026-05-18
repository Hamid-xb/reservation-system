<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RestaurantType;


class RestaurantTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RestaurantType::create(['name' => 'Arabisch']);
        RestaurantType::create(['name' => 'Syrisch']);
        RestaurantType::create(['name' => 'Jemenitisch']);
        RestaurantType::create(['name' => 'Italiaans']);
        RestaurantType::create(['name' => 'Frans']);
        RestaurantType::create(['name' => 'Spaans']);
        RestaurantType::create(['name' => 'Grieks']);
        RestaurantType::create(['name' => 'Marokkaans']);
        RestaurantType::create(['name' => 'Surinaams']);
        RestaurantType::create(['name' => 'Indonesisch']);
        RestaurantType::create(['name' => 'Chinees']);
        RestaurantType::create(['name' => 'Japans']);
        RestaurantType::create(['name' => 'Thais']);
        RestaurantType::create(['name' => 'Indiaas']);
        RestaurantType::create(['name' => 'Mexicaans']);
        RestaurantType::create(['name' => 'Amerikaans']);
        RestaurantType::create(['name' => 'Nederlands']);
        RestaurantType::create(['name' => 'Vegan']);
        RestaurantType::create(['name' => 'Vegetarisch']);
        RestaurantType::create(['name' => 'Anders']);

    }
}
