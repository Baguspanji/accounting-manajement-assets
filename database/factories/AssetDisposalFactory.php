<?php

namespace Database\Factories;

use App\Models\Asset;
use App\Models\AssetDisposal;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssetDisposalFactory extends Factory
{
    protected $model = AssetDisposal::class;

    public function definition(): array
    {
        return [
            'asset_id' => Asset::factory(),
            'disposal_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'disposal_type' => $this->faker->randomElement(['sale', 'write_off', 'transfer']),
            'sale_price' => $this->faker->randomFloat(2, 0, 50000000),
            'accumulated_depreciation' => $this->faker->randomFloat(2, 0, 20000000),
            'book_value' => $this->faker->randomFloat(2, 0, 50000000),
            'gain_loss' => $this->faker->randomFloat(2, -10000000, 10000000),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
