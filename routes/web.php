<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Kiosk Semesta Jatimulyo
|--------------------------------------------------------------------------
*/

// 1. RUTE UTAMA (BERANDA)
Route::get('/', function () {
    return view('beranda.index');
})->name('beranda');


// 2. GROUP RUTE MODAL & LAYANAN (8 MODUL UTAMA)
Route::prefix('kiosk')->group(function () {
    
    // Profil Desa
    Route::get('/profil-desa', function () { 
        return view('profil_desa.index'); 
    })->name('profil.desa');

    // APBDes
    Route::get('/apbdes', function () { 
        return view('apbdes.index'); 
    })->name('apbdes');

    // BUMDes
    Route::get('/bumdes', function () { 
        return view('bumdes.index'); 
    })->name('bumdes');

    // Program Kades
    Route::get('/program-kades', function () { 
        return view('program_kades.index'); 
    })->name('program.kades');

    // PKK & Posyandu
    Route::get('/pkk-posyandu', function () { 
        return view('pkk_posyandu.index'); 
    })->name('pkk.posyandu');

    // Peta Wilayah
    Route::get('/peta-wilayah', function () { 
        return view('peta_wilayah.index'); 
    })->name('peta.wilayah');

    // Layanan Surat
    Route::get('/layanan-surat', function () { 
        return view('layanan_surat.index'); 
    })->name('layanan.surat');

    Route::get('/cek-surat', function () { 
        return view('layanan_surat.cek_surat'); 
    })->name('cek.surat');

    // 3. GROUP EVALUASI (DENGAN SUB-KATEGORI)
    Route::prefix('evaluasi')->group(function () {
        
        // Halaman Utama Evaluasi (Menu Pilihan Kategori)
        Route::get('/', function () {
            return view('evaluasi.index');
        })->name('evaluasi');

        // Sub-Kategori Evaluasi
        Route::get('/infrastruktur', function () {
            return view('evaluasi.infrastruktur'); // File evaluasi pembangunanmu
        })->name('evaluasi.infrastruktur');

        Route::get('/sarana', function () {
            return view('evaluasi.sarana');
        })->name('evaluasi.sarana');

        Route::get('/ekonomi', function () {
            return view('evaluasi.ekonomi');
        })->name('evaluasi.ekonomi');

        Route::get('/sosial', function () {
            return view('evaluasi.sosial');
        })->name('evaluasi.sosial');

        // Detail Evaluasi Berdasarkan ID
        Route::get('/detail/{id}', function ($id) {
            return view('evaluasi.detail', compact('id'));
        })->name('evaluasi.detail');
    });

    // PKK & Posyandu Utama
    Route::get('/kiosk/pkk-posyandu', function () { 
        return view('pkk_posyandu.index'); 
    })->name('pkk.posyandu');

    // Sub-Menu PKK
    Route::get('/kiosk/pkk-posyandu/pkk', function () {
        // Karena filenya pkk_posyandu/pkk.blade.php
        return view('pkk_posyandu.pkk'); 
    })->name('pkk.index');

    // Sub-Menu Posyandu
    Route::get('/kiosk/pkk-posyandu/posyandu', function () {
        // Karena filenya pkk_posyandu/posyandu.blade.php
        return view('pkk_posyandu.posyandu'); 
    })->name('posyandu.index');

});