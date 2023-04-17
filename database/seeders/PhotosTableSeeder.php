<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Photo;
use App\Models\Comment;
use Faker\Factory as Faker;

class PhotosTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Create 20 photos
        for ($i = 0; $i < 20; $i++) {
            $photo = new Photo([
                'image' => 'photo' . ($i % 5 + 1) . '.png', // Random image file name
                'user_id' => User::inRandomOrder()->first()->id, // Random user_id between 1 and 2
                'title' => $faker->word, // Random title
            ]);
            $photo->save();

            // Create 1-3 random tags for each photo
            $numTags = random_int(1, 3);
            $tags = Tag::inRandomOrder()->take($numTags)->get();
            $photo->tags()->attach($tags);

            // Create 2 comments for each photo
            for ($j = 0; $j < 2; $j++) {
                $comment = new Comment([
                    'body' => $faker->sentence, // Random comment body
                    'user_id' => User::inRandomOrder()->first()->id, // Random user_id between 1 and 2
                ]);
                $photo->comments()->save($comment);
            }
        }
    }
}

