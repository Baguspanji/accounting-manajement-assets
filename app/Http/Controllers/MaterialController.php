<?php

namespace App\Http\Controllers;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = [
            [
                'id' => 1,
                'title' => 'Pengertian & Karakteristik Aset Tetap',
                'description' => 'Memahami definisi aset tetap, kriteria pengakuan, dan jenis-jenis aset tetap menurut PSAK 216.',
                'level' => 'Pemula',
                'duration' => '45 menit',
                'category' => 'Teori',
                'completed' => false,
            ],
            [
                'id' => 2,
                'title' => 'Harga Perolehan Aset Tetap',
                'description' => 'Mempelajari komponen biaya yang dikapitalisasi hingga aset siap digunakan.',
                'level' => 'Menengah',
                'duration' => '30 menit',
                'category' => 'Teori',
                'completed' => false,
            ],
            [
                'id' => 3,
                'title' => 'Metode Penyusutan Aset Tetap',
                'description' => 'Mendalami metode garis lurus, saldo menurun, jumlah angka tahun, dan unit produksi.',
                'level' => 'Menengah',
                'duration' => '50 menit',
                'category' => 'Teknis',
                'completed' => false,
            ],
            [
                'id' => 4,
                'title' => 'Pelepasan & Penghapusan Aset',
                'description' => 'Mempelajari pencatatan penjualan, penghapusan, dan laba/rugi pelepasan aset.',
                'level' => 'Lanjut',
                'duration' => '60 menit',
                'category' => 'Teknis',
                'completed' => false,
            ],
        ];

        return view('materials.index', compact('materials'));
    }

    public function show($id)
    {
        return view('materials.show', compact('id'));
    }
}
