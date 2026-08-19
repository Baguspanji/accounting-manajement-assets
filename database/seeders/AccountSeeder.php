<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            ['code' => '1000', 'name' => 'Aset', 'category' => 'asset', 'normal_balance' => 'debit'],
            ['code' => '1100', 'name' => 'Aset Lancar', 'category' => 'asset', 'normal_balance' => 'debit', 'parent_code' => '1000'],
            ['code' => '1110', 'name' => 'Kas', 'category' => 'asset', 'normal_balance' => 'debit', 'parent_code' => '1100'],

            ['code' => '1200', 'name' => 'Aset Tetap', 'category' => 'asset', 'normal_balance' => 'debit', 'parent_code' => '1000'],
            ['code' => '1210', 'name' => 'Tanah', 'category' => 'asset', 'normal_balance' => 'debit', 'parent_code' => '1200'],
            ['code' => '1220', 'name' => 'Bangunan', 'category' => 'asset', 'normal_balance' => 'debit', 'parent_code' => '1200'],
            ['code' => '1230', 'name' => 'Kendaraan', 'category' => 'asset', 'normal_balance' => 'debit', 'parent_code' => '1200'],
            ['code' => '1240', 'name' => 'Mesin', 'category' => 'asset', 'normal_balance' => 'debit', 'parent_code' => '1200'],
            ['code' => '1250', 'name' => 'Peralatan', 'category' => 'asset', 'normal_balance' => 'debit', 'parent_code' => '1200'],
            ['code' => '1260', 'name' => 'Komputer & Elektronik', 'category' => 'asset', 'normal_balance' => 'debit', 'parent_code' => '1200'],
            ['code' => '1290', 'name' => 'Akumulasi Penyusutan', 'category' => 'asset', 'normal_balance' => 'credit', 'parent_code' => '1200'],

            ['code' => '2000', 'name' => 'Liabilitas', 'category' => 'liability', 'normal_balance' => 'credit'],
            ['code' => '2100', 'name' => 'Utang Usaha', 'category' => 'liability', 'normal_balance' => 'credit', 'parent_code' => '2000'],

            ['code' => '3000', 'name' => 'Ekuitas', 'category' => 'equity', 'normal_balance' => 'credit'],
            ['code' => '3100', 'name' => 'Modal Pemilik', 'category' => 'equity', 'normal_balance' => 'credit', 'parent_code' => '3000'],

            ['code' => '4000', 'name' => 'Pendapatan', 'category' => 'revenue', 'normal_balance' => 'credit'],
            ['code' => '4100', 'name' => 'Laba Pelepasan Aset', 'category' => 'revenue', 'normal_balance' => 'credit', 'parent_code' => '4000'],

            ['code' => '5000', 'name' => 'Beban', 'category' => 'expense', 'normal_balance' => 'debit'],
            ['code' => '5100', 'name' => 'Beban Penyusutan', 'category' => 'expense', 'normal_balance' => 'debit', 'parent_code' => '5000'],
            ['code' => '5200', 'name' => 'Beban Administrasi', 'category' => 'expense', 'normal_balance' => 'debit', 'parent_code' => '5000'],
            ['code' => '5300', 'name' => 'Rugi Pelepasan Aset', 'category' => 'expense', 'normal_balance' => 'debit', 'parent_code' => '5000'],
        ];

        foreach ($accounts as $data) {
            $parentCode = $data['parent_code'] ?? null;
            unset($data['parent_code']);

            $account = Account::create($data);

            if ($parentCode) {
                $parent = Account::where('code', $parentCode)->first();
                if ($parent) {
                    $account->parent_id = $parent->id;
                    $account->save();
                }
            }
        }
    }
}
