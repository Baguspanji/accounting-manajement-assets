<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = [
            [
                'id' => 1,
                'title' => 'Perbedaan Simpan Pinjam Konvensional dan Syariah',
                'description' => 'Laporan analitis mengenai perbedaan mendasar antara skema simpan pinjam konvensional dan syariah di Indonesia.',
                'level' => 'Pemula',
                'duration' => '45 menit',
                'category' => 'Teori',
                'completed' => false,
            ],
            [
                'id' => 2,
                'title' => 'Produk Simpanan Syariah',
                'description' => 'Memahami produk simpanan syariah seperti Wadiah dan Mudharabah serta mekanisme imbalan dana.',
                'level' => 'Menengah',
                'duration' => '30 menit',
                'category' => 'Teori',
                'completed' => false,
            ],
            [
                'id' => 3,
                'title' => 'Akad-Akad Pembiayaan Syariah',
                'description' => 'Mendalami berbagai akad pembiayaan syariah: Murabahah, Musyarakah, Mudharabah, Ijarah, dan Qardh.',
                'level' => 'Menengah',
                'duration' => '50 menit',
                'category' => 'Teori',
                'completed' => false,
            ],
            [
                'id' => 4,
                'title' => 'Akuntansi Koperasi Syariah',
                'description' => 'Mempelajari pencatatan akuntansi khusus untuk produk syariah sesuai PSAK Syariah.',
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
