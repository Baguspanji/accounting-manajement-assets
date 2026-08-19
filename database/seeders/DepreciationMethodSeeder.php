<?php

namespace Database\Seeders;

use App\Models\DepreciationMethod;
use Illuminate\Database\Seeder;

class DepreciationMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            [
                'code' => 'SL',
                'name' => 'Garis Lurus',
                'formula' => '(Harga Perolehan - Nilai Residu) / Umur Manfaat',
                'description' => 'Beban penyusutan sama besar setiap periode. Cocok untuk aset yang manfaatnya dikonsumsi merata (bangunan, peralatan kantor).',
            ],
            [
                'code' => 'DDB',
                'name' => 'Saldo Menurun',
                'formula' => 'Tarif (2 x 1/Umur Manfaat) x Nilai Buku Awal Periode',
                'description' => 'Beban penyusutan menurun setiap periode. Nilai residu tidak diperhitungkan dalam perhitungan tarif.',
            ],
            [
                'code' => 'SOYD',
                'name' => 'Jumlah Angka Tahun',
                'formula' => '(Sisa Umur / Jumlah Angka Tahun) x (Harga Perolehan - Nilai Residu)',
                'description' => 'Beban penyusutan menurun. Penyebut = n(n+1)/2 dengan n = umur manfaat.',
            ],
            [
                'code' => 'UP',
                'name' => 'Unit Produksi',
                'formula' => '(Harga Perolehan - Nilai Residu) x (Produksi Periode / Kapasitas Total)',
                'description' => 'Beban penyusutan berdasarkan volume pemakaian. Cocok untuk mesin produksi.',
            ],
        ];

        foreach ($methods as $method) {
            DepreciationMethod::create($method);
        }
    }
}
