@extends('layouts.app')

@section('title', 'Data Geografis')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/kiosk-semesta.css') }}">
@endpush

@section('content')

<div class="modul-header">
    <div class="d-flex align-items-center gap-2">
        <div class="modul-icon"><i class="bi bi-houses"></i></div>
        <span class="modul-title">PROFIL DESA</span>
    </div>
</div>

<div class="subtitle-left">Data Geografis</div>

<div class="center-img">
    <img src="{{ asset('images/Computer-World-Map-Location Streamline Milano (datageografis).png') }}" alt="Geografis">
</div>

<div class="luas-box">
    <div class="luas-title">Luas Wilayah</div>
    <div class="luas-value">{{ $data['luas_wilayah'] ?? '-' }}</div>
</div>

<div class="batas">
    <div class="batas-row">
        <div class="batas-left">Batas Utara</div>
        <div class="batas-right">{{ $data['batas_wilayah']['utara'] ?? '-' }}</div>
    </div>
    <div class="batas-row">
        <div class="batas-left">Batas Selatan</div>
        <div class="batas-right">{{ $data['batas_wilayah']['selatan'] ?? '-' }}</div>
    </div>
    <div class="batas-row">
        <div class="batas-left">Batas Timur</div>
        <div class="batas-right">{{ $data['batas_wilayah']['timur'] ?? '-' }}</div>
    </div>
    <div class="batas-row">
        <div class="batas-left">Batas Barat</div>
        <div class="batas-right">{{ $data['batas_wilayah']['barat'] ?? '-' }}</div>
    </div>
</div>

@endsection

@section('bottom_navigation')
    <a href="{{ route('profil.desa') }}" class="btn-nav">
        <i class="bi bi-arrow-left"></i> KEMBALI
    </a>
@endsection

@push('scripts')
    <script src="{{ asset('js/kiosk-semesta.js') }}"></script>
@endpush