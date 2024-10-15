<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;
use App\Models\TagTranslation;
use App\Models\Language;
use Faker\Factory as Faker;

class TagTranslationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = Tag::all();
        $languages = Language::all();

        foreach($tags as $tag){
            foreach($languages as $language){
                $faker = Faker::create((string)$language->locale);
                TagTranslation::create([
                    'tag_id' => $tag->id,
                    'locale' => $language->locale,
                    'title' => $faker->realText(10),
                ]);  
            }  
        }
    }
}
