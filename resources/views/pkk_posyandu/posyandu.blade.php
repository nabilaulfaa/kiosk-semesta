POSYANDU 

@extends('layouts.app')

@section('content')

<style>
.container-posyandu { 
    padding: 0 80px; 
    background-color: #fff; 
}
.menu-title { 
    font-size: 32px; 
    font-weight: 800; 
    margin-bottom: 15px; 
    display: flex; 
    align-items: center; 
    gap: 15px; 
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
    padding: 10px 20px; 
    border-radius: 8px; 
    font-size: 18px; 
    font-weight: bold; 
    cursor: pointer;
}
.table-posyandu { 
    width: 100%; 
    border-collapse: separate; 
    border-spacing: 10px; 
}
.table-posyandu th { 
    background: #B51016; 
    color: white; 
    padding: 15px; 
    border-radius: 10px; 
    font-size: 20px; 
    text-align: left; 
}
.table-posyandu td { 
    background: #dcdcdc; 
    height: 60px; 
    border-radius: 10px; 
}
.grid-layanan { 
    display: grid; 
    grid-template-columns: 1.2fr 0.8fr; 
    gap: 30px; 
    margin-top: 20px; 
}
.grid-2-col { 
    display: grid; 
    grid-template-columns: 1fr 1fr; 
    gap: 20px; 
    margin-top: 20px; 
}

.card-stat { 
    background: #f0f0f0; 
    padding: 15px 25px; 
    border-radius: 15px; 
    display: flex; 
    align-items: center; 
    gap: 15px; 
    position: relative; 
    overflow: hidden;   
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    cursor: pointer;
    border: 1px solid transparent;
}

.card-stat:hover { 
    transform: translateY(-8px);
    background: #ffffff;
    box-shadow: 0 12px 25px rgba(0,0,0,0.1);
    border-color: #B51016;
}


.card-stat::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 4px;
    background: #B51016;
    transition: width 0.3s ease;
}

.card-stat:hover::after {
    width: 100%;
}


.card-stat:active {
    transform: scale(0.96);
    transition: 0.1s;
}


.card-stat .dot { 
    width: 25px; 
    height: 25px; 
    border-radius: 50%; 
    flex-shrink: 0; 
}

.card-stat .info { 
    font-size: 18px; 
    font-weight: bold; 
    color: #333;
}

.card-stat .value { 
    font-size: 28px; 
    font-weight: 800; 
    margin-left: auto; 
    color: #B51016; 
    transition: transform 0.3s ease;
}

.card-stat:hover .value {
    transform: scale(1.1); 
}
.chart-card { 
    background: #f0f0f0; 
    border-radius: 20px; 
    overflow: hidden; 
    box-shadow: 0 4px 6px rgba(0,0,0,0.05); 
}
.chart-header { 
    background: #B51016; 
    padding: 10px; 
    color: white; 
    text-align: center; 
    font-weight: bold; 
    font-size: 18px; 
}
.chart-body { 
    padding: 20px; 
    height: 320px; 
    position: relative; 
}
.rincian-item { 
    display: flex; 
    justify-content: space-between; 
    background: #dcdcdc; 
    margin-bottom: 8px; 
    padding: 10px 15px; 
    border-radius: 5px; 
    font-weight: bold; 
}
.vital-header { 
    background: #B51016; 
    color: white; 
    text-align: center; 
    padding: 12px; 
    border-radius: 15px 15px 0 0; 
    font-weight: bold; 
    font-size: 20px; 
}
.vital-total-box { 
    background: #DCDCDC; 
    text-align: center; 
    padding: 15px; 
    font-size: 24px; 
    font-weight: 900; 
    border-radius: 0 0 15px 15px; 
    margin-bottom: 10px; 
    box-shadow: 0 4px 4px rgba(0,0,0,0.1); 
}
.vital-table { 
    width: 100%; 
    border-collapse: separate; 
    border-spacing: 0 8px; 
}
.vital-table td { 
    padding: 8px 12px; 
    font-weight: bold; 
}
.v-label { 
    background: #B51016; 
    color: white; 
    width: 40%; 
    border-radius: 5px 0 0 5px; 
    font-size: 14px; 
}
.v-value { 
    background: #DCDCDC; 
    color: #000; b
    order-radius: 0 5px 5px 0; 
    border-left: 3px solid #fff; 
    font-size: 18px; 
}

@media (max-width: 992px) {
    .container-posyandu { padding: 0 20px; }
    .grid-layanan, .grid-2-col { grid-template-columns: 1fr; }
}
</style>

<div class="container-posyandu">
    <div class="menu-title">MENU POSYANDU</div>

    <div class="section">
        <div class="section-header">
            <h3>Jadwal Posyandu</h3>
            <select class="btn-tahun">
                <option value="2026">Tahun 2026</option>
                <option value="2025">Tahun 2025</option>
            </select>
        </div>
        <table class="table-posyandu">
            <thead>
                <tr>
                    <th style="width: 35%;">Nama Posyandu</th>
                    <th style="width: 30%;">Tanggal</th>
                    <th style="width: 35%;">Lokasi</th>
                </tr>
            </thead>
            <tbody>
                <tr><td></td><td></td><td></td></tr>
                <tr><td></td><td></td><td></td></tr>
                <tr><td></td><td></td><td></td></tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <h3>Jumlah Layanan Posyandu</h3>
        <div class="grid-layanan">
            <div class="chart-card">
                <div class="chart-header">Statistik Pengunjung</div>
                <div class="chart-body"><canvas id="chartLayanan"></canvas></div>
            </div>
            <div>
                <p style="font-weight: bold; font-size: 20px; margin-bottom: 15px;">Rincian Pengunjung :</p>
                <div class="rincian-list">
                    <div class="rincian-item"><span>Jumlah Balita :</span> 60 Orang</div>
                    <div class="rincian-item"><span>Jumlah Lansia :</span> 40 Orang</div>
                    <div class="rincian-item"><span>Jumlah Ibu Hamil :</span> 20 Orang</div>
                    <div class="rincian-item"><span>Sudah Imunisasi :</span> 180 Orang</div>
                </div>
            </div>
        </div>

        <div class="grid-2-col">
            <div class="card-stat">
                <div class="dot" style="background: #109688;"></div>
                <div class="info">Indikasi Stunting</div><div class="value">30</div>
            </div>
            <div class="card-stat">
                <div class="dot" style="background: #FF5252;"></div>
                <div class="info">Gizi Buruk</div><div class="value">20</div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="grid-2-col">
            <div>
                <h3 style="font-size: 24px;">Data Kelahiran</h3>
                <div class="vital-header">Data Kelahiran</div>
                <div class="vital-total-box">850 Jiwa</div>
                <div style="height: 250px; margin-bottom: 15px;"><canvas id="chartKelahiran"></canvas></div>
                <table class="vital-table">
                    <tr><td class="v-label">Jumlah Laki-Laki</td><td class="v-value">250 Jiwa</td></tr>
                    <tr><td class="v-label">Jumlah Perempuan</td><td class="v-value">600 Jiwa</td></tr>
                </table>
            </div>
            <div>
                <h3 style="font-size: 24px;">Data Kematian</h3>
                <div class="vital-header">Data Kematian</div>
                <div class="vital-total-box">850 Jiwa</div>
                <div style="height: 250px; margin-bottom: 15px;"><canvas id="chartKematian"></canvas></div>
                <table class="vital-table">
                    <tr><td class="v-label">Jumlah Laki-Laki</td><td class="v-value">250 Jiwa</td></tr>
                    <tr><td class="v-label">Jumlah Perempuan</td><td class="v-value">600 Jiwa</td></tr>
                </table>
            </div>
        </div>
    </div>

    <div class="section" style="margin-bottom: 50px;">
        <h3>Data Kesehatan</h3>
        <div class="grid-layanan">
            <div class="chart-card">
                <div class="chart-header">Statistik Imunisasi Balita</div>
                <div class="chart-body"><canvas id="chartImunisasi"></canvas></div>
            </div>
            <div>
                <p style="font-weight: bold; font-size: 18px; margin-bottom: 10px;">Status Gizi Balita</p>
                <div style="height: 300px; position: relative;">
                    <canvas id="chartGizi"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

<script>

    Chart.register(ChartDataLabels);

    const labels12Bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

    
    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        devicePixelRatio: 2, 
        plugins: {
            datalabels: {
                color: '#fff',
                font: { weight: 'bold', size: 11 },
                formatter: (value) => value
            }
        }
    };

    window.onload = function() {
        
        new Chart(document.getElementById('chartLayanan'), {
            type: 'bar',
            data: {
                labels: labels12Bulan,
                datasets: [{ 
                    data: [10, 20, 15, 25, 30, 35, 40, 45, 50, 55, 60, 65], 
                    backgroundColor: '#FF7676',
                    borderRadius: 5
                }]
            },
            options: {
                ...commonOptions,
                plugins: { 
                    legend: { display: false },
                    datalabels: { anchor: 'end', align: 'top', color: '#B51016' }
                },
                scales: { y: { beginAtZero: true, grid: { display: false } } }
            }
        });

        
        new Chart(document.getElementById('chartKelahiran'), {
            type: 'pie',
            data: { 
                labels: ['Laki-laki', 'Perempuan'], 
                datasets: [{ data: [250, 600], backgroundColor: ['#B51016', '#FF7676'], borderWidth: 2 }] 
            },
            options: {
                ...commonOptions,
                plugins: { legend: { position: 'bottom' }, datalabels: { formatter: (val) => val + ' Jiwa' } }
            }
        });

        
        new Chart(document.getElementById('chartKematian'), {
            type: 'pie',
            data: { 
                labels: ['Laki-laki', 'Perempuan'], 
                datasets: [{ data: [300, 550], backgroundColor: ['#B51016', '#FF7676'], borderWidth: 2 }] 
            },
            options: {
                ...commonOptions,
                plugins: { legend: { position: 'bottom' }, datalabels: { formatter: (val) => val + ' Jiwa' } }
            }
        });

        new Chart(document.getElementById('chartImunisasi'), {
            type: 'line', 
            data: {
                labels: labels12Bulan,
                datasets: [{ 
                    data: [15, 25, 20, 35, 45, 40, 50, 55, 60, 65, 70, 75], 
                    borderColor: '#42A5F5', 
                    backgroundColor: 'rgba(66, 165, 245, 0.2)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5
                }]
            },
            options: {
                ...commonOptions,
                plugins: { 
                    legend: { display: false },
                    datalabels: { backgroundColor: '#42A5F5', borderRadius: 4, padding: 4 }
                }
            }
        });


        new Chart(document.getElementById('chartGizi'), {
            type: 'doughnut', 
            data: {
                labels: ['Gizi Buruk', 'Sedang', 'Cukup Gizi'],
                datasets: [{ 
                    data: [20, 30, 50], 
                    backgroundColor: ['#4B0082', '#FF7676', '#42A5F5'],
                    hoverOffset: 15 
                }]
            },
            options: {
                ...commonOptions,
                plugins: { 
                    legend: { position: 'bottom' },
                    datalabels: { formatter: (val) => val + '%' }
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