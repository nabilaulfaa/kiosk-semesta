@extends('layouts.app')

@section('content')
<style>
    .header-kategori {
        padding: 40px 80px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .title-area h1 {
        font-size: 50px;
        font-weight: 800;
        color: #B51016;
        margin: 0;
        text-transform: uppercase;
    }
    .subtitle {
        margin: 0;
        color: #E72128;
        font-weight: 700;
        font-size: 20px;
    }

    .list-container {
        padding: 0 80px 100px 80px; 
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    .detail-item-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        text-decoration: none !important;
        color: inherit;
        border-left: 12px solid #B51016;
        transition: transform 0.2s;
    }
    .detail-item-card:active { transform: scale(0.98); }

    .item-info h3 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 10px;
        color: #190370;
    }
    .item-meta {
        display: flex;
        gap: 30px;
        font-size: 18px;
        color: #555;
    }
    .status-pill {
        padding: 8px 20px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 16px;
        text-transform: uppercase;
    }
</style>

@php
    $data = [];
    if ($kategori == 'infrastruktur') {
        $data = [
            ['nama' => 'Pembangunan Jalan Desa', 'tahun' => 2025, 'status' => 'Proses', 'lokasi' => 'Dusun Krajan'],
            ['nama' => 'Renovasi Balai Desa', 'tahun' => 2024, 'status' => 'Selesai', 'lokasi' => 'Balai Desa'],
        ];
    } elseif ($kategori == 'sarana') {
        $data = [
            ['nama' => 'Pembangunan Lapangan Olahraga', 'tahun' => 2025, 'status' => 'Perencanaan', 'lokasi' => 'Dusun Timur'],
        ];
    } elseif ($kategori == 'ekonomi') {
        $data = [
            ['nama' => 'Program Bantuan UMKM', 'tahun' => 2025, 'status' => 'Proses', 'lokasi' => 'Desa'],
        ];
    } elseif ($kategori == 'sosial') {
        $data = [
            ['nama' => 'Pelatihan Digitalisasi Desa', 'tahun' => 2024, 'status' => 'Selesai', 'lokasi' => 'Balai Desa'],
        ];
    }
@endphp

<div class="header-kategori">
    <div class="title-area">
        <p class="subtitle">DATA EVALUASI PEMBANGUNAN:</p>
        <h1>{{ $kategori }}</h1>
    </div>
    <div class="evaluasi-icon" style="width: 80px; height: 80px; background: #B51016; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
        <i class="bi bi-clipboard-check text-white fs-1"></i>
    </div>
</div>

<div class="list-container">
    @foreach ($data as $item)
    <a href="{{ url('/evaluasi-pembangunan/detail/1') }}" class="detail-item-card">
        <div class="item-info">
            <h3>{{ $item['nama'] }}</h3>
            <div class="item-meta">
                <span><i class="bi bi-geo-alt-fill text-danger"></i> {{ $item['lokasi'] }}</span>
                <span><i class="bi bi-calendar-event text-danger"></i> {{ $item['tahun'] }}</span>
            </div>
        </div>
        
        <div class="d-flex align-items: center gap-4">
            <span class="status-pill 
                @if($item['status'] == 'Selesai') bg-success text-white
                @elseif($item['status'] == 'Proses') bg-warning text-dark
                @else bg-secondary text-white
                @endif">
                {{ $item['status'] }}
            </span>
            <i class="bi bi-chevron-right fs-3" style="color: #ccc;"></i>
        </div>
    </a>
    @endforeach
</div>
@endsection

@section('footer-nav')
    <a href="{{ url('/evaluasi-pembangunan') }}" class="btn-kembali text-decoration-none">
        <i class="bi bi-arrow-left"></i> KEMBALI
    </a>

    <a href="{{ url('/') }}" class="btn-beranda text-decoration-none">
        <i class="bi bi-house-door-fill"></i> BERANDA
    </a>
@endsection