@props([
    'items' => null,
    'empty' => 'Belum ada data.',
    'sticky' => false,
])

@php
    $isPaginator = $items && $items instanceof \Illuminate\Contracts\Pagination\Paginator;
@endphp

<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl shadow-soft border border-slate-100 overflow-hidden']) }}>
    @if (isset($header) && trim($header))
        <div {{ $header->attributes->merge(['class' => 'p-4 border-b border-slate-100']) }}>
            {{ $header }}
        </div>
    @endif

    @if (trim($slot))
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                @if (isset($head) && trim($head))
                    <thead class="bg-slate-50 border-b border-slate-100 {{ $sticky ? 'sticky top-0' : '' }}">
                        <tr>{{ $head }}</tr>
                    </thead>
                @endif
                <tbody class="divide-y divide-slate-100">
                    {{ $slot }}
                </tbody>

                @if (isset($footer) && trim($footer))
                    <tfoot class="border-t-2 border-slate-200 bg-slate-50">
                        {{ $footer }}
                    </tfoot>
                @endif
            </table>
        </div>

        @if ($isPaginator && $items->hasPages())
            <div>{{ $items->links() }}</div>
        @endif
    @else
        <div class="py-10 px-4 text-center">
            <i data-lucide="inbox" class="w-10 h-10 mx-auto mb-3 text-slate-300"></i>
            <p class="text-text-secondary">{{ $empty }}</p>
        </div>
    @endif
</div>