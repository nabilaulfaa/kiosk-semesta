@extends('layouts.app')

@section('content')

<style>
.container-pkk { 
    padding: 0 80px; 
}
.menu-title { 
    font-size: 32px; 
    font-weight: 800; 
    margin-bottom: 15px; 
}
.section { 
    margin-top: 30px; 
}
.section h3 { 
    color: #B51016; 
    font-size: 30px; 
    font-weight: 800; 
    margin-bottom: 15px; 
}
.section-header { 
    display: flex; 
    justify-content: space-between; 
    align-items: center; 
    margin-bottom: 15px; 
}

.btn-tahun { 
    background: #B51016; 
    color: white; 
    border: none; 
    padding: 12px 25px; 
    border-radius: 25px; 
    font-size: 20px; 
    font-weight: bold; 
    cursor: pointer;
    appearance: none; 
    outline: none;
}

.table-pkk { 
    width: 100%; 
    border-collapse: separate; 
    border-spacing: 10px; 
    margin-top: 15px; 
}
.table-pkk th { 
    background: #B51016; 
    color: white; 
    padding: 15px; 
    border-radius: 10px; 
    font-size: 20px; 
    text-align: center; 
}
.table-pkk td { 
    background: #dcdcdc; 
    height: 50px; 
    border-radius: 10px; 
}
.sub-title { 
    color: #B51016; 
    font-size: 18px; 
    margin-bottom: 10px; 
    font-weight: bold; 
}

.grid-data { 
    display: grid; 
    grid-template-columns: 1fr 1fr; 
    gap: 20px; 
}


.card { 
    background: #f0f0f0; 
    padding: 20px; 
    border-radius: 15px; 
    position: relative; 
    overflow: hidden; 
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    cursor: pointer;
    border: 1px solid transparent;
}


.card:hover { 
    transform: translateY(-10px);
    background: #ffffff;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    border-color: #B51016;
}


.card::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 4px;
    background: #B51016;
    transition: width 0.3s ease;
}

.card:hover::after {
    width: 100%;
}

/* 4. Efek saat diklik */
.card:active {
    transform: scale(0.95);
    transition: 0.1s;
}


.card p { 
    font-size: 20px; 
    margin-left: 35px; 
    margin-bottom: 5px; 
    transition: color 0.3s ease;
}

.card h2 { 
    font-size: 32px; 
    font-weight: bold; 
    margin-left: 35px;
    color: #B51016; 
}


.card::before { 
    content: ''; 
    width: 18px; 
    height: 18px; 
    border-radius: 50%; 
    position: absolute; 
    left: 15px; 
    top: 28px; 
    z-index: 1;
}

.card.orange::before { 
    background: orange; 
}
.card.blue::before { 
    background: blue; 
}
.card.green::before { 
    background: green; 
}
.card.red::before { 
    background: red; 
}
.chart-row {
    display: grid;
    grid-template-columns: 1.2fr 0.8fr; 
    gap: 30px;
    margin-top: 20px;
    align-items: start;
}

.chart-card {
    background: #f0f0f0;
    border-radius: 20px;
    padding: 0;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

.chart-header {
    padding: 10px;
    color: white;
    text-align: center;
    font-weight: bold;
    font-size: 18px;
}

.chart-body {
    padding: 20px;
    height: 350px; 
    position: relative; 
}

.legend-custom {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 20px;
}

.legend-item {
    display: flex;
    align-items: center;
    font-size: 14px;
    font-weight: bold;
}

.legend-color {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    margin-right: 15px;
}

@media (max-width: 992px) {
    .container-pkk { padding: 0 20px; }
    .grid-data, .chart-row { grid-template-columns: 1fr; }
    .section-header { 
        flex-direction: column; 
        align-items: flex-start; 
        gap: 10px; }
    .chart-body { height: 300px; }
}
</style>

<div class="container-pkk">

    <div class="menu-title">MENU PKK</div>
    
    <div class="section">
        <div class="section-header">
            <h3>KEGIATAN POKJA PKK</h3>
            <form action="" method="GET" id="tahunForm">
                <select name="tahun" class="btn-tahun" onchange="document.getElementById('tahunForm').submit()">
                    @for($i = date('Y')+1; $i >= 2020; $i--)
                        <option value="{{ $i }}" {{ request('tahun', '2026') == $i ? 'selected' : '' }}>Tahun {{ $i }} </option>
                    @endfor
                </select>
            </form>
        </div>
        <div style="overflow-x: auto;"> 
            <table class="table-pkk" style="min-width: 600px;">
                <thead><tr><th>Pokja</th><th>Nama Kegiatan</th><th>Tanggal</th><th>Lokasi</th></tr></thead>
                <tbody>@for($i=0;$i<6;$i++) <tr><td></td><td></td><td></td><td></td></tr> @endfor</tbody>
            </table>
        </div>
    </div>

    <div class="section">
        <h3>DATA UMUM DAN POKJA PKK</h3>
        <div class="sub-title">DATA UMUM PKK DESA</div>
        <div class="grid-data">
            <div class="card orange"><p>Total Anggota PKK</p><h2>6</h2></div>
            <div class="card blue"><p>Total Kader PKK</p><h2>30</h2></div>
            <div class="card green"><p>Kelompok Dasawisma</p><h2>6</h2></div>
            <div class="card red"><p>RT Aktif</p><h2>10</h2></div>
        </div>
    </div>

    <div class="section">
        <div class="chart-row">
            <div class="chart-card">
                <div class="chart-header" style="background: #4B0082;">Distribusi Anggota Pokja</div>
                <div class="chart-body" style="background: #e0e0e0;">
                    <canvas id="chartPokjaBar"></canvas> 
                    <div style="text-align: center; margin-top: 15px; font-weight: bold; font-size: 18px;">
                        Total Anggota : 85 Orang
                    </div>
                </div>
            </div>
            <div>
                <div class="sub-title" style="color: black; font-size: 22px;">Persentase Pokja</div>
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div class="legend-custom" style="width: 45%;">
                        <div class="legend-item"><div class="legend-color" style="background: #109688;"></div> Pokja 1 - 24%</div>
                        <div class="legend-item"><div class="legend-color" style="background: #B51016;"></div> Pokja 2 - 21%</div>
                        <div class="legend-item"><div class="legend-color" style="background: #0D47A1;"></div> Pokja 3 - 26%</div>
                        <div class="legend-item"><div class="legend-color" style="background: #FFB74D;"></div> Pokja 4 - 29%</div>
                    </div>
                    <div style="width: 50%; height: 200px; position: relative;">
                        <canvas id="chartPokjaPie"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-header" style="margin-bottom: 20px;">
            <h3>STATISTIK KEGIATAN PKK</h3>
        </div>
        <div class="grid-data" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
            <div class="card red"><p>Total Kegiatan</p><h2>10</h2></div>
            <div class="card orange"><p>Pelatihan</p><h2>9</h2></div>
            <div class="card green"><p>Pertemuan</p><h2>3</h2></div>
        </div>
        <div class="chart-row">
            <div class="chart-card">
                <div class="chart-header" style="background: #B51016;">Jumlah Kegiatan Per Bulan</div>
                <div class="chart-body">
                    <canvas id="chartKegiatanBulanan"></canvas>
                </div>
            </div>
            <div>
                <div class="sub-title" style="color: black; font-size: 22px;">Jenis Kegiatan</div>
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div class="legend-custom" style="width: 55%;">
                        <div class="legend-item"><div class="legend-color" style="background: #B51016;"></div> Total Kegiatan - 10</div>
                        <div class="legend-item"><div class="legend-color" style="background: #FFB74D;"></div> Pelatihan - 9</div>
                        <div class="legend-item"><div class="legend-color" style="background: #109688;"></div> Pertemuan - 3</div>
                    </div>
                    <div style="width: 40%; height: 180px; position: relative;">
                        <canvas id="chartJenisKegiatan"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <h3>DATA KELUARGA</h3>
        <div class="chart-row">
            <div>
                <div class="sub-title" style="color: black; font-size: 22px;">Penduduk Per Kategori Umur</div>
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div class="legend-custom" style="width: 45%;">
                        <div class="legend-item"><div class="legend-color" style="background: #B51016;"></div> Dewasa</div>
                        <div class="legend-item"><div class="legend-color" style="background: #FFB74D;"></div> Anak</div>
                        <div class="legend-item"><div class="legend-color" style="background: #109688;"></div> Lansia</div>
                    </div>
                    <div style="width: 50%; height: 200px; position: relative;">
                        <canvas id="chartUmurPie"></canvas>
                    </div>
                </div>
            </div>
            <div class="chart-card">
                <div class="chart-header" style="background: #B51016;">Jumlah Keluarga Berdasarkan Jenis</div>
                <div class="chart-body">
                    <canvas id="chartKeluargaBar"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    Chart.defaults.devicePixelRatio = 2; 
    Chart.defaults.font.family = "'Arial', sans-serif";

    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false, 
        plugins: { legend: { display: false } }
    };

    window.onload = function() {
        const pkkColors = ['#109688', '#B51016', '#0D47A1', '#FFB74D'];

        new Chart(document.getElementById('chartPokjaBar').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Pokja 1', 'Pokja 2', 'Pokja 3', 'Pokja 4'],
                datasets: [{
                    data: [25, 35, 18, 22],
                    backgroundColor: pkkColors,
                    barThickness: 15
                }]
            },
            options: { ...commonOptions, indexAxis: 'y' }
        });

        new Chart(document.getElementById('chartPokjaPie').getContext('2d'), {
            type: 'pie',
            data: {
                datasets: [{
                    data: [24, 21, 26, 29],
                    backgroundColor: pkkColors
                }]
            },
            options: commonOptions
        });

        new Chart(document.getElementById('chartKegiatanBulanan').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                datasets: [{
                    data: [2, 3, 4, 5, 7, 8],
                    backgroundColor: '#FF7676'
                }]
            },
            options: commonOptions
        });

        new Chart(document.getElementById('chartJenisKegiatan').getContext('2d'), {
            type: 'pie',
            data: {
                datasets: [{
                    data: [10, 9, 3],
                    backgroundColor: ['#B51016', '#FFB74D', '#109688']
                }]
            },
            options: commonOptions
        });

        
        new Chart(document.getElementById('chartUmurPie').getContext('2d'), {
            type: 'pie',
            data: {
                labels: ['Dewasa', 'Anak', 'Lansia'],
                datasets: [{
                    data: [50, 30, 20],
                    backgroundColor: ['#B51016', '#FFB74D', '#109688']
                }]
            },
            options: commonOptions
        });

        new Chart(document.getElementById('chartKeluargaBar').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Kurang Mampu', 'Pra Sejahtera', 'Sejahtera'],
                datasets: [{
                    data: [20, 45, 60],
                    backgroundColor: ['#FF7676', '#FFB74D', '#0D47A1'],
                    barThickness: 30
                }]
            },
            options: {
                ...commonOptions,
                scales: {
                    y: { beginAtZero: true, grid: { color: '#e0e0e0' } },
                    x: { grid: { display: false } }
                }
            }
        });
    }
</script>

@endsection

@section('bottom_navigation')
<a href="{{ route('pkk.posyandu') }}" class="btn-nav">
    <i class="bi bi-arrow-left"></i>
    KEMBALI
</a>
@endsection