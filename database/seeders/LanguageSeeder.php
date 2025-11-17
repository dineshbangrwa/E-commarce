<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('languages')->insert([
            ['language' => 'English', 'code' => 'en'],
            ['language' => 'Hindi', 'code' => 'hi'],
            ['language' => 'Spanish', 'code' => 'es'],
            ['language' => 'French', 'code' => 'fr'],
        ]);
    }
}
