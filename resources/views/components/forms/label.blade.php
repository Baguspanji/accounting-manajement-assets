@props(['for' => null, 'required' => false])

<label {{ $attributes->merge(['for' => $for, 'class' => 'block text-sm font-medium text-slate-700 mb-1.5']) }}>
    {{ $slot }}
    @if ($required)
        <span class="text-danger">*</span>
    @endif
</label>