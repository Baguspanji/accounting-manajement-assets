<?php

namespace App\Http\Controllers;

use App\Services\ReportDataService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function __construct(private readonly ReportDataService $reportData) {}

    public function index(): View
    {
        $summary = $this->reportData->summary();

        return view('reports.index', compact('summary'));
    }

    public function neraca(Request $request): View
    {
        $asOf = $request->filled('as_of') ? Carbon::parse($request->as_of) : null;

        return view('reports.neraca', $this->reportData->neraca($asOf));
    }

    public function labaRugi(Request $request): View
    {
        $from = $request->filled('from') ? Carbon::parse($request->from) : null;
        $to = $request->filled('to') ? Carbon::parse($request->to) : null;

        return view('reports.laba-rugi', $this->reportData->labaRugi($from, $to));
    }

    public function kategori(): View
    {
        $categories = $this->reportData->kategori();

        return view('reports.kategori', compact('categories'));
    }

    public function kartuAset(Request $request): View
    {
        $data = $this->reportData->kartuAset($request->filled('asset_id') ? (int) $request->asset_id : null);

        return view('reports.kartu-aset', $data);
    }

    public function jadwalPenyusutan(): View
    {
        $data = $this->reportData->jadwalPenyusutan();

        return view('reports.jadwal-penyusutan', $data);
    }

    public function pelepasan(): View
    {
        $data = $this->reportData->pelepasan();

        return view('reports.pelepasan', $data);
    }

    public function arusKas(): View
    {
        $data = $this->reportData->arusKas();

        return view('reports.arus-kas', $data);
    }
}
