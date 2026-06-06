<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiDesaController extends Controller
{

    private function readJson(string $path): array
    {
        if (!file_exists($path)) return [];
        return json_decode(file_get_contents($path), true) ?? [];
    }
    public function getProgramKadesData(): array
    {
        $path = public_path('data/programkades.json');
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

    //PROFIL DESA
    public function getProfil(): JsonResponse
    {
        $data = $this->readJson(public_path('data/profil-desa.json'));
        return response()->json($data);
    }

    public function getGeografis(): JsonResponse
    {
        $data = $this->readJson(public_path('data/data-geografis.json'));
        return response()->json($data);
    }

    public function getInfrastruktur(): JsonResponse
    {
        $data = $this->readJson(public_path('data/data-infrastruktur.json'));
        return response()->json($data);
    }

    public function getKependudukan(): JsonResponse
    {
        $data = $this->readJson(public_path('data/data-kependudukan.json'));
        return response()->json($data);
    }

    public function getKesehatan(): JsonResponse
    {
        $data = $this->readJson(public_path('data/data-kesehatan.json'));
        return response()->json($data);
    }

    public function getSda(): JsonResponse
    {
        $data = $this->readJson(public_path('data/data-sda.json'));
        return response()->json($data);
    }

    public function getSosial(): JsonResponse
    {
        $data = $this->readJson(public_path('data/data-sosial.json'));
        return response()->json($data);
    }
    public function getUmum(): JsonResponse
    {
        $data = $this->readJson(public_path('data/data-umum.json'));
        return response()->json($data);
    }

    public function getEkonomi(): JsonResponse
    {
        $data = $this->readJson(public_path('data/ekonomi.json'));
        return response()->json($data);
    }
    public function getPendidikan(Request $request): JsonResponse
    {
        $all  = $this->readJson(public_path('data/datapendidikan.json'));
        $tahun = (string) $request->input('tahun', 2025);
        $data  = $all[$tahun] ?? null;

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'tahun' => (int) $tahun,
            'data'  => $data,
        ]);
    }


    //APBDes
    public function getApbdesStatistik(Request $request): JsonResponse
    {
        $tahun = (string) $request->input('tahun', 2025);
        $all   = $this->readJson(public_path('data/apbdes.json'));
        $data  = $all[$tahun] ?? null;

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'tahun'     => (int) $tahun,
            'statistik' => $data['statistik'],
        ]);
    }

    public function getApbdesPeriode(): JsonResponse
    {
        $all = $this->readJson(public_path('data/apbdes.json'));
        return response()->json(['data' => $all['periode'] ?? []]);
    }

    public function getApbdesPembangunan(Request $request): JsonResponse
    {
        $tahun = (string) $request->input('tahun', 2025);
        $all   = $this->readJson(public_path('data/apbdes.json'));
        return response()->json(['data' => $all[$tahun]['pembangunan'] ?? []]);
    }


    //Bumdes
    public function getBumdes(): JsonResponse
    {
        $data = $this->readJson(public_path('data/bumdes.json'));
        return response()->json($data);
    }


    //Evaluasi
    public function getEvaluasiInfrastruktur(): JsonResponse
    {
        $data = $this->readJson(public_path('data/evaluasi/infrastruktur.json'));
        return response()->json($data);
    }

    public function getEvaluasiSarana(): JsonResponse
    {
        $data = $this->readJson(public_path('data/evaluasi/sarana.json'));
        return response()->json($data);
    }

    public function getEvaluasiSosial(): JsonResponse
    {
        $data = $this->readJson(public_path('data/evaluasi/sosial.json'));
        return response()->json($data);
    }

    
    //Layanan Surat
    public function getLayananSurat(): JsonResponse
    {
        $data = $this->readJson(public_path('data/layanan_surat.json'));
        return response()->json($data);
    }


    //Peta Wilayah
    public function getPetaGeojson(): JsonResponse
    {
        $data    = $this->readJson(public_path('data/peta.json'));
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

    public function getPetaDusun(): JsonResponse
    {
        $data  = $this->readJson(public_path('data/peta.json'));
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

    public function getPetaInfrastruktur(): JsonResponse
    {
        $data  = $this->readJson(public_path('data/peta.json'));
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


    //pkk & posyandu
    public function getPkk(): JsonResponse
    {
        $data = $this->readJson(public_path('data/pkk-posyandu/pkk.json'));
        return response()->json($data);
    }

    public function getPosyandu(): JsonResponse
    {
        $data = $this->readJson(public_path('data/pkk-posyandu/posyandu.json'));
        return response()->json($data);
    }
}