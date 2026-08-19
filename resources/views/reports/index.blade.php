@extends('layouts.app')

@section('title', 'Laporan')
@section('page-title', 'Laporan')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Laporan</a>
    <span>/</span>
    <span class="text-slate-700">Semua Laporan</span>
@endsection

@section('content')
    <div class="mb-6">
        <h2 class="text-xl font-bold text-text-primary">Laporan</h2>
        <p class="text-text-secondary text-sm">Ringkasan finansial dan laporan manajemen aset.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @php
            $cards = [
                ['label' => 'Total Aset', 'value' => $summary['assets'], 'icon' => 'building-2', 'color' => 'text-primary bg-primary-light'],
                ['label' => 'Total Liabilitas', 'value' => $summary['liabilities'], 'icon' => 'hand-coins', 'color' => 'text-danger bg-danger-light'],
                ['label' => 'Ekuitas', 'value' => $summary['equity'], 'icon' => 'piggy-bank', 'color' => 'text-info bg-info-light'],
                ['label' => 'Pendapatan', 'value' => $summary['revenue'], 'icon' => 'trending-up', 'color' => 'text-warning bg-warning-light'],
                ['label' => 'Beban', 'value' => $summary['expense'], 'icon' => 'trending-down', 'color' => 'text-text-secondary bg-slate-100'],
                ['label' => 'Laba Bersih', 'value' => $summary['net_income'], 'icon' => 'badge-dollar-sign', 'color' => $summary['net_income'] >= 0 ? 'text-primary bg-primary-light' : 'text-danger bg-danger-light'],
            ];
        @endphp
        @foreach ($cards as $card)
            <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-5">
                <div class="flex items-center gap-4">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center {{ $card['color'] }}">
                        <i data-lucide="{{ $card['icon'] }}" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="text-xs text-text-secondary">{{ $card['label'] }}</p>
                        <p class="text-lg font-bold text-text-primary">Rp {{ number_format($card['value'], 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @php
            $reports = [
                ['title' => 'Neraca', 'desc' => 'Posisi keuangan per tanggal (aset, liabilitas, ekuitas).', 'icon' => 'bar-chart-3', 'route' => route('reports.neraca')],
                ['title' => 'Laba Rugi', 'desc' => 'Pendapatan, beban, dan laba/rugi periode.', 'icon' => 'trending-up', 'route' => route('reports.laba-rugi')],
                ['title' => 'Arus Kas', 'desc' => 'Arus kas masuk dan keluar per periode.', 'icon' => 'wallet', 'route' => route('reports.arus-kas')],
                ['title' => 'Nilai Buku per Kategori', 'desc' => 'Harga perolehan, akumulasi, dan nilai buku per kategori.', 'icon' => 'folder', 'route' => route('reports.kategori')],
                ['title' => 'Kartu Aset', 'desc' => 'Detail aset beserta jadwal penyusutannya.', 'icon' => 'file-text', 'route' => route('reports.kartu-aset')],
                ['title' => 'Jadwal Penyusutan', 'desc' => 'Beban penyusutan seluruh aset per periode.', 'icon' => 'calendar', 'route' => route('reports.jadwal-penyusutan')],
                ['title' => 'Pelepasan Aset', 'desc' => 'Penjualan, penghapusan, dan laba/rugi pelepasan.', 'icon' => 'package-minus', 'route' => route('reports.pelepasan')],
            ];
        @endphp
        @foreach ($reports as $report)
            <a href="{{ $report['route'] }}" class="bg-white rounded-2xl shadow-soft border border-slate-100 p-5 hover:border-primary/40 hover:shadow-md transition-all group">
                <div class="w-11 h-11 bg-primary-light rounded-xl flex items-center justify-center mb-3 group-hover:bg-primary group-hover:text-white transition-colors">
                    <i data-lucide="{{ $report['icon'] }}" class="w-5 h-5 text-primary group-hover:text-white"></i>
                </div>
                <h3 class="font-bold text-text-primary">{{ $report['title'] }}</h3>
                <p class="text-sm text-text-secondary mt-1">{{ $report['desc'] }}</p>
            </a>
        @endforeach
    </div>

    <script>lucide.createIcons();</script>
@endsection