<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        // Create 5 categories
        foreach(range(1, 5) as $index){
            Category::create([
                'slug'=>$faker->word().'-'.$faker->word().'-'.$faker->word(),
            ]);
        }
    }
}
