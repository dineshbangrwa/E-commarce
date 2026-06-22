<?php

namespace Database\Seeders;

use App\Models\Enquiry;
use App\Models\User;
use Illuminate\Database\Seeder;

class EnquieySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Enquiry::factory()->count(10)->create();
        User::factory()->count(3)->create();
    }
}
