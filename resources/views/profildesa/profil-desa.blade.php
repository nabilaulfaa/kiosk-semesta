@extends('layouts.app')

@section('title', 'Profil Desa')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/kiosk-semesta.css') }}">
@endpush

@section('content')

<div class="modul-header">
    <div class="modul-icon"><i class="bi bi-houses"></i></div>
    <div class="modul-title">PROFIL DESA</div>
</div>

<div class="text-center mt-2 center-image">
    <img src="{{ asset('images/Add-Comment-2 Streamline Milano (profildesa).png') }}"
         onerror="this.style.display='none'" alt="Profil Desa">
</div>

<div class="px-3 mt-2">
    <table class="data-table">
        <tr>
            <td class="td-label">Desa</td>
            <td class="td-value">{{ $data['nama_desa'] ?? '-' }}</td>
        </tr>
        <tr>
            <td class="td-label">Kecamatan</td>
            <td class="td-value">{{ $data['kecamatan'] ?? '-' }}</td>
        </tr>
        <tr>
            <td class="td-label">Kabupaten/Kota</td>
            <td class="td-value">{{ $data['kabupaten'] ?? '-' }}</td>
        </tr>
        <tr>
            <td class="td-label">Provinsi</td>
            <td class="td-value">{{ $data['provinsi'] ?? '-' }}</td>
        </tr>
    </table>
</div>

<div class="px-3 mt-3">
    <div class="alamat-title">Alamat Kantor Desa</div>
    <div class="alamat-box">{{ $data['alamat'] ?? '-' }}</div>
</div>

<div class="px-3 mt-3 mb-3">
    <div class="row g-2">
        <div class="col-4">
            <button class="btn-desa" onclick="openModal('modalVisiMisi')">
                VISI &amp; MISI
            </button>
        </div>
        <div class="col-4">
            <button class="btn-desa" onclick="openModal('modalStruktur')">
                STRUKTUR DESA
            </button>
        </div>
        <div class="col-4 position-relative">
            <button class="btn-desa" id="btnMonografi" onclick="toggleMonografi()">
                MONOGRAFI <span id="arrowIcon">›</span>
            </button>
            <div id="monografiMenu" class="monografi-dropdown">
                <a href="{{ route('data.umum') }}">Data Umum</a>
                <a href="{{ route('data.geografis') }}">Data Geografis</a>
                <a href="{{ route('data.kependudukan') }}">Data Kependudukan</a>
                <a href="{{ route('data.sosial') }}">Data Sosial</a>
                <a href="{{ route('ekonomi') }}">Data Ekonomi</a>
                <a href="{{ route('data.sda') }}">Data Potensi SDA</a>
                <a href="{{ route('data.infrastruktur') }}">Data Infrastruktur</a>
                <a href="{{ route('data.pendidikan') }}">Data Pendidikan</a>
                <a href="{{ route('data.kesehatan') }}">Data Kesehatan</a>
            </div>
        </div>
    </div>
</div>

@endsection

{{-- Halaman index profil desa → tombol BERANDA (default layout, tidak perlu override) --}}

@section('modal_content')

<div class="modal-overlay" id="modalVisiMisi">
    <div class="modal-box">
        <div class="modal-header-kiosk">
            <h2>VISI &amp; MISI</h2>
            <button class="btn-close-modal" onclick="closeModal('modalVisiMisi')">✕</button>
        </div>
        <div class="modal-body-kiosk">
            <p class="fw-bold text-center mb-1" style="font-size:clamp(13px,1.3vw,20px);">VISI</p>
            <p style="font-size:clamp(12px,1.2vw,18px);">{{ $data['visi'] ?? '-' }}</p>
            <hr style="border-color:var(--merah);border-width:2px;">
            <p class="fw-bold text-center mb-1" style="font-size:clamp(13px,1.3vw,20px);">MISI</p>
            <ol style="font-size:clamp(12px,1.2vw,18px);padding-left:18px;">
                @foreach($data['misi'] ?? [] as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ol>
        </div>
    </div>
</div>

<div class="modal-overlay" id="modalStruktur">
    <div class="modal-box" style="max-width:700px;">
        <div class="modal-header-kiosk">
            <h2>STRUKTUR DESA</h2>
            <button class="btn-close-modal" onclick="closeModal('modalStruktur')">✕</button>
        </div>
        <div class="modal-body-kiosk text-center">
            <img src="{{ asset($data['struktur'] ?? '') }}"
                 class="img-fluid w-100"
                 style="max-height:65vh;object-fit:contain;"
                 id="strukturImg"
                 onclick="toggleZoom(this)"
                 alt="Struktur Desa">
            <p class="text-muted mt-2 mb-0" style="font-size:11px;">Klik gambar untuk zoom</p>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script src="{{ asset('js/kiosk-semesta.js') }}"></script>
@endpush