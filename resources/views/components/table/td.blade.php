@props(['align' => 'left', 'relaxed' => false])

@php
    $alignClass = match ($align) {
        'right' => 'text-right',
        'center' => 'text-center',
        default => 'text-left',
    };
@endphp

<td {{ $attributes->merge(['class' => ($relaxed ? 'py-4 px-5' : 'py-3 px-4').' '.$alignClass]) }}>
    {{ $slot }}
</td>