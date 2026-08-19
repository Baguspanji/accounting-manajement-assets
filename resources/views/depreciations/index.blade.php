@extends('layouts.app')

@section('title', 'Penyusutan')
@section('page-title', 'Transaksi')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Transaksi</a>
    <span>/</span>
    <span class="text-slate-700">Penyusutan</span>
@endsection

@section('content')
    <div class="mb-6">
        <h2 class="text-xl font-bold text-text-primary">Penyusutan Aset</h2>
        <p class="text-text-secondary text-sm">Hitung dan posting penyusutan per periode untuk seluruh aset aktif.</p>
    </div>

    @if (Session::has('success'))
        <x-flash type="success">{{ Session::get('success') }}</x-flash>
    @endif
    @if (Session::has('info'))
        <x-flash type="info">{{ Session::get('info') }}</x-flash>
    @endif
    @if (Session::has('error'))
        <x-flash type="error">{{ Session::get('error') }}</x-flash>
    @endif

    @if ($errors->any())
        <div class="mb-6 p-4 bg-danger-light border border-danger rounded-xl flex items-start gap-3">
            <i data-lucide="alert-circle" class="w-5 h-5 text-danger shrink-0 mt-0.5"></i>
            <div class="space-y-1">
                <p class="font-medium text-text-primary">Periksa kembali data berikut:</p>
                @foreach ($errors->all() as $error)
                    <p class="text-sm text-slate-600">- {{ $error }}</p>
                @endforeach
            </div>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-end gap-4">
            <div class="w-full md:w-96">
                <x-forms.label for="month">Bulan</x-forms.label>
                @php $monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']; @endphp
                <x-forms.select name="month" id="month">
                    @foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12] as $m)
                        <option value="{{ $m }}" {{ $period && (int) substr($period, 5, 2) === $m ? 'selected' : '' }}>
                            {{ $monthNames[$m - 1] }}
                        </option>
                    @endforeach
                </x-forms.select>
            </div>
            <div class="w-full md:w-40">
                <x-forms.label for="year">Tahun</x-forms.label>
                <x-forms.select name="year" id="year">
                    @foreach (range(now()->year, now()->year - 4) as $y)
                        <option value="{{ $y }}" {{ $period && (int) substr($period, 0, 4) === $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </x-forms.select>
            </div>
            <div class="flex gap-3">
                <form method="POST" action="{{ route('depreciations.run') }}" id="form-run">
                    @csrf
                    <input type="hidden" name="period" value="{{ $period ?? now()->format('Y-m') }}">
                    <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-primary rounded-xl hover:bg-primary-dark transition-colors shadow-sm flex items-center gap-2">
                        <i data-lucide="play" class="w-4 h-4"></i>
                        Jalankan Penyusutan
                    </button>
                </form>
                <form method="POST" action="{{ route('depreciations.post') }}" id="form-post">
                    @csrf
                    <input type="hidden" name="period" value="{{ $period ?? now()->format('Y-m') }}">
                    <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-warning rounded-xl hover:bg-warning/90 transition-colors shadow-sm flex items-center gap-2">
                        <i data-lucide="check-check" class="w-4 h-4"></i>
                        Posting Jurnal
                    </button>
                </form>
            </div>
        </div>
        <p class="text-xs text-text-secondary mt-2">
            <i data-lucide="info" class="w-3.5 h-3.5 inline"></i>
            Periode aktif: <span class="font-medium text-text-primary">{{ $period ?? now()->format('Y-m') }}</span>.
            "Jalankan" membuat catatan penyusutan (pending), "Posting" membuat jurnal & memfinalisasi.
        </p>
    </div>

<x-table :items="$depreciations" empty="Belum ada data penyusutan. Pilih periode lalu klik &quot;Jalankan Penyusutan&quot;.">
        <x-slot:header>
            <h3 class="font-semibold text-text-primary">Riwayat Penyusutan</h3>
            @if ($periods->isNotEmpty())
                <div class="flex items-center gap-2 text-sm">
                    <span class="text-text-secondary">Periode:</span>
                    @foreach ($periods as $p)
                        <a href="{{ route('depreciations.index', ['period' => $p]) }}"
                           class="px-3 py-1 rounded-lg font-mono text-xs {{ $period === $p ? 'bg-primary text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            {{ $p }}
                        </a>
                    @endforeach
                </div>
            @endif
        </x-slot:header>

        <x-slot:head>
            <x-table.th>Aset</x-table.th>
            <x-table.th>Periode</x-table.th>
            <x-table.th align="right">Beban Penyusutan</x-table.th>
            <x-table.th align="right">Akumulasi</x-table.th>
            <x-table.th align="right">Nilai Buku</x-table.th>
            <x-table.th>Status</x-table.th>
        </x-slot>

        @foreach ($depreciations as $depreciation)
            <tr class="hover:bg-slate-50 transition-colors">
                <x-table.td>
                    <p class="font-medium text-text-primary text-sm">{{ $depreciation->asset?->name }}</p>
                    <p class="text-xs text-text-secondary">{{ $depreciation->asset?->asset_number }}</p>
                </x-table.td>
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

    <script>
        document.getElementById('month')?.addEventListener('change', syncPeriod);
        document.getElementById('year')?.addEventListener('change', syncPeriod);
        function syncPeriod() {
            const month = document.getElementById('month').value.padStart(2, '0');
            const year = document.getElementById('year').value;
            const period = year + '-' + month;
            document.getElementById('form-run').querySelector('input[name="period"]').value = period;
            document.getElementById('form-post').querySelector('input[name="period"]').value = period;
        }
        lucide.createIcons();
    </script>
@endsection
