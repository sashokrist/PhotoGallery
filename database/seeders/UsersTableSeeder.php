<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => Hash::make('test1234'),
            'is_admin' => 1, // Set is_admin to 1 for admin user
        ]);

        // Create regular user
        User::create([
            'name' => 'Regular User',
            'email' => 'user@test.com',
            'password' => Hash::make('test1234'),
            'is_admin' => 0, // Set is_admin to 0 for regular user
        ]);
    }
}
