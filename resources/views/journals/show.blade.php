@extends('layouts.app')

@section('title', 'Detail Jurnal')
@section('page-title', 'Akuntansi')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Akuntansi</a>
    <span>/</span>
    <a href="{{ route('journals.index') }}" class="hover:text-primary">Jurnal</a>
    <span>/</span>
    <span class="text-slate-700">Detail</span>
@endsection

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-text-primary">Detail Jurnal</h2>
            <p class="text-text-secondary text-sm">Referensi {{ $journal->reference }}.</p>
        </div>
        <a href="{{ route('journals.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 text-sm font-medium">
            Kembali
        </a>
    </div>

    @include('journals._detail', ['journal' => $journal])

    <script>lucide.createIcons();</script>
@endsection