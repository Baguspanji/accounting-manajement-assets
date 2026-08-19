<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AssetCategory;
use Illuminate\Http\Request;

class AssetCategoryController extends Controller
{
    public function index()
    {
        $categories = AssetCategory::with('assetAccount')->latest()->paginate(15);

        return view('asset_categories.index', compact('categories'));
    }

    public function create()
    {
        $accounts = Account::where('is_active', true)->get();

        return view('asset_categories.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:50|unique:asset_categories,code',
            'name' => 'required|string|max:255',
            'asset_account_id' => 'nullable|exists:accounts,id',
            'depreciation_expense_account_id' => 'nullable|exists:accounts,id',
            'accumulated_depreciation_account_id' => 'nullable|exists:accounts,id',
            'default_useful_life' => 'nullable|integer|min:1',
            'default_residual_value' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        AssetCategory::create($data);

        return redirect()->route('asset-categories.index')->with('success', 'Kategori aset berhasil ditambahkan.');
    }

    public function show(AssetCategory $assetCategory)
    {
        $assetCategory->load('assetAccount', 'depreciationExpenseAccount', 'accumulatedDepreciationAccount', 'assets');

        return view('asset_categories.show', compact('assetCategory'));
    }

    public function edit(AssetCategory $assetCategory)
    {
        $accounts = Account::where('is_active', true)->get();

        return view('asset_categories.edit', compact('assetCategory', 'accounts'));
    }

    public function update(Request $request, AssetCategory $assetCategory)
    {
        $data = $request->validate([
            'code' => 'required|string|max:50|unique:asset_categories,code,'.$assetCategory->id,
            'name' => 'required|string|max:255',
            'asset_account_id' => 'nullable|exists:accounts,id',
            'depreciation_expense_account_id' => 'nullable|exists:accounts,id',
            'accumulated_depreciation_account_id' => 'nullable|exists:accounts,id',
            'default_useful_life' => 'nullable|integer|min:1',
            'default_residual_value' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $assetCategory->update($data);

        return redirect()->route('asset-categories.index')->with('success', 'Data kategori aset berhasil diperbarui.');
    }

    public function destroy(AssetCategory $assetCategory)
    {
        $assetCategory->delete();

        return redirect()->route('asset-categories.index')->with('success', 'Data kategori aset berhasil dihapus.');
    }
}
