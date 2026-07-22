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
            ['code' => '1100', 'name' => 'Kas & Setara Kas', 'category' => 'asset', 'normal_balance' => 'debit', 'parent_code' => '1000'],
            ['code' => '1110', 'name' => 'Kas Koperasi', 'category' => 'asset', 'normal_balance' => 'debit', 'parent_code' => '1100'],
            
            ['code' => '1200', 'name' => 'Piutang', 'category' => 'asset', 'normal_balance' => 'debit', 'parent_code' => '1000'],
            ['code' => '1210', 'name' => 'Piutang Murabahah', 'category' => 'asset', 'normal_balance' => 'debit', 'parent_code' => '1200'],
            ['code' => '1220', 'name' => 'Piutang Qardh', 'category' => 'asset', 'normal_balance' => 'debit', 'parent_code' => '1200'],

            ['code' => '2000', 'name' => 'Liabilitas', 'category' => 'liability', 'normal_balance' => 'credit'],
            ['code' => '2100', 'name' => 'Simpanan', 'category' => 'liability', 'normal_balance' => 'credit', 'parent_code' => '2000'],
            ['code' => '2110', 'name' => 'Simpanan Sukarela', 'category' => 'liability', 'normal_balance' => 'credit', 'parent_code' => '2100'],

            ['code' => '3000', 'name' => 'Ekuitas', 'category' => 'equity', 'normal_balance' => 'credit'],
            ['code' => '3100', 'name' => 'Simpanan Pokok', 'category' => 'equity', 'normal_balance' => 'credit', 'parent_code' => '3000'],
            ['code' => '3200', 'name' => 'Simpanan Wajib', 'category' => 'equity', 'normal_balance' => 'credit', 'parent_code' => '3000'],

            ['code' => '4000', 'name' => 'Pendapatan', 'category' => 'revenue', 'normal_balance' => 'credit'],
            ['code' => '4100', 'name' => 'Pendapatan Margin Murabahah', 'category' => 'revenue', 'normal_balance' => 'credit', 'parent_code' => '4000'],

            ['code' => '5000', 'name' => 'Beban', 'category' => 'expense', 'normal_balance' => 'debit'],
            ['code' => '5100', 'name' => 'Beban Operasional', 'category' => 'expense', 'normal_balance' => 'debit', 'parent_code' => '5000'],
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
