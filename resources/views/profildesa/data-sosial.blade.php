@extends('layouts.app')

@section('title', 'Data Sosial')

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

<div class="subtitle-left">Data Sosial</div>

<div class="stat-box">
    <div class="stat">
        <div class="stat-title">Fasilitas Ibadah</div>
        <div class="stat-value">{{ $data['statistik']['fasilitas_ibadah'] ?? '-' }}</div>
    </div>
    <div class="stat">
        <div class="stat-title">Organisasi</div>
        <div class="stat-value">{{ $data['statistik']['organisasi'] ?? '-' }}</div>
    </div>
    <div class="stat">
        <div class="stat-title">Kegiatan Sosial</div>
        <div class="stat-value">{{ $data['statistik']['kegiatan_sosial'] ?? '-' }}</div>
    </div>
</div>

<div class="section-title">Fasilitas Ibadah</div>
<div class="grid-wrapper">
    <div class="grid" id="scrollIbadah">
        @if(isset($data['fasilitas_ibadah']))
            @foreach($data['fasilitas_ibadah'] as $item)
            <div class="sosial-card">
                <img src="{{ asset($item['gambar']) }}" alt="{{ $item['nama'] }}">
                <div class="card-body">
                    <b>{{ $item['nama'] }}</b>
                    {{ $item['keterangan'] }}
                </div>
            </div>
            @endforeach
        @endif
    </div>
    <button class="scroll-btn" onclick="scrollRight('scrollIbadah')">➜</button>
</div>

<div class="section-title">Organisasi</div>
<div class="grid-wrapper">
    <div class="grid" id="scrollOrganisasi">
        @if(isset($data['organisasi']))
            @foreach($data['organisasi'] as $item)
            <div class="sosial-card">
                <img src="{{ asset($item['gambar']) }}" alt="{{ $item['nama'] }}">
                <div class="card-body">
                    <b>{{ $item['nama'] }}</b>
                    {{ $item['keterangan'] }}
                </div>
            </div>
            @endforeach
        @endif
    </div>
    <button class="scroll-btn" onclick="scrollRight('scrollOrganisasi')">➜</button>
</div>

<div class="section-title">Kegiatan Sosial</div>
<div class="grid-wrapper">
    <div class="grid" id="scrollKegiatan">
        @if(isset($data['kegiatan_sosial']))
            @foreach($data['kegiatan_sosial'] as $item)
            <div class="sosial-card">
                <img src="{{ asset($item['gambar']) }}" alt="{{ $item['nama'] }}">
                <div class="card-body">
                    <b>{{ $item['nama'] }}</b>
                    {{ $item['keterangan'] }}
                </div>
            </div>
            @endforeach
        @endif
    </div>
    <button class="scroll-btn" onclick="scrollRight('scrollKegiatan')">➜</button>
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