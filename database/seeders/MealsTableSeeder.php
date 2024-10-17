<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Meal;
use App\Models\Tag;
use App\Models\Ingredient;

class MealsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 20 meals
        foreach (range(1, 20) as $index) {
            // Store the created meal in a variable
            $meal = Meal::create([
                'status' => 'created',
                'category_id' => rand(0, 10) > 7 ? null : rand(1, 5), // 30% chance of null
            ]);

            // Seeding pivot tables, ingredients and tags tables need to be seeded before meal table
            // Attach at least one tag to the meal
            $tags = Tag::inRandomOrder()->take(rand(1, 3))->pluck('id'); // Random 1 to 3 tags
            $meal->tags()->attach($tags);

            // Attach at least one ingredient to the meal
            $ingredients = Ingredient::inRandomOrder()->take(rand(1, 5))->pluck('id'); // Random 1 to 5 ingredients
            $meal->ingredients()->attach($ingredients);
        }
    }
}
