<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        DB::table('languages')->insert([
            ['locale' => 'en_GB', 'language' => 'English'],
            ['locale' => 'hr_HR', 'language' => 'Hrvatski (Croatian)'],
            ['locale' => 'de_DE', 'language' => 'Deutsch (German)'],
        ]);
    }
}
