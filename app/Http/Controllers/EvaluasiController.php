<?php

namespace App\Http\Controllers;

class EvaluasiController extends Controller
{
    private function load(string $file): array
    {
        return json_decode(
            file_get_contents(public_path("api/evaluasi/{$file}.json")),
            true
        );
    }

    public function index()
    {
        return view('evaluasi.index');
    }

    public function infrastruktur()
    {
        $infrastruktur = $this->load('infrastruktur')['proyek'];
        return view('evaluasi.infrastruktur', compact('infrastruktur'));
    }

    public function sarana()
    {
        $sarana = $this->load('sarana');
        return view('evaluasi.sarana', compact('sarana'));
    }

    public function saranaDetail(string $slug)
    {
        $sarana = $this->load('sarana');

        $item = null;
        foreach ($sarana as $kategori => $list) {
            foreach ($list as $s) {
                if (isset($s['slug']) && $s['slug'] === $slug) {
                    $item = $s;
                    break 2;
                }
            }
        }

        if (!$item) abort(404);

        $data = [
            'nama' => $item['nama'],
            'item' => $item['detail'],
        ];

        return view('evaluasi.sarana_detail', compact('data', 'slug'));
    }

    public function ekonomi()
    {
        $ekonomi = $this->load('ekonomi');
        return view('evaluasi.ekonomi', compact('ekonomi'));
    }

    public function sosial()
    {
        $sosial = $this->load('sosial');
        return view('evaluasi.sosial', compact('sosial'));
    }
}