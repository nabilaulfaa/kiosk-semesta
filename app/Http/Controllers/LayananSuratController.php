<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LayananSuratController extends Controller
{
    // Baca data dari JSON
    private function getData(): array
    {
        return json_decode(
            file_get_contents(database_path('data/layanan_surat.json')),
            true
        );
    }

    // Halaman index — daftar jenis surat
    public function index()
    {
        $data = $this->getData();
        return view('layanan_surat.index', compact('data'));
    }

    // Halaman cek surat — detail per jenis surat
    public function cekSurat(Request $request)
    {
        $data  = $this->getData();
        $jenis = $request->query('jenis', '');

        return view('layanan_surat.cek_surat', compact('data', 'jenis'));
    }

    /**
     * API endpoint — dipakai JS (fetch) untuk ambil data surat & mock_status
     */
    public function apiData()
    {
        return response()->json($this->getData());
    }
}