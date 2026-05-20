<?php

namespace App\Http\Controllers;

class BumdesController extends Controller
{
    private function getData(): array
    {
        return json_decode(
            file_get_contents(database_path('data/bumdes.json')),
            true
        );
    }

    public function index()
    {
        $d = $this->getData();

        $pengurus          = $d['pengurus'];
        $unitUsaha         = $d['unit_usaha'];
        $statistik         = $d['statistik'];
        $pendapatanTahunan = $d['pendapatan_tahunan'];

        return view('bumdes.index', compact('pengurus', 'unitUsaha', 'statistik', 'pendapatanTahunan'));
    }
}