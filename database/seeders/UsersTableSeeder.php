<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Use hashed password
        ]);

        User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Random User',
            'email' => 'random@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Hacker',
            'email' => 'hacker@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'VIP User',
            'email' => 'vip@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
