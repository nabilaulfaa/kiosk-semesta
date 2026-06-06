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

<div style="padding:0 5vw 3vh;">

    <div style="font-size:clamp(18px,2vw,32px);font-weight:800;margin-bottom:2vh;">
        Ringkasan APBDes
    </div>

    {{-- Filter Tahun --}}
    <div class="d-flex justify-content-end mb-3">
        <div class="tahun-wrapper">
            <button class="tahun-btn" onclick="toggleTahunMenu()" type="button">
                Tahun <span id="yearText">{{ $tahunAktif ?? 2025 }}</span> ▼
            </button>

            <div id="tahunMenu" class="dropdown-tahun">
                @foreach($listTahun ?? [2025,2024,2023,2022,2021] as $t)
                    <a onclick="pilihTahun({{ $t }}); return false;" href="#">
                        {{ $t }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="row g-3 mb-4">

        <div class="col-6">
            <div class="kiosk-card">
                <div style="font-size:clamp(13px,1.2vw,20px);font-weight:600;color:#333;margin-bottom:0.5vh;">
                    Tahun Anggaran
                </div>
                <div id="gridTahun"
                     style="font-size:clamp(16px,1.8vw,30px);font-weight:800;color:var(--merah-tua);">
                    -
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="kiosk-card">
                <div style="font-size:clamp(13px,1.2vw,20px);font-weight:600;color:#333;margin-bottom:0.5vh;">
                    Total Pendapatan
                </div>
                <div id="gridPendapatan"
                     style="font-size:clamp(16px,1.8vw,30px);font-weight:800;color:var(--merah-tua);">
                    -
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="kiosk-card">
                <div style="font-size:clamp(13px,1.2vw,20px);font-weight:600;color:#333;margin-bottom:0.5vh;">
                    Total Belanja
                </div>
                <div id="gridBelanja"
                     style="font-size:clamp(16px,1.8vw,30px);font-weight:800;color:var(--merah-tua);">
                    -
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="kiosk-card">
                <div style="font-size:clamp(13px,1.2vw,20px);font-weight:600;color:#333;margin-bottom:0.5vh;">
                    SILPA
                </div>
                <div id="gridSilpa"
                     style="font-size:clamp(16px,1.8vw,30px);font-weight:800;color:var(--merah-tua);">
                    -
                </div>
            </div>
        </div>

    </div>

<div class="apb-bar-wrap mb-1">
    <div class="apb-bar-fill" id="barBelanja" style="width:0%"></div>
</div>

<div class="bar-legend mb-4">
    <div class="bl-item">
        <div class="bl-dot" style="background:#f5b5b7;"></div>
       <span style="
        font-size:clamp(13px,1.2vw,20px);
        font-weight:600;
        color:#333;
    ">
        Pendapatan
    </span>
    </div>

    <div class="bl-item">
        <div class="bl-dot" style="background:var(--merah);"></div>
       <span style="
        font-size:clamp(13px,1.2vw,20px);
        font-weight:600;
        color:#333;
    ">
        Belanja
    </span>
    </div>
</div>

    {{-- Pendapatan --}}
    <div style="color:var(--merah-tua);font-size:clamp(16px,1.8vw,30px);font-weight:800;margin-bottom:1.5vh;">
        Pendapatan
    </div>

    <div class="project-card kiosk-card d-flex gap-3 mb-3">
        <div style="flex:1;width:100%;">
            <table class="apb-table mb-0" id="tabelPendapatan">
                <tr>
                    <td colspan="2">
                        <div class="skeleton w-75"></div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    {{-- Belanja --}}
    <div style="color:var(--merah-tua);font-size:clamp(16px,1.8vw,30px);font-weight:800;margin-bottom:1.5vh;">
        Belanja
    </div>

    <div class="project-card kiosk-card d-flex gap-3 mb-3">
        <div style="flex:1;width:100%;">
            <table class="apb-table mb-0" id="tabelBelanja">
                <tr>
                    <td colspan="2">
                        <div class="skeleton w-75"></div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    {{-- Program Pembangunan --}}
    <div style="color:var(--merah-tua);font-size:clamp(16px,1.8vw,30px);font-weight:800;margin-bottom:1.5vh;">
        Program Pembangunan
    </div>

    <div id="listPembangunan" class="mb-4">
        <div class="text-center py-3 text-secondary small">
            Memuat data...
        </div>
    </div>

    {{-- Riwayat 5 Tahun --}}
    <div style="color:var(--merah-tua);font-size:clamp(16px,1.8vw,30px);font-weight:800;margin-bottom:1.5vh;">
        Riwayat 5 Tahun
    </div>

    <div class="table-wrap mb-4">
        <div class="table-header">
            <div>Tahun</div>
            <div>Pendapatan</div>
            <div>Belanja</div>
            <div>Pembiayaan</div>
            <div>SILPA</div>
        </div>
        <div id="bodyPeriode">
            <div class="table-row">
                <div style="text-align:center;color:#666;">Memuat data...</div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
    const API_STATISTIK   = '/api/desa/apbdes';
    const API_PERIODE     = '/api/desa/apbdes-periode';
    const API_PEMBANGUNAN = '/api/desa/pembangunan';

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

    document.addEventListener('click', function(e) {
        const wrapper = document.querySelector('.tahun-wrapper');
        if (wrapper && !wrapper.contains(e.target)) {
            const menu = document.getElementById('tahunMenu');
            if (menu) menu.style.display = 'none';
        }
    });

    function renderPembangunan(items) {
        if (!items || items.length === 0) {
            document.getElementById('listPembangunan').innerHTML =
                '<div class="text-center py-3 text-secondary small">Tidak ada program pembangunan tahun ini.</div>';
            return;
        }

        document.getElementById('listPembangunan').innerHTML = items.map(item => {
            const rw     = item.wilayah?.rw ? `RW ${item.wilayah.rw}` : '';
            const rt     = item.wilayah?.rt ? `RT ${item.wilayah.rt}` : '';
            const lokasi = [item.lokasi, rw, rt].filter(Boolean).join(' · ');

            return `
            <div class="project-card kiosk-card mb-3">
                <div style="font-weight:700;font-size:clamp(14px,1.4vw,22px);margin-bottom:4px;">
                    ${item.judul}
                </div>
                <div style="font-size:clamp(12px,1.1vw,18px);color:#555;margin-bottom:6px;">
                    ${item.keterangan}
                </div>
                <div style="font-size:clamp(11px,1vw,16px);color:#888;">
                    📍 ${lokasi} &nbsp;|&nbsp; 👷 ${item.pelaksana}
                </div>
                <div style="font-size:clamp(12px,1.1vw,18px);color:var(--merah-tua);font-weight:700;margin-top:6px;">
                    Rp ${Number(item.anggaran).toLocaleString('id-ID')}
                </div>
                <div style="font-size:clamp(11px,1vw,16px);color:#666;">
                    Sumber: ${item.sumber_dana}
                </div>
            </div>`;
        }).join('');
    }
</script>

<script src="{{ asset('js/kiosk-semesta.js') }}"></script>
@endpush