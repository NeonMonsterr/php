<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;
use App\Models\PharmacyStaff;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prescription>
 */
class PrescriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),  // Assign a random client from the Client factory
            'staff_id' => PharmacyStaff::factory(),  // Assign a random staff member from the Staff factory
            'pres_date' => $this->faker->date(),  // Random prescription date
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
