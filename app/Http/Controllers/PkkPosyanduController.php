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
        $tahun = request('tahun', '2026'); // default 2026, bukan 'all'
        $d = json_decode(file_get_contents(database_path('data/pkk posyandu/pkk.json')), true);

        $tahunTersedia = array_keys($d['kegiatan']);

        // Kegiatan
        if ($tahun === 'all') {
            $kegiatanPkk = array_merge(...array_values($d['kegiatan']));
        } else {
            $kegiatanPkk = $d['kegiatan'][$tahun] ?? [];
        }

        // Statistik
        if ($tahun === 'all') {
            $statistikKegiatan = [
                'total'     => array_sum(array_column($d['statistik_kegiatan'], 'total')),
                'pelatihan' => array_sum(array_column($d['statistik_kegiatan'], 'pelatihan')),
                'pertemuan' => array_sum(array_column($d['statistik_kegiatan'], 'pertemuan')),
                'bulanan'   => array_map(
                    fn(...$vals) => array_sum($vals),
                    ...array_column($d['statistik_kegiatan'], 'bulanan')
                ),
            ];
        } else {
            $statistikKegiatan = $d['statistik_kegiatan'][$tahun]
                ?? ['total' => 0, 'pelatihan' => 0, 'pertemuan' => 0, 'bulanan' => array_fill(0, 12, 0)];
        }

        // Data umum & distribusi pokja per tahun
        $dataUmum        = $d['data_umum'][$tahun]        ?? $d['data_umum']['2026'];
        $distribusiPokja = $d['distribusi_pokja'][$tahun] ?? $d['distribusi_pokja']['2026'];

        return view('pkk_posyandu.pkk', compact(
            'tahun', 'kegiatanPkk', 'dataUmum',
            'statistikKegiatan', 'distribusiPokja', 'tahunTersedia'
        ));
    }

    public function posyandu()
    {
        $tahun = request('tahun', '2026');
        $d = json_decode(file_get_contents(database_path('data/pkk posyandu/posyandu.json')), true);

        $tahunTersedia = array_keys($d['jadwal']);

        // Jadwal
        if ($tahun === 'all') {
            $jadwalPosyandu = array_merge(...array_values($d['jadwal']));
        } else {
            $jadwalPosyandu = $d['jadwal'][$tahun] ?? [];
        }

        // Data per tahun
        $dataPerTahun      = $d['data'][$tahun] ?? $d['data']['2026'];
        $rincianPengunjung = $dataPerTahun['rincian_pengunjung'];
        $dataKelahiran     = $dataPerTahun['data_kelahiran'];
        $dataKematian      = $dataPerTahun['data_kematian'];
        $statPengunjung    = $dataPerTahun['statistik_pengunjung'];
        $imunisasiBulanan  = $dataPerTahun['imunisasi_bulanan'];
        $giziBalita        = $dataPerTahun['gizi_balita'];

        return view('pkk_posyandu.posyandu', compact(
            'tahun', 'jadwalPosyandu', 'rincianPengunjung',
            'dataKelahiran', 'dataKematian', 'tahunTersedia',
            'statPengunjung', 'imunisasiBulanan', 'giziBalita'
        ));
    }
}