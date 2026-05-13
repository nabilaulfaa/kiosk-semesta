<?php

namespace App\Http\Controllers;

class EvaluasiController extends Controller
{
    public function index()
    {
        return view('evaluasi.index');
    }

    // Infrastruktur
    public function infrastruktur()
    {
        // Simulasi data dari API
        $infrastruktur = [
            [
                'id'       => 1,
                'judul'    => 'Pembangunan Jalan Desa',
                'lokasi'   => 'Dusun 1',
                'status'   => 'Selesai',
                'tahun'    => 2025,
                'progress' => 100,
                'anggaran' => 20000000,
                'deskripsi'=> 'Pembangunan jalan sepanjang 1,7 km untuk menghubungkan Dusun 1 dengan pusat desa.',
                'gambar'   => [
                    'utama'   => 'infrastruktur/jalan_utama.jpg',
                    'awal'    => 'infrastruktur/jalan_awal.jpg',
                    'proses'  => 'infrastruktur/jalan_proses.jpg',
                    'selesai' => 'infrastruktur/jalan_selesai.jpg',
                ],
            ],
            [
                'id'       => 2,
                'judul'    => 'Pembangunan Balai Desa',
                'lokasi'   => 'Dusun 2',
                'status'   => 'Proses',
                'tahun'    => 2025,
                'progress' => 60,
                'anggaran' => 15000000,
                'deskripsi'=> 'Renovasi balai desa untuk fasilitas warga dan kegiatan kemasyarakatan.',
                'gambar'   => [
                    'utama'   => 'infrastruktur/balai_utama.jpg',
                    'awal'    => 'infrastruktur/balai_awal.jpg',
                    'proses'  => 'infrastruktur/balai_proses.jpg',
                    'selesai' => 'infrastruktur/balai_selesai.jpg',
                ],
            ],
            [
                'id'       => 3,
                'judul'    => 'Pembangunan Drainase',
                'lokasi'   => 'Dusun 3',
                'status'   => 'Proses',
                'tahun'    => 2024,
                'progress' => 40,
                'anggaran' => 12000000,
                'deskripsi'=> 'Perbaikan sistem drainase desa untuk mengurangi genangan saat musim hujan.',
                'gambar'   => [
                    'utama'   => 'infrastruktur/drainase_utama.jpg',
                    'awal'    => 'infrastruktur/drainase_awal.jpg',
                    'proses'  => 'infrastruktur/drainase_proses.jpg',
                    'selesai' => 'infrastruktur/drainase_selesai.jpg',
                ],
            ],
            [
                'id'       => 4,
                'judul'    => 'Pembangunan Taman Desa',
                'lokasi'   => 'Dusun 4',
                'status'   => 'Belum',
                'tahun'    => 2025,
                'progress' => 10,
                'anggaran' => 8000000,
                'deskripsi'=> 'Rencana pembangunan taman desa sebagai ruang terbuka hijau bagi warga.',
                'gambar'   => [
                    'utama'   => 'infrastruktur/taman_utama.jpg',
                    'awal'    => 'infrastruktur/taman_awal.jpg',
                    'proses'  => 'infrastruktur/taman_proses.jpg',
                    'selesai' => 'infrastruktur/taman_selesai.jpg',
                ],
            ],
            [
                'id'       => 5,
                'judul'    => 'Perbaikan Jembatan Desa',
                'lokasi'   => 'Dusun 5',
                'status'   => 'Selesai',
                'tahun'    => 2024,
                'progress' => 100,
                'anggaran' => 18000000,
                'deskripsi'=> 'Perbaikan jembatan penghubung antar dusun sepanjang 12 meter.',
                'gambar'   => [
                    'utama'   => 'infrastruktur/jembatan_utama.jpg',
                    'awal'    => 'infrastruktur/jembatan_awal.jpg',
                    'proses'  => 'infrastruktur/jembatan_proses.jpg',
                    'selesai' => 'infrastruktur/jembatan_selesai.jpg',
                ],
            ],
        ];

        return view('evaluasi.infrastruktur', compact('infrastruktur'));
    }

    // Data Sarana (private — dipakai sarana & saranaDetail)
    private function dataSarana()
    {
        return [
            'pendidikan' => [
                [
                    'slug'    => 'tk',
                    'nama'    => 'Taman Kanak-Kanak (TK)',
                    'jumlah'  => 4,
                    'kondisi' => 'baik',
                    'gambar'  => 'sarana/tk_default.jpg',
                    'detail'  => [
                        ['nama' => 'TK Al Islam',  'kondisi' => 'baik',  'gambar' => 'sarana/tk_al_islam.jpg',  'deskripsi' => 'TK memiliki fasilitas bermain yang aman dan ruang belajar yang nyaman.'],
                        ['nama' => 'TK Al Ikhlas', 'kondisi' => 'baik',  'gambar' => 'sarana/tk_al_ikhlas.jpg', 'deskripsi' => 'Kondisi bangunan sangat baik dan terawat secara rutin.'],
                        ['nama' => 'TK Pertiwi',   'kondisi' => 'cukup', 'gambar' => 'sarana/tk_pertiwi.jpg',   'deskripsi' => 'Perlu peremajaan beberapa fasilitas bermain.'],
                        ['nama' => 'TK Muslimat',  'kondisi' => 'baik',  'gambar' => 'sarana/tk_muslimat.jpg',  'deskripsi' => 'Baru direnovasi tahun 2024, kondisi sangat baik.'],
                    ],
                ],
                [
                    'slug'    => 'sd',
                    'nama'    => 'Sekolah Dasar (SD)',
                    'jumlah'  => 3,
                    'kondisi' => 'baik',
                    'gambar'  => 'sarana/sd_default.jpg',
                    'detail'  => [
                        ['nama' => 'SDN 1 Jatimulyo', 'kondisi' => 'baik',  'gambar' => 'sarana/sdn1.jpg', 'deskripsi' => 'Kondisi bangunan sangat baik dan terawat secara rutin.'],
                        ['nama' => 'SDN 2 Jatimulyo', 'kondisi' => 'baik',  'gambar' => 'sarana/sdn2.jpg', 'deskripsi' => 'Kondisi bangunan sangat baik dan terawat secara rutin.'],
                        ['nama' => 'SDN 3 Jatimulyo', 'kondisi' => 'cukup', 'gambar' => 'sarana/sdn3.jpg', 'deskripsi' => 'Perlu perbaikan atap dan pengecatan ulang.'],
                    ],
                ],
            ],
            'kesehatan' => [
                [
                    'slug'    => 'puskesmas',
                    'nama'    => 'Puskesmas',
                    'jumlah'  => 1,
                    'kondisi' => 'cukup',
                    'gambar'  => 'sarana/puskesmas.jpg',
                    'detail'  => [
                        ['nama' => 'Puskesmas Jatimulyo', 'kondisi' => 'cukup', 'gambar' => 'sarana/puskesmas_detail.jpg', 'deskripsi' => 'Perlu penambahan peralatan medis dan ruang periksa.'],
                    ],
                ],
            ],
            'umum' => [
                [
                    'slug'    => 'balai-desa',
                    'nama'    => 'Balai Desa',
                    'jumlah'  => 1,
                    'kondisi' => 'baik',
                    'gambar'  => 'sarana/balai_desa.jpg',
                    'detail'  => [
                        ['nama' => 'Balai Desa Jatimulyo', 'kondisi' => 'baik', 'gambar' => 'sarana/balai_desa_detail.jpg', 'deskripsi' => 'Baru selesai direnovasi, kondisi sangat baik.'],
                    ],
                ],
                [
                    'slug'    => 'lapangan',
                    'nama'    => 'Lapangan',
                    'jumlah'  => 3,
                    'kondisi' => 'baik',
                    'gambar'  => 'sarana/lapangan.jpg',
                    'detail'  => [],
                ],
            ],
            'lingkungan' => [],
        ];
    }

    // Sarana & Prasarana
    public function sarana()
    {
        $sarana = $this->dataSarana();
        return view('evaluasi.sarana', compact('sarana'));
    }

    // Sarana Detail
    public function saranaDetail($slug)
    {
        // Cari item berdasarkan slug dari dataSarana()
        $item = collect($this->dataSarana())
            ->flatten(1)
            ->firstWhere('slug', $slug);

        if (!$item) abort(404);

        $data = [
            'nama' => $item['nama'],
            'item' => $item['detail'],
        ];

        return view('evaluasi.sarana_detail', compact('data', 'slug'));
    }

    // Ekonomi
    public function ekonomi()
    {
        $ekonomi = [
            2026 => [
                'summary' => [
                    'pendapatan'  => 1500000000,
                    'pengeluaran' => 900000000,
                    'pengusaha'   => 60,
                    'program'     => 10,
                ],
                'bulanan' => [
                    'pendapatan'  => [100,150,200,250,300,350,400,450,500,550,600,700],
                    'pengeluaran' => [80,100,120,150,180,200,220,250,280,300,320,350],
                    'pengusaha'   => [40,42,45,48,50,52,53,55,57,58,59,60],
                ],
            ],
            2025 => [
                'summary' => [
                    'pendapatan'  => 900000000,
                    'pengeluaran' => 850000000,
                    'pengusaha'   => 38,
                    'program'     => 6,
                ],
                'bulanan' => [
                    'pendapatan'  => [300,280,350,200,400,150,300,250,450,200,350,400],
                    'pengeluaran' => [250,240,300,180,350,130,280,220,400,180,320,380],
                    'pengusaha'   => [20,25,22,28,24,30,26,32,28,35,30,38],
                ],
            ],
            2024 => [
                'summary' => [
                    'pendapatan'  => 500000000,
                    'pengeluaran' => 400000000,
                    'pengusaha'   => 20,
                    'program'     => 4,
                ],
                'bulanan' => [
                    'pendapatan'  => [50,60,55,70,65,80,75,90,85,100,95,110],
                    'pengeluaran' => [40,45,42,50,48,60,55,70,65,80,75,90],
                    'pengusaha'   => [5,7,8,10,12,13,15,16,17,18,19,20],
                ],
            ],
        ];

        return view('evaluasi.ekonomi', compact('ekonomi'));
    }

    // Sosial
    public function sosial()
    {
        $sosial = [
            2026 => [
                'penduduk'         => 12548,
                'laki'             => 6360,
                'perempuan'        => 6188,
                'produktif'        => 7890,
                'balita'           => 1230,
                'tahun_label'      => ['2020','2021','2022','2023','2024'],
                'kelahiran'        => [120,130,150,170,190],
                'kematian'         => [70,80,85,90,100],
                'kategori_label'   => ['Bayi','Balita','Remaja','Dewasa','Lansia'],
                'kategori_jumlah'  => [800,1230,2500,6000,2018],
            ],
            2025 => [
                'penduduk'         => 12000,
                'laki'             => 6000,
                'perempuan'        => 6000,
                'produktif'        => 7500,
                'balita'           => 1100,
                'tahun_label'      => ['2020','2021','2022','2023','2024'],
                'kelahiran'        => [100,120,140,160,180],
                'kematian'         => [60,70,80,85,90],
                'kategori_label'   => ['Bayi','Balita','Remaja','Dewasa','Lansia'],
                'kategori_jumlah'  => [700,1100,2300,5800,2100],
            ],
            2024 => [
                'penduduk'         => 11500,
                'laki'             => 5800,
                'perempuan'        => 5700,
                'produktif'        => 7000,
                'balita'           => 1000,
                'tahun_label'      => ['2020','2021','2022','2023','2024'],
                'kelahiran'        => [90,110,130,150,170],
                'kematian'         => [50,60,70,80,85],
                'kategori_label'   => ['Bayi','Balita','Remaja','Dewasa','Lansia'],
                'kategori_jumlah'  => [650,1000,2100,5600,2150],
            ],
        ];

        return view('evaluasi.sosial', compact('sosial'));
    }
}