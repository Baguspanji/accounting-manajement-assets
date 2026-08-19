@props(['name' => null, 'value' => null])

@php
    $hasError = $errors->has($name ?? '');
@endphp

<div class="relative">
    <select
        name="{{ $name }}"
        {{ $attributes->merge([
            'class' => 'w-full px-4 py-2.5 pr-10 appearance-none border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white transition-all '
                . ($hasError ? 'border-danger' : 'border-slate-200'),
        ]) }}
    >
        {{ $slot }}
    </select>

    <svg
        class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 20 20"
        fill="currentColor"
        aria-hidden="true"
    >
        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
    </svg>
</div>

<x-forms.error :message="$hasError ? $errors->first($name) : null" />
