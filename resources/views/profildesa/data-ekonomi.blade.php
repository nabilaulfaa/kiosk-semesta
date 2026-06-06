@extends('layouts.app')

@section('title', 'Data Ekonomi')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

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

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2vh;padding: 0 5vw;">
    <div class="page-title" style="padding:0;">DATA EKONOMI</div>
    <select id="filterTahun" class="select-merah">
        @foreach(array_keys($ekonomi) as $th)
        <option value="{{ $th }}" {{ $th == 2026 ? 'selected' : '' }}>Tahun {{ $th }}</option>
        @endforeach
    </select>
</div>

<div style="padding: 0 5vw;">

    {{-- Summary Cards --}}
    <div class="row g-3 mb-3">
        <div class="col-6">
            <div class="kiosk-card">
                <div style="font-size:clamp(13px,1.2vw,20px);font-weight:600;color:#333;margin-bottom:0.5vh;">Pendapatan Desa Tahun ini</div>
                <div id="pendapatanCard" style="font-size:clamp(16px,1.8vw,30px);font-weight:800;color:var(--merah-tua);">-</div>
            </div>
        </div>
        <div class="col-6">
            <div class="kiosk-card">
                <div style="font-size:clamp(13px,1.2vw,20px);font-weight:600;color:#333;margin-bottom:0.5vh;">Pengeluaran Anggaran Tahun ini</div>
                <div id="pengeluaranCard" style="font-size:clamp(16px,1.8vw,30px);font-weight:800;color:var(--merah-tua);">-</div>
            </div>
        </div>
        <div class="col-6">
            <div class="kiosk-card">
                <div style="font-size:clamp(13px,1.2vw,20px);font-weight:600;color:#333;margin-bottom:0.5vh;">Jumlah Pengusaha Desa</div>
                <div id="pengusahaCard" style="font-size:clamp(16px,1.8vw,30px);font-weight:800;color:var(--merah-tua);">-</div>
            </div>
        </div>
        <div class="col-6">
            <div class="kiosk-card">
                <div style="font-size:clamp(13px,1.2vw,20px);font-weight:600;color:#333;margin-bottom:0.5vh;">Program Ekonomi Desa</div>
                <div id="programCard" style="font-size:clamp(16px,1.8vw,30px);font-weight:800;color:var(--merah-tua);">-</div>
            </div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="chart-box mb-3">
        <div class="chart-title">Pendapatan vs Pengeluaran</div>
        <canvas id="chartKeuangan"></canvas>
    </div>

    <div class="chart-box mb-4">
        <div class="chart-title">Perkembangan Jumlah Pengusaha</div>
        <canvas id="chartPengusaha"></canvas>
    </div>

</div>

@endsection

@push('scripts')
<script src="{{ asset('js/kiosk-semesta.js') }}"></script>
<script>
const ekonomiData = @json($ekonomi);
const bulanLabels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
let chart1, chart2;

function formatRupiah(num) {
    return 'Rp ' + Number(num).toLocaleString('id-ID');
}

function loadData() {
    const tahun = document.getElementById('filterTahun').value;
    const data  = ekonomiData[tahun];
    if (!data) return;

    document.getElementById('pendapatanCard').innerText  = formatRupiah(data.summary.pendapatan);
    document.getElementById('pengeluaranCard').innerText = formatRupiah(data.summary.pengeluaran);
    document.getElementById('pengusahaCard').innerText   = data.summary.pengusaha + ' UMKM';
    document.getElementById('programCard').innerText     = data.summary.program + ' Program';

    if (chart1) chart1.destroy();
    if (chart2) chart2.destroy();

    chart1 = new Chart(document.getElementById('chartKeuangan'), {
        type: 'line',
        data: {
            labels: bulanLabels,
            datasets: [
                { label: 'Pendapatan',  data: data.bulanan.pendapatan,  borderColor: '#22c55e', backgroundColor: 'rgba(34,197,94,0.2)', fill: true, borderWidth: 3, tension: 0.1 },
                { label: 'Pengeluaran', data: data.bulanan.pengeluaran, borderColor: '#ef4444', backgroundColor: 'rgba(239,68,68,0.2)', fill: true, borderWidth: 2, borderDash: [5,5], tension: 0.1 }
            ]
        },
        options: { responsive: true, maintainAspectRatio: false, devicePixelRatio: 2, scales: { y: { beginAtZero: true } } }
    });

    chart2 = new Chart(document.getElementById('chartPengusaha'), {
        type: 'bar',
        data: {
            labels: bulanLabels,
            datasets: [{ label: 'Jumlah UMKM', data: data.bulanan.pengusaha, backgroundColor: '#3b82f6' }]
        },
        options: { responsive: true, maintainAspectRatio: false, devicePixelRatio: 2, scales: { y: { beginAtZero: true } } }
    });
}

document.getElementById('filterTahun').addEventListener('change', loadData);
loadData();
</script>
@endpush