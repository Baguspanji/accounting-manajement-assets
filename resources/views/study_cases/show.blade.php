@extends('layouts.app')

@section('title', $studyCase['title'])
@section('page-title', 'Studi Kasus')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Home</a>
    <span>/</span>
    <a href="{{ route('study-cases.index') }}" class="hover:text-primary">Studi Kasus</a>
    <span>/</span>
    <span class="text-slate-700">{{ $studyCase['code'] }}</span>
@endsection

@section('content')
    <div class="mb-6">
        <div class="flex items-start justify-between">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">{{ $studyCase['code'] }}</span>
                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full 
                        @switch($studyCase['level'])
                            @case('Pemula') bg-green-100 text-green-700 @break
                            @case('Menengah') bg-yellow-100 text-yellow-700 @break
                            @case('Lanjut') bg-red-100 text-red-700 @break
                        @endswitch">
                        {{ $studyCase['level'] }}
                    </span>
                </div>
                <h2 class="text-2xl font-bold text-slate-800">{{ $studyCase['title'] }}</h2>
                <p class="text-slate-500 mt-1">{{ $studyCase['description'] }}</p>
            </div>
            <a href="{{ route('study-cases.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 text-sm font-medium">
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-6">
                <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <i data-lucide="file-text" class="w-5 h-5 text-primary"></i>
                    Skenario Kasus
                </h3>
                <p class="text-slate-600 leading-relaxed">{{ $studyCase['scenario'] }}</p>
            </div>

            <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-6">
                <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <i data-lucide="book-open" class="w-5 h-5 text-primary"></i>
                    Entri Jurnal yang Diharapkan
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="text-left py-2 px-3 text-slate-600 font-medium">Akun</th>
                                <th class="text-right py-2 px-3 text-slate-600 font-medium">Debit</th>
                                <th class="text-right py-2 px-3 text-slate-600 font-medium">Kredit</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($studyCase['expected_journal'] as $entry)
                            <tr>
                                <td class="py-2 px-3 text-slate-700">{{ $entry['account'] }}</td>
                                <td class="py-2 px-3 text-right text-slate-700">{{ $entry['debit'] > 0 ? 'Rp ' . number_format($entry['debit'], 0, ',', '.') : '-' }}</td>
                                <td class="py-2 px-3 text-right text-slate-700">{{ $entry['credit'] > 0 ? 'Rp ' . number_format($entry['credit'], 0, ',', '.') : '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-6">
                <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <i data-lucide="clipboard-list" class="w-5 h-5 text-primary"></i>
                    Detail Kasus
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Kategori</span>
                        <span class="font-medium text-slate-800">{{ $studyCase['category'] }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Durasi</span>
                        <span class="font-medium text-slate-800">{{ $studyCase['duration'] }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-primary-light rounded-2xl p-6 border border-primary/20">
                <h3 class="font-bold text-slate-800 mb-3 flex items-center gap-2">
                    <i data-lucide="lightbulb" class="w-5 h-5 text-primary"></i>
                    Penjelasan
                </h3>
                <p class="text-sm text-slate-600 leading-relaxed">{{ $studyCase['explanation'] }}</p>
            </div>

            <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-6">
                <h3 class="font-bold text-slate-800 mb-4">Latihan Praktik</h3>
                <p class="text-sm text-slate-500 mb-4">Kerjakan studi kasus ini dengan menginput transaksi di sistem.</p>
                <button type="button" class="w-full block text-center bg-primary text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-primary-dark transition-colors shadow-sm mb-2">
                    Input Perolehan Aset
                </button>
                <button type="button" class="w-full block text-center border border-primary text-primary py-2.5 rounded-xl text-sm font-semibold hover:bg-primary-light transition-colors">
                    Input Penyusutan
                </button>
            </div>
        </div>
    </div>

    <script>lucide.createIcons();</script>
@endsection