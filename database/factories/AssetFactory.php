<?php

namespace Database\Factories;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\DepreciationMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssetFactory extends Factory
{
    protected $model = Asset::class;

    public function definition(): array
    {
        $categories = ['Tanah', 'Bangunan', 'Kendaraan', 'Mesin', 'Peralatan', 'Komputer'];

        return [
            'asset_number' => 'AST-'.str_pad($this->faker->unique()->numberBetween(1, 99999), 5, '0', STR_PAD_LEFT),
            'name' => $this->faker->randomElement([
                'Tanah Kantor', 'Gedung Operasional', 'Toyota Avanza', 'Honda PCX',
                'Mesin Cetak Offset', 'Mesin Jahit', 'Meja Direksi', 'Komputer iMac', 'Laptop ASUS', 'Proyektor Epson',
            ]),
            'category_id' => AssetCategory::query()->exists()
                ? AssetCategory::inRandomOrder()->value('id')
                : AssetCategory::factory(),
            'serial_number' => $this->faker->optional()->bothify('SN-####-####'),
            'location' => $this->faker->city(),
            'responsible_person' => $this->faker->name(),
            'supplier' => $this->faker->company(),
            'acquisition_date' => $this->faker->dateTimeBetween('-5 years', 'now'),
            'acquisition_cost' => $this->faker->randomFloat(2, 3000000, 250000000),
            'residual_value' => $this->faker->randomFloat(2, 0, 5000000),
            'useful_life' => $this->faker->numberBetween(4, 20),
            'depreciation_method_id' => DepreciationMethod::query()->exists()
                ? DepreciationMethod::inRandomOrder()->value('id')
                : DepreciationMethod::factory(),
            'production_capacity' => $this->faker->optional()->numberBetween(1000, 100000),
            'status' => 'active',
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
