<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Journal;
use App\Models\JournalDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class JournalDetailFactory extends Factory
{
    protected $model = JournalDetail::class;

    public function definition(): array
    {
        return [
            'journal_id' => Journal::factory(),
            'account_id' => Account::factory(),
            'debit' => $this->faker->randomFloat(2, 0, 10000000),
            'credit' => $this->faker->randomFloat(2, 0, 10000000),
        ];
    }
}
