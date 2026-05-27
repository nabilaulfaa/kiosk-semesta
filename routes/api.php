<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Desa\DesaController;

Route::prefix('desa')->group(function () {
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
});