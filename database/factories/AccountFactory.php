<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    protected $model = Account::class;

    public function definition(): array
    {
        return [
            'code' => 'ACC-' . $this->faker->unique()->numerify('####'),
            'name' => $this->faker->words(3, true),
            'category' => $this->faker->randomElement(['asset', 'liability', 'equity', 'revenue', 'expense']),
            'normal_balance' => $this->faker->randomElement(['debit', 'credit']),
            'parent_id' => null,
            'is_active' => true,
        ];
    }
}
