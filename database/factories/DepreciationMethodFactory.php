<?php

namespace Database\Factories;

use App\Models\DepreciationMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepreciationMethodFactory extends Factory
{
    protected $model = DepreciationMethod::class;

    public function definition(): array
    {
        $methods = [
            'SL' => ['Garis Lurus', '(Harga Perolehan - Nilai Residu) / Umur Manfaat'],
            'DDB' => ['Saldo Menurun', 'Tarif (2 x 1/umur) x Nilai Buku Awal Periode'],
            'SOYD' => ['Jumlah Angka Tahun', '(Sisa Umur / Jumlah Angka Tahun) x Jumlah yang Disusutkan'],
            'UP' => ['Unit Produksi', '(Harga Perolehan - Nilai Residu) x (Produksi Periode / Kapasitas Total)'],
        ];

        $code = $this->faker->unique()->randomElement(array_keys($methods));
        [$name, $formula] = $methods[$code];

        return [
            'code' => $code.'-'.$this->faker->unique()->numerify('###'),
            'name' => $name,
            'formula' => $formula,
            'description' => $this->faker->sentence(),
            'is_active' => true,
        ];
    }
}
