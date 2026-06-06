@extends('layouts.app')

@section('title', 'Data Sosial')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/kiosk-semesta.css') }}">
@endpush

@section('content')

<div class="modul-header">
    <div class="d-flex align-items-center gap-2">
        <div class="modul-icon"><i class="bi bi-houses"></i></div>
        <a href="{{ route('profil.desa') }}" class="modul-title modul-title-link">PROFIL DESA</a>
    </div>
</div>

<div class="page-title" style="padding-left: 15px;">Data Sosial</div>

<div class="stat-box">
    <div class="kep-card">
        <div class="card-title">Fasilitas Ibadah</div>
        <div class="card-value">{{ $data['statistik']['fasilitas_ibadah'] ?? '-' }}</div>
    </div>
    <div class="kep-card">
        <div class="card-title">Organisasi</div>
        <div class="card-value">{{ $data['statistik']['organisasi'] ?? '-' }}</div>
    </div>
    <div class="kep-card">
        <div class="card-title">Kegiatan Sosial</div>
        <div class="card-value">{{ $data['statistik']['kegiatan_sosial'] ?? '-' }}</div>
    </div>
</div>

<div class="section-title">Fasilitas Ibadah</div>
<div class="card-grid">
    @if(isset($data['fasilitas_ibadah']))
        @foreach($data['fasilitas_ibadah'] as $item)
            <div class="img-card sda-card" style="background-image:url('{{ asset($item['gambar']) }}')">
                <div class="card-footer-sda">
                    <div class="label">{{ $item['nama'] }}</div>
                    <div class="value">{{ $item['keterangan'] }}</div>
                </div>
            </div>
        @endforeach
    @endif
</div>

<div class="section-title">Organisasi</div>
<div class="card-grid">
    @if(isset($data['organisasi']))
        @foreach($data['organisasi'] as $item)
            <div class="img-card sda-card" style="background-image:url('{{ asset($item['gambar']) }}')">
                <div class="card-footer-sda">
                    <div class="label">{{ $item['nama'] }}</div>
                    <div class="value">{{ $item['keterangan'] }}</div>
                </div>
            </div>
        @endforeach
    @endif
</div>

<div class="section-title">Kegiatan Sosial</div>
<div class="card-grid">
    @if(isset($data['kegiatan_sosial']))
        @foreach($data['kegiatan_sosial'] as $item)
            <div class="img-card sda-card" style="background-image:url('{{ asset($item['gambar']) }}')">
                <div class="card-footer-sda">
                    <div class="label">{{ $item['nama'] }}</div>
                    <div class="value">{{ $item['keterangan'] }}</div>
                </div>
            </div>
        @endforeach
    @endif
</div>

@endsection

@push('scripts')
    <script src="{{ asset('js/kiosk-semesta.js') }}"></script>
@endpush