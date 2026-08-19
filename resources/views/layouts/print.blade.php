<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Akuntansi Aset</title>
    <style>{!! app(\App\Services\PdfExportService::class)->inlineCss() !!}</style>
    <style>
        @page {
            size: A4;
            margin: 12mm;
        }
        html, body {
            background: #ffffff !important;
        }
        body {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            font-size: 12px;
        }
        .print-header {
            border-bottom: 2px solid #1e40af;
            padding-bottom: 8px;
            margin-bottom: 16px;
        }
        .print-footer {
            border-top: 1px solid #e2e8f0;
            margin-top: 24px;
            padding-top: 8px;
            font-size: 10px;
            color: #64748b;
            display: flex;
            justify-content: space-between;
        }
        table { width: 100%; border-collapse: collapse; }
        .print-table th {
            background: #eff6ff;
            border: 1px solid #e2e8f0;
            padding: 6px 8px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            text-align: left;
        }
        .print-table td {
            border: 1px solid #e2e8f0;
            padding: 6px 8px;
            font-size: 11px;
            color: #1e293b;
        }
        .print-table td.num, .print-table th.num { text-align: right; }
        .print-table tfoot td {
            background: #f8fafc;
            font-weight: 700;
            color: #0f172a;
        }
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 600;
        }
        .badge-primary { background: #dbeafe; color: #1d4ed8; }
        .badge-warning { background: #fef3c7; color: #b45309; }
        .badge-danger { background: #fee2e2; color: #b91c1c; }
        .badge-slate { background: #f1f5f9; color: #475569; }
        .section-title {
            font-size: 13px;
            font-weight: 700;
            color: #0f172a;
            margin: 14px 0 8px;
        }
    </style>
</head>
<body>
    <header class="print-header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-base font-bold" style="color:#0f172a;">Akuntansi Manajemen Aset</p>
                <p class="text-sm" style="color:#64748b;">Laporan {{ $title }}</p>
            </div>
            <div class="text-right">
                <p class="text-xs" style="color:#64748b;">Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
                <p class="text-xs" style="color:#64748b;">Oleh: {{ auth()->user()->name ?? '-' }}</p>
            </div>
        </div>
        @if ($subtitle)
            <p class="text-xs mt-1" style="color:#475569;">{{ $subtitle }}</p>
        @endif
    </header>

    <main>
        {!! $content !!}
    </main>

    <footer class="print-footer">
        <span>{{ config('app.name', 'Akuntansi Aset') }}</span>
        <span>Halaman ini dicetak melalui aplikasi Akuntansi Manajemen Aset</span>
    </footer>
</body>
</html>