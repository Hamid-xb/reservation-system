<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Admin', 'scope' => 'global']);
        Role::create(['name' => 'Moderator', 'scope' => 'global']);
        Role::create(['name' => 'User', 'scope' => 'global']);

        Role::create(['name' => 'Restaurant_owner', 'scope' => 'restaurant']);
        Role::create(['name' => 'Restaurant_manager', 'scope' => 'restaurant']);
        Role::create(['name' => 'Restaurant_staff', 'scope' => 'restaurant']);
    }
}
