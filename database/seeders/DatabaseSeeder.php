<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(2)->create();

        // User::factory()->create([
        //     'name' => 'Dinesh kumar',
        //     'email' => 'dinesh@gmail.com',
        //     'password'=>1234567890,
        //     'phone'=>7014658316,
            
        // ]);
        $this->call([
       
        CurrencySeeder::class,
      
    ]);
    
    }
}
