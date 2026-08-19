<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetDisposal;
use App\Services\DisposalService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DisposalController extends Controller
{
    public function __construct(private readonly DisposalService $disposalService) {}

    public function index(): View
    {
        $disposals = AssetDisposal::with('asset')->latest()->paginate(10);

        return view('disposals.index', compact('disposals'));
    }

    public function create(): View
    {
        $assets = Asset::with('category')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('disposals.create', compact('assets'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'disposal_date' => 'required|date',
            'disposal_type' => 'required|in:sale,write_off,transfer',
            'sale_price' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $asset = Asset::findOrFail($data['asset_id']);

        try {
            $disposal = $this->disposalService->dispose(
                $asset,
                $data['disposal_date'],
                $data['disposal_type'],
                (float) ($data['sale_price'] ?? 0),
                $data['notes'] ?? null,
            );
        } catch (\InvalidArgumentException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('disposals.show', $disposal)
            ->with('success', 'Pelepasan aset '.$asset->name.' berhasil dicatat.');
    }

    public function show(AssetDisposal $disposal): View
    {
        $disposal->load('asset', 'journals.details.account');

        return view('disposals.show', compact('disposal'));
    }
}
