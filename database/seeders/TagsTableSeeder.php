<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Tag;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        // Create 10 tags
        foreach(range(1, 10) as $index){
            Tag::create([
                'slug' => $faker->unique()->word() . '-' . $faker->word() . '-' . $faker->word(),
            ]);
        }
    }
}
