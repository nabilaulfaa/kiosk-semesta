@extends('layouts.app')

@section('title', 'Data Potensi Sumber Daya Alam')

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

<div class="page-title" style="padding-left: 15px;">Data Potensi Sumber Daya Alam</div>

<div class="section-title">Potensi Pertanian & TOGA</div>
<div class="card-grid">
    @foreach($data['pertanian'] as $card)
        <div class="img-card sda-card" style="background-image:url('{{ asset('images/'.$card['image']) }}')">
            <div class="card-footer-sda">
                <div class="label">{{ $card['label'] }}</div>
                <div class="value">{{ $card['value'] }}</div>
            </div>
        </div>
    @endforeach
</div>

<div class="section-title">Potensi Kebun Warga</div>
<div class="card-grid">
    @foreach($data['perkebunan'] as $card)
        <div class="img-card sda-card" style="background-image:url('{{ asset('images/'.$card['image']) }}')">
            <div class="card-footer-sda">
                <div class="label">{{ $card['label'] }}</div>
                <div class="value">{{ $card['value'] }}</div>
            </div>
        </div>
    @endforeach
</div>

<div class="section-title">Potensi Budidaya Ikan</div>
<div class="card-grid">
    @foreach($data['perikanan'] as $card)
        <div class="img-card sda-card" style="background-image:url('{{ asset('images/'.$card['image']) }}')">
            <div class="card-footer-sda">
                <div class="label">{{ $card['label'] }}</div>
                <div class="value">{{ $card['value'] }}</div>
            </div>
        </div>
    @endforeach
</div>

<div class="section-title">Potensi Wisata & Edukasi</div>
<div class="card-grid">
    @foreach($data['wisata'] as $card)
        <div class="img-card sda-card" style="background-image:url('{{ asset('images/'.$card['image']) }}')">
            <div class="card-footer-sda">
                <div class="label">{{ $card['label'] }}</div>
                <div class="value">{{ $card['value'] }}</div>
            </div>
        </div>
    @endforeach
</div>

<div class="section-title">Sumber Daya</div>
<div class="sumberdaya-grid">
    <div class="sd-card">
        <div class="sd-label">Lahan Urban Farming</div>
        <div class="sd-value">{{ $data['sumber_daya']['lahan_pertanian'] }}</div>
    </div>
    <div class="sd-card">
        <div class="sd-label">Ruang Terbuka Hijau</div>
        <div class="sd-value">{{ $data['sumber_daya']['kehutanan'] }}</div>
    </div>
    <div class="sd-card">
        <div class="sd-label">Hasil Budidaya Ikan</div>
        <div class="sd-value">{{ $data['sumber_daya']['perikanan'] }}</div>
    </div>
    <div class="sd-card">
        <div class="sd-label">Kunjungan Wisatawan</div>
        <div class="sd-value">{{ $data['sumber_daya']['wisatawan'] }}</div>
    </div>
</div>

@endsection

@push('scripts')
    <script src="{{ asset('js/kiosk-semesta.js') }}"></script>
@endpush