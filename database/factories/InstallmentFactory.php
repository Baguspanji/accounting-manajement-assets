<?php

namespace Database\Factories;

use App\Models\Financing;
use App\Models\Installment;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstallmentFactory extends Factory
{
    protected $model = Installment::class;

    public function definition(): array
    {
        return [
            'financing_id' => Financing::factory(),
            'installment_number' => $this->faker->numberBetween(1, 36),
            'amount' => $this->faker->randomFloat(2, 100000, 2000000),
            'principal' => $this->faker->randomFloat(2, 80000, 1800000),
            'margin' => $this->faker->randomFloat(2, 10000, 500000),
            'due_date' => $this->faker->dateTimeBetween('-1 year', '+1 year'),
            'paid_date' => $this->faker->optional()->dateTimeBetween('-1 year', 'now'),
            'status' => $this->faker->randomElement(['unpaid', 'paid']),
            'notes' => $this->faker->sentence(),
        ];
    }
}
