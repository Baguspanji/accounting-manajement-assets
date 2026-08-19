<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JournalController extends Controller
{
    public function index(Request $request): View
    {
        $journals = Journal::with('journalable', 'details.account')
            ->when($request->filled('from'), fn ($query) => $query->whereDate('transaction_date', '>=', $request->from))
            ->when($request->filled('to'), fn ($query) => $query->whereDate('transaction_date', '<=', $request->to))
            ->when($request->filled('search'), fn ($query) => $query->where(function ($q) use ($request) {
                $q->where('reference', 'like', '%'.$request->search.'%')
                    ->orWhere('description', 'like', '%'.$request->search.'%');
            }))
            ->orderByDesc('transaction_date')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('journals.index', compact('journals'));
    }

    public function show(Journal $journal): View
    {
        $journal->load('journalable', 'details.account');

        return view('journals.show', compact('journal'));
    }
}
