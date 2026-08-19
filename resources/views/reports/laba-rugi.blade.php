@extends('layouts.app')

@section('title', 'Laporan Laba Rugi')
@section('page-title', 'Laporan')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Laporan</a>
    <span>/</span>
    <a href="{{ route('reports.index') }}" class="hover:text-primary">Semua Laporan</a>
    <span>/</span>
    <span class="text-slate-700">Laba Rugi</span>
@endsection

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-text-primary">Laba Rugi</h2>
            <p class="text-text-secondary text-sm">
                @if ($from && $to)
                    Periode {{ $from->format('d M Y') }} s.d. {{ $to->format('d M Y') }}
                @elseif ($from)
                    Mulai {{ $from->format('d M Y') }}
                @elseif ($to)
                    Hingga {{ $to->format('d M Y') }}
                @else
                    Seluruh periode
                @endif
            </p>
        </div>
        <form method="GET" action="{{ route('reports.laba-rugi') }}" class="flex items-end gap-2 flex-wrap">
            <div class="w-44">
                <x-forms.label for="from">Dari</x-forms.label>
                <x-forms.datepicker name="from" :value="$from?->format('Y-m-d')" />
            </div>
            <div class="w-44">
                <x-forms.label for="to">Sampai</x-forms.label>
                <x-forms.datepicker name="to" :value="$to?->format('Y-m-d')" />
            </div>
            <button type="submit" class="px-4 py-2.5 text-sm font-semibold text-white bg-primary rounded-xl hover:bg-primary-dark transition-colors shadow-sm flex items-center gap-2">
                <i data-lucide="filter" class="w-4 h-4"></i> Tampilkan
            </button>
        </form>
    </div>

    @php
        $revenueRows = $revenues->where('normal_balance', '!=', 0);
        $expenseRows = $expenses->where('normal_balance', '!=', 0);
    @endphp

    <div class="space-y-6">
        <x-table empty="Tidak ada pendapatan.">
            <x-slot:header>
                <h3 class="font-bold text-text-primary">Pendapatan</h3>
            </x-slot:header>
            <x-slot:head>
                <x-table.th>Kode</x-table.th>
                <x-table.th>Nama Akun</x-table.th>
                <x-table.th align="right">Jumlah</x-table.th>
            </x-slot>
            @foreach ($revenueRows as $entry)
                <tr class="hover:bg-slate-50 transition-colors">
                    <x-table.td class="text-sm font-mono text-slate-700">{{ $entry['account']->code }}</x-table.td>
                    <x-table.td class="text-sm text-text-primary">{{ $entry['account']->name }}</x-table.td>
                    <x-table.td align="right" class="text-sm text-slate-600">{{ number_format($entry['normal_balance'], 0, ',', '.') }}</x-table.td>
                </tr>
            @endforeach
            <x-slot:footer>
                <tr>
                    <x-table.td class="text-xs font-semibold uppercase tracking-wider text-text-secondary" colspan="2">Total Pendapatan</x-table.td>
                    <x-table.td align="right" class="text-sm font-bold text-text-primary">{{ number_format($revenueTotal, 0, ',', '.') }}</x-table.td>
                </tr>
            </x-slot:footer>
        </x-table>

        <x-table empty="Tidak ada beban.">
            <x-slot:header>
                <h3 class="font-bold text-text-primary">Beban</h3>
            </x-slot:header>
            <x-slot:head>
                <x-table.th>Kode</x-table.th>
                <x-table.th>Nama Akun</x-table.th>
                <x-table.th align="right">Jumlah</x-table.th>
            </x-slot>
            @foreach ($expenseRows as $entry)
                <tr class="hover:bg-slate-50 transition-colors">
                    <x-table.td class="text-sm font-mono text-slate-700">{{ $entry['account']->code }}</x-table.td>
                    <x-table.td class="text-sm text-text-primary">{{ $entry['account']->name }}</x-table.td>
                    <x-table.td align="right" class="text-sm text-slate-600">{{ number_format($entry['normal_balance'], 0, ',', '.') }}</x-table.td>
                </tr>
            @endforeach
            <x-slot:footer>
                <tr>
                    <x-table.td class="text-xs font-semibold uppercase tracking-wider text-text-secondary" colspan="2">Total Beban</x-table.td>
                    <x-table.td align="right" class="text-sm font-bold text-text-primary">{{ number_format($expenseTotal, 0, ',', '.') }}</x-table.td>
                </tr>
            </x-slot:footer>
        </x-table>

        <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-5 flex items-center justify-between">
            <div>
                <p class="text-xs text-text-secondary">Laba / Rugi Bersih</p>
                <p class="text-lg font-bold {{ $netIncome >= 0 ? 'text-primary' : 'text-danger' }}">{{ $netIncome >= 0 ? 'Laba' : 'Rugi' }}</p>
            </div>
            <p class="text-2xl font-bold {{ $netIncome >= 0 ? 'text-primary' : 'text-danger' }}">Rp {{ number_format(abs($netIncome), 0, ',', '.') }}</p>
        </div>
    </div>

    <script>lucide.createIcons();</script>
@endsection