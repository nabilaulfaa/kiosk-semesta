@extends('layouts.app')

@section('title', 'Data Kesehatan')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/kiosk-semesta.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endpush

@section('content')

<div class="modul-header">
    <div class="d-flex align-items-center gap-2">
        <div class="modul-icon"><i class="bi bi-houses"></i></div>
        <span class="modul-title">PROFIL DESA</span>
    </div>
</div>

<div class="subtitle-left">Data Kesehatan</div>

<div class="px-0 mt-2">

    <div class="stat-grid">
        <div class="stat-card">
            <div class="icon-wrap" style="background:#b51016;">
                <i class="fa-solid fa-house-medical" style="color:#fff;font-size:16px;"></i>
            </div>
            <div class="card-text">Posyandu<b>{{ $data['posyandu'] ?? '-' }}</b></div>
        </div>
        <div class="stat-card">
            <div class="icon-wrap" style="background:#0061fe;">
                <i class="fa-solid fa-syringe" style="color:#fff;font-size:16px;"></i>
            </div>
            <div class="card-text">Balita Imunisasi<b>{{ $data['balita_imunisasi'] ?? '-' }}</b></div>
        </div>
        <div class="stat-card">
            <div class="icon-wrap" style="background:#00923f;">
                <i class="fa-solid fa-face-smile" style="color:#fff;font-size:16px;"></i>
            </div>
            <div class="card-text">Balita Gizi Baik<b>{{ $data['balita_gizi_baik'] ?? '-' }}</b></div>
        </div>
        <div class="stat-card">
            <div class="icon-wrap" style="background:#e72128;">
                <i class="fa-solid fa-face-frown" style="color:#fff;font-size:16px;"></i>
            </div>
            <div class="card-text">Balita Gizi Buruk<b>{{ $data['balita_gizi_buruk'] ?? '-' }}</b></div>
        </div>
        <div class="stat-card">
            <div class="icon-wrap" style="background:#034d70;">
                <i class="fa-solid fa-person-cane" style="color:#fff;font-size:16px;"></i>
            </div>
            <div class="card-text">Lansia Gizi Baik<b>{{ $data['lansia_gizi_baik'] ?? '-' }}</b></div>
        </div>
        <div class="stat-card">
            <div class="icon-wrap" style="background:#ff9e4f;">
                <i class="fa-solid fa-person-cane" style="color:#fff;font-size:16px;"></i>
            </div>
            <div class="card-text">Lansia Gizi Buruk<b>{{ $data['lansia_gizi_buruk'] ?? '-' }}</b></div>
        </div>
        <div class="stat-card">
            <div class="icon-wrap" style="background:#00927c;">
                <i class="fa-solid fa-ruler-vertical" style="color:#fff;font-size:16px;"></i>
            </div>
            <div class="card-text">Balita Stunting<b>{{ $data['balita_stunting'] ?? '-' }}</b></div>
        </div>
        <div class="stat-card">
            <div class="icon-wrap" style="background:#480370;">
                <i class="fa-solid fa-virus" style="color:#fff;font-size:16px;"></i>
            </div>
            <div class="card-text">Kasus Penyakit<b>{{ $data['kasus_penyakit'] ?? '-' }}</b></div>
        </div>
    </div>

    <div class="status-wrap">
        <div class="status-card">
            <div class="status-title" style="background:var(--merah-tua);">Status Gizi Balita</div>
            <div class="status-content">
                @php
                    $gizi  = $data['status_gizi'] ?? [];
                    $total = max(($gizi['baik'] ?? 0) + ($gizi['buruk'] ?? 0) + ($gizi['stunting'] ?? 0), 1);
                    $hBaik     = round((($gizi['baik']     ?? 0) / $total) * 80);
                    $hBuruk    = round((($gizi['buruk']    ?? 0) / $total) * 80);
                    $hStunting = round((($gizi['stunting'] ?? 0) / $total) * 80);
                @endphp
                <div class="custom-bar">
                    <div class="bar-item"><div class="bar green" style="height:{{ $hBaik }}px;"></div></div>
                    <div class="bar-item"><div class="bar red"   style="height:{{ $hBuruk }}px;"></div></div>
                    <div class="bar-item"><div class="bar teal"  style="height:{{ $hStunting }}px;"></div></div>
                </div>
                <div class="bar-line"></div>
                <div class="labels-bottom">
                    <div>Baik</div><div>Buruk</div><div>Stunting</div>
                </div>
            </div>
        </div>

        <div class="status-card">
            <div class="status-title" style="background:#6a1b9a;">Kasus Penyakit</div>
            <div class="status-content">
                @php
                    $penyakitList = $data['penyakit'] ?? [];
                    $maxNilai     = collect($penyakitList)->max('nilai') ?: 1;
                @endphp
                @foreach($penyakitList as $p)
                    @php $pct = round(($p['nilai'] / $maxNilai) * 100); @endphp
                    <div class="penyakit-item">
                        <div class="penyakit-text">{{ $p['nama'] }}</div>
                        <div class="line-wrapper">
                            <div class="line-bg"></div>
                            <div class="line-color" style="width:{{ $pct }}%;background:var(--merah);"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

@endsection

@section('bottom_navigation')
    <a href="{{ route('profil.desa') }}" class="btn-nav">
        <i class="bi bi-arrow-left"></i> KEMBALI
    </a>
@endsection