<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/evaluasi-pembangunan');
});

Route::prefix('evaluasi-pembangunan')->group(function () {

    Route::get('/', function () {
        return view('evaluasi.index');
    });

    Route::get('/detail/{id}', function ($id) {
        return view('evaluasi.detail', compact('id'));
    });

    Route::get('/{kategori}', function ($kategori) {
        return view('evaluasi.kategori', compact('kategori'));
    });

});