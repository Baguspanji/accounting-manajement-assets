<?php

namespace App\Http\Controllers;

class StudyCaseController extends Controller
{
    public function index()
    {
        $studyCases = $this->getStudyCasesData();

        return view('study_cases.index', compact('studyCases'));
    }

    public function show($id)
    {
        $studyCases = $this->getStudyCasesData();
        $studyCase = collect($studyCases)->firstWhere('id', (int) $id);

        if (! $studyCase) {
            abort(404, 'Studi kasus tidak ditemukan');
        }

        return view('study_cases.show', compact('studyCase'));
    }

    private function getStudyCasesData()
    {
        return [
            [
                'id' => 1,
                'code' => 'Case 1',
                'title' => 'Perolehan Peralatan Kantor Tunai',
                'description' => 'Perusahaan membeli peralatan kantor secara tunai.',
                'category' => 'Perolehan',
                'level' => 'Pemula',
                'duration' => '10 menit',
                'scenario' => 'PT Sejahtera membeli peralatan kantor senilai Rp 50.000.000 secara tunai. Biaya instalasi Rp 2.000.000 dibayar tunai. Aset siap digunakan.',
                'expected_journal' => [
                    ['account' => 'Peralatan', 'debit' => 52000000, 'credit' => 0],
                    ['account' => 'Kas', 'debit' => 0, 'credit' => 52000000],
                ],
                'explanation' => 'Harga perolehan = harga beli + biaya instalasi = Rp 52.000.000. Jurnal mendebit akun Peralatan dan mengkredit Kas.',
            ],
            [
                'id' => 2,
                'code' => 'Case 2',
                'title' => 'Perolehan Kendaraan Kredit',
                'description' => 'Perusahaan membeli kendaraan operasional secara kredit.',
                'category' => 'Perolehan',
                'level' => 'Pemula',
                'duration' => '10 menit',
                'scenario' => 'PT Sejahtera membeli mobil operasional seharga Rp 250.000.000 secara kredit.',
                'expected_journal' => [
                    ['account' => 'Kendaraan', 'debit' => 250000000, 'credit' => 0],
                    ['account' => 'Utang Usaha', 'debit' => 0, 'credit' => 250000000],
                ],
                'explanation' => 'Perolehan secara kredit mengkredit Utang Usaha sebagai pengganti Kas.',
            ],
            [
                'id' => 3,
                'code' => 'Case 3',
                'title' => 'Penyusutan Metode Garis Lurus',
                'description' => 'Menghitung dan mencatat penyusutan dengan metode garis lurus.',
                'category' => 'Penyusutan',
                'level' => 'Menengah',
                'duration' => '15 menit',
                'scenario' => 'Mesin dibeli Rp 120.000.000, nilai residu Rp 20.000.000, umur manfaat 8 tahun. Hitung penyusutan tahunan.',
                'expected_journal' => [
                    ['account' => 'Beban Penyusutan', 'debit' => 12500000, 'credit' => 0],
                    ['account' => 'Akumulasi Penyusutan', 'debit' => 0, 'credit' => 12500000],
                ],
                'explanation' => 'Penyusutan = (120.000.000 - 20.000.000) / 8 = Rp 12.500.000 per tahun.',
            ],
            [
                'id' => 4,
                'code' => 'Case 4',
                'title' => 'Penyusutan Metode Saldo Menurun',
                'description' => 'Menghitung penyusutan dengan metode double declining balance.',
                'category' => 'Penyusutan',
                'level' => 'Menengah',
                'duration' => '15 menit',
                'scenario' => 'Peralatan dibeli Rp 100.000.000, umur manfaat 5 tahun. Gunakan metode saldo menurun (DDB).',
                'expected_journal' => [
                    ['account' => 'Beban Penyusutan', 'debit' => 40000000, 'credit' => 0],
                    ['account' => 'Akumulasi Penyusutan', 'debit' => 0, 'credit' => 40000000],
                ],
                'explanation' => 'Tarif DDB = 2 x (1/5) = 40%. Penyusutan tahun 1 = 40% x 100.000.000 = Rp 40.000.000.',
            ],
            [
                'id' => 5,
                'code' => 'Case 5',
                'title' => 'Penyusutan Metode Jumlah Angka Tahun',
                'description' => 'Menghitung penyusutan dengan metode sum of the year digits.',
                'category' => 'Penyusutan',
                'level' => 'Lanjut',
                'duration' => '20 menit',
                'scenario' => 'Mesin dibeli Rp 90.000.000, nilai residu Rp 10.000.000, umur manfaat 5 tahun.',
                'expected_journal' => [
                    ['account' => 'Beban Penyusutan', 'debit' => 26666667, 'credit' => 0],
                    ['account' => 'Akumulasi Penyusutan', 'debit' => 0, 'credit' => 26666667],
                ],
                'explanation' => 'Jumlah angka tahun = 5+4+3+2+1 = 15. Penyusutan tahun 1 = (5/15) x 80.000.000 = Rp 26.666.667.',
            ],
            [
                'id' => 6,
                'code' => 'Case 6',
                'title' => 'Penyusutan Metode Unit Produksi',
                'description' => 'Menghitung penyusutan berdasarkan kapasitas produksi.',
                'category' => 'Penyusutan',
                'level' => 'Lanjut',
                'duration' => '20 menit',
                'scenario' => 'Mesin dibeli Rp 80.000.000, nilai residu Rp 0, kapasitas total 100.000 unit. Produksi tahun ini 12.000 unit.',
                'expected_journal' => [
                    ['account' => 'Beban Penyusutan', 'debit' => 9600000, 'credit' => 0],
                    ['account' => 'Akumulasi Penyusutan', 'debit' => 0, 'credit' => 9600000],
                ],
                'explanation' => 'Penyusutan = 80.000.000 x (12.000/100.000) = Rp 9.600.000.',
            ],
            [
                'id' => 7,
                'code' => 'Case 7',
                'title' => 'Penjualan Aset (Laba)',
                'description' => 'Mencatat pelepasan aset yang dijual dengan laba.',
                'category' => 'Pelepasan',
                'level' => 'Lanjut',
                'duration' => '20 menit',
                'scenario' => 'Mesin harga perolehan Rp 50.000.000, akumulasi penyusutan Rp 30.000.000 (nilai buku Rp 20.000.000), dijual Rp 25.000.000 tunai.',
                'expected_journal' => [
                    ['account' => 'Akumulasi Penyusutan', 'debit' => 30000000, 'credit' => 0],
                    ['account' => 'Kas', 'debit' => 25000000, 'credit' => 0],
                    ['account' => 'Mesin', 'debit' => 0, 'credit' => 50000000],
                    ['account' => 'Laba Pelepasan Aset', 'debit' => 0, 'credit' => 5000000],
                ],
                'explanation' => 'Laba pelepasan = harga jual - nilai buku = 25.000.000 - 20.000.000 = Rp 5.000.000.',
            ],
            [
                'id' => 8,
                'code' => 'Case 8',
                'title' => 'Penghapusan Aset (Rugi)',
                'description' => 'Mencatat penghapusan aset yang rusak total.',
                'category' => 'Pelepasan',
                'level' => 'Menengah',
                'duration' => '15 menit',
                'scenario' => 'Peralatan harga perolehan Rp 20.000.000, akumulasi penyusutan Rp 15.000.000 (nilai buku Rp 5.000.000), rusak total dan dihapus.',
                'expected_journal' => [
                    ['account' => 'Akumulasi Penyusutan', 'debit' => 15000000, 'credit' => 0],
                    ['account' => 'Rugi Pelepasan Aset', 'debit' => 5000000, 'credit' => 0],
                    ['account' => 'Peralatan', 'debit' => 0, 'credit' => 20000000],
                ],
                'explanation' => 'Nilai buku yang tersisa Rp 5.000.000 menjadi beban Rugi Pelepasan Aset.',
            ],
        ];
    }
}
