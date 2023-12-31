<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TransacoesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'conta_id' => 1,
            'valor' => 50.00,
            'forma_pagamento' => 'D',
            'valor_total' => 52.50,
            'taxa_percentual' => 0.05,
        ];
    }
}
