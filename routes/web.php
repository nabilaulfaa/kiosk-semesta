<?php

use App\Http\Controllers\Desa\ApiDesaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Desa\DesaController;

// BERANDA
Route::get('/', function () {
    return view('beranda/index');
})->name('beranda');

// GRUP KIOSK
Route::prefix('kiosk')->group(function () {

    // BUMDES
    Route::get('/bumdes', [DesaController::class, 'bumdes'])->name('bumdes');

    // PKK & Posyandu
    Route::get('/pkk-posyandu',          [DesaController::class, 'pkkPosyandu'])->name('pkk.posyandu');
    Route::get('/pkk-posyandu/pkk',      [DesaController::class, 'pkk'])->name('pkk.index');
    Route::get('/pkk-posyandu/posyandu', [DesaController::class, 'posyandu'])->name('posyandu.index');

    // LAYANAN SURAT
    Route::get('/layanan-surat', [DesaController::class, 'layananSurat'])->name('layanan.surat');
    Route::get('/cek-surat',     [DesaController::class, 'layananSuratCek'])->name('cek.surat');

    // EVALUASI DESA
    Route::prefix('evaluasi')->group(function () {
        Route::get('/',              [DesaController::class, 'evaluasi'])->name('evaluasi');
        Route::get('/infrastruktur', [DesaController::class, 'evaluasiInfrastruktur'])->name('evaluasi.infrastruktur');
        Route::get('/sarana',        [DesaController::class, 'evaluasiSarana'])->name('evaluasi.sarana');
        Route::get('/sarana/{slug}', [DesaController::class, 'evaluasiSaranaDetail'])->name('evaluasi.sarana.detail');
        Route::get('/ekonomi',       [DesaController::class, 'evaluasiEkonomi'])->name('evaluasi.ekonomi');
        Route::get('/sosial',        [DesaController::class, 'evaluasiSosial'])->name('evaluasi.sosial');
    });

    // PROFIL DESA & DATA DESA
    Route::get('/profil-desa',        [DesaController::class, 'profilDesa'])->name('profil.desa');
    Route::get('/data-umum',          [DesaController::class, 'umum'])->name('data.umum');
    Route::get('/data-geografis',     [DesaController::class, 'geografis'])->name('data.geografis');
    Route::get('/data-kependudukan',  [DesaController::class, 'kependudukan'])->name('data.kependudukan');
    Route::get('/data-sosial',        [DesaController::class, 'sosial'])->name('data.sosial');
    Route::get('/data-ekonomi',       [DesaController::class, 'ekonomi'])->name('ekonomi');
    Route::get('/data-sda',           [DesaController::class, 'sda'])->name('data.sda');
    Route::get('/data-infrastruktur', [DesaController::class, 'infrastruktur'])->name('data.infrastruktur');
    Route::get('/data-pendidikan',    [DesaController::class, 'pendidikan'])->name('data.pendidikan');
    Route::get('/data-kesehatan',     [DesaController::class, 'kesehatan'])->name('data.kesehatan');

    // APBDes
    Route::get('/apbdes', [DesaController::class, 'apbdes'])->name('apbdes');

    // PROGRAM KADES
    Route::get('/program-kades',         [DesaController::class, 'programKades'])->name('program.kades');
    Route::get('/program-kades/kerja',   [DesaController::class, 'programKerja'])->name('program-kerja');
    Route::get('/program-kades/baru',    [DesaController::class, 'programBaru'])->name('program-baru');
    Route::get('/program-kades/selesai', [DesaController::class, 'programSelesai'])->name('program-selesai');

    // PETA WILAYAH
    Route::get('/peta-wilayah', [DesaController::class, 'petaWilayah'])->name('peta.wilayah');

});

// API ROUTES
Route::prefix('api/desa')->group(function () {
    Route::get('/profil',         [DesaController::class, 'apiProfil']);
    Route::get('/geografis',      [DesaController::class, 'apiGeografis']);
    Route::get('/infrastruktur',  [DesaController::class, 'apiInfrastruktur']);
    Route::get('/kependudukan',   [DesaController::class, 'apiKependudukan']);
    Route::get('/kesehatan',      [DesaController::class, 'apiKesehatan']);
    Route::get('/sda',            [DesaController::class, 'apiSda']);
    Route::get('/sosial',         [DesaController::class, 'apiSosial']);
    Route::get('/layanan-surat',  [DesaController::class, 'layananSuratApi']);
    Route::get('/apbdes',         [DesaController::class, 'apbdesStatistik']);
    Route::get('/apbdes-periode', [DesaController::class, 'apbdesPeriode']);
    Route::get('/pembangunan',    [DesaController::class, 'apbdesPembangunanJson']);
    Route::get('/peta-geojson',   [DesaController::class, 'petaGeojson']);
    Route::get('/peta-infra',     [DesaController::class, 'petaInfrastruktur']);
    Route::get('/peta-dusun',     [DesaController::class, 'petaDusun']);
    Route::get('/program-kades',  [DesaController::class, 'programKadesApi']);


// API BARU
    Route::get('/program-kades-data', [ApiDesaController::class, 'getProgramKadesData']);

    // Profil Desa
    Route::get('/profil',        [ApiDesaController::class, 'getProfil']);
    Route::get('/geografis',     [ApiDesaController::class, 'getGeografis']);
    Route::get('/infrastruktur', [ApiDesaController::class, 'getInfrastruktur']);
    Route::get('/kependudukan',  [ApiDesaController::class, 'getKependudukan']);
    Route::get('/kesehatan',     [ApiDesaController::class, 'getKesehatan']);
    Route::get('/sda',           [ApiDesaController::class, 'getSda']);
    Route::get('/sosial',        [ApiDesaController::class, 'getSosial']);
    Route::get('/umum',   [ApiDesaController::class, 'getUmum']);
    Route::get('/ekonomi', [ApiDesaController::class, 'getEkonomi']);
    Route::get('/pendidikan', [ApiDesaController::class, 'getPendidikan']);

    // APBDes
    Route::get('/apbdes',         [ApiDesaController::class, 'getApbdesStatistik']);
    Route::get('/apbdes-periode', [ApiDesaController::class, 'getApbdesPeriode']);
    Route::get('/pembangunan',    [ApiDesaController::class, 'getApbdesPembangunan']);

    //Bumdes
    Route::get('/bumdes', [ApiDesaController::class, 'getBumdes']);

    //Evaluasi
    Route::get('/evaluasi-infrastruktur', [ApiDesaController::class, 'getEvaluasiInfrastruktur']);
    Route::get('/evaluasi-sarana',        [ApiDesaController::class, 'getEvaluasiSarana']);
    Route::get('/evaluasi-ekonomi',       [ApiDesaController::class, 'getEvaluasiEkonomi']);
    Route::get('/evaluasi-sosial',        [ApiDesaController::class, 'getEvaluasiSosial']);

    // Layanan Surat
    Route::get('/layanan-surat', [ApiDesaController::class, 'getLayananSurat']);

    //Peta Wilayah
    Route::get('/peta-geojson',   [DesaController::class, 'petaGeojson'])->name('peta.geojson');
    Route::get('/peta-infra',     [DesaController::class, 'petaInfrastruktur'])->name('peta.infrastruktur');
    Route::get('/peta-dusun',     [DesaController::class, 'petaDusun'])->name('peta.dusun');

    // PKK & Posyandu
    Route::get('/pkk',      [ApiDesaController::class, 'getPkk']);
    Route::get('/posyandu', [ApiDesaController::class, 'getPosyandu']);
});