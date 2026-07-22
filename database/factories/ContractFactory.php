<?php

namespace Database\Factories;

use App\Models\Contract;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractFactory extends Factory
{
    protected $model = Contract::class;

    public function definition(): array
    {
        $name = $this->faker->randomElement(['Wadiah', 'Mudharabah', 'Musyarakah', 'Murabahah', 'Ijarah', 'Qardh']);

        return [
            'code' => strtoupper(substr($name, 0, 3)) . '-' . $this->faker->unique()->numerify('###'),
            'name' => $name,
            'description' => $this->faker->sentence(),
            'default_journal' => null,
            'debit_account_id' => null,
            'credit_account_id' => null,
            'is_active' => true,
        ];
    }
}
