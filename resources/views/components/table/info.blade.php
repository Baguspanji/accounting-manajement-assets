@props(['title' => null])

<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl shadow-soft border border-slate-100 overflow-hidden']) }}>
    @if ($title)
        <div class="p-5 border-b border-slate-100">
            <h3 class="font-bold text-text-primary">{{ $title }}</h3>
        </div>
    @endif
    <div class="p-0">
        <table class="w-full text-sm text-left">
            <tbody class="divide-y divide-slate-100">
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>