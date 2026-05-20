@extends('layouts.app')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')

<div style="padding: 0 5vw 4vh;">

    <div class="modul-header" style="padding: 3vh 0 1vh;">
        <div class="modul-icon"><i class="bi bi-buildings"></i></div>
        <div class="modul-title">BUMDES</div>
    </div>

    <div style="font-size:clamp(18px,2.2vw,36px);font-weight:800;color:var(--teks-gelap);margin-bottom:3vh;">BADAN USAHA MILIK DESA</div>

    {{-- Struktur Pengurus --}}
    <div style="color:var(--merah-tua);font-size:clamp(16px,1.8vw,28px);font-weight:700;margin-bottom:1.5vh;">Struktur Pengurus</div>
    <div class="row g-3 mb-4">
        @foreach($pengurus as $i => $p)
        <div class="col-6">
            <div class="card-pengurus" onclick="showDetailPengurus({{ $i }})">
                <div class="photo-container">
                    <img src="{{ asset($p['foto']) }}" alt="{{ $p['nama'] }}" class="photo-img">
                </div>
                <div>
                    <div class="jabatan">{{ $p['jabatan'] }}</div>
                    <div class="nama">{{ $p['nama'] }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Unit Usaha --}}
    <div style="color:var(--merah-tua);font-size:clamp(16px,1.8vw,28px);font-weight:700;margin-bottom:1.5vh;">Unit Usaha</div>
    <div class="row g-3 mb-4">
        @foreach($unitUsaha as $key => $unit)
        @php
        $warnaBg = ['blue'=>'#C5E1FF','red'=>'#F8B4B4','green'=>'#C1E1C1','yellow'=>'#FFE4B5'];
        $warnaLabel = ['blue'=>'#007bff','red'=>'#ff4d4d','green'=>'#28a745','yellow'=>'#ffa500'];
        $bg = $warnaBg[$unit['warna']] ?? '#eee';
        $lbl = $warnaLabel[$unit['warna']] ?? '#333';
        @endphp
        <div class="col-3">
            <div style="background:{{ $bg }};border-radius:20px;overflow:hidden;text-align:center;padding-bottom:2vh;cursor:pointer;"
                onclick="updateChartByUnit('{{ $key }}'); openModal('modalStatistik{{ ucfirst($key) }}')">
                <div style="background:{{ $lbl }};color:white;padding:1.5vh;font-weight:800;font-size:clamp(13px,1.3vw,20px);margin-bottom:1vh;">
                    {{ $unit['label'] }}
                </div>
                <div style="font-size:clamp(40px,6vw,80px);color:{{ $lbl }};padding:1vh 0;">
                    <i class="bi {{ $unit['icon'] }}"></i>
                </div>
                <button class="btn-merah" style="background:white;color:#333;font-size:clamp(13px,1.2vw,20px);padding:0.8vh 3vw;border-radius:35px;">
                    Detail
                </button>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Statistik Tahunan --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5vh;">
        <div style="color:var(--merah-tua);font-size:clamp(16px,1.8vw,28px);font-weight:700;">Statistik Tahunan Pendapatan</div>
        <select class="select-merah" id="unitSelector" onchange="updateChartFromSelect()">
            @foreach($unitUsaha as $key => $unit)
            <option value="{{ $key }}">Jenis : {{ $unit['label'] }}</option>
            @endforeach
        </select>
    </div>

    <div style="background:#ffffff;padding:3vh 2vw;border-radius:30px;height:clamp(250px,32vh,480px);border:1px solid #eee;position:relative;">
        <canvas id="chartBumdes"></canvas>
    </div>

</div>

@endsection

@section('modal_content')

{{-- Modal Detail Pengurus --}}
<div class="modal-overlay" id="modalPengurus">
    <div class="modal-box">
        <div class="modal-header-kiosk">
            <h2 id="modalPengurusTitle">DETAIL</h2>
            <button class="btn-close-modal" onclick="closeModal('modalPengurus')">×</button>
        </div>
        <div class="modal-body-kiosk">
            <div class="row g-3">
                <div class="col-4 text-center">
                    <div style="width:100%;height:clamp(140px,18vh,220px);background:#333;border-radius:15px;overflow:hidden;margin-bottom:1vh;">
                        <img id="modalPengurusFoto" style="width:100%;height:100%;object-fit:cover;">
                    </div>
                    <div style="font-size:clamp(13px,1.2vw,18px);color:#333;line-height:1.4;">
                        <strong id="modalPengurusNama"></strong><br>
                        <span id="modalPengurusJabatan"></span>
                    </div>
                </div>
                <div class="col-8">
                    <table class="detail-table">
                        <tr><td class="lbl">Nama</td><td id="dNama"></td></tr>
                        <tr><td class="lbl">Lahir</td><td id="dLahir"></td></tr>
                        <tr><td class="lbl">Agama</td><td id="dAgama"></td></tr>
                        <tr><td class="lbl">Pendidikan</td><td id="dPendidikan"></td></tr>
                        <tr><td class="lbl">Periode</td><td id="dPeriode"></td></tr>
                        <tr><td class="lbl">No. SK</td><td id="dSK"></td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Statistik per Unit --}}
@foreach($unitUsaha as $key => $unit)
<div class="modal-overlay" id="modalStatistik{{ ucfirst($key) }}">
    <div class="modal-box">
        <div class="modal-header-kiosk">
            <h2>{{ $unit['label'] }}</h2>
            <button class="btn-close-modal" onclick="closeModal('modalStatistik{{ ucfirst($key) }}')">×</button>
        </div>
        <div class="modal-body-kiosk">
            <div style="margin-bottom:1.5vh;">
                <select class="select-merah" id="filterTahun{{ ucfirst($key) }}"
                    onchange="updateStatistik('{{ $key }}')">
                    <option value="2026" selected>Tahun 2026</option>
                    <option value="2025">Tahun 2025</option>
                    <option value="2024">Tahun 2024</option>
                </select>
            </div>
            <div style="height:clamp(160px,22vh,260px);background:#f5f5f5;border-radius:15px;padding:1vh;margin-bottom:1.5vh;">
                <canvas id="chartStat{{ ucfirst($key) }}"></canvas>
            </div>
            <div>
                <b>Info Keuangan :</b>
                <table class="detail-table" style="margin-top:1vh;width:clamp(200px,40%,380px);">
                    <tr><td class="lbl">Income</td><td id="statIncome{{ ucfirst($key) }}"></td></tr>
                    <tr><td class="lbl">Pengeluaran</td><td id="statExpense{{ ucfirst($key) }}"></td></tr>
                    <tr><td class="lbl">Keuntungan</td><td id="statProfit{{ ucfirst($key) }}"></td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection

@section('bottom_navigation')
<a href="{{ route('beranda') }}" class="btn-nav">
    <i class="bi bi-arrow-left"></i> KEMBALI
</a>
@endsection

@push('scripts')
<script>
const pengurusData  = @json($pengurus);
const statistikData = @json($statistik);
const tahunanData   = @json($pendapatanTahunan);
const colorsUnit = { air: '#007bff', ternak: '#ff4d4d', tani: '#28a745', sembako: '#ffa500' };
const statCharts = {};
let mainChart;

// Chart utama
document.addEventListener('DOMContentLoaded', function () {
    mainChart = new Chart(document.getElementById('chartBumdes'), {
        type: 'bar',
        data: {
            labels: ['2023','2024','2025'],
            datasets: [{
                label: 'Pendapatan (%)',
                data: tahunanData.air,
                backgroundColor: colorsUnit.air,
                borderRadius: 12,
                barThickness: clamp(40, 6, 85)
            }]
        },
        options: {
            devicePixelRatio: window.devicePixelRatio,
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, max: 100, ticks: { callback: v => v + '%' } },
                x: { grid: { display: false } }
            }
        }
    });
});

function clamp(val, min, max) { return Math.min(Math.max(val, min), max); }

function updateChartByUnit(key) {
    document.getElementById('unitSelector').value = key;
    updateChartData(key);
}

function updateChartFromSelect() {
    updateChartData(document.getElementById('unitSelector').value);
}

function updateChartData(key) {
    if (!mainChart) return;
    mainChart.data.datasets[0].data            = tahunanData[key];
    mainChart.data.datasets[0].backgroundColor = colorsUnit[key];
    mainChart.update();
}

function showDetailPengurus(i) {
    const p = pengurusData[i];
    document.getElementById('modalPengurusTitle').innerText = 'DETAIL ' + p.jabatan.toUpperCase();
    document.getElementById('modalPengurusFoto').src        = '/' + p.foto;
    document.getElementById('modalPengurusNama').innerText  = p.nama;
    document.getElementById('modalPengurusJabatan').innerText = p.jabatan;
    document.getElementById('dNama').innerText        = p.nama;
    document.getElementById('dLahir').innerText       = p.lahir;
    document.getElementById('dAgama').innerText       = p.agama;
    document.getElementById('dPendidikan').innerText  = p.pendidikan;
    document.getElementById('dPeriode').innerText     = p.periode;
    document.getElementById('dSK').innerText          = p.sk;
    openModal('modalPengurus');
}

function updateStatistik(unit) {
    const key    = unit.charAt(0).toUpperCase() + unit.slice(1);
    const tahun  = document.getElementById('filterTahun' + key).value;
    const data   = statistikData[unit][tahun];
    if (!data) return;

    document.getElementById('statIncome'  + key).innerText = data.income;
    document.getElementById('statExpense' + key).innerText = data.expense;
    document.getElementById('statProfit'  + key).innerText = data.profit;

    if (statCharts[unit]) statCharts[unit].destroy();

    statCharts[unit] = new Chart(document.getElementById('chartStat' + key), {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
            datasets: [{ data: data.bulanan, backgroundColor: colorsUnit[unit], borderRadius: 8 }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, max: 100 } } }
    });
}

// Init statistik saat modal pertama dibuka
@foreach($unitUsaha as $key => $unit)
document.getElementById('modalStatistik{{ ucfirst($key) }}').addEventListener('click', function() {}, { once: false });
// Auto-init chart saat modal show
const obs{{ ucfirst($key) }} = new MutationObserver(function(muts) {
    muts.forEach(m => {
        if (m.target.classList.contains('show')) updateStatistik('{{ $key }}');
    });
});
obs{{ ucfirst($key) }}.observe(document.getElementById('modalStatistik{{ ucfirst($key) }}'), { attributes: true, attributeFilter: ['class'] });
@endforeach
</script>
@endpush
