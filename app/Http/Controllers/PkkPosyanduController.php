<?php

namespace App\Http\Controllers;

class PkkPosyanduController extends Controller
{
    public function index()
    {
        return view('pkk_posyandu.index');
    }

    public function pkk()
    {
        $tahun          = request('tahun', 'all');
        $tahunStatistik = request('tahun_statistik', 'all');

        $semuaKegiatan = [
            2026 => [
                ['pokja' => 'Pokja 1', 'nama' => 'Penyuluhan KB',             'tanggal' => '05 Jan 2026', 'lokasi' => 'Balai Desa'],
                ['pokja' => 'Pokja 2', 'nama' => 'Pelatihan Memasak Sehat',   'tanggal' => '12 Jan 2026', 'lokasi' => 'Rumah Kader RT 3'],
                ['pokja' => 'Pokja 3', 'nama' => 'Sosialisasi Pendidikan',    'tanggal' => '19 Jan 2026', 'lokasi' => 'TK Al Islam'],
                ['pokja' => 'Pokja 4', 'nama' => 'Pelatihan Menjahit',        'tanggal' => '26 Jan 2026', 'lokasi' => 'Balai Desa'],
                ['pokja' => 'Pokja 1', 'nama' => 'Pertemuan Rutin Dasawisma', 'tanggal' => '02 Feb 2026', 'lokasi' => 'Rumah Kader RT 7'],
                ['pokja' => 'Pokja 2', 'nama' => 'Pelatihan Batik Tulis',     'tanggal' => '09 Feb 2026', 'lokasi' => 'Balai Desa'],
            ],
            2025 => [
                ['pokja' => 'Pokja 1', 'nama' => 'Penyuluhan Gizi',           'tanggal' => '07 Jan 2025', 'lokasi' => 'Balai Desa'],
                ['pokja' => 'Pokja 2', 'nama' => 'Pelatihan Kerajinan',       'tanggal' => '14 Jan 2025', 'lokasi' => 'Rumah Kader RT 5'],
                ['pokja' => 'Pokja 3', 'nama' => 'Sosialisasi Kesehatan',     'tanggal' => '21 Jan 2025', 'lokasi' => 'Puskesmas'],
            ],
            2024 => [
                ['pokja' => 'Pokja 1', 'nama' => 'Pertemuan PKK Desa',        'tanggal' => '10 Jan 2024', 'lokasi' => 'Balai Desa'],
                ['pokja' => 'Pokja 2', 'nama' => 'Pelatihan Memasak',         'tanggal' => '17 Jan 2024', 'lokasi' => 'Rumah Kader RT 2'],
            ],
        ];

        $semuaStatistik = [
            2026 => ['total' => 10, 'pelatihan' => 9, 'pertemuan' => 3, 'bulanan' => [2,3,4,5,7,8,6,5,4,7,8,9]],
            2025 => ['total' => 7,  'pelatihan' => 5, 'pertemuan' => 2, 'bulanan' => [1,2,3,2,4,5,3,4,2,3,4,5]],
            2024 => ['total' => 4,  'pelatihan' => 3, 'pertemuan' => 1, 'bulanan' => [1,1,2,1,2,3,2,1,2,1,2,2]],
        ];

        $tahunTersediaKegiatan  = array_keys($semuaKegiatan);
        $tahunTersediaStatistik = array_keys($semuaStatistik);

        if ($tahun === 'all') {
            $kegiatanPkk = array_merge(...array_values($semuaKegiatan));
        } elseif (isset($semuaKegiatan[(int)$tahun])) {
            $kegiatanPkk = $semuaKegiatan[(int)$tahun];
        } else {
            $kegiatanPkk = [];
        }

        if ($tahunStatistik === 'all') {
            $statistikKegiatan = [
                'total'     => array_sum(array_column($semuaStatistik, 'total')),
                'pelatihan' => array_sum(array_column($semuaStatistik, 'pelatihan')),
                'pertemuan' => array_sum(array_column($semuaStatistik, 'pertemuan')),
                'bulanan'   => array_map(
                    fn(...$vals) => array_sum($vals),
                    ...array_column($semuaStatistik, 'bulanan')
                ),
            ];
        } elseif (isset($semuaStatistik[(int)$tahunStatistik])) {
            $statistikKegiatan = $semuaStatistik[(int)$tahunStatistik];
        } else {
            $statistikKegiatan = ['total' => 0, 'pelatihan' => 0, 'pertemuan' => 0, 'bulanan' => array_fill(0, 12, 0)];
        }

        $dataUmum = [
            'total_anggota' => 6,
            'total_kader'   => 30,
            'dasawisma'     => 6,
            'rt_aktif'      => 10,
        ];

        $distribusiPokja = [
            ['label' => 'Pokja 1', 'jumlah' => 25, 'persen' => 24, 'warna' => '#109688'],
            ['label' => 'Pokja 2', 'jumlah' => 35, 'persen' => 21, 'warna' => '#B51016'],
            ['label' => 'Pokja 3', 'jumlah' => 18, 'persen' => 26, 'warna' => '#0D47A1'],
            ['label' => 'Pokja 4', 'jumlah' => 22, 'persen' => 29, 'warna' => '#FFB74D'],
        ];

        return view('pkk_posyandu.pkk', compact(
            'tahun', 'tahunStatistik', 'kegiatanPkk', 'dataUmum', 'statistikKegiatan', 'distribusiPokja',
            'tahunTersediaKegiatan', 'tahunTersediaStatistik'
        ));
    }

    public function posyandu()
    {
        $tahun = request('tahun', 'all');

        $semuaJadwal = [
            2026 => [
                ['nama' => 'Posyandu Melati 1', 'tanggal' => '03 Jan 2026', 'lokasi' => 'RT 01 Dusun 1'],
                ['nama' => 'Posyandu Melati 2', 'tanggal' => '10 Jan 2026', 'lokasi' => 'RT 04 Dusun 2'],
                ['nama' => 'Posyandu Mawar',    'tanggal' => '17 Jan 2026', 'lokasi' => 'RT 07 Dusun 3'],
                ['nama' => 'Posyandu Anggrek',  'tanggal' => '24 Jan 2026', 'lokasi' => 'RT 10 Dusun 4'],
                ['nama' => 'Posyandu Kenanga',  'tanggal' => '31 Jan 2026', 'lokasi' => 'RT 13 Dusun 5'],
                ['nama' => 'Posyandu Melati 1', 'tanggal' => '07 Feb 2026', 'lokasi' => 'RT 01 Dusun 1'],
            ],
            2025 => [
                ['nama' => 'Posyandu Melati 1', 'tanggal' => '05 Jan 2025', 'lokasi' => 'RT 01 Dusun 1'],
                ['nama' => 'Posyandu Mawar',    'tanggal' => '12 Jan 2025', 'lokasi' => 'RT 07 Dusun 3'],
                ['nama' => 'Posyandu Anggrek',  'tanggal' => '19 Jan 2025', 'lokasi' => 'RT 10 Dusun 4'],
            ],
            2024 => [
                ['nama' => 'Posyandu Melati 2', 'tanggal' => '08 Jan 2024', 'lokasi' => 'RT 04 Dusun 2'],
                ['nama' => 'Posyandu Kenanga',  'tanggal' => '15 Jan 2024', 'lokasi' => 'RT 13 Dusun 5'],
            ],
        ];

        $tahunTersedia = array_keys($semuaJadwal);

        if ($tahun === 'all') {
            $jadwalPosyandu = array_merge(...array_values($semuaJadwal));
        } elseif (isset($semuaJadwal[(int)$tahun])) {
            $jadwalPosyandu = $semuaJadwal[(int)$tahun];
        } else {
            $jadwalPosyandu = [];
        }

        $rincianPengunjung = [
            'balita'     => 60,
            'lansia'     => 40,
            'ibu_hamil'  => 20,
            'imunisasi'  => 180,
            'stunting'   => 30,
            'gizi_buruk' => 20,
        ];

        $dataKelahiran = ['total' => 850, 'laki' => 250, 'perempuan' => 600];
        $dataKematian  = ['total' => 850, 'laki' => 250, 'perempuan' => 600];

        return view('pkk_posyandu.posyandu', compact(
            'tahun', 'jadwalPosyandu', 'rincianPengunjung', 'dataKelahiran', 'dataKematian', 'tahunTersedia'
        ));
    }
}