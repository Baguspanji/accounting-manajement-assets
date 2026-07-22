<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\Saving;
use Illuminate\Database\Eloquent\Factories\Factory;

class SavingFactory extends Factory
{
    protected $model = Saving::class;

    public function definition(): array
    {
        return [
            'member_id' => Member::factory(),
            'type' => $this->faker->randomElement(['pokok', 'wajib', 'sukarela']),
            'transaction_type' => $this->faker->randomElement(['setor', 'tarik']),
            'amount' => $this->faker->randomFloat(2, 50000, 1000000),
            'transaction_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'notes' => $this->faker->sentence(),
        ];
    }
}