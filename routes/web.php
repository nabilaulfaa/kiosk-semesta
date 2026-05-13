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


// 1. BERANDA
Route::get('/', [BerandaController::class, 'index'])->name('beranda');

// 2. GROUP KIOSK
Route::prefix('kiosk')->group(function () {

    // Profil Desa
    Route::get('/profil-desa', [ProfilDesaController::class, 'index'])->name('profil.desa');

    // APBDes
    Route::get('/apbdes', [ApbdesController::class, 'index'])->name('apbdes');

    // BUMDes
    Route::get('/bumdes', [BumdesController::class, 'index'])->name('bumdes');

    // Program Kades
    Route::get('/program-kades', [ProgramKadesController::class, 'index'])->name('program.kades');

    // Peta Wilayah
    Route::get('/peta-wilayah', [PetaWilayahController::class, 'index'])->name('peta.wilayah');

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

});

// API data layanan surat 
Route::get('/api/layanan-surat/data', [LayananSuratController::class, 'apiData'])->name('layanan.surat.api');