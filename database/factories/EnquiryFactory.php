<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Enquiry;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enquiry>
 */
class EnquiryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        //     'name'=>$this->faker->word(),
        //      'email'=>$this->faker->word(),
        // 'phone'=>$this->faker->word(),
        // 'message'=>$this->faker->word(),
        ];
    }
}
