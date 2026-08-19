<?php

namespace App\Http\Controllers;

use App\Services\PdfExportService;
use App\Services\ReportDataService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportExportController extends Controller
{
    public function __construct(
        private readonly ReportDataService $reportData,
        private readonly PdfExportService $pdf,
    ) {}

    public function neraca(Request $request): BinaryFileResponse
    {
        $asOf = $request->filled('as_of') ? Carbon::parse($request->as_of) : null;
        $data = $this->reportData->neraca($asOf);

        return $this->pdf->fromView('reports.print.neraca', $data, [
            'title' => 'Neraca',
            'subtitle' => $asOf ? 'Posisi keuangan per '.$asOf->format('d M Y') : 'Posisi keuangan seluruh transaksi tercatat',
            'filename' => 'laporan-neraca-'.($asOf?->format('Y-m-d') ?? 'all').'.pdf',
        ]);
    }

    public function labaRugi(Request $request): BinaryFileResponse
    {
        $from = $request->filled('from') ? Carbon::parse($request->from) : null;
        $to = $request->filled('to') ? Carbon::parse($request->to) : null;
        $data = $this->reportData->labaRugi($from, $to);

        $subtitle = 'Seluruh periode';
        if ($from && $to) {
            $subtitle = 'Periode '.$from->format('d M Y').' s.d. '.$to->format('d M Y');
        } elseif ($from) {
            $subtitle = 'Mulai '.$from->format('d M Y');
        } elseif ($to) {
            $subtitle = 'Hingga '.$to->format('d M Y');
        }

        return $this->pdf->fromView('reports.print.laba-rugi', $data, [
            'title' => 'Laba Rugi',
            'subtitle' => $subtitle,
            'filename' => 'laporan-laba-rugi.pdf',
        ]);
    }

    public function kategori(): BinaryFileResponse
    {
        $data = $this->reportData->kategori();

        return $this->pdf->fromView('reports.print.kategori', ['categories' => $data], [
            'title' => 'Nilai Buku per Kategori',
            'subtitle' => 'Ringkasan harga perolehan, akumulasi penyusutan, dan nilai buku per kategori aset',
            'filename' => 'laporan-nilai-buku-kategori.pdf',
        ]);
    }

    public function kartuAset(Request $request): BinaryFileResponse
    {
        $data = $this->reportData->kartuAset($request->filled('asset_id') ? (int) $request->asset_id : null);
        $selected = $data['selected'];

        $subtitle = $selected
            ? 'Kartu aset: '.$selected->name.' ('.$selected->asset_number.')'
            : 'Belum ada aset yang tercatat';

        return $this->pdf->fromView('reports.print.kartu-aset', $data, [
            'title' => 'Kartu Aset',
            'subtitle' => $subtitle,
            'filename' => 'laporan-kartu-aset.pdf',
        ]);
    }

    public function jadwalPenyusutan(): BinaryFileResponse
    {
        $data = $this->reportData->jadwalPenyusutan();

        return $this->pdf->fromView('reports.print.jadwal-penyusutan', $data, [
            'title' => 'Jadwal Penyusutan',
            'subtitle' => 'Beban penyusutan seluruh aset per periode',
            'filename' => 'laporan-jadwal-penyusutan.pdf',
        ]);
    }

    public function pelepasan(): BinaryFileResponse
    {
        $data = $this->reportData->pelepasan();

        return $this->pdf->fromView('reports.print.pelepasan', $data, [
            'title' => 'Pelepasan Aset',
            'subtitle' => 'Penjualan, penghapusan, dan transfer aset beserta laba/ruginya',
            'filename' => 'laporan-pelepasan-aset.pdf',
        ]);
    }

    public function arusKas(): BinaryFileResponse
    {
        $data = $this->reportData->arusKas();

        return $this->pdf->fromView('reports.print.arus-kas', $data, [
            'title' => 'Arus Kas',
            'subtitle' => 'Arus kas masuk dan keluar akun Kas per periode',
            'filename' => 'laporan-arus-kas.pdf',
        ]);
    }
}
