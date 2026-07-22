<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Contract;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::latest()->paginate(15);
        $accounts = Account::where('is_active', true)->get(['id', 'code', 'name']);

        return view('contracts.index', compact('contracts', 'accounts'));
    }

    public function create()
    {
        $accounts = Account::where('is_active', true)->get();

        return view('contracts.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:50|unique:contracts,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'debit_account_id' => 'nullable|exists:accounts,id',
            'credit_account_id' => 'nullable|exists:accounts,id',
            'is_active' => 'boolean',
        ]);

        Contract::create($data);

        return redirect()->route('contracts.index')->with('success', 'Akad berhasil ditambahkan.');
    }

    public function show(Contract $contract)
    {
        $contract->load('debitAccount', 'creditAccount');

        return view('contracts.show', compact('contract'));
    }

    public function edit(Contract $contract)
    {
        $accounts = Account::where('is_active', true)->get();

        return view('contracts.edit', compact('contract', 'accounts'));
    }

    public function update(Request $request, Contract $contract)
    {
        $data = $request->validate([
            'code' => 'required|string|max:50|unique:contracts,code,'.$contract->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'debit_account_id' => 'nullable|exists:accounts,id',
            'credit_account_id' => 'nullable|exists:accounts,id',
            'is_active' => 'boolean',
        ]);

        $contract->update($data);

        return redirect()->route('contracts.index')->with('success', 'Data akad berhasil diperbarui.');
    }

    public function destroy(Contract $contract)
    {
        $contract->delete();

        return redirect()->route('contracts.index')->with('success', 'Data akad berhasil dihapus.');
    }
}
