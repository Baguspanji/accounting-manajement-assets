@props(['type' => 'success'])

@php
    $styles = [
        'success' => 'bg-primary-light border-primary',
        'error' => 'bg-danger-light border-danger',
        'info' => 'bg-info-light border-info',
    ];
    $icons = [
        'success' => 'check-circle',
        'error' => 'alert-circle',
        'info' => 'info',
    ];
@endphp

<div class="mb-6 p-4 border rounded-xl flex items-start gap-3 {{ $styles[$type] ?? $styles['success'] }}">
    <i data-lucide="{{ $icons[$type] ?? 'check-circle' }}" class="w-5 h-5 flex-shrink-0 mt-0.5 {{ $type === 'success' ? 'text-primary' : ($type === 'error' ? 'text-danger' : 'text-info') }}"></i>
    <div>
        <p class="font-medium text-text-primary">{{ $slot }}</p>
    </div>
</div>