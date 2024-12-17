<?php

namespace Database\Factories;
use App\Models\Client;

use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PrivateDetails>
 */
class PrivateDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),  // Associate with a random Client
            'ssn' => $this->faker->ssn,  // Random Social Security Number
            'date_of_birth' => $this->faker->date(),  // Random Date of Birth
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
