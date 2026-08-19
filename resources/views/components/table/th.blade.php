@props(['align' => 'left'])

@php
    $alignClass = match ($align) {
        'right' => 'text-right',
        'center' => 'text-center',
        default => 'text-left',
    };
@endphp

<th {{ $attributes->merge(['class' => 'py-3 px-4 text-xs font-semibold text-text-secondary uppercase tracking-wider '.$alignClass]) }}>
    {{ $slot }}
</th>