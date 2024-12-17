<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicalHistory>
 */
class MedicalHistoryFactory extends Factory
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
            'conditions' => json_encode($this->faker->words(5)),  // Random conditions (encoded as JSON)
            'allergies' => json_encode($this->faker->words(3)),  // Random allergies (encoded as JSON)
            'medications' => json_encode($this->faker->words(3)),  // Random medications (encoded as JSON)
            'immunizations' => json_encode($this->faker->words(3)),  // Random immunizations (encoded as JSON)
            'procedures' => json_encode($this->faker->words(3)),  // Random procedures (encoded as JSON)
            'notes' => $this->faker->text(),  // Random notes text
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
