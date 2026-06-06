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
        <a href="{{ route('profil.desa') }}" class="modul-title modul-title-link">PROFIL DESA</a>
    </div>
</div>

<div class="page-title" style="padding-left: 15px;">Informasi Data Kesehatan Tahun 2025</div>

<div class="px-0 mt-2">

    <div class="kes-stat-grid">
        <div class="kes-stat-card">
            <div class="kes-icon-wrap" style="background:#b51016;">
                <i class="fa-solid fa-house-medical"></i>
            </div>
            <div class="kes-card-text">
                <span>Posyandu</span>
                <b>{{ $data['posyandu'] ?? '-' }}</b>
            </div>
        </div>
        <div class="kes-stat-card">
            <div class="kes-icon-wrap" style="background:#0061fe;">
                <i class="fa-solid fa-syringe"></i>
            </div>
            <div class="kes-card-text">
                <span>Balita Imunisasi</span>
                <b>{{ $data['balita_imunisasi'] ?? '-' }}</b>
            </div>
        </div>
        <div class="kes-stat-card">
            <div class="kes-icon-wrap" style="background:#00923f;">
                <i class="fa-solid fa-face-smile"></i>
            </div>
            <div class="kes-card-text">
                <span>Balita Gizi Baik</span>
                <b>{{ $data['balita_gizi_baik'] ?? '-' }}</b>
            </div>
        </div>
        <div class="kes-stat-card">
            <div class="kes-icon-wrap" style="background:#e72128;">
                <i class="fa-solid fa-face-frown"></i>
            </div>
            <div class="kes-card-text">
                <span>Balita Gizi Buruk</span>
                <b>{{ $data['balita_gizi_buruk'] ?? '-' }}</b>
            </div>
        </div>
        <div class="kes-stat-card">
            <div class="kes-icon-wrap" style="background:#034d70;">
                <i class="fa-solid fa-person-cane"></i>
            </div>
            <div class="kes-card-text">
                <span>Lansia Gizi Baik</span>
                <b>{{ $data['lansia_gizi_baik'] ?? '-' }}</b>
            </div>
        </div>
        <div class="kes-stat-card">
            <div class="kes-icon-wrap" style="background:#ff9e4f;">
                <i class="fa-solid fa-person-cane"></i>
            </div>
            <div class="kes-card-text">
                <span>Lansia Gizi Buruk</span>
                <b>{{ $data['lansia_gizi_buruk'] ?? '-' }}</b>
            </div>
        </div>
        <div class="kes-stat-card">
            <div class="kes-icon-wrap" style="background:#00927c;">
                <i class="fa-solid fa-ruler-vertical"></i>
            </div>
            <div class="kes-card-text">
                <span>Balita Stunting</span>
                <b>{{ $data['balita_stunting'] ?? '-' }}</b>
            </div>
        </div>
        <div class="kes-stat-card">
            <div class="kes-icon-wrap" style="background:#480370;">
                <i class="fa-solid fa-virus"></i>
            </div>
            <div class="kes-card-text">
                <span>Kasus Penyakit</span>
                <b>{{ $data['kasus_penyakit'] ?? '-' }}</b>
            </div>
        </div>
    </div>

    <div class="kes-status-wrap">

        <div class="kes-status-card">
            <div class="kes-status-title" style="background:var(--merah-tua);">Status Gizi Balita</div>
            <div class="kes-status-content">
                @php
                    $gizi  = $data['status_gizi'] ?? [];
                    $total = max(($gizi['baik'] ?? 0) + ($gizi['buruk'] ?? 0) + ($gizi['stunting'] ?? 0), 1);
                    $hBaik     = round((($gizi['baik']     ?? 0) / $total) * 100);
                    $hBuruk    = round((($gizi['buruk']    ?? 0) / $total) * 100);
                    $hStunting = round((($gizi['stunting'] ?? 0) / $total) * 100);
                @endphp

                <div class="kes-bar-chart">
                    <div class="kes-bar-item">
                        <div class="kes-bar-fill" style="height: 100%; background: #00923F;">
                            <div class="kes-bar-val">378</div>
                        </div>
                    </div>
                    <div class="kes-bar-item">
                        <div class="kes-bar-fill" style="height: 5%; background: var(--merah);">
                            <div class="kes-bar-val">18</div>
                        </div>
                    </div>
                    <div class="kes-bar-item">
                        <div class="kes-bar-fill" style="height: 9%; background: #0771d5;">
                            <div class="kes-bar-val">34</div>
                        </div>
                    </div>
                </div>
                <div class="kes-bar-labels">
                    <span>Baik</span>
                    <span>Buruk</span>
                    <span>Stunting</span>
                </div>
            </div>
        </div>

        <div class="kes-status-card">
            <div class="kes-status-title" style="background:#6a1b9a;">Kasus Penyakit</div>
            <div class="kes-status-content">
                @php
                    $penyakitList = $data['penyakit'] ?? [];
                    $maxNilai     = collect($penyakitList)->max('nilai') ?: 1;
                @endphp
                @foreach($penyakitList as $p)
                    @php $pct = round(($p['nilai'] / $maxNilai) * 100); @endphp
                    <div class="kes-penyakit-item">
                        <div class="kes-penyakit-label">
                            <span>{{ $p['nama'] }}</span>
                            <b>{{ $p['nilai'] }} kasus</b>
                        </div>
                        <div class="kes-penyakit-bar">
                            <div class="kes-penyakit-fill" style="width:{{ $pct }}%;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

</div>

@endsection
