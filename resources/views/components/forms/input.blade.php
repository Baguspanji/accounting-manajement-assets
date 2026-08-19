@props(['name' => null, 'type' => 'text', 'value' => null, 'icon' => null])

@php
    $hasError = $errors->has($name ?? '');
@endphp

<div @class(['relative' => $icon])>
    @if ($icon)
        <i data-lucide="{{ $icon }}" class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        {{ $attributes->merge([
            'class' => 'w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all '
                . ($icon ? 'pl-10 ' : '')
                . ($hasError ? 'border-danger' : 'border-slate-200'),
        ]) }}
    >
</div>

<x-forms.error :message="$hasError ? $errors->first($name) : null" />