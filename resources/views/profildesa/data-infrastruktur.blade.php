@extends('layouts.app')

@section('title', 'Data Infrastruktur')

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

<div class="page-title" style="padding-left: 15px;">Data Infrastruktur</div>

<div class="infra-grid">
    <div class="infra-card">
        <small>Jalan Protokol</small>
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
        <small>Fasilitas Kesehatan</small>
        <b id="total-faskes">-</b>
    </div>
</div>

<div class="section-title">Informasi Jalan</div>
<div class="card-grid" id="jalan-container"></div>

<div id="jembatan-section" style="display:none;">
    <div class="section-title">Informasi Jembatan</div>
    <div class="card-grid" id="jembatan-container"></div>
</div>

<div class="section-title">Informasi Sekolah & Pendidikan</div>
<div class="card-grid" id="sekolah-container"></div>

<div class="section-title">Informasi Fasilitas Kesehatan</div>
<div class="card-grid" id="faskes-container"></div>

@endsection

@push('scripts')
<script src="{{ asset('js/kiosk-semesta.js') }}"></script>
<script>
fetch('/api/desa/infrastruktur')
    .then(response => response.json())
    .then(data => {
        document.getElementById('total-jalan').innerText    = data.summary.total_jalan;
        document.getElementById('total-jembatan').innerText = data.summary.total_jembatan || 0;
        document.getElementById('total-sekolah').innerText  = data.summary.total_sekolah;
        document.getElementById('total-faskes').innerText   = data.summary.total_faskes;

        renderInfra(data.jalan,   'jalan-container');
        renderInfra(data.sekolah, 'sekolah-container');
        renderInfra(data.faskes,  'faskes-container');

        if (data.jembatan && data.jembatan.length > 0) {
            document.getElementById('jembatan-section').style.display = 'block';
            renderInfra(data.jembatan, 'jembatan-container');
        }
    });

function renderInfra(items, containerId) {
    if (!items || items.length === 0) {
        document.getElementById(containerId).innerHTML = '<p class="text-muted" style="font-size:13px;">Data belum tersedia.</p>';
        return;
    }
    document.getElementById(containerId).innerHTML = items.map(item => `
        <div class="img-card sda-card" style="background-image:url('${item.gambar}')">
            <div class="card-footer-sda">
                <div class="label">${item.nama}</div>
            </div>
        </div>
    `).join('');
}
</script>
@endpush