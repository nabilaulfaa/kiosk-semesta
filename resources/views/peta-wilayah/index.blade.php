@extends('layouts.app')
@section('title', 'Peta Wilayah')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/kiosk-semesta.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@section('content')

<div style="overflow-y: auto; flex: 1; min-height: 0; padding-bottom: 2vh;">

    <div class="modul-header">
        <div class="modul-icon"><i class="bi bi-map"></i></div>
        <div class="modul-title">PETA WILAYAH</div>
    </div>

    {{-- PETA --}}
    <div class="map-wrap" style="margin: 0 clamp(10px, 2vw, 24px);">
        <div class="map-spinner" id="mapSpinner">
            <div class="spinner-ring"></div>
            <span style="font-size: clamp(13px, 1.3vw, 20px);">Memuat peta…</span>
        </div>
        <div id="map" style="height: clamp(280px, 45vh, 600px);"></div>
    </div>

    {{-- Toolbar — Semua | Hapus | Refresh sejajar --}}
    <div class="d-flex align-items-center justify-content-between mt-2 mb-1"
        style="padding: 0 clamp(10px, 2vw, 24px);">
        <span style="font-size: clamp(13px, 1.3vw, 20px); font-weight: 700; color: #555;">
            Tampilkan di peta :
        </span>
        <div class="d-flex gap-2">
            <button class="toggle-btn" onclick="checkAll(true)"
                style="font-size: clamp(12px, 1.2vw, 18px); padding: clamp(6px, 0.8vh, 12px) clamp(14px, 1.5vw, 24px); border-radius: 8px;">
                Semua
            </button>
            <button class="toggle-btn" onclick="checkAll(false)"
                style="font-size: clamp(12px, 1.2vw, 18px); padding: clamp(6px, 0.8vh, 12px) clamp(14px, 1.5vw, 24px); border-radius: 8px;">
                Hapus
            </button>
            {{-- REVISI 2: Tombol Refresh dipindah ke sini --}}
            <button class="toggle-btn" onclick="refreshAll()"
                style="font-size: clamp(12px, 1.2vw, 18px); padding: clamp(6px, 0.8vh, 12px) clamp(14px, 1.5vw, 24px); border-radius: 8px; background: var(--merah-tua); color: white; border-color: var(--merah-tua);">
                <i class="bi bi-arrow-clockwise"></i> Refresh
            </button>
        </div>
    </div>

    {{-- LEGENDA --}}
    <div class="legend-wrap" style="margin: 0 clamp(10px, 2vw, 24px) clamp(10px, 1.5vh, 20px);">
        <div class="legend-head" style="font-size: clamp(13px, 1.3vw, 20px); padding: clamp(8px, 1.2vh, 16px);">
            Legenda
        </div>
        <div class="legend-grid">

            {{-- REVISI 1: Kolom Informasi Tanah — Tanah Warga dihapus --}}
            <div class="legend-col" style="padding: clamp(10px, 1.4vh, 20px) clamp(10px, 1.2vw, 18px);">
                <div class="legend-col-ttl" style="font-size: clamp(11px, 1.1vw, 17px); margin-bottom: clamp(8px, 1vh, 14px);">
                    Informasi Tanah
                </div>
                <label class="chk-item" style="margin-bottom: clamp(6px, 0.9vh, 12px);">
                    <input type="checkbox" class="layer-chk" data-layer="wilayah" checked>
                    <span class="chk-box" style="background: var(--merah); width: clamp(14px, 1.4vw, 22px); height: clamp(14px, 1.4vw, 22px);"></span>
                    <span class="chk-label" style="font-size: clamp(12px, 1.2vw, 18px);">Batas Wilayah</span>
                </label>
                <div id="legendDusun"></div>
            </div>

            <div class="legend-col" style="padding: clamp(10px, 1.4vh, 20px) clamp(10px, 1.2vw, 18px);">
                <div class="legend-col-ttl" style="font-size: clamp(11px, 1.1vw, 17px); margin-bottom: clamp(8px, 1vh, 14px);">
                    Infrastruktur
                </div>
                @foreach([
                    ['kategori' => 'Kantor Desa',    'icon' => 'fa-solid fa-landmark'],
                    ['kategori' => 'Masjid/Mushola', 'icon' => 'fa-solid fa-mosque'],
                    ['kategori' => 'Makam',          'icon' => 'fa-solid fa-monument'],
                ] as $item)
                <label class="chk-item" style="margin-bottom: clamp(6px, 0.9vh, 12px);">
                    <input type="checkbox" class="infra-chk" data-kategori="{{ $item['kategori'] }}" checked>
                    <span class="chk-infra-box" style="width: clamp(14px, 1.4vw, 22px); height: clamp(14px, 1.4vw, 22px);"></span>
                    <span class="chk-icon" style="font-size: clamp(13px, 1.3vw, 20px);"><i class="{{ $item['icon'] }}"></i></span>
                    <span class="chk-label" style="font-size: clamp(12px, 1.2vw, 18px);">{{ $item['kategori'] }}</span>
                </label>
                @endforeach
            </div>
            
            <div class="legend-col" style="padding: clamp(10px, 1.4vh, 20px) clamp(10px, 1.2vw, 18px);">
                <div class="legend-col-ttl" style="font-size: clamp(11px, 1.1vw, 17px); margin-bottom: clamp(8px, 1vh, 14px);">
                    Infrastruktur
                </div>
                @foreach([
                    ['kategori' => 'Pendidikan',       'icon' => 'fa-solid fa-school'],
                    ['kategori' => 'Kesehatan',        'icon' => 'fa-solid fa-hospital'],
                    ['kategori' => 'Restoran/Cafe',    'icon' => 'fa-solid fa-utensils'],
                    ['kategori' => 'Stadion/Lapangan', 'icon' => 'fa-solid fa-map'],
                ] as $item)
                <label class="chk-item" style="margin-bottom: clamp(6px, 0.9vh, 12px);">
                    <input type="checkbox" class="infra-chk" data-kategori="{{ $item['kategori'] }}" checked>
                    <span class="chk-infra-box" style="width: clamp(14px, 1.4vw, 22px); height: clamp(14px, 1.4vw, 22px);"></span>
                    <span class="chk-icon" style="font-size: clamp(13px, 1.3vw, 20px);"><i class="{{ $item['icon'] }}"></i></span>
                    <span class="chk-label" style="font-size: clamp(12px, 1.2vw, 18px);">{{ $item['kategori'] }}</span>
                </label>
                @endforeach
            </div>

        </div>
    </div>

</div>

@endsection

{{-- REVISI 2: Tombol Refresh di footer section dihapus / diganti tombol Beranda saja --}}
@section('bottom_navigation')
{{-- Kosong: tombol Refresh sudah dipindah ke toolbar di atas --}}
@endsection

@push('scripts')
<script>
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