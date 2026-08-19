<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\DepreciationMethod;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::with('category', 'depreciationMethod')->latest()->paginate(10);

        return view('assets.index', compact('assets'));
    }

    public function create()
    {
        $categories = AssetCategory::where('is_active', true)->get();
        $depreciationMethods = DepreciationMethod::where('is_active', true)->get();

        return view('assets.create', compact('categories', 'depreciationMethods'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'asset_number' => 'required|string|max:50|unique:assets,asset_number',
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:asset_categories,id',
            'serial_number' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'responsible_person' => 'nullable|string|max:255',
            'supplier' => 'nullable|string|max:255',
            'acquisition_date' => 'required|date',
            'acquisition_cost' => 'required|numeric|min:0',
            'residual_value' => 'required|numeric|min:0',
            'useful_life' => 'required|integer|min:1',
            'depreciation_method_id' => 'required|exists:depreciation_methods,id',
            'production_capacity' => 'nullable|integer|min:0',
            'status' => 'required|in:active,disposed,written_off,maintenance',
            'notes' => 'nullable|string',
        ]);

        Asset::create($data);

        return redirect()->route('assets.index')->with('success', 'Aset berhasil ditambahkan.');
    }

    public function show(Asset $asset)
    {
        $asset->load('category', 'depreciationMethod', 'depreciations', 'disposals');

        return view('assets.show', compact('asset'));
    }

    public function edit(Asset $asset)
    {
        $categories = AssetCategory::where('is_active', true)->get();
        $depreciationMethods = DepreciationMethod::where('is_active', true)->get();

        return view('assets.edit', compact('asset', 'categories', 'depreciationMethods'));
    }

    public function update(Request $request, Asset $asset)
    {
        $data = $request->validate([
            'asset_number' => 'required|string|max:50|unique:assets,asset_number,'.$asset->id,
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:asset_categories,id',
            'serial_number' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'responsible_person' => 'nullable|string|max:255',
            'supplier' => 'nullable|string|max:255',
            'acquisition_date' => 'required|date',
            'acquisition_cost' => 'required|numeric|min:0',
            'residual_value' => 'required|numeric|min:0',
            'useful_life' => 'required|integer|min:1',
            'depreciation_method_id' => 'required|exists:depreciation_methods,id',
            'production_capacity' => 'nullable|integer|min:0',
            'status' => 'required|in:active,disposed,written_off,maintenance',
            'notes' => 'nullable|string',
        ]);

        $asset->update($data);

        return redirect()->route('assets.index')->with('success', 'Data aset berhasil diperbarui.');
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();

        return redirect()->route('assets.index')->with('success', 'Data aset berhasil dihapus.');
    }
}
