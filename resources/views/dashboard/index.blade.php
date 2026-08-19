@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb')
    <a href="#" class="hover:text-primary">Home</a>
    <span>/</span>
    <span class="text-slate-700">Dashboard</span>
@endsection

@section('content')
    @php
        $statusMeta = [
            'active' => ['label' => 'Aktif', 'class' => 'bg-primary-light text-primary'],
            'maintenance' => ['label' => 'Perawatan', 'class' => 'bg-warning-light text-warning'],
            'disposed' => ['label' => 'Dilepas', 'class' => 'bg-slate-100 text-slate-600'],
            'written_off' => ['label' => 'Dihapus', 'class' => 'bg-danger-light text-danger'],
        ];
        $journalType = fn ($reference) => str_starts_with($reference, 'ACQ') ? 'Perolehan'
            : (str_starts_with($reference, 'DEP') ? 'Penyusutan'
                : (str_starts_with($reference, 'DSP') ? 'Pelepasan' : 'Lainnya'));
    @endphp

    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-text-primary">Selamat Datang, {{ auth()->user()->name ?? 'Admin' }}</h2>
            <p class="text-text-secondary">Ringkasan manajemen aset tetap, {{ now()->translatedFormat('l, d F Y') }}.</p>
        </div>
        <a href="{{ route('reports.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-primary rounded-xl hover:bg-primary-dark transition-colors shadow-sm">
            <i data-lucide="file-text" class="w-4 h-4"></i> Lihat Laporan
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-5 rounded-2xl shadow-soft border border-slate-100">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-primary-light rounded-xl">
                    <i data-lucide="package" class="w-6 h-6 text-primary"></i>
                </div>
                <span class="text-xs font-medium text-primary bg-primary-light px-2 py-1 rounded-full">Register</span>
            </div>
            <h3 class="text-text-secondary text-sm">Total Aset</h3>
            <p class="text-2xl font-bold text-text-primary">{{ $assets->count() }}</p>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-soft border border-slate-100">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-info-light rounded-xl">
                    <i data-lucide="badge-dollar-sign" class="w-6 h-6 text-info"></i>
                </div>
            </div>
            <h3 class="text-text-secondary text-sm">Nilai Perolehan</h3>
            <p class="text-2xl font-bold text-text-primary">Rp {{ number_format($totalCost, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-soft border border-slate-100">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-warning-light rounded-xl">
                    <i data-lucide="trending-down" class="w-6 h-6 text-warning"></i>
                </div>
            </div>
            <h3 class="text-text-secondary text-sm">Akumulasi Penyusutan</h3>
            <p class="text-2xl font-bold text-text-primary">Rp {{ number_format($totalAccumulated, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-soft border border-slate-100">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-slate-100 rounded-xl">
                    <i data-lucide="scale" class="w-6 h-6 text-slate-600"></i>
                </div>
            </div>
            <h3 class="text-text-secondary text-sm">Nilai Buku</h3>
            <p class="text-2xl font-bold text-text-primary">Rp {{ number_format($bookValue, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-5">
            <h3 class="font-bold text-text-primary mb-4 flex items-center gap-2">
                <i data-lucide="activity" class="w-4 h-4 text-primary"></i> Status Aset
            </h3>
            <div class="space-y-3">
                @forelse ($statusCounts as $status => $count)
                    @php $meta = $statusMeta[$status] ?? ['label' => ucwords($status), 'class' => 'bg-slate-100 text-slate-600']; @endphp
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-text-secondary">{{ $meta['label'] }}</span>
                        <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full {{ $meta['class'] }}">{{ $count }}</span>
                    </div>
                @empty
                    <p class="text-sm text-text-secondary">Belum ada data aset.</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-5">
            <h3 class="font-bold text-text-primary mb-4 flex items-center gap-2">
                <i data-lucide="calendar-clock" class="w-4 h-4 text-primary"></i> Penyusutan
            </h3>
            <div class="space-y-3 text-sm">
                <div class="flex items-center justify-between">
                    <span class="text-text-secondary">Beban Bulan Ini</span>
                    <span class="font-semibold text-text-primary">Rp {{ number_format($currentPeriodExpense, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-text-secondary">Menunggu Posting</span>
                    <span class="font-semibold {{ $pendingCount > 0 ? 'text-warning' : 'text-text-primary' }}">{{ $pendingCount }} periode</span>
                </div>
            </div>
            <a href="{{ route('depreciations.index') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-primary hover:text-primary-dark">
                Buka Penyusutan <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-5">
            <h3 class="font-bold text-text-primary mb-4 flex items-center gap-2">
                <i data-lucide="zap" class="w-4 h-4 text-primary"></i> Aksi Cepat
            </h3>
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('acquisitions.create') }}" class="px-3 py-2.5 rounded-xl border border-slate-200 text-sm font-medium text-text-primary hover:border-primary hover:text-primary transition-colors text-center">
                    Perolehan Aset
                </a>
                <a href="{{ route('disposals.create') }}" class="px-3 py-2.5 rounded-xl border border-slate-200 text-sm font-medium text-text-primary hover:border-primary hover:text-primary transition-colors text-center">
                    Pelepasan Aset
                </a>
                <a href="{{ route('assets.create') }}" class="px-3 py-2.5 rounded-xl border border-slate-200 text-sm font-medium text-text-primary hover:border-primary hover:text-primary transition-colors text-center">
                    Tambah Aset
                </a>
                <a href="{{ route('trial-balance.index') }}" class="px-3 py-2.5 rounded-xl border border-slate-200 text-sm font-medium text-text-primary hover:border-primary hover:text-primary transition-colors text-center">
                    Neraca Saldo
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <x-table :items="$categorySummaries" empty="Belum ada aset yang tercatat.">
            <x-slot:header>
                <h3 class="font-bold text-text-primary">Aset per Kategori</h3>
            </x-slot:header>
            <x-slot:head>
                <x-table.th>Kode</x-table.th>
                <x-table.th>Kategori</x-table.th>
                <x-table.th align="right">Jumlah</x-table.th>
                <x-table.th align="right">Nilai Buku</x-table.th>
            </x-slot>

            @foreach ($categorySummaries as $summary)
                <tr class="hover:bg-slate-50 transition-colors">
                    <x-table.td class="text-sm font-mono text-slate-700">{{ $summary['category']->code }}</x-table.td>
                    <x-table.td class="text-sm font-medium text-text-primary">{{ $summary['category']->name }}</x-table.td>
                    <x-table.td align="right" class="text-sm text-slate-600">{{ $summary['count'] }}</x-table.td>
                    <x-table.td align="right" class="text-sm text-slate-600">{{ number_format($summary['book_value'], 0, ',', '.') }}</x-table.td>
                </tr>
            @endforeach

            <x-slot:footer>
                <tr>
                    <x-table.td class="text-xs font-semibold uppercase tracking-wider text-text-secondary" colspan="2">Total</x-table.td>
                    <x-table.td align="right" class="text-sm font-bold text-text-primary">{{ $categorySummaries->sum('count') }}</x-table.td>
                    <x-table.td align="right" class="text-sm font-bold text-text-primary">{{ number_format($categorySummaries->sum('book_value'), 0, ',', '.') }}</x-table.td>
                </tr>
            </x-slot:footer>
        </x-table>

        <x-table :items="$recentJournals" empty="Belum ada jurnal.">
            <x-slot:header>
                <h3 class="font-bold text-text-primary">Jurnal Terbaru</h3>
            </x-slot:header>
            <x-slot:head>
                <x-table.th>Referensi</x-table.th>
                <x-table.th>Tanggal</x-table.th>
                <x-table.th>Keterangan</x-table.th>
                <x-table.th>Jenis</x-table.th>
            </x-slot>

            @foreach ($recentJournals as $journal)
                <tr class="hover:bg-slate-50 transition-colors">
                    <x-table.td>
                        <a href="{{ route('journals.show', $journal) }}" class="text-sm font-mono font-medium text-primary hover:underline">{{ $journal->reference }}</a>
                    </x-table.td>
                    <x-table.td class="text-sm text-slate-600">{{ $journal->transaction_date->format('d M Y') }}</x-table.td>
                    <x-table.td class="text-sm text-slate-600">{{ $journal->relatedLabel() ?? '-' }}</x-table.td>
                    <x-table.td>
                        <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full bg-slate-100 text-slate-600">{{ $journalType($journal->reference) }}</span>
                    </x-table.td>
                </tr>
            @endforeach
        </x-table>
    </div>

    <x-table :items="$assets->take(5)" empty="Belum ada aset yang tercatat.">
        <x-slot:header>
            <h3 class="font-bold text-text-primary">Aset Terbaru</h3>
        </x-slot:header>
        <x-slot:head>
            <x-table.th>Nomor Aset</x-table.th>
            <x-table.th>Nama Aset</x-table.th>
            <x-table.th>Kategori</x-table.th>
            <x-table.th align="right">Nilai Perolehan</x-table.th>
            <x-table.th>Status</x-table.th>
        </x-slot>

        @foreach ($assets->take(5) as $asset)
            <tr class="hover:bg-slate-50 transition-colors">
                <x-table.td>
                    <a href="{{ route('assets.show', $asset) }}" class="text-sm font-mono font-medium text-primary hover:underline">{{ $asset->asset_number }}</a>
                </x-table.td>
                <x-table.td class="text-sm font-medium text-text-primary">{{ $asset->name }}</x-table.td>
                <x-table.td class="text-sm text-slate-600">{{ $asset->category?->name ?? '-' }}</x-table.td>
                <x-table.td align="right" class="text-sm text-slate-600">{{ number_format($asset->acquisition_cost, 0, ',', '.') }}</x-table.td>
                <x-table.td>
                    @php $meta = $statusMeta[$asset->status] ?? ['label' => ucwords($asset->status), 'class' => 'bg-slate-100 text-slate-600']; @endphp
                    <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full {{ $meta['class'] }}">{{ $meta['label'] }}</span>
                </x-table.td>
            </tr>
        @endforeach
    </x-table>

    <script>lucide.createIcons();</script>
@endsection