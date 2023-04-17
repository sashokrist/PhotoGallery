<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create();
         \App\Models\User::factory(10)->create();

        $this->call([
            UsersTableSeeder::class,
            TagsTableSeeder::class,
            PhotosTableSeeder::class,
        ]);

    }
}
