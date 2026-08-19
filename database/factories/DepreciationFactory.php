<?php

namespace Database\Factories;

use App\Models\Asset;
use App\Models\Depreciation;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepreciationFactory extends Factory
{
    protected $model = Depreciation::class;

    public function definition(): array
    {
        $year = $this->faker->numberBetween(2020, 2026);
        $month = $this->faker->numberBetween(1, 12);

        return [
            'asset_id' => Asset::factory(),
            'period' => sprintf('%04d-%02d', $year, $month),
            'year' => $year,
            'month' => $month,
            'expense_amount' => $this->faker->randomFloat(2, 50000, 5000000),
            'accumulated_after' => $this->faker->randomFloat(2, 100000, 20000000),
            'book_value_after' => $this->faker->randomFloat(2, 1000000, 100000000),
            'status' => $this->faker->randomElement(['pending', 'posted']),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
