<?php

namespace App\Http\Controllers;

class PetaWilayahController extends Controller
{
    public function index()
    {
        return view('peta-wilayah.index');
    }

    private function getPetaData(): array
    {
        $path = public_path('api/peta.json');
        return file_exists($path)
            ? json_decode(file_get_contents($path), true)
            : [];
    }

    public function geojson()
    {
        $data    = $this->getPetaData();
        $wilayah = $data['wilayah'];
        $dusun   = $data['dusun'] ?? [];

        $features = [[
            'type' => 'Feature',
            'properties' => [
                'nama'  => $wilayah['nama'],
                'tipe'  => 'wilayah',
                'warna' => $wilayah['warna'],
            ],
            'geometry' => [
                'type'        => 'Polygon',
                'coordinates' => [$wilayah['coordinates']],
            ],
        ]];

        foreach ($dusun as $d) {
            $features[] = [
                'type' => 'Feature',
                'properties' => [
                    'nama'         => $d['nama'],
                    'kepala_dusun' => $d['kepala_dusun'],
                    'tipe'         => 'dusun',
                    'warna'        => $d['warna'],
                ],
                'geometry' => [
                    'type'        => 'Polygon',
                    'coordinates' => [$d['coordinates']],
                ],
            ];
        }

        return response()->json([
            'status' => 'success',
            'desa'   => [
                'nama_wilayah' => $wilayah['nama'],
                'warna'        => $wilayah['warna'],
                'geojson'      => [
                    'type'     => 'FeatureCollection',
                    'features' => $features,
                ],
            ],
        ]);
    }

    public function dusun()
    {
        $data  = $this->getPetaData();
        $dusun = $data['dusun'] ?? [];

        return response()->json([
            'data' => [[
                'jumlah_dusun' => count($dusun),
                'data_dusun'   => array_map(fn($d) => [
                    'dusun'        => strtolower($d['nama']),
                    'nama'         => $d['nama'],
                    'kepala_dusun' => $d['kepala_dusun'],
                    'warna'        => $d['warna'],
                    'coordinates'  => $d['coordinates'],
                ], $dusun),
            ]],
        ]);
    }

    public function infrastruktur()
{
    $data  = $this->getPetaData();
    $infra = $data['infrastruktur'] ?? [];
    $tanah = $data['tanah_warga']   ?? [];

    $features = [];

    foreach ($infra as $f) {
        $features[] = [
            'type' => 'Feature',
            'properties' => [
                'nama'     => $f['nama'],
                'kategori' => $f['kategori'],
                'icon'     => $f['icon'],
                'tipe'     => 'infrastruktur',
            ],
            'geometry' => [
                'type'        => 'Point',
                'coordinates' => [$f['lng'], $f['lat']],
            ],
        ];
    }

    foreach ($tanah as $t) {
        $features[] = [
            'type' => 'Feature',
            'properties' => [
                'nama'     => $t['nama'],
                'luas'     => $t['luas'],
                'kategori' => 'Tanah Warga',
                'tipe'     => 'tanah',
            ],
            'geometry' => [
                'type'        => 'Polygon',
                'coordinates' => [$t['polygon']],
            ],
        ];
    }

    return response()->json([
        'type'     => 'FeatureCollection',
        'features' => $features,
    ]);
}
}