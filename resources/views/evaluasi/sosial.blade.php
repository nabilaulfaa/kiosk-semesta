@extends('layouts.app')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')

<div style="padding: 0 5vw;">
    <div class="modul-header" style="padding: 3vh 0 1vh;">
        <div class="modul-icon"><i class="bi bi-search"></i></div>
        <div class="modul-title">EVALUASI</div>
    </div>

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2vh;">
        <div class="page-title" style="padding:0;">SOSIAL</div>
        <select id="tahunFilter" class="select-merah">
            @foreach(array_keys($sosial) as $th)
            <option value="{{ $th }}" {{ $th == 2026 ? 'selected' : '' }}>Tahun {{ $th }}</option>
            @endforeach
        </select>
    </div>

    {{-- Summary Cards --}}
    <div class="row g-3 mb-3">
        <div class="col-6">
            <div class="kiosk-card">
                <div style="font-size:clamp(13px,1.2vw,18px);font-weight:600;color:#333;">Jumlah Penduduk</div>
                <div id="v-penduduk" style="font-size:clamp(16px,1.8vw,28px);font-weight:800;color:var(--merah-tua);margin-top:0.5vh;"></div>
            </div>
        </div>
        <div class="col-6">
            <div class="kiosk-card">
                <div style="font-size:clamp(13px,1.2vw,18px);font-weight:600;color:#333;">Jenis Kelamin</div>
                <div id="v-gender" style="font-size:clamp(13px,1.4vw,22px);font-weight:800;color:var(--merah-tua);margin-top:0.5vh;"></div>
            </div>
        </div>
        <div class="col-6">
            <div class="kiosk-card">
                <div style="font-size:clamp(13px,1.2vw,18px);font-weight:600;color:#333;">Pekerja Produktif</div>
                <div id="v-produktif" style="font-size:clamp(16px,1.8vw,28px);font-weight:800;color:var(--merah-tua);margin-top:0.5vh;"></div>
            </div>
        </div>
        <div class="col-6">
            <div class="kiosk-card">
                <div style="font-size:clamp(13px,1.2vw,18px);font-weight:600;color:#333;">Jumlah Balita</div>
                <div id="v-balita" style="font-size:clamp(16px,1.8vw,28px);font-weight:800;color:var(--merah-tua);margin-top:0.5vh;"></div>
            </div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="chart-box mb-3">
        <canvas id="lineChart"></canvas>
    </div>
    <div class="chart-box mb-4">
        <canvas id="barChart"></canvas>
    </div>
</div>

@endsection

@section('bottom_navigation')
<a href="{{ route('evaluasi') }}" class="btn-nav">
    <i class="bi bi-arrow-left"></i> KEMBALI
</a>
@endsection

@push('scripts')
<script>
const sosialData = @json($sosial);
let lineChart, barChart;

function updateDashboard(tahun) {
    const d = sosialData[tahun];
    document.getElementById('v-penduduk').innerText  = d.penduduk + ' Jiwa';
    document.getElementById('v-gender').innerHTML    = d.laki + ' Laki-laki<br>' + d.perempuan + ' Perempuan';
    document.getElementById('v-produktif').innerText = d.produktif + ' Orang';
    document.getElementById('v-balita').innerText    = d.balita + ' Balita';

    if (lineChart) lineChart.destroy();
    if (barChart)  barChart.destroy();

    lineChart = new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: d.tahun_label,
            datasets: [
                { label: 'Kelahiran', data: d.kelahiran, borderColor: '#22c55e', backgroundColor: 'rgba(34,197,94,0.2)', borderWidth: 3, tension: 0.4, fill: true },
                { label: 'Kematian',  data: d.kematian,  borderColor: '#ef4444', backgroundColor: 'rgba(239,68,68,0.2)',  borderWidth: 3, tension: 0.4, fill: true }
            ]
        },
        options: { responsive: true, maintainAspectRatio: false, devicePixelRatio: 2 }
    });

    barChart = new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: d.kategori_label,
            datasets: [{
                label: 'Jumlah Penduduk',
                data: d.kategori_jumlah,
                backgroundColor: ['#22c55e','#3b82f6','#f59e0b','#6366f1','#ef4444'],
                borderRadius: 8
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, devicePixelRatio: 2, plugins: { legend: { display: false } } }
    });
}

document.getElementById('tahunFilter').addEventListener('change', function () {
    updateDashboard(this.value);
});

updateDashboard('2026');
</script>
@endpush
