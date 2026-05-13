@extends('layouts.app')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
@endpush

@section('content')

<div style="padding: 0 5vw;">

    <div class="modul-header" style="padding: 3vh 0 1vh;">
        <div class="modul-icon"><i class="bi bi-people"></i></div>
        <div class="modul-title">PKK POSYANDU</div>
    </div>

    <div style="font-size:clamp(18px,2vw,32px);font-weight:800;margin-bottom:2vh;">MENU POSYANDU</div>

    {{-- Filter Jadwal Posyandu --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5vh;">
        <div style="color:var(--merah-tua);font-size:clamp(16px,1.6vw,28px);font-weight:700;">Jadwal Posyandu</div>
        <form action="{{ route('posyandu.index') }}" method="GET">
            <select name="tahun" class="select-merah" onchange="this.form.submit()">
                <option value="all" {{ $tahun === 'all' ? 'selected' : '' }}>Semua Tahun</option>
                @foreach($tahunTersedia as $th)
                    <option value="{{ $th }}" {{ $tahun == $th ? 'selected' : '' }}>Tahun {{ $th }}</option>
                @endforeach
            </select>
        </form>
    </div>

    {{-- Tabel: thead stay, tbody scroll jika > 5 baris --}}
    <div style="margin-bottom:2vh;border-radius:12px;overflow:hidden;">
        <table class="tabel-kiosk" style="margin-bottom:0;">
            <thead>
                <tr>
                    <th style="width:40%;">Nama Posyandu</th>
                    <th style="width:30%;">Tanggal</th>
                    <th style="width:30%;">Lokasi</th>
                </tr>
            </thead>
        </table>
        <div class="{{ count($jadwalPosyandu) > 5 ? 'tabel-scroll-wrapper' : 'tabel-scroll-wrapper no-scroll' }}">
            <table class="tabel-kiosk" style="margin-top:0;">
                <tbody>
                    @forelse($jadwalPosyandu as $j)
                    <tr>
                        <td>{{ $j['nama'] }}</td>
                        <td style="text-align:center;">{{ $j['tanggal'] }}</td>
                        <td>{{ $j['lokasi'] }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" style="text-align:center;color:#666;">Tidak ada jadwal.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Jumlah Layanan Posyandu --}}
    <div style="color:var(--merah-tua);font-size:clamp(16px,1.6vw,28px);font-weight:700;margin-bottom:1.5vh;">Jumlah Layanan Posyandu</div>

    <div class="row g-3 mb-3">
        <div class="col-7">
            <div style="background:#f0f0f0;border-radius:20px;overflow:hidden;">
                <div style="background:var(--merah-tua);color:white;text-align:center;padding:1vh;font-weight:700;font-size:clamp(13px,1.2vw,18px);">Statistik Pengunjung</div>
                <div style="padding:2vh;height:clamp(160px,20vh,260px);position:relative;">
                    <canvas id="chartLayanan"></canvas>
                </div>
            </div>
        </div>
        <div class="col-5">
            <div style="font-weight:700;font-size:clamp(14px,1.3vw,20px);margin-bottom:1.5vh;">Rincian Pengunjung :</div>
            @php
            $rincian = [
                ['label'=>'Jumlah Balita',    'val'=>$rincianPengunjung['balita'],    'dot'=>'#109688'],
                ['label'=>'Jumlah Lansia',    'val'=>$rincianPengunjung['lansia'],    'dot'=>'#FFB74D'],
                ['label'=>'Jumlah Ibu Hamil', 'val'=>$rincianPengunjung['ibu_hamil'],'dot'=>'#B51016'],
                ['label'=>'Sudah Imunisasi',  'val'=>$rincianPengunjung['imunisasi'],'dot'=>'#42A5F5'],
            ];
            @endphp
            @foreach($rincian as $r)
            <div style="display:flex;align-items:center;gap:1vw;background:var(--abu);margin-bottom:0.8vh;padding:1vh 1.5vw;border-radius:5px;font-weight:700;font-size:clamp(12px,1.1vw,17px);">
                <div style="width:14px;height:14px;border-radius:50%;background:{{ $r['dot'] }};flex-shrink:0;"></div>
                <span style="flex:1;">{{ $r['label'] }} :</span>
                <span>{{ $r['val'] }} Orang</span>
            </div>
            @endforeach
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-6">
            <div class="kiosk-card d-flex align-items-center gap-3">
                <div style="width:22px;height:22px;border-radius:50%;background:#109688;flex-shrink:0;"></div>
                <div style="font-size:clamp(13px,1.2vw,18px);font-weight:600;">Indikasi Stunting</div>
                <div style="margin-left:auto;font-size:clamp(18px,2vw,28px);font-weight:800;color:var(--merah-tua);">{{ $rincianPengunjung['stunting'] }}</div>
            </div>
        </div>
        <div class="col-6">
            <div class="kiosk-card d-flex align-items-center gap-3">
                <div style="width:22px;height:22px;border-radius:50%;background:#FF5252;flex-shrink:0;"></div>
                <div style="font-size:clamp(13px,1.2vw,18px);font-weight:600;">Gizi Buruk</div>
                <div style="margin-left:auto;font-size:clamp(18px,2vw,28px);font-weight:800;color:var(--merah-tua);">{{ $rincianPengunjung['gizi_buruk'] }}</div>
            </div>
        </div>
    </div>

    {{-- Data Kelahiran & Kematian --}}
    <div class="row g-3 mb-3">
        <div class="col-6">
            <div style="color:var(--merah-tua);font-size:clamp(15px,1.5vw,24px);font-weight:700;margin-bottom:1vh;">Data Kelahiran</div>
            <div style="background:var(--merah-tua);color:white;text-align:center;padding:1.2vh;border-radius:15px 15px 0 0;font-weight:700;font-size:clamp(13px,1.2vw,18px);">Data Kelahiran</div>
            <div style="background:var(--abu);text-align:center;padding:1.5vh;font-size:clamp(16px,1.8vw,26px);font-weight:900;border-radius:0 0 15px 15px;margin-bottom:1vh;box-shadow:0 4px 4px rgba(0,0,0,0.1);">
                {{ $dataKelahiran['total'] }} Jiwa
            </div>
            <div style="height:clamp(130px,16vh,220px);margin-bottom:1.5vh;position:relative;">
                <canvas id="chartKelahiran"></canvas>
            </div>
            <table style="width:100%;border-collapse:separate;border-spacing:0 0.6vh;">
                <tr>
                    <td style="background:var(--merah-tua);color:white;padding:0.8vh 1.2vw;width:55%;border-radius:5px 0 0 5px;font-weight:700;font-size:clamp(12px,1.1vw,16px);">Jumlah Laki-Laki</td>
                    <td style="background:var(--abu);padding:0.8vh 1.2vw;font-weight:700;font-size:clamp(12px,1.1vw,18px);">{{ $dataKelahiran['laki'] }} Jiwa</td>
                </tr>
                <tr>
                    <td style="background:var(--merah-tua);color:white;padding:0.8vh 1.2vw;border-radius:5px 0 0 5px;font-weight:700;font-size:clamp(12px,1.1vw,16px);">Jumlah Perempuan</td>
                    <td style="background:var(--abu);padding:0.8vh 1.2vw;font-weight:700;font-size:clamp(12px,1.1vw,18px);">{{ $dataKelahiran['perempuan'] }} Jiwa</td>
                </tr>
            </table>
        </div>

        <div class="col-6">
            <div style="color:var(--merah-tua);font-size:clamp(15px,1.5vw,24px);font-weight:700;margin-bottom:1vh;">Data Kematian</div>
            <div style="background:var(--merah-tua);color:white;text-align:center;padding:1.2vh;border-radius:15px 15px 0 0;font-weight:700;font-size:clamp(13px,1.2vw,18px);">Data Kematian</div>
            <div style="background:var(--abu);text-align:center;padding:1.5vh;font-size:clamp(16px,1.8vw,26px);font-weight:900;border-radius:0 0 15px 15px;margin-bottom:1vh;box-shadow:0 4px 4px rgba(0,0,0,0.1);">
                {{ $dataKematian['total'] }} Jiwa
            </div>
            <div style="height:clamp(130px,16vh,220px);margin-bottom:1.5vh;position:relative;">
                <canvas id="chartKematian"></canvas>
            </div>
            <table style="width:100%;border-collapse:separate;border-spacing:0 0.6vh;">
                <tr>
                    <td style="background:var(--merah-tua);color:white;padding:0.8vh 1.2vw;width:55%;border-radius:5px 0 0 5px;font-weight:700;font-size:clamp(12px,1.1vw,16px);">Jumlah Laki-Laki</td>
                    <td style="background:var(--abu);padding:0.8vh 1.2vw;font-weight:700;font-size:clamp(12px,1.1vw,18px);">{{ $dataKematian['laki'] }} Jiwa</td>
                </tr>
                <tr>
                    <td style="background:var(--merah-tua);color:white;padding:0.8vh 1.2vw;border-radius:5px 0 0 5px;font-weight:700;font-size:clamp(12px,1.1vw,16px);">Jumlah Perempuan</td>
                    <td style="background:var(--abu);padding:0.8vh 1.2vw;font-weight:700;font-size:clamp(12px,1.1vw,18px);">{{ $dataKematian['perempuan'] }} Jiwa</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- Data Kesehatan --}}
    <div style="color:var(--merah-tua);font-size:clamp(16px,1.6vw,28px);font-weight:700;margin-bottom:1.5vh;">Data Kesehatan</div>
    <div class="row g-3 mb-4">
        <div class="col-7">
            <div style="background:#f0f0f0;border-radius:20px;overflow:hidden;">
                <div style="background:var(--merah-tua);color:white;text-align:center;padding:1vh;font-weight:700;font-size:clamp(13px,1.2vw,18px);">Statistik Imunisasi Balita</div>
                <div style="padding:2vh;height:clamp(160px,20vh,280px);position:relative;">
                    <canvas id="chartImunisasi"></canvas>
                </div>
            </div>
        </div>
        <div class="col-5">
            <div style="font-weight:700;font-size:clamp(14px,1.3vw,18px);margin-bottom:1vh;">Status Gizi Balita</div>
            <div style="display:flex;align-items:center;gap:1vw;margin-bottom:1vh;">
                @php
                $giziLegend = [
                    ['warna'=>'#4B0082','label'=>'Gizi Buruk'],
                    ['warna'=>'#FF7676','label'=>'Sedang'],
                    ['warna'=>'#42A5F5','label'=>'Cukup Gizi'],
                ];
                @endphp
                @foreach($giziLegend as $g)
                <div style="display:flex;align-items:center;gap:0.5vw;font-size:clamp(11px,1vw,15px);font-weight:700;">
                    <div style="width:14px;height:14px;border-radius:50%;background:{{ $g['warna'] }};flex-shrink:0;"></div>
                    {{ $g['label'] }}
                </div>
                @endforeach
            </div>
            <div style="height:clamp(160px,22vh,300px);position:relative;">
                <canvas id="chartGizi"></canvas>
            </div>
        </div>
    </div>

</div>

@endsection

@section('bottom_navigation')
<a href="{{ route('pkk.posyandu') }}" class="btn-nav">
    <i class="bi bi-arrow-left"></i> KEMBALI
</a>
@endsection

@push('scripts')
<script>
Chart.register(ChartDataLabels);
const labels12 = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
const commonOpts = {
    responsive: true, maintainAspectRatio: false, devicePixelRatio: 2,
    plugins: { datalabels: { color: '#fff', font: { weight: 'bold', size: 11 }, formatter: v => v } }
};

window.onload = function () {
    new Chart(document.getElementById('chartLayanan'), {
        type: 'bar',
        data: { labels: labels12, datasets: [{ data: [10,20,15,25,30,35,40,45,50,55,60,65], backgroundColor: '#FF7676', borderRadius: 5 }] },
        options: { ...commonOpts, plugins: { legend: { display: false }, datalabels: { anchor: 'end', align: 'top', color: '#B51016' } }, scales: { y: { beginAtZero: true, grid: { display: false } } } }
    });

    new Chart(document.getElementById('chartKelahiran'), {
        type: 'pie',
        data: { labels: ['Laki-laki','Perempuan'], datasets: [{ data: [{{ $dataKelahiran['laki'] }}, {{ $dataKelahiran['perempuan'] }}], backgroundColor: ['#B51016','#FF7676'], borderWidth: 2 }] },
        options: { ...commonOpts, plugins: { legend: { position: 'bottom' }, datalabels: { formatter: v => v + ' Jiwa' } } }
    });

    new Chart(document.getElementById('chartKematian'), {
        type: 'pie',
        data: { labels: ['Laki-laki','Perempuan'], datasets: [{ data: [{{ $dataKematian['laki'] }}, {{ $dataKematian['perempuan'] }}], backgroundColor: ['#B51016','#FF7676'], borderWidth: 2 }] },
        options: { ...commonOpts, plugins: { legend: { position: 'bottom' }, datalabels: { formatter: v => v + ' Jiwa' } } }
    });

    new Chart(document.getElementById('chartImunisasi'), {
        type: 'line',
        data: { labels: labels12, datasets: [{ data: [15,25,20,35,45,40,50,55,60,65,70,75], borderColor: '#42A5F5', backgroundColor: 'rgba(66,165,245,0.2)', fill: true, tension: 0.4, pointRadius: 5 }] },
        options: { ...commonOpts, plugins: { legend: { display: false }, datalabels: { backgroundColor: '#42A5F5', borderRadius: 4, padding: 4 } } }
    });

    new Chart(document.getElementById('chartGizi'), {
        type: 'doughnut',
        data: { labels: ['Gizi Buruk','Sedang','Cukup Gizi'], datasets: [{ data: [20,30,50], backgroundColor: ['#4B0082','#FF7676','#42A5F5'], hoverOffset: 15 }] },
        options: { ...commonOpts, plugins: { legend: { display: false }, datalabels: { formatter: v => v + '%' } } }
    });
};
</script>
@endpush