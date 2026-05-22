@extends('layouts.app')

@section('title', 'Data Potensi Sumber Daya Alam')

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

<div class="subtitle-left">Data Potensi Sumber Daya Alam</div>

<div class="tab-wrapper">
    <div class="tab-info">Potensi Pertanian</div>
    <div class="tab-info">Potensi Perkebunan</div>
    <div class="tab-info">Potensi Perikanan</div>
    <div class="tab-info">Potensi Wisata</div>
</div>

<div class="category-title">Potensi Pertanian</div>
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

<div class="category-title">Potensi Perkebunan</div>
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

<div class="category-title">Potensi Perikanan</div>
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

<div class="category-title">Potensi Wisata</div>
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

<div class="category-title">Sumber Daya</div>
<div class="sumberdaya-grid">
    <div class="sd-card">
        <div class="sd-label">Total Lahan Pertanian</div>
        <div class="sd-value">{{ $data['sumber_daya']['lahan_pertanian'] }}</div>
    </div>
    <div class="sd-card">
        <div class="sd-label">Cakupan Kehutanan</div>
        <div class="sd-value">{{ $data['sumber_daya']['kehutanan'] }}</div>
    </div>
    <div class="sd-card">
        <div class="sd-label">Hasil Perikanan</div>
        <div class="sd-value">{{ $data['sumber_daya']['perikanan'] }}</div>
    </div>
    <div class="sd-card">
        <div class="sd-label">Kunjungan Wisatawan</div>
        <div class="sd-value">{{ $data['sumber_daya']['wisatawan'] }}</div>
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