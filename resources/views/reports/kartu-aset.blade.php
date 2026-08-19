@extends('layouts.app')

@section('title', 'Kartu Aset')
@section('page-title', 'Laporan')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Laporan</a>
    <span>/</span>
    <a href="{{ route('reports.index') }}" class="hover:text-primary">Semua Laporan</a>
    <span>/</span>
    <span class="text-slate-700">Kartu Aset</span>
@endsection

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-text-primary">Kartu Aset</h2>
            <p class="text-text-secondary text-sm">Detail aset beserta jadwal penyusutannya.</p>
        </div>
        <form method="GET" action="{{ route('reports.kartu-aset') }}" class="flex items-end gap-2">
            <div class="w-72">
                <x-forms.label for="asset_id">Pilih Aset</x-forms.label>
                <x-forms.select name="asset_id">
                    @foreach ($assets as $asset)
                        <option value="{{ $asset->id }}" {{ $selected?->id === $asset->id ? 'selected' : '' }}>
                            {{ $asset->name }} ({{ $asset->asset_number }})
                        </option>
                    @endforeach
                </x-forms.select>
            </div>
            <button type="submit" class="px-4 py-2.5 text-sm font-semibold text-white bg-primary rounded-xl hover:bg-primary-dark transition-colors shadow-sm flex items-center gap-2">
                <i data-lucide="filter" class="w-4 h-4"></i> Tampilkan
            </button>
            <a href="{{ route('reports.kartu-aset.pdf', request()->query()) }}" target="_blank"
                class="px-4 py-2.5 text-sm font-semibold text-primary bg-primary-light rounded-xl hover:bg-primary/15 transition-colors flex items-center gap-2">
                <i data-lucide="file-down" class="w-4 h-4"></i> Export PDF
            </a>
        </form>
    </div>

    @if (! $selected)
        <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-8 text-center text-text-secondary">
            Belum ada aset.
        </div>
    @else
        @php
            $accumulated = (float) $selected->depreciations()->where('status', 'posted')->sum('expense_amount');
            $bookValue = (float) $selected->acquisition_cost - $accumulated;
        @endphp

        <div class="bg-white rounded-2xl shadow-soft border border-slate-100 overflow-hidden mb-6">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between flex-wrap gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-primary-light rounded-xl flex items-center justify-center">
                        <i data-lucide="package" class="w-6 h-6 text-primary"></i>
                    </div>
                    <div>
                        <p class="font-bold text-text-primary">{{ $selected->name }}</p>
                        <p class="text-sm text-text-secondary">{{ $selected->asset_number }} - {{ $selected->category?->name }}</p>
                    </div>
                </div>
                @php
                    $statusColor = [
                        'active' => 'bg-primary-light text-primary',
                        'disposed' => 'bg-danger-light text-danger',
                        'written_off' => 'bg-slate-100 text-slate-600',
                        'maintenance' => 'bg-warning-light text-warning',
                    ][$selected->status] ?? 'bg-slate-100 text-slate-600';
                @endphp
                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColor }}">{{ ucwords(str_replace('_', ' ', $selected->status)) }}</span>
            </div>
            <div class="p-5 grid grid-cols-2 md:grid-cols-5 gap-4 text-sm">
                <div><p class="text-text-secondary text-xs">Harga Perolehan</p><p class="font-semibold text-text-primary">Rp {{ number_format($selected->acquisition_cost, 0, ',', '.') }}</p></div>
                <div><p class="text-text-secondary text-xs">Nilai Residu</p><p class="font-semibold text-text-primary">Rp {{ number_format($selected->residual_value, 0, ',', '.') }}</p></div>
                <div><p class="text-text-secondary text-xs">Umur Manfaat</p><p class="font-semibold text-text-primary">{{ $selected->useful_life }} tahun</p></div>
                <div><p class="text-text-secondary text-xs">Akumulasi Penyusutan</p><p class="font-semibold text-text-primary">Rp {{ number_format($accumulated, 0, ',', '.') }}</p></div>
                <div><p class="text-text-secondary text-xs">Nilai Buku</p><p class="font-semibold text-primary">Rp {{ number_format($bookValue, 0, ',', '.') }}</p></div>
            </div>
        </div>

        <x-table :items="$schedule" empty="Belum ada jadwal penyusutan untuk aset ini.">
            <x-slot:header>
                <h3 class="font-semibold text-text-primary">Jadwal Penyusutan</h3>
            </x-slot:header>
            <x-slot:head>
                <x-table.th>Periode</x-table.th>
                <x-table.th align="right">Beban Penyusutan</x-table.th>
                <x-table.th align="right">Akumulasi</x-table.th>
                <x-table.th align="right">Nilai Buku</x-table.th>
                <x-table.th>Status</x-table.th>
            </x-slot>
            @foreach ($schedule as $depreciation)
                <tr class="hover:bg-slate-50 transition-colors">
                    <x-table.td class="text-sm font-mono text-slate-600">{{ $depreciation->period }}</x-table.td>
                    <x-table.td align="right" class="text-sm text-slate-600">{{ number_format($depreciation->expense_amount, 0, ',', '.') }}</x-table.td>
                    <x-table.td align="right" class="text-sm text-slate-600">{{ number_format($depreciation->accumulated_after, 0, ',', '.') }}</x-table.td>
                    <x-table.td align="right" class="text-sm text-slate-600">{{ number_format($depreciation->book_value_after, 0, ',', '.') }}</x-table.td>
                    <x-table.td>
                        @if ($depreciation->status === 'posted')
                            <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full bg-primary-light text-primary">Posted</span>
                        @else
                            <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full bg-warning-light text-warning">Pending</span>
                        @endif
                    </x-table.td>
                </tr>
            @endforeach
        </x-table>
    @endif

    <script>lucide.createIcons();</script>
@endsection