<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class ProgramKadesController extends Controller
{
    private function getData(): array
    {
        $path = public_path('api/programkades.json');
        $raw  = file_exists($path)
            ? json_decode(file_get_contents($path), true)
            : [];

        $semua = $raw['semua_program'] ?? [];
        $col   = collect($semua);

        $latestDate = $col->pluck('updated_at')
            ->map(fn($d) => Carbon::parse($d))
            ->max();

        $raw['progress'] = [
            'update'   => $latestDate ? $latestDate->locale('id')->isoFormat('D MMMM YYYY') : '-',
            'persen'   => $col->count() > 0 ? round($col->avg('persen')) : 0,
            'berjalan' => $col->where('status', 'berjalan')->count(),
            'selesai'  => $col->where('status', 'selesai')->count(),
            'tertunda' => $col->where('status', 'tertunda')->count(),
        ];

        return $raw;
    }

    public function index()
    {
        $data = $this->getData();
        return view('program-kades.index', compact('data'));
    }

    public function programKerja()
    {
        $data = $this->getData();
        return view('program-kades.program-kerja', compact('data'));
    }

    public function programBaru()
    {
        $data     = $this->getData();
        $programs = collect($data['semua_program'])->where('status', 'baru')->values()->all();
        return view('program-kades.program-baru', compact('programs'));
    }

    public function programSelesai()
    {
        $data     = $this->getData();
        $programs = collect($data['semua_program'])->where('status', 'selesai')->values()->all();
        return view('program-kades.program-selesai', compact('programs'));
    }

    public function data()
    {
        return response()->json($this->getData());
    }
}