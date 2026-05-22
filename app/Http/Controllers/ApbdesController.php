<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembangunan;

class ApbdesController extends Controller
{
    /* ----------------------------------------------------------
     | HELPER — baca file JSON dari public/api/
     ---------------------------------------------------------- */
    private function getAllData(): array
    {
        $path = public_path('api/apbdes.json');
        return file_exists($path)
            ? json_decode(file_get_contents($path), true)
            : [];
    }

    /* ----------------------------------------------------------
     | VIEW — Halaman APBDes
     ---------------------------------------------------------- */
    public function index(Request $request)
    {
        $tahunAktif = (int) $request->input('tahun', 2025);
        $listTahun  = [2025, 2024, 2023, 2022, 2021];
        return view('apbdes.apbdes', compact('tahunAktif', 'listTahun'));
    }

    /* ----------------------------------------------------------
     | API — Statistik APBDes per tahun
     ---------------------------------------------------------- */
    public function statistik(Request $request)
    {
        $tahun = (string) $request->input('tahun', 2025);
        $all   = $this->getAllData();
        $data  = $all[$tahun] ?? null;

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'tahun'     => (int) $tahun,
            'statistik' => $data['statistik'],
        ]);
    }

    /* ----------------------------------------------------------
     | API — Riwayat APBDes 5 tahun
     ---------------------------------------------------------- */
    public function periode()
    {
        $all = $this->getAllData();
        return response()->json(['data' => $all['periode'] ?? []]);
    }

    /* ----------------------------------------------------------
     | API — Program Pembangunan dari JSON (fallback)
     |
     | Dipakai kalau data pembangunan masih dari JSON,
     | bukan dari database.
     ---------------------------------------------------------- */
    public function pembangunanJson(Request $request)
    {
        $tahun = (string) $request->input('tahun', 2025);
        $all   = $this->getAllData();
        return response()->json(['data' => $all[$tahun]['pembangunan'] ?? []]);
    }

    /* ----------------------------------------------------------
     | API — Program Pembangunan dari Database (Eloquent)
     |
     | Dipakai kalau data pembangunan sudah pakai model & DB.
     | Dukung filter ?tahun=2025 & ?sumber_dana=DD
     ---------------------------------------------------------- */
    public function pembangunan(Request $request)
    {
        $query = Pembangunan::query();

        if ($request->tahun)       $query->where('tahun_anggaran', $request->tahun);
        if ($request->sumber_dana) $query->where('sumber_dana', $request->sumber_dana);

        $data = $query->latest()->get()->map(function ($d) {
            return [
                'id'             => $d->id,
                'judul'          => $d->judul,
                'keterangan'     => $d->keterangan,
                'tahun_anggaran' => $d->tahun_anggaran,
                'sumber_dana'    => $d->sumber_dana,
                'pelaksana'      => $d->pelaksana,
                'anggaran'       => $d->anggaran,
                'lokasi'         => $d->lokasi,
                'wilayah'        => [
                    'dusun' => $d->dusun,
                    'rw'    => $d->rw,
                    'rt'    => $d->rt,
                ],
            ];
        });

        return response()->json([
            'total' => $data->count(),
            'data'  => $data,
        ]);
    }
}