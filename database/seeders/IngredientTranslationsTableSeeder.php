<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ingredient;
use App\Models\IngredientTranslation;
use App\Models\Language;
use Faker\Factory as Faker;

class IngredientTranslationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingredients = Ingredient::all();
        $languages = Language::all();

        foreach($ingredients as $ingredient){
            foreach($languages as $language){
                $faker = Faker::create((string)$language->locale);
                IngredientTranslation::create([
                    'ingredient_id' => $ingredient->id,
                    'locale' => $language->locale,
                    'title' => $faker->realText(10),
                ]);  
            }  
        }
    }
}
