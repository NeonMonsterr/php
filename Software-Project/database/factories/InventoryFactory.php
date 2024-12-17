<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inventory>
 */
class InventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => $this->faker->word(),  // Random description
            'dosage' => $this->faker->word(),  // Random dosage
            'unit_price' => $this->faker->randomFloat(2, 10, 500),  // Random unit price between 10 and 500
            'stock_level' => $this->faker->numberBetween(0, 100),  // Random stock level between 0 and 100
            'reorder_level' => $this->faker->numberBetween(0, 20),  // Random reorder level between 0 and 20
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
