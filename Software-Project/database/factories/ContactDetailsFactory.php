<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactDetails>
 */
class ContactDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),  // Random Client
            'phone_number' => $this->faker->phoneNumber(),  // Random phone number
            'mobile_number' => $this->faker->phoneNumber(),  // Random mobile number
            'email_address' => $this->faker->unique()->safeEmail(),  // Unique random email address
            'mailing_address' => $this->faker->address(),  // Random mailing address
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
