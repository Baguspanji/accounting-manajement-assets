<?php

namespace App\Http\Controllers;

use App\Models\Depreciation;
use App\Services\DepreciationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepreciationController extends Controller
{
    public function __construct(private readonly DepreciationService $depreciationService) {}

    public function index(Request $request): View
    {
        $period = $request->query('period');

        $periods = Depreciation::query()
            ->select('period')
            ->distinct()
            ->orderByDesc('period')
            ->pluck('period');

        $depreciations = Depreciation::with('asset')
            ->when($period, fn ($query) => $query->where('period', $period))
            ->orderByDesc('period')
            ->orderBy('id')
            ->paginate(10);

        return view('depreciations.index', compact('period', 'periods', 'depreciations'));
    }

    public function run(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'period' => ['required', 'regex:/^\d{4}-(0[1-9]|1[0-2])$/'],
        ]);

        $result = $this->depreciationService->runForPeriod($data['period']);

        if ($result['created'] === 0) {
            return redirect()
                ->route('depreciations.index', ['period' => $data['period']])
                ->with('info', 'Tidak ada aset yang perlu disusutkan pada periode '.$data['period'].'.');
        }

        return redirect()
            ->route('depreciations.index', ['period' => $data['period']])
            ->with('success', 'Penyusutan periode '.$data['period'].' dihasilkan untuk '.$result['created'].' aset.');
    }

    public function post(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'period' => ['required', 'regex:/^\d{4}-(0[1-9]|1[0-2])$/'],
        ]);

        $result = $this->depreciationService->postForPeriod($data['period']);

        if ($result['posted'] === 0) {
            return redirect()
                ->route('depreciations.index', ['period' => $data['period']])
                ->with('info', 'Tidak ada penyusutan pending pada periode '.$data['period'].'.');
        }

        return redirect()
            ->route('depreciations.index', ['period' => $data['period']])
            ->with('success', 'Penyusutan periode '.$data['period'].' untuk '.$result['posted'].' aset berhasil diposting.');
    }
}
