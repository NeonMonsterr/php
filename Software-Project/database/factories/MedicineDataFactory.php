<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicineData>
 */
class MedicineDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'batch_no' => $this->faker->unique()->randomNumber(5, true),
            'drug_name' => $this->faker->word,
            'price' => $this->faker->randomFloat(2, 1, 500),
            'manufacturer' =>$this->faker->name(),
            'stock_qty' => $this->faker->numberBetween(0, 1000),
            'expiry_date' =>$this->faker->date('Y-m-d'),
            

        ];
    }
}
