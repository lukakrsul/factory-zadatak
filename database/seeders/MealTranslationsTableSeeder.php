<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Meal;
use App\Models\Language;
use App\Models\MealTranslation;
use Faker\Factory as Faker;

class MealTranslationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //$faker = Faker::create();
        $languages = Language::all();
        $meals = Meal::all();


        foreach($meals as $meal){
            foreach($languages as $language){
                $faker = Faker::create((string)$language->locale);
                MealTranslation::create([
                    'meal_id' => $meal->id,
                    'locale' => $language->locale,
                    'title' => $faker->realText(10),
                    'description' => $faker->realText(30)
                ]);  
            }
        }
    }
}
