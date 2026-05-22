<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\EvaluasiController;
use App\Http\Controllers\BumdesController;
use App\Http\Controllers\PkkPosyanduController;
use App\Http\Controllers\LayananSuratController;
use App\Http\Controllers\ProfilDesaController;
use App\Http\Controllers\ApbdesController;
use App\Http\Controllers\ProgramKadesController;
use App\Http\Controllers\PetaWilayahController;

// ============================================================
// 1. BERANDA
// ============================================================
Route::get('/', [BerandaController::class, 'index'])->name('beranda');

// ============================================================
// 2. GROUP KIOSK
// ============================================================
Route::prefix('kiosk')->group(function () {

    // ----------------------------------------------------------
    // MODUL KAMU
    // ----------------------------------------------------------

    // BUMDes
    Route::get('/bumdes', [BumdesController::class, 'index'])->name('bumdes');

    // PKK & Posyandu
    Route::get('/pkk-posyandu',          [PkkPosyanduController::class, 'index'])->name('pkk.posyandu');
    Route::get('/pkk-posyandu/pkk',      [PkkPosyanduController::class, 'pkk'])->name('pkk.index');
    Route::get('/pkk-posyandu/posyandu', [PkkPosyanduController::class, 'posyandu'])->name('posyandu.index');

    // Layanan Surat
    Route::get('/layanan-surat', [LayananSuratController::class, 'index'])->name('layanan.surat');
    Route::get('/cek-surat',     [LayananSuratController::class, 'cekSurat'])->name('cek.surat');

    // Evaluasi
    Route::prefix('evaluasi')->group(function () {
        Route::get('/',              [EvaluasiController::class, 'index'])->name('evaluasi');
        Route::get('/infrastruktur', [EvaluasiController::class, 'infrastruktur'])->name('evaluasi.infrastruktur');
        Route::get('/sarana',        [EvaluasiController::class, 'sarana'])->name('evaluasi.sarana');
        Route::get('/sarana/{slug}', [EvaluasiController::class, 'saranaDetail'])->name('evaluasi.sarana.detail');
        Route::get('/ekonomi',       [EvaluasiController::class, 'ekonomi'])->name('evaluasi.ekonomi');
        Route::get('/sosial',        [EvaluasiController::class, 'sosial'])->name('evaluasi.sosial');
    });

    // ----------------------------------------------------------
    // MODUL TEMAN — Profil Desa (semua pakai ProfilDesaController)
    // ----------------------------------------------------------
    Route::get('/profil-desa',       [ProfilDesaController::class, 'index'])->name('profil.desa');
    Route::get('/data-umum',         [ProfilDesaController::class, 'umum'])->name('data.umum');
    Route::get('/data-geografis',    [ProfilDesaController::class, 'geografis'])->name('data.geografis');
    Route::get('/data-kependudukan', [ProfilDesaController::class, 'kependudukan'])->name('data.kependudukan');
    Route::get('/data-sosial',       [ProfilDesaController::class, 'sosial'])->name('data.sosial');
    Route::get('/data-ekonomi',      [ProfilDesaController::class, 'ekonomi'])->name('ekonomi');
    Route::get('/data-sda',          [ProfilDesaController::class, 'sda'])->name('data.sda');
    Route::get('/data-infrastruktur',[ProfilDesaController::class, 'infrastruktur'])->name('data.infrastruktur');
    Route::get('/data-pendidikan',   [ProfilDesaController::class, 'pendidikan'])->name('data.pendidikan');
    Route::get('/data-kesehatan',    [ProfilDesaController::class, 'kesehatan'])->name('data.kesehatan');

    // MODUL TEMAN — APBDes
    Route::get('/apbdes', [ApbdesController::class, 'index'])->name('apbdes');

    // MODUL TEMAN — Program Kades
    Route::get('/program-kades',         [ProgramKadesController::class, 'index'])->name('program.kades');
    Route::get('/program-kades/kerja',   [ProgramKadesController::class, 'programKerja'])->name('program-kerja');
    Route::get('/program-kades/baru',    [ProgramKadesController::class, 'programBaru'])->name('program-baru');
    Route::get('/program-kades/selesai', [ProgramKadesController::class, 'programSelesai'])->name('program-selesai');

    // MODUL TEMAN — Peta Wilayah
    Route::get('/peta-wilayah', [PetaWilayahController::class, 'index'])->name('peta.wilayah');

});

// ============================================================
// 3. API ROUTES
// ============================================================

// API Layanan Surat (modul kamu)
Route::get('/api/layanan-surat/data', [LayananSuratController::class, 'apiData'])->name('layanan.surat.api');

// API Profil Desa (modul teman)
Route::get('/api/profil-desa',        [ProfilDesaController::class, 'apiProfil']);
Route::get('/api/data-geografis',     [ProfilDesaController::class, 'apiGeografis']);
Route::get('/api/data-infrastruktur', [ProfilDesaController::class, 'apiInfrastruktur']);
Route::get('/api/data-kependudukan',  [ProfilDesaController::class, 'apiKependudukan']);
Route::get('/api/data-kesehatan',     [ProfilDesaController::class, 'apiKesehatan']);
Route::get('/api/data-sda',           [ProfilDesaController::class, 'apiSda']);
Route::get('/api/data-sosial',        [ProfilDesaController::class, 'apiSosial']);

// API APBDes (modul teman)
Route::get('/api/apbdes',             [ApbdesController::class, 'statistik'])->name('apbdes.statistik');
Route::get('/api/apbdes-periode',     [ApbdesController::class, 'periode'])->name('apbdes.periode');
Route::get('/api/pembangunan',        [ApbdesController::class, 'pembangunanJson'])->name('apbdes.pembangunan');

// API Peta Wilayah (modul teman)
Route::get('/api/peta/geojson',       [PetaWilayahController::class, 'geojson'])->name('peta.geojson');
Route::get('/api/peta/infrastruktur', [PetaWilayahController::class, 'infrastruktur'])->name('peta.infrastruktur');
Route::get('/api/peta/dusun',         [PetaWilayahController::class, 'dusun'])->name('peta.dusun');