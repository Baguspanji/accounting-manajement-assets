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

    <!-- Custom Dropdown SVG Arrow -->
    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </div>
</div>

<x-forms.error :message="$hasError ? $errors->first($name) : null" />
