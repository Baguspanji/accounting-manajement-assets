<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Akuntansi Aset</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css">
    <style>
        .custom-scroll::-webkit-scrollbar { width: 5px; height: 5px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

        .flatpickr-calendar { border-radius: 1rem; box-shadow: 0 10px 40px -10px rgba(30, 41, 59, 0.25); }
        .flatpickr-day.selected,
        .flatpickr-day.startRange,
        .flatpickr-day.endRange {
            background: #2563eb;
            border-color: #2563eb;
        }
        .flatpickr-day.selected:hover { background: #1d4ed8; border-color: #1d4ed8; }
        .flatpickr-day.today { border-color: #2563eb; }
        .flatpickr-day.today:hover { background: #dbeafe; border-color: #2563eb; }
        .flatpickr-day:hover { background: #dbeafe; }
        .flatpickr-day.inRange,
        .flatpickr-prev-month:hover svg,
        .flatpickr-next-month:hover svg { fill: #dbeafe; }
        .flatpickr-prev-month:hover svg,
        .flatpickr-next-month:hover svg { color: #2563eb; }
        .flatpickr-month .flatpickr-current-month { font-weight: 600; color: #1e293b; }
        .flatpickr-weekday { font-weight: 600; color: #64748b; }
        .flatpickr-day.flatpickr-disabled,
        .flatpickr-day.prevMonthDay,
        .flatpickr-day.nextMonthDay { color: #cbd5e1; }
        .flatpickr-day.today.selected { color: #fff; }
    </style>
</head>
<body class="bg-background text-text-primary antialiased">
    <div class="flex h-screen overflow-hidden">
        @include('layouts.sidebar')
        <div class="flex-1 flex flex-col overflow-hidden">
            @include('layouts.header')
            <main class="flex-1 overflow-y-auto custom-scroll p-6">
                @yield('content')
            </main>
        </div>
    </div>
    <script>lucide.createIcons();</script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/l10n/id.js"></script>
</body>
</html>
