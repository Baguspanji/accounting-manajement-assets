<?php

namespace Database\Factories;

use App\Models\Contract;
use App\Models\Financing;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

class FinancingFactory extends Factory
{
    protected $model = Financing::class;

    public function definition(): array
    {
        return [
            'code' => 'FIN-' . $this->faker->unique()->numerify('####'),
            'member_id' => Member::factory(),
            'contract_id' => Contract::factory(),
            'amount' => $this->faker->randomFloat(2, 1000000, 50000000),
            'margin' => $this->faker->randomFloat(2, 100000, 5000000),
            'tenor' => $this->faker->numberBetween(6, 36),
            'transaction_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'remaining' => $this->faker->randomFloat(2, 0, 50000000),
            'status' => $this->faker->randomElement(['active', 'paid_off', 'default']),
            'notes' => $this->faker->sentence(),
        ];
    }
}