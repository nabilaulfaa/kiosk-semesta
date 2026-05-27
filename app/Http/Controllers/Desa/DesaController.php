<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class DesaController extends Controller
{
    // Shared Helpers

    /**
     * Baca file JSON dari public/data/
     */
    private function readJson(string $filename): array
    {
        $path = public_path("data/{$filename}");

        if (!file_exists($path)) {
            abort(404, "File {$filename} tidak ditemukan");
        }

        return json_decode(file_get_contents($path), true) ?? [];
    }

    /**
     * Return file JSON sebagai response JSON langsung
     */
    private function apiJson(string $filename)
    {
        $path = public_path("data/{$filename}");

        if (!file_exists($path)) {
            return response()->json(['message' => 'File tidak ditemukan'], 404);
        }

        return response(file_get_contents($path), 200)
            ->header('Content-Type', 'application/json');
    }


    //BERANDA

    public function beranda()
    {
        return view('beranda.index');
    }


    // APBDes

    public function apbdes(Request $request)
    {
        $tahunAktif = (int) $request->input('tahun', 2025);
        $listTahun  = [2025, 2024, 2023, 2022, 2021];
        return view('apbdes.apbdes', compact('tahunAktif', 'listTahun'));
    }

    public function apbdesStatistik(Request $request)
    {
        $tahun = $request->input('tahun', 2025);

        $response = Http::get('https://nakulasadewa.com/apisidesa/public/api/desa/apbdes', [
            'tahun' => $tahun,
        ]);

        if ($response->failed()) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($response->json());
    }

    public function apbdesPeriode()
    {
        $response = Http::get('https://nakulasadewa.com/apisidesa/public/api/desa/apbdes-periode');

        if ($response->failed()) {
            return response()->json(['data' => []]);
        }

        return response()->json($response->json());
    }

    public function apbdesPembangunanJson(Request $request)
    {
        $tahun = $request->input('tahun', 2025);

        $response = Http::get('https://nakulasadewa.com/apisidesa/public/api/desa/pembangunan', [
            'tahun' => $tahun,
        ]);

        if ($response->failed()) {
            return response()->json(['data' => []]);
        }

        return response()->json($response->json());
    }



    // BUMDes

    private function getBumdesData(): array
    {
        return json_decode(
            file_get_contents(public_path('data/bumdes.json')),
            true
        );
    }

    public function bumdes()
    {
        $response = Http::get('https://nakulasadewa.com/apisidesa/public/api/desa/bumdes');
        $d = $response->json();

        $pengurus          = $d['pengurus'];
        $unitUsaha         = $d['unit_usaha'];
        $statistik         = $d['statistik'];
        $pendapatanTahunan = $d['pendapatan_tahunan'];

        return view('bumdes.index', compact('pengurus', 'unitUsaha', 'statistik', 'pendapatanTahunan'));
    }


    // Evaluasi

    private function loadEvaluasi(string $file): array
    {
        return json_decode(
            file_get_contents(public_path("data/evaluasi/{$file}.json")),
            true
        );
    }

    public function evaluasi()
    {
        return view('evaluasi.index');
    }

    public function evaluasiInfrastruktur()
    {
        $response = Http::get('https://nakulasadewa.com/apisidesa/public/api/desa/evaluasi-infrastruktur');
        $infrastruktur = $response->json()['proyek'] ?? [];
        return view('evaluasi.infrastruktur', compact('infrastruktur'));
    }

    public function evaluasiSarana()
    {
        $response = Http::get('https://nakulasadewa.com/apisidesa/public/api/desa/evaluasi-sarana');
        $sarana = $response->json();
        return view('evaluasi.sarana', compact('sarana'));
    }

    public function evaluasiSaranaDetail(string $slug)
    {
        $response = Http::get('https://nakulasadewa.com/apisidesa/public/api/desa/evaluasi-sarana');
        $sarana = $response->json();

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

    public function evaluasiEkonomi()
    {
        $response = Http::get('https://nakulasadewa.com/apisidesa/public/api/desa/evaluasi-ekonomi');
        $ekonomi = $response->json();
        return view('evaluasi.ekonomi', compact('ekonomi'));
    }

    public function evaluasiSosial()
    {
        $response = Http::get('https://nakulasadewa.com/apisidesa/public/api/desa/evaluasi-sosial');
        $sosial = $response->json();
        return view('evaluasi.sosial', compact('sosial'));
    }


    // Layanan Surat

    private function getLayananSuratData(): array
    {
        return json_decode(
            file_get_contents(public_path('data/layanan_surat.json')),
            true
        );
    }

    public function layananSurat()
    {
        $response = Http::get('https://nakulasadewa.com/apisidesa/public/api/desa/layanan-surat');
        $data = $response->json();
        return view('layanan_surat.index', compact('data'));
    }

    public function layananSuratCek(Request $request)
    {
        $response = Http::get('https://nakulasadewa.com/apisidesa/public/api/desa/layanan-surat');
        $data  = $response->json();
        $jenis = $request->query('jenis', '');
        return view('layanan_surat.cek_surat', compact('data', 'jenis'));
    }

    public function layananSuratApi()
    {
        $response = Http::get('https://nakulasadewa.com/apisidesa/public/api/desa/layanan-surat');
        return response()->json($response->json());
    }
    

    // Peta Wilayah

    public function petaWilayah()
    {
        return view('peta-wilayah.index');
    }

    public function petaGeojson()
    {
        $response = Http::get('https://nakulasadewa.com/apisidesa/public/api/desa/peta-geojson');
        return response()->json($response->json());
    }

    public function petaDusun()
    {
        $response = Http::get('https://nakulasadewa.com/apisidesa/public/api/desa/peta-dusun');
        return response()->json($response->json());
    }

    public function petaInfrastruktur()
    {
        $response = Http::get('https://nakulasadewa.com/apisidesa/public/api/desa/peta-infra');
        return response()->json($response->json());
    }


    // PKK & Posyandu

    public function pkkPosyandu()
    {
        return view('pkk_posyandu.index');
    }

    public function pkk()
{
    $tahun = request('tahun', '2026');
    $d     = Http::get('https://nakulasadewa.com/apisidesa/public/api/desa/pkk')->json();

    $tahunTersedia = array_keys($d['kegiatan']);

    if ($tahun === 'all') {
        $kegiatanPkk = array_merge(...array_values($d['kegiatan']));
    } else {
        $kegiatanPkk = $d['kegiatan'][$tahun] ?? [];
    }

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
    $d     = Http::get('https://nakulasadewa.com/apisidesa/public/api/desa/posyandu')->json();

    $tahunTersedia = array_keys($d['jadwal']);

    if ($tahun === 'all') {
        $jadwalPosyandu = array_merge(...array_values($d['jadwal']));
    } else {
        $jadwalPosyandu = $d['jadwal'][$tahun] ?? [];
    }

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

    // Profil Desa

    public function profilDesa()
    {
        $response = Http::get('https://nakulasadewa.com/apisidesa/public/api/desa/profil');
        $data = $response->json();
        
        //return $data; 
        return view('profildesa.profil-desa', compact('data'));
    }

    public function apiProfil()
    {
        return $this->apiJson('profil-desa.json');
    }

    public function geografis()
    {
        $response = Http::get('https://nakulasadewa.com/apisidesa/public/api/desa/geografis');
        $data = $response->json();
        
        //return $data; 
        return view('profildesa.data-geografis', compact('data'));
    }

    public function apiGeografis()
    {
        return $this->apiJson('data-geografis.json');
    }

    public function infrastruktur()
    {
        $response = Http::get('https://nakulasadewa.com/apisidesa/public/api/desa/infrastruktur');
        $data     = $response->json();

        //return $data; 
        return view('profildesa.data-infrastruktur', compact('data'));
    }

    public function apiInfrastruktur()
    {
        return $this->apiJson('data-infrastruktur.json');
    }

    public function kependudukan()
    {
        $response = Http::get('https://nakulasadewa.com/apisidesa/public/api/desa/kependudukan');
        $data = $response->json();
        
        //return $data; 
        return view('profildesa.data-kependudukan', compact('data'));
    }

    public function apiKependudukan()
    {
        return $this->apiJson('data-kependudukan.json');
    }

    public function kesehatan()
    {
        $response = Http::get('https://nakulasadewa.com/apisidesa/public/api/desa/kesehatan');
        $data = $response->json();
        
        //return $data; 
        return view('profildesa.data-kesehatan', compact('data'));
    }

    public function apiKesehatan()
    {
        return $this->apiJson('data-kesehatan.json');
    }

    public function pendidikan(Request $request)
    {
        $tahun     = (int) $request->input('tahun', 2025);
        $listTahun = [2026, 2025, 2024, 2023, 2022, 2021, 2020];

        $response = Http::get('https://nakulasadewa.com/apisidesa/public/api/desa/pendidikan?tahun=' . $tahun);
        $result   = $response->json();

        // return $result; 

        $data = $result['data'] ?? null; 

        return view('profildesa.data-pendidikan', compact('tahun', 'data', 'listTahun'));
    }

    public function sda()
    {
        $response = Http::get('https://nakulasadewa.com/apisidesa/public/api/desa/sda');
        $data = $response->json();
        
        //return $data; 
        return view('profildesa.data-sda', compact('data'));
    }

    public function apiSda()
    {
        return $this->apiJson('data-sda.json');
    }

    public function sosial()
    {
        $response = Http::get('https://nakulasadewa.com/apisidesa/public/api/desa/sosial');
        $data = $response->json();
        
        //return $data; 
        return view('profildesa.data-sosial', compact('data'));
    }

    public function apiSosial()
    {
        return $this->apiJson('data-sosial.json');
    }

    public function umum(Request $request)
    {
        $response  = Http::get('https://nakulasadewa.com/apisidesa/public/api/desa/umum');
        $all       = $response->json();

        //return $all;
        
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

    public function ekonomi(Request $request)
    {
        $response  = Http::get('https://nakulasadewa.com/apisidesa/public/api/desa/ekonomi');
        $all       = $response->json();

        //return $all;

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


    // Program Kades

    private function getProgramKadesData(): array
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

    public function programKades()
    {
        $response = Http::get('https://nakulasadewa.com/apisidesa/public/api/desa/program-kades-data');
        $data = $response->json();
        
        //return $data; 
        return view('program-kades.index', compact('data')); 
    }

    public function programKerja()
    {

        $response = Http::get('https://nakulasadewa.com/apisidesa/public/api/desa/program-kades');
        $data     = $response->json();

        //return $data;
        return view('program-kades.program-kerja', compact('data'));
    }

    public function programBaru()
    {
        $response = Http::get('https://nakulasadewa.com/apisidesa/public/api/desa/program-kades');
        $data     = $response->json();

        //return $data;
        $programs = collect($data['semua_program'])->where('status', 'baru')->values()->all();
        return view('program-kades.program-baru', compact('programs'));
    }

    public function programSelesai()
    {
        $response = Http::get('https://nakulasadewa.com/apisidesa/public/api/desa/program-kades');
        $data     = $response->json();

        //return $data;
        $programs = collect($data['semua_program'])->where('status', 'selesai')->values()->all();
        return view('program-kades.program-selesai', compact('programs'));
    }

    public function programKadesApi()
    {
        return response()->json($this->getProgramKadesData());
    }
}