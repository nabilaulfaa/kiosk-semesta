@extends('layouts.app')

@section('title', 'Data Ekonomi')

@php
    $max = max($data['umkm'], $data['petani'], $data['pedagang']);
    $lines = 5;
    $step = ceil($max / ($lines - 1) / 1000) * 1000;
    $top = $step * ($lines - 1);
    $chartHeight = 200;
    $scale = $top > 0 ? $chartHeight / $top : 1;
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/kiosk-semesta.css') }}">
    <style>
        .bar1 { height: {{ round($data['umkm'] * $scale) }}px; background: #ef9a9a; }
        .bar2 { height: {{ round($data['petani'] * $scale) }}px; background: #e53935; }
        .bar3 { height: {{ round($data['pedagang'] * $scale) }}px; background: #7f0000; }
    </style>
@endpush

@section('content')

<div class="modul-header">
    <div class="d-flex align-items-center gap-2">
        <div class="modul-icon"><i class="bi bi-houses"></i></div>
        <span class="modul-title">PROFIL DESA</span>
    </div>
</div>

<div class="subtitle-left">Data Ekonomi</div>

<div class="top-info">
    <div></div>
    @include('layouts.partials.year-picker', ['tahun' => $tahun])
</div>

<div class="container-fluid px-3">
    <div class="row g-2">
        <div class="col-6">
            <div class="rounded-3 overflow-hidden" style="background:#e0e0e0;box-shadow:0 3px 0 #bdbdbd;">
                <div class="text-white text-center fw-bold py-2" style="background:var(--merah-tua);font-size:12px;">Jumlah UMKM</div>
                <div class="text-center fw-bold py-2" style="font-size:18px;">{{ $data['umkm'] }}</div>
            </div>
        </div>
        <div class="col-6">
            <div class="rounded-3 overflow-hidden" style="background:#e0e0e0;box-shadow:0 3px 0 #bdbdbd;">
                <div class="text-white text-center fw-bold py-2" style="background:var(--merah-tua);font-size:12px;">Sektor Unggulan</div>
                <div class="text-center fw-bold py-2" style="font-size:18px;">Agribisnis</div>
            </div>
        </div>
        <div class="col-6">
            <div class="rounded-3 overflow-hidden" style="background:#e0e0e0;box-shadow:0 3px 0 #bdbdbd;">
                <div class="text-white text-center fw-bold py-2" style="background:var(--merah-tua);font-size:12px;">Jumlah Petani</div>
                <div class="text-center fw-bold py-2" style="font-size:18px;">{{ $data['petani'] }}</div>
            </div>
        </div>
        <div class="col-6">
            <div class="rounded-3 overflow-hidden" style="background:#e0e0e0;box-shadow:0 3px 0 #bdbdbd;">
                <div class="text-white text-center fw-bold py-2" style="background:var(--merah-tua);font-size:12px;">Jumlah Pedagang</div>
                <div class="text-center fw-bold py-2" style="font-size:18px;">{{ $data['pedagang'] }}</div>
            </div>
        </div>
    </div>
</div>

<div class="mx-3 mt-3 bg-white rounded-4 shadow-sm" style="padding:20px 50px 40px 60px; margin-top:16px !important; position:relative;">
    <div class="chart">
        <div class="y-axis">
            @for($i = 0; $i < $lines; $i++)
                <div style="bottom: {{ $i * ($chartHeight / ($lines - 1)) }}px">{{ $i * $step }}</div>
            @endfor
        </div>
        <div class="bar-group">
            <div class="bar bar1"></div>
            <div class="bar-label">UMKM</div>
        </div>
        <div class="bar-group">
            <div class="bar bar2"></div>
            <div class="bar-label">PETANI</div>
        </div>
        <div class="bar-group">
            <div class="bar bar3"></div>
            <div class="bar-label">PEDAGANG</div>
        </div>
    </div>
</div>

@endsection

@section('bottom_navigation')
    <a href="{{ route('profil.desa') }}" class="btn-nav">
        <i class="bi bi-arrow-left"></i> KEMBALI
    </a>
@endsection

@push('scripts')
<script>
    window.__yearRoute = '{{ route('ekonomi') }}';
</script>
<script src="{{ asset('js/kiosk-semesta.js') }}"></script>
@endpush