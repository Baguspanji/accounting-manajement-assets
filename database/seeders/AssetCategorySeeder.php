<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\AssetCategory;
use Illuminate\Database\Seeder;

class AssetCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'code' => 'TNH',
                'name' => 'Tanah',
                'asset_code' => '1210',
                'depreciation_expense_code' => '5100',
                'accumulated_depreciation_code' => '1290',
                'default_useful_life' => null,
            ],
            [
                'code' => 'GDB',
                'name' => 'Bangunan',
                'asset_code' => '1220',
                'depreciation_expense_code' => '5100',
                'accumulated_depreciation_code' => '1290',
                'default_useful_life' => 20,
            ],
            [
                'code' => 'KDN',
                'name' => 'Kendaraan',
                'asset_code' => '1230',
                'depreciation_expense_code' => '5100',
                'accumulated_depreciation_code' => '1290',
                'default_useful_life' => 8,
            ],
            [
                'code' => 'MSN',
                'name' => 'Mesin',
                'asset_code' => '1240',
                'depreciation_expense_code' => '5100',
                'accumulated_depreciation_code' => '1290',
                'default_useful_life' => 10,
            ],
            [
                'code' => 'PRL',
                'name' => 'Peralatan',
                'asset_code' => '1250',
                'depreciation_expense_code' => '5100',
                'accumulated_depreciation_code' => '1290',
                'default_useful_life' => 5,
            ],
            [
                'code' => 'KMP',
                'name' => 'Komputer & Elektronik',
                'asset_code' => '1260',
                'depreciation_expense_code' => '5100',
                'accumulated_depreciation_code' => '1290',
                'default_useful_life' => 4,
            ],
        ];

        foreach ($categories as $data) {
            $assetAccount = Account::where('code', $data['asset_code'])->first();
            $expenseAccount = Account::where('code', $data['depreciation_expense_code'])->first();
            $accumulatedAccount = Account::where('code', $data['accumulated_depreciation_code'])->first();

            AssetCategory::create([
                'code' => $data['code'],
                'name' => $data['name'],
                'asset_account_id' => $assetAccount?->id,
                'depreciation_expense_account_id' => $expenseAccount?->id,
                'accumulated_depreciation_account_id' => $accumulatedAccount?->id,
                'default_useful_life' => $data['default_useful_life'],
                'default_residual_value' => 0,
                'is_active' => true,
            ]);
        }
    }
}
