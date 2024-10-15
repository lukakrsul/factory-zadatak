<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Ingredient;

class IngredientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach(range(1, 50) as $index){
            Ingredient::create([
                'slug' => $faker->unique()->word() . '-' . $faker->word() . '-' . $faker->word(),
            ]);
        }
    }
}
