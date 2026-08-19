<?php

namespace App\Http\Controllers;

use App\Services\FinancialReportService;
use Illuminate\View\View;

class TrialBalanceController extends Controller
{
    public function __construct(private readonly FinancialReportService $reportService) {}

    public function index(): View
    {
        $entries = $this->reportService->accountBalances();

        $totalDebit = $entries->sum('debit');
        $totalCredit = $entries->sum('credit');

        return view('trial-balance.index', compact('entries', 'totalDebit', 'totalCredit'));
    }
}
