@props([
    'name' => null,
    'value' => null,
    'id' => null,
    'min' => null,
    'max' => null,
    'placeholder' => null,
    'format' => 'Y-m-d',
    'required' => false,
    'disabled' => false,
])

@php
    $hasError = $errors->has($name ?? '');
    $inputId = $id ?? ($name ? str_replace(['[', ']', '.'], ['-', '', '_'], (string) $name) : null);
@endphp

<div class="relative">
    <i data-lucide="calendar" class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>

    <input
        type="text"
        name="{{ $name }}"
        id="{{ $inputId }}"
        value="{{ old($name, $value) }}"
        @if ($placeholder) placeholder="{{ $placeholder }}" @endif
        @if ($required) required @endif
        @if ($disabled) disabled @endif
        readonly
        autocomplete="off"
        data-datepicker
        data-datepicker-format="{{ $format }}"
        @if ($min) data-datepicker-min="{{ $min }}" @endif
        @if ($max) data-datepicker-max="{{ $max }}" @endif
        {{ $attributes->merge([
            'class' => 'w-full pl-10 pr-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all bg-white cursor-pointer '
                . ($hasError ? 'border-danger' : 'border-slate-200'),
        ]) }}
    >
</div>

<x-forms.error :message="$hasError ? $errors->first($name) : null" />

<script>
    if (!window.__akuntansiDatepickerInit) {
        window.__akuntansiDatepickerInit = true;

        document.addEventListener('DOMContentLoaded', function () {
            if (typeof flatpickr === 'undefined') return;

            document.querySelectorAll('[data-datepicker]').forEach(function (el) {
                if (el._flatpickr) return;

                flatpickr(el, {
                    dateFormat: el.dataset.datepickerFormat || 'Y-m-d',
                    minDate: el.dataset.datepickerMin || undefined,
                    maxDate: el.dataset.datepickerMax || undefined,
                    locale: 'id',
                    allowInput: false,
                    disableMobile: true,
                    onChange: function () {
                        lucide.createIcons();
                    },
                });
            });
        });
    }
</script>