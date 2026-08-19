@props(['width' => 'w-1/3'])

<th {{ $attributes->merge(['class' => $width.' py-4 px-5 font-medium text-text-secondary text-left']) }}>
    {{ $slot }}
</th>