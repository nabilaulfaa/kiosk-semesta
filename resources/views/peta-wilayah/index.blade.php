@extends('layouts.app')
@section('title', 'Peta Wilayah')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/kiosk-semesta.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    {{-- ✅ FIX: Leaflet CSS wajib ada agar peta bisa render --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@section('content')

<div style="overflow-y: auto; flex: 1; min-height: 0; padding-bottom: 2vh;">

    <div class="modul-header">
        <div class="modul-icon"><i class="bi bi-map"></i></div>
        <div class="modul-title">PETA WILAYAH</div>
    </div>

    <div class="map-wrap">
        <div class="map-spinner" id="mapSpinner">
            <div class="spinner-ring"></div>
            <span>Memuat peta…</span>
        </div>
        <div id="map"></div>
    </div>

    <div class="d-flex align-items-center justify-content-between px-3 mt-2 mb-1">
        <span class="fw-semibold" style="font-size:11px;color:#666;">Tampilkan di peta :</span>
        <div class="d-flex gap-2">
            <button class="toggle-btn" onclick="checkAll(true)">Semua</button>
            <button class="toggle-btn" onclick="checkAll(false)">Hapus</button>
        </div>
    </div>

    <div class="legend-wrap">
        <div class="legend-head">Legenda</div>
        <div class="legend-grid">

            <div class="legend-col">
                <div class="legend-col-ttl">Informasi Tanah</div>
                <label class="chk-item">
                    <input type="checkbox" class="layer-chk" data-layer="wilayah" checked>
                    <span class="chk-box" style="background:var(--merah);"></span>
                    <span class="chk-label">Batas Wilayah</span>
                </label>
                <label class="chk-item">
                    <input type="checkbox" class="infra-chk" data-kategori="Tanah Warga" checked>
                    <span class="chk-infra-box" style="background:#795548;border-color:#795548;"></span>
                    <span class="chk-label">Tanah Warga</span>
                </label>
                <div id="legendDusun"></div>
            </div>

            <div class="legend-col">
                <div class="legend-col-ttl">Infrastruktur</div>
                <label class="chk-item"><input type="checkbox" class="infra-chk" data-kategori="Kantor Desa" checked><span class="chk-infra-box"></span><span class="chk-icon"><i class="fa-solid fa-landmark"></i></span><span class="chk-label">Kantor Desa</span></label>
                <label class="chk-item"><input type="checkbox" class="infra-chk" data-kategori="Masjid/Mushola" checked><span class="chk-infra-box"></span><span class="chk-icon"><i class="fa-solid fa-mosque"></i></span><span class="chk-label">Masjid/Mushola</span></label>
                <label class="chk-item"><input type="checkbox" class="infra-chk" data-kategori="Gereja" checked><span class="chk-infra-box"></span><span class="chk-icon"><i class="fa-solid fa-church"></i></span><span class="chk-label">Gereja</span></label>
                <label class="chk-item"><input type="checkbox" class="infra-chk" data-kategori="Pura" checked><span class="chk-infra-box"></span><span class="chk-icon"><i class="fa-solid fa-torii-gate"></i></span><span class="chk-label">Pura</span></label>
                <label class="chk-item"><input type="checkbox" class="infra-chk" data-kategori="Makam" checked><span class="chk-infra-box"></span><span class="chk-icon"><i class="fa-solid fa-cross"></i></span><span class="chk-label">Makam</span></label>
            </div>

            <div class="legend-col">
                <div class="legend-col-ttl">Infrastruktur</div>
                <label class="chk-item"><input type="checkbox" class="infra-chk" data-kategori="Pendidikan" checked><span class="chk-infra-box"></span><span class="chk-icon"><i class="fa-solid fa-school"></i></span><span class="chk-label">Pendidikan</span></label>
                <label class="chk-item"><input type="checkbox" class="infra-chk" data-kategori="Pasar" checked><span class="chk-infra-box"></span><span class="chk-icon"><i class="fa-solid fa-store"></i></span><span class="chk-label">Pasar</span></label>
                <label class="chk-item"><input type="checkbox" class="infra-chk" data-kategori="Kesehatan" checked><span class="chk-infra-box"></span><span class="chk-icon"><i class="fa-solid fa-hospital"></i></span><span class="chk-label">Kesehatan</span></label>
                <label class="chk-item"><input type="checkbox" class="infra-chk" data-kategori="Restoran/Cafe" checked><span class="chk-infra-box"></span><span class="chk-icon"><i class="fa-solid fa-utensils"></i></span><span class="chk-label">Restoran/Cafe</span></label>
                <label class="chk-item"><input type="checkbox" class="infra-chk" data-kategori="Stadion/Lapangan" checked><span class="chk-infra-box"></span><span class="chk-icon"><i class="fa-solid fa-futbol"></i></span><span class="chk-label">Stadion/Lapangan</span></label>
            </div>

        </div>
    </div>

</div>

@endsection

{{-- Override footer nav --}}
@section('bottom_navigation')
<div class="d-flex gap-3 w-100" style="padding: 0 4vw;">
    <a href="{{ route('beranda') }}" class="btn-nav" style="flex:1;">
        <i class="bi bi-house-door-fill"></i>
        BERANDA
    </a>
    <button class="btn-nav" onclick="refreshAll()" style="flex:1;border:none;cursor:pointer;">
        <i class="bi bi-arrow-clockwise"></i>
        REFRESH
    </button>
</div>
@endsection

@push('scripts')
<script>
    {{-- Variabel ini harus didefinisikan sebelum kiosk-semesta.js di-load --}}
    const API = {
        geojson:       '{{ route("peta.geojson") }}',
        infrastruktur: '{{ route("peta.infrastruktur") }}',
        dusun:         '{{ route("peta.dusun") }}',
    };
    const MAP_CENTER = [-7.9435, 112.6295];
    const MAP_ZOOM   = 15;
</script>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="{{ asset('js/kiosk-semesta.js') }}"></script>
@endpush