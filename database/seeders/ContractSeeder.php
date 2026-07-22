<?php

namespace Database\Seeders;

use App\Models\Contract;
use Illuminate\Database\Seeder;

class ContractSeeder extends Seeder
{
    public function run(): void
    {
        $contracts = [
            ['code' => 'WAD', 'name' => 'Wadiah', 'description' => 'Akad titipan.'],
            ['code' => 'MUD', 'name' => 'Mudharabah', 'description' => 'Akad bagi hasil.'],
            ['code' => 'MUS', 'name' => 'Musyarakah', 'description' => 'Akad kerja sama.'],
            ['code' => 'MUR', 'name' => 'Murabahah', 'description' => 'Akad jual beli dengan margin.'],
            ['code' => 'IJR', 'name' => 'Ijarah', 'description' => 'Akad sewa.'],
            ['code' => 'QRD', 'name' => 'Qardh', 'description' => 'Akad pinjaman kebajikan.'],
        ];

        foreach ($contracts as $contract) {
            Contract::create($contract);
        }
    }
}
