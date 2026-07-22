@if ($paginator->hasPages())
    <div class="p-4 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-3">
        <p class="text-sm text-slate-500">
            Menampilkan {{ $paginator->firstItem() }} - {{ $paginator->lastItem() }} dari {{ $paginator->total() }} data
        </p>
        
        <div class="flex items-center gap-1">
            {{-- Previous Page Button --}}
            @if ($paginator->onFirstPage())
                <button class="p-2 rounded-lg border border-slate-200 text-slate-400 cursor-not-allowed opacity-50" disabled>
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="p-2 rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50 transition-colors">
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <button class="p-2 text-slate-400 cursor-not-allowed" disabled>...</button>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <button class="w-9 h-9 rounded-lg bg-primary text-white font-medium text-sm">
                                {{ $page }}
                            </button>
                        @else
                            <a href="{{ $url }}" class="w-9 h-9 rounded-lg text-slate-600 hover:bg-slate-100 font-medium text-sm flex items-center justify-center transition-colors">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Button --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="p-2 rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50 transition-colors">
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </a>
            @else
                <button class="p-2 rounded-lg border border-slate-200 text-slate-400 cursor-not-allowed opacity-50" disabled>
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </button>
            @endif
        </div>
    </div>
@endif