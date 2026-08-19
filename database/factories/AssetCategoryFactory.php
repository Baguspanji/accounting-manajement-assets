<?php

namespace Database\Factories;

use App\Models\AssetCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssetCategoryFactory extends Factory
{
    protected $model = AssetCategory::class;

    public function definition(): array
    {
        return [
            'code' => strtoupper(substr($this->faker->word(), 0, 3)).'-'.$this->faker->unique()->numerify('###'),
            'name' => $this->faker->randomElement(['Tanah', 'Bangunan', 'Kendaraan', 'Mesin', 'Peralatan', 'Komputer']),
            'asset_account_id' => null,
            'depreciation_expense_account_id' => null,
            'accumulated_depreciation_account_id' => null,
            'default_useful_life' => $this->faker->numberBetween(4, 20),
            'default_residual_value' => $this->faker->randomFloat(2, 0, 1000000),
            'is_active' => true,
        ];
    }
}
