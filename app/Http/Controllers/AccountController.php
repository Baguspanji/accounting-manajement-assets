<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::with('parent')->latest()->paginate(15);

        return view('accounts.index', compact('accounts'));
    }

    public function create()
    {
        $categories = ['asset', 'liability', 'equity', 'revenue', 'expense'];
        $normalBalances = ['debit', 'credit'];
        $parentAccounts = Account::where('parent_id', null)->get();

        return view('accounts.create', compact('categories', 'normalBalances', 'parentAccounts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:50|unique:accounts,code',
            'name' => 'required|string|max:255',
            'category' => 'required|in:asset,liability,equity,revenue,expense',
            'normal_balance' => 'required|in:debit,credit',
            'parent_id' => 'nullable|exists:accounts,id',
            'is_active' => 'boolean',
        ]);

        Account::create($data);

        return redirect()->route('accounts.index')->with('success', 'Akun berhasil ditambahkan.');
    }

    public function show(Account $account)
    {
        $account->load('parent', 'children', 'journalDetails');

        return view('accounts.show', compact('account'));
    }

    public function edit(Account $account)
    {
        $categories = ['asset', 'liability', 'equity', 'revenue', 'expense'];
        $normalBalances = ['debit', 'credit'];
        $parentAccounts = Account::where('parent_id', null)->where('id', '!=', $account->id)->get();

        return view('accounts.edit', compact('account', 'categories', 'normalBalances', 'parentAccounts'));
    }

    public function update(Request $request, Account $account)
    {
        $data = $request->validate([
            'code' => 'required|string|max:50|unique:accounts,code,'.$account->id,
            'name' => 'required|string|max:255',
            'category' => 'required|in:asset,liability,equity,revenue,expense',
            'normal_balance' => 'required|in:debit,credit',
            'parent_id' => 'nullable|exists:accounts,id',
            'is_active' => 'boolean',
        ]);

        $account->update($data);

        return redirect()->route('accounts.index')->with('success', 'Data akun berhasil diperbarui.');
    }

    public function destroy(Account $account)
    {
        $account->delete();

        return redirect()->route('accounts.index')->with('success', 'Data akun berhasil dihapus.');
    }
}
