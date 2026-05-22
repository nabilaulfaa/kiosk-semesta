@extends('layouts.app')

@section('title', 'Data Infrastruktur')

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

<div class="subtitle-left">Data Infrastruktur</div>

<div class="infra-grid">
    <div class="infra-card">
        <small>Total Jalan</small>
        <b id="total-jalan">-</b>
    </div>
    <div class="infra-card">
        <small>Total Jembatan</small>
        <b id="total-jembatan">-</b>
    </div>
    <div class="infra-card">
        <small>Total Sekolah</small>
        <b id="total-sekolah">-</b>
    </div>
    <div class="infra-card">
        <small>Total Fasilitas Kesehatan</small>
        <b id="total-faskes">-</b>
    </div>
</div>

<div class="section-title">Informasi Jalan</div>
<div class="img-grid" id="jalan-container"></div>

<div class="section-title">Informasi Jembatan</div>
<div class="img-grid" id="jembatan-container"></div>

<div class="section-title">Informasi Sekolah</div>
<div class="img-grid" id="sekolah-container"></div>

<div class="section-title">Informasi Fasilitas Kesehatan</div>
<div class="img-grid" id="faskes-container"></div>

@endsection

@section('bottom_navigation')
    <a href="{{ route('profil.desa') }}" class="btn-nav">
        <i class="bi bi-arrow-left"></i> KEMBALI
    </a>
@endsection

@push('scripts')
<script src="{{ asset('js/kiosk-semesta.js') }}"></script>
<script>
fetch('/api/data-infrastruktur')
    .then(response => response.json())
    .then(data => {
        document.getElementById('total-jalan').innerText    = data.summary.total_jalan;
        document.getElementById('total-jembatan').innerText = data.summary.total_jembatan;
        document.getElementById('total-sekolah').innerText  = data.summary.total_sekolah;
        document.getElementById('total-faskes').innerText   = data.summary.total_faskes;

        renderInfra(data.jalan,    'jalan-container');
        renderInfra(data.jembatan, 'jembatan-container');
        renderInfra(data.sekolah,  'sekolah-container');
        renderInfra(data.faskes,   'faskes-container');
    });

function renderInfra(items, containerId) {
    document.getElementById(containerId).innerHTML = items.map(item => `
        <div class="img-card">
            <img src="${item.gambar}" alt="${item.nama}">
            <div class="img-label">${item.nama}</div>
        </div>
    `).join('');
}
</script>
@endpush