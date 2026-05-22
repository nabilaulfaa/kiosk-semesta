<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LayananSuratController extends Controller
{
    private function getData(): array
    {
        return json_decode(
            file_get_contents(public_path('api/layanan_surat.json')),
            true
        );
    }

    public function index()
    {
        $data = $this->getData();
        return view('layanan_surat.index', compact('data'));
    }

    public function cekSurat(Request $request)
    {
        $data  = $this->getData();
        $jenis = $request->query('jenis', '');

        return view('layanan_surat.cek_surat', compact('data', 'jenis'));
    }

    public function apiData()
    {
        return response()->json($this->getData());
    }
}