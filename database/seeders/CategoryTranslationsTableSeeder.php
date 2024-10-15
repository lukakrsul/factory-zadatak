<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Language;
use Faker\Factory as Faker;


class CategoryTranslationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $categories = Category::all();
        $languages = Language::all();
        
        
        foreach($categories as $category){
            foreach($languages as $language){
                $faker = Faker::create((string)$language->locale);
                CategoryTranslation::create([
                    'category_id' => $category->id,
                    'locale' => $language->locale,
                    'title' => $faker->realText(10),
                ]);  
            }
        }
    }
}
