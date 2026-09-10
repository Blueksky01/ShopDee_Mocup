<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::updateOrCreate(
            ['email' => 'admin@shopdee.com'],
            [
                'name' => 'Admin ShopDee',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        // Customer user
        User::updateOrCreate(
            ['email' => 'customer@shopdee.com'],
            [
                'name' => 'John Customer',
                'password' => Hash::make('password123'),
                'role' => 'customer',
            ]
        );
    }
}
