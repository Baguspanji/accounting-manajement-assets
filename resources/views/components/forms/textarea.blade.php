@props(['name' => null, 'value' => null, 'rows' => 3])

@php
    $hasError = $errors->has($name ?? '');
@endphp

<textarea
    name="{{ $name }}"
    rows="{{ $rows }}"
    {{ $attributes->merge([
        'class' => 'w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary resize-none transition-all '
            . ($hasError ? 'border-danger' : 'border-slate-200'),
    ]) }}
>{{ old($name, $value) }}</textarea>

<x-forms.error :message="$hasError ? $errors->first($name) : null" />