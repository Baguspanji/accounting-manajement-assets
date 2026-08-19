@extends('layouts.app')

@section('title', $document['title'])
@section('page-title', 'Dokumentasi Pemakaian')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Home</a>
    <span>/</span>
    <a href="{{ route('documentation.index') }}" class="hover:text-primary">Dokumentasi</a>
    <span>/</span>
    <span class="text-text-secondary">{{ $document['title'] }}</span>
@endsection

@section('content')
    <div class="mb-6 flex items-start justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-primary-light text-primary">{{ $document['category'] }}</span>
                <span class="flex items-center gap-1 text-sm text-text-secondary">
                    <i data-lucide="clock" class="w-4 h-4"></i> {{ $document['updated_at'] }}
                </span>
            </div>
            <h1 class="text-3xl font-bold text-text-primary">{{ $document['title'] }}</h1>
            <p class="text-text-secondary mt-2">{{ $document['description'] }}</p>
        </div>
        <a href="{{ route('documentation.index') }}" class="px-4 py-2 border border-slate-200 text-text-secondary rounded-xl hover:bg-slate-50 text-sm font-medium flex items-center gap-2 shrink-0">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>
    </div>

    <div class="max-w-4xl bg-surface rounded-2xl shadow-soft border border-slate-100 p-6 md:p-8">
        @foreach($document['content'] as $block)
            @switch($block['type'])
                @case('heading')
                    <h2 class="text-xl font-bold text-text-primary mb-4 mt-2">{{ $block['text'] }}</h2>
                    @break
                @case('paragraph')
                    <p class="text-text-secondary leading-relaxed mb-4">{{ $block['text'] }}</p>
                    @break
                @case('list')
                    <ol class="space-y-2 mb-4">
                        @foreach($block['items'] as $item)
                            <li class="flex items-start gap-2 text-text-secondary leading-relaxed">
                                <i data-lucide="check-circle" class="w-4 h-4 text-primary mt-1 shrink-0"></i>
                                <span>{{ $item }}</span>
                            </li>
                        @endforeach
                    </ol>
                    @break
                @case('table')
                    <div class="overflow-x-auto mb-4 rounded-xl border border-slate-100">
                        <table class="w-full text-sm">
                            <thead class="bg-slate-50">
                                <tr>
                                    @foreach($block['headers'] as $header)
                                        <th class="text-left py-2.5 px-3 text-text-secondary font-semibold">{{ $header }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($block['rows'] as $row)
                                    <tr>
                                        @foreach($row as $cell)
                                            <td class="py-2.5 px-3 text-text-primary">{{ $cell }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @break
                @case('callout')
                    <div class="mb-4 p-4 bg-primary-light border border-primary/20 rounded-xl flex items-start gap-3">
                        <i data-lucide="lightbulb" class="w-5 h-5 text-primary mt-0.5 shrink-0"></i>
                        <p class="text-sm text-text-primary leading-relaxed">{{ $block['text'] }}</p>
                    </div>
                    @break
            @endswitch
        @endforeach
    </div>

    <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-between">
        <a href="{{ route('documentation.index') }}" class="px-5 py-2.5 border border-slate-200 text-text-secondary rounded-xl hover:bg-slate-50 text-sm font-medium">
            Daftar Dokumentasi
        </a>
        <a href="{{ route('dashboard') }}" class="px-5 py-2.5 bg-primary text-white rounded-xl font-semibold hover:bg-primary-dark transition-colors shadow-sm flex items-center gap-2">
            Kembali ke Dashboard <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
    </div>

    <script>lucide.createIcons();</script>
@endsection