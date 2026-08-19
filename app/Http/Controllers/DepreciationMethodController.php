<?php

namespace App\Http\Controllers;

use App\Models\DepreciationMethod;
use Illuminate\Http\Request;

class DepreciationMethodController extends Controller
{
    public function index()
    {
        $methods = DepreciationMethod::latest()->paginate(15);

        return view('depreciation_methods.index', compact('methods'));
    }

    public function create()
    {
        return view('depreciation_methods.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:50|unique:depreciation_methods,code',
            'name' => 'required|string|max:255',
            'formula' => 'nullable|string',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        DepreciationMethod::create($data);

        return redirect()->route('depreciation-methods.index')->with('success', 'Metode penyusutan berhasil ditambahkan.');
    }

    public function show(DepreciationMethod $depreciationMethod)
    {
        return view('depreciation_methods.show', compact('depreciationMethod'));
    }

    public function edit(DepreciationMethod $depreciationMethod)
    {
        return view('depreciation_methods.edit', compact('depreciationMethod'));
    }

    public function update(Request $request, DepreciationMethod $depreciationMethod)
    {
        $data = $request->validate([
            'code' => 'required|string|max:50|unique:depreciation_methods,code,'.$depreciationMethod->id,
            'name' => 'required|string|max:255',
            'formula' => 'nullable|string',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $depreciationMethod->update($data);

        return redirect()->route('depreciation-methods.index')->with('success', 'Data metode penyusutan berhasil diperbarui.');
    }

    public function destroy(DepreciationMethod $depreciationMethod)
    {
        $depreciationMethod->delete();

        return redirect()->route('depreciation-methods.index')->with('success', 'Data metode penyusutan berhasil dihapus.');
    }
}
