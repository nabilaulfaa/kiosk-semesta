@extends('layouts.app')
@section('title', 'APBDes - Kelurahan Jatimulyo')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/kiosk-semesta.css') }}">
@endpush

@section('content')

<div class="modul-header">
    <div class="modul-icon"><i class="bi bi-bar-chart-line"></i></div>
    <div class="modul-title">APBDes</div>
</div>

<div class="px-3 pb-3">

    <p class="fw-bold mb-2 mt-2" style="font-size:14px;">Ringkasan APBDes</p>

    <div class="d-flex justify-content-end mb-2">
        <div class="tahun-wrapper">
            <button class="tahun-btn" onclick="toggleTahunMenu()" type="button">
                Tahun <span id="yearText">{{ $tahunAktif ?? 2025 }}</span> ▼
            </button>
            <div id="tahunMenu" class="dropdown-tahun">
                @foreach($listTahun ?? [2025,2024,2023,2022,2021] as $t)
                    <a onclick="pilihTahun({{ $t }}); return false;" href="#">{{ $t }}</a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="ringkasan-grid mb-2">
        <div class="rg-cell"><div class="rg-label">Tahun Anggaran</div><div class="rg-value" id="gridTahun">-</div></div>
        <div class="rg-cell"><div class="rg-label">Total Pendapatan</div><div class="rg-value" id="gridPendapatan">-</div></div>
        <div class="rg-cell"><div class="rg-label">Total Belanja</div><div class="rg-value" id="gridBelanja">-</div></div>
        <div class="rg-cell"><div class="rg-label">SILPA</div><div class="rg-value" id="gridSilpa">-</div></div>
    </div>

    <div class="apb-bar-wrap mb-1">
        <div class="apb-bar-fill" id="barBelanja" style="width:0%"></div>
    </div>
    <div class="bar-legend mb-3">
        <div class="bl-item"><div class="bl-dot" style="background:#f5b5b7;"></div><span>Pendapatan</span></div>
        <div class="bl-item"><div class="bl-dot" style="background:var(--merah);"></div><span>Belanja</span></div>
    </div>

    <p class="fw-bold mb-2" style="font-size:14px;">Pendapatan</p>
    <table class="apb-table mb-3" id="tabelPendapatan">
        <tr><td colspan="2"><div class="skeleton w-75"></div></td></tr>
    </table>

    <p class="fw-bold mb-2" style="font-size:14px;">Belanja</p>
    <table class="apb-table mb-3" id="tabelBelanja">
        <tr><td colspan="2"><div class="skeleton w-75"></div></td></tr>
    </table>

    <p class="fw-bold mb-2" style="font-size:14px;">Program Pembangunan</p>
    <div id="listPembangunan">
        <div class="text-center py-3 text-secondary small">Memuat data...</div>
    </div>

    <p class="fw-bold mb-2 mt-3" style="font-size:14px;">Riwayat 5 Tahun</p>
    <div style="overflow-x:auto;border-radius:10px;border:1.5px solid var(--abu);">
        <table class="periode-table">
            <thead>
                <tr>
                    <th>Tahun</th><th>Pendapatan</th><th>Belanja</th>
                    <th>Pembiayaan</th><th>SILPA</th>
                </tr>
            </thead>
            <tbody id="bodyPeriode">
                <tr><td colspan="5" class="text-center py-3" style="color:#999;">Memuat data...</td></tr>
            </tbody>
        </table>
    </div>

</div>

@endsection

@push('scripts')
<script>
    const API_STATISTIK   = '/api/apbdes';
    const API_PERIODE     = '/api/apbdes-periode';
    const API_PEMBANGUNAN = '/api/pembangunan';

    var tahunAktif = {{ $tahunAktif ?? 2025 }};

    function toggleTahunMenu() {
        const menu = document.getElementById('tahunMenu');
        menu.style.display = menu.style.display === 'flex' ? 'none' : 'flex';
        if (menu.style.display === 'flex') menu.style.flexDirection = 'column';
    }

    function pilihTahun(tahun) {
        tahunAktif = tahun;
        document.getElementById('yearText').textContent = tahun;
        document.getElementById('tahunMenu').style.display = 'none';
        loadStatistik(tahun);
        loadPembangunan(tahun);
    }

    {{-- Tutup dropdown saat klik di luar — khusus tahun-wrapper APBDes --}}
    document.addEventListener('click', function(e) {
        const wrapper = document.querySelector('.tahun-wrapper');
        if (wrapper && !wrapper.contains(e.target)) {
            const menu = document.getElementById('tahunMenu');
            if (menu) menu.style.display = 'none';
        }
    });
</script>
<script src="{{ asset('js/kiosk-semesta.js') }}"></script>
@endpush