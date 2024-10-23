<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $paid = $this->faker->boolean();
        return [
            'type' => $this->faker->randomElement(['B', 'C', 'P']),
            'paid' => $paid,
            'value' => $this->faker->numberBetween(100, 1000),
            'payment_data' => $paid ? $this->faker->randomElement([$this->faker->dateTimeThisMonth()]): NULL
        ];
    }
}
