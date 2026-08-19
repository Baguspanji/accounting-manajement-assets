<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudyCaseController extends Controller
{
    public function index()
    {
        $studyCases = [
            [
                'id' => 1,
                'code' => 'Case 1',
                'title' => 'Penyetoran Simpanan Rp 500.000',
                'description' => 'Simulasi penyetoran simpanan pokok/wajib anggota ke koperasi.',
                'category' => 'Simpanan',
                'level' => 'Pemula',
                'duration' => '10 menit',
                'progress' => 0,
                'akad' => 'Wadiah',
            ],
            [
                'id' => 2,
                'code' => 'Case 2',
                'title' => 'Simpanan Wajib Bulanan',
                'description' => 'Anggota melakukan setoran simpanan wajib bulanan.',
                'category' => 'Simpanan',
                'level' => 'Pemula',
                'duration' => '10 menit',
                'progress' => 0,
                'akad' => '-',
            ],
            [
                'id' => 3,
                'code' => 'Case 3',
                'title' => 'Pembiayaan Murabahah Motor Rp 20.000.000',
                'description' => 'Anggota membeli motor melalui akad Murabahah dengan margin 15%.',
                'category' => 'Pembiayaan',
                'level' => 'Menengah',
                'duration' => '20 menit',
                'progress' => 0,
                'akad' => 'Murabahah',
            ],
            [
                'id' => 4,
                'code' => 'Case 4',
                'title' => 'Pembiayaan Murabahah Laptop Rp 8.000.000',
                'description' => 'Anggota membeli laptop untuk usaha melalui akad Murabahah.',
                'category' => 'Pembiayaan',
                'level' => 'Menengah',
                'duration' => '15 menit',
                'progress' => 0,
                'akad' => 'Murabahah',
            ],
            [
                'id' => 5,
                'code' => 'Case 5',
                'title' => 'Pembiayaan Mudharabah Warung',
                'description' => 'Anggota mengajukan modal usaha warung dengan akad Mudharabah bagi hasil.',
                'category' => 'Pembiayaan',
                'level' => 'Lanjut',
                'duration' => '25 menit',
                'progress' => 0,
                'akad' => 'Mudharabah',
            ],
            [
                'id' => 6,
                'code' => 'Case 6',
                'title' => 'Pembiayaan Musyarakah Usaha Bersama',
                'description' => 'Kerja sama modal antara anggota dan koperasi dengan akad Musyarakah.',
                'category' => 'Pembiayaan',
                'level' => 'Lanjut',
                'duration' => '30 menit',
                'progress' => 0,
                'akad' => 'Musyarakah',
            ],
            [
                'id' => 7,
                'code' => 'Case 7',
                'title' => 'Ijarah Sewa Kendaraan',
                'description' => 'Anggota menyewa kendaraan melalui akad Ijarah selama 12 bulan.',
                'category' => 'Pembiayaan',
                'level' => 'Menengah',
                'duration' => '20 menit',
                'progress' => 0,
                'akad' => 'Ijarah',
            ],
            [
                'id' => 8,
                'code' => 'Case 8',
                'title' => 'Qardh Hasan Pinjaman Sosial',
                'description' => 'Pinjaman sosial tanpa margin untuk membantu anggota yang membutuhkan.',
                'category' => 'Pembiayaan',
                'level' => 'Pemula',
                'duration' => '15 menit',
                'progress' => 0,
                'akad' => 'Qardh',
            ],
        ];

        return view('study_cases.index', compact('studyCases'));
    }

    public function show($id)
    {
        $studyCases = $this->getStudyCasesData();
        $studyCase = collect($studyCases)->firstWhere('id', (int) $id);

        if (!$studyCase) {
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
                'title' => 'Penyetoran Simpanan Rp 500.000',
                'description' => 'Simulasi penyetoran simpanan pokok/wajib anggota ke koperasi.',
                'category' => 'Simpanan',
                'level' => 'Pemula',
                'duration' => '10 menit',
                'akad' => 'Wadiah',
                'scenario' => 'Anggota menyetorkan Rp 500.000 sebagai simpanan wadiah ke koperasi syariah.',
                'expected_journal' => [
                    ['account' => 'Kas', 'debit' => 500000, 'credit' => 0],
                    ['account' => 'Simpanan Wadiah', 'debit' => 0, 'credit' => 500000],
                ],
                'explanation' => 'Pada saat setor, saldo kas koperasi bertambah dan saldo simpanan wadiah anggota juga bertambah. Tidak ada imbal hasil langsung karena akad wadiah adalah titipan amanah.',
            ],
            [
                'id' => 3,
                'code' => 'Case 3',
                'title' => 'Pembiayaan Murabahah Motor Rp 20.000.000',
                'description' => 'Anggota membeli motor melalui akad Murabahah dengan margin 15%.',
                'category' => 'Pembiayaan',
                'level' => 'Menengah',
                'duration' => '20 menit',
                'akad' => 'Murabahah',
                'scenario' => 'Anggota mengajukan pembiayaan motor senilai Rp 20.000.000 dengan margin 15% (Rp 3.000.000). Total piutang: Rp 23.000.000, tenor 24 bulan.',
                'expected_journal' => [
                    ['account' => 'Piutang Murabahah', 'debit' => 23000000, 'credit' => 0],
                    ['account' => 'Kas', 'debit' => 0, 'credit' => 20000000],
                    ['account' => 'Pendapatan Margin Murabahah', 'debit' => 0, 'credit' => 3000000],
                ],
                'explanation' => 'Koperasi membeli motor Rp 20.000.000 dari pemasok, kemudian menjual ke anggota Rp 23.000.000 (harga pokok + margin). Piutang murabahah mencatat total yang harus dibayar anggota.',
            ],
        ];
    }
}
