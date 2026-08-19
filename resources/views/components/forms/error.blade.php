@props(['message' => null])

@if ($message)
    <p class="text-xs text-danger mt-1">{{ $message }}</p>
@endif