<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TrainingAndSupport>
 */
class TrainingAndSupportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'knowledge_base' => $this->faker->text(),  // Random text for knowledge base
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
