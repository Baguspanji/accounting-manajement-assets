<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Journal;
use App\Services\AcquisitionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AcquisitionController extends Controller
{
    public function __construct(private readonly AcquisitionService $acquisitionService) {}

    public function index(): View
    {
        $journals = Journal::with('journalable', 'details.account')
            ->where('reference', 'like', 'ACQ-%')
            ->latest()
            ->paginate(10);

        return view('acquisitions.index', compact('journals'));
    }

    public function create(): View
    {
        $assets = Asset::with('category')
            ->where('status', 'active')
            ->whereDoesntHave('journals', fn ($query) => $query->where('reference', 'like', 'ACQ-%'))
            ->orderBy('name')
            ->get();

        return view('acquisitions.create', compact('assets'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'transaction_date' => 'required|date',
            'source' => 'required|in:kas,utang',
        ]);

        $asset = Asset::findOrFail($data['asset_id']);

        try {
            $this->acquisitionService->acquire($asset, $data['transaction_date'], $data['source']);
        } catch (\InvalidArgumentException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('acquisitions.index')
            ->with('success', 'Perolehan aset '.$asset->name.' berhasil dicatat.');
    }

    public function show(Journal $acquisition): View
    {
        abort_if(! str_starts_with($acquisition->reference, 'ACQ-'), 404);

        $acquisition->load('journalable', 'details.account');

        return view('acquisitions.show', compact('acquisition'));
    }
}
