<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/evaluasi-pembangunan');
});

Route::prefix('evaluasi-pembangunan')->group(function () {

    Route::get('/', function () {
        return view('evaluasi.index');
    });

    Route::get('/infrastruktur', function () {
        return view('evaluasi.infrastruktur');
    });

    Route::get('/sarana', function () {
        return view('evaluasi.sarana');
    });

    Route::get('/ekonomi', function () {
        return view('evaluasi.ekonomi');
    });

    Route::get('/sosial', function () {
        return view('evaluasi.sosial');
    });

    Route::get('/detail/{id}', function ($id) {
        return view('evaluasi.detail', compact('id'));
    });

    // Route::get('/{kategori}', function ($kategori) {
    //     return view('evaluasi.kategori', compact('kategori'));
    // });

});