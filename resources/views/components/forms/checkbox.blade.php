@props(['name' => null, 'value' => '1', 'checked' => false])

<label class="flex items-center gap-2 cursor-pointer">
    <input
        type="checkbox"
        name="{{ $name }}"
        value="{{ $value }}"
        @checked($checked)
        {{ $attributes->merge(['class' => 'w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary/30']) }}
    >
    @if ($slot->isNotEmpty())
        <span class="text-sm text-slate-600">{{ $slot }}</span>
    @endif
</label>