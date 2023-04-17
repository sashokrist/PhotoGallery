<?php

namespace Database\Seeders;

use App\Models\Tag;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TagsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 20; $i++) {
            Tag::create([
                'name' => $faker->randomElement(['животни', 'коли', 'природа', 'спорт']),
                'created_at' => $faker->date()
            ]);
        }
    }
}
