<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('currencies')->insert([
            ['code' => 'USD', 'symbol' => '$', 'exchange_rate' => 1, 'is_default' => 1],
            ['code' => 'INR', 'symbol' => '₹', 'exchange_rate' => 83, 'is_default' => 0],
            ['code' => 'EUR', 'symbol' => '€', 'exchange_rate' => 0.91, 'is_default' => 0],
        ]);
    }
}
