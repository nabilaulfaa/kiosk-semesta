<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilDesaController extends Controller
{
    /* ----------------------------------------------------------
     | HELPER — baca file JSON dari public/api/
     ---------------------------------------------------------- */
    private function readJson(string $filename): array
    {
        $path = public_path("api/{$filename}");

        if (!file_exists($path)) {
            abort(404, "File {$filename} tidak ditemukan");
        }

        return json_decode(file_get_contents($path), true) ?? [];
    }

    private function apiJson(string $filename)
    {
        $path = public_path("api/{$filename}");

        if (!file_exists($path)) {
            return response()->json(['message' => 'File tidak ditemukan'], 404);
        }

        return response(file_get_contents($path), 200)
            ->header('Content-Type', 'application/json');
    }

    /* ----------------------------------------------------------
     | PROFIL DESA
     ---------------------------------------------------------- */
    public function index()
    {
        $data = $this->readJson('profil-desa.json');
        return view('profildesa.profil-desa', compact('data'));
    }

    public function apiProfil()
    {
        return $this->apiJson('profil-desa.json');
    }

    /* ----------------------------------------------------------
     | DATA GEOGRAFIS
     ---------------------------------------------------------- */
    public function geografis()
    {
        $data = $this->readJson('data-geografis.json');
        return view('profildesa.data-geografis', compact('data'));
    }

    public function apiGeografis()
    {
        return $this->apiJson('data-geografis.json');
    }

    /* ----------------------------------------------------------
     | DATA INFRASTRUKTUR
     ---------------------------------------------------------- */
    public function infrastruktur()
    {
        return view('profildesa.data-infrastruktur');
    }

    public function apiInfrastruktur()
    {
        return $this->apiJson('data-infrastruktur.json');
    }

    /* ----------------------------------------------------------
     | DATA KEPENDUDUKAN
     ---------------------------------------------------------- */
    public function kependudukan()
    {
        $data = $this->readJson('data-kependudukan.json');
        return view('profildesa.data-kependudukan', compact('data'));
    }

    public function apiKependudukan()
    {
        return $this->apiJson('data-kependudukan.json');
    }

    /* ----------------------------------------------------------
     | DATA KESEHATAN
     ---------------------------------------------------------- */
    public function kesehatan()
    {
        $data = $this->readJson('data-kesehatan.json');
        return view('profildesa.data-kesehatan', compact('data'));
    }

    public function apiKesehatan()
    {
        return $this->apiJson('data-kesehatan.json');
    }

    /* ----------------------------------------------------------
     | DATA PENDIDIKAN (dengan filter tahun)
     ---------------------------------------------------------- */
    public function pendidikan(Request $request)
    {
        $tahun     = (int) $request->input('tahun', 2025);
        $listTahun = [2026, 2025, 2024, 2023, 2022, 2021, 2020];

        $all  = $this->readJson('datapendidikan.json');
        $data = $all[(string) $tahun] ?? null;

        return view('profildesa.data-pendidikan', compact('tahun', 'data', 'listTahun'));
    }

    /* ----------------------------------------------------------
     | DATA SDA
     ---------------------------------------------------------- */
    public function sda()
    {
        $data = $this->readJson('data-sda.json');
        return view('profildesa.data-sda', compact('data'));
    }

    public function apiSda()
    {
        return $this->apiJson('data-sda.json');
    }

    /* ----------------------------------------------------------
     | DATA SOSIAL
     ---------------------------------------------------------- */
    public function sosial()
    {
        $data = $this->readJson('data-sosial.json');
        return view('profildesa.data-sosial', compact('data'));
    }

    public function apiSosial()
    {
        return $this->apiJson('data-sosial.json');
    }

    /* ----------------------------------------------------------
     | DATA UMUM (dengan filter tahun)
     ---------------------------------------------------------- */
    public function umum(Request $request)
    {
        $all       = $this->readJson('data-umum.json');
        $listTahun = array_keys($all);
        $tahun     = (string) $request->input('tahun', $listTahun[0]);

        if (!isset($all[$tahun])) {
            $tahun = $listTahun[0];
        }

        return view('profildesa.data-umum', [
            'tahun'     => $tahun,
            'listTahun' => $listTahun,
            'kode_desa' => $all[$tahun]['kode_desa'],
            'data'      => $all[$tahun]['data'],
        ]);
    }

    /* ----------------------------------------------------------
     | DATA EKONOMI (dengan filter tahun)
     ---------------------------------------------------------- */
    public function ekonomi(Request $request)
    {
        $all       = $this->readJson('ekonomi.json');
        $listTahun = array_keys($all);
        $tahun     = (string) $request->input('tahun', $listTahun[0] ?? '2025');

        if (!isset($all[$tahun])) {
            $tahun = $listTahun[0] ?? '2025';
        }

        $data = $all[$tahun] ?? [
            'umkm' => 0, 'petani' => 0,
            'pedagang' => 0, 'sektor_unggulan' => '-'
        ];

        return view('profildesa.data-ekonomi', compact('tahun', 'data', 'listTahun'));
    }
}