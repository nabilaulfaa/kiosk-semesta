@extends('layouts.app')

@section('content')

<style>
    html, body { 
        margin: 0; 
        padding: 0; 
    }

    .header-container { 
        padding: 40px 80px 20px; 
    }

    .top-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .sosial-title { 
        font-size: 28px; 
        font-weight: 800; }

    .evaluasi-badge {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .icon-circle {
        width: 55px;
        height: 55px;
        background: #E72128;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        font-size: 22px;
    }

    .evaluasi-text { 
        font-size: 24px; 
        font-weight: 800; 
    }

    .tahun-wrapper {
        display: flex;
        justify-content: flex-end;
        margin-top: 50px;
    }

    .btn-tahun {
        background: #B51016;
        color: white;
        padding: 10px 20px;
        border-radius: 7px;
        font-weight: 700;
        border: none;
        cursor: pointer;
    }

    .btn-tahun:hover {
        background: #7f0c10;
        box-shadow: 0 4px 12px rgba(181, 16, 22, 0.2);
    }

    .stats-grid {
        padding: 0 80px;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: #EDEDED;
        border-radius: 12px;
        padding: 15px 20px;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        cursor: pointer;
        border: 1px solid transparent;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-10px); 
        background: #ffffff; 
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1); 
        border-color: #E72128; 
    }

    .stat-card::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 4px;
        background: #E72128;
        transition: width 0.3s ease;
    }

    .stat-card:hover::after {
        width: 100%;
    }

    .stat-card:hover .stat-title {
        color: #E72128;
        font-weight: 700;
    }

    .stat-card:active {
        transform: scale(0.95);
        transition: 0.1s;
    }

    .stat-title { 
        font-size: 18px; 
        color: #000000; }

    .stat-value {
        font-size: 25px;
        font-weight: 800;
        margin-top: 5px;
    }

    .chart-section { 
        padding: 0 80px; 
    }

    .chart-box {
        background: #F4F6F8;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 25px;
        height: 300px;
        transition: all 0.4s ease;
        border: 1px solid transparent;
    }

    .chart-box:hover {
        background: #ffffff;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border-color: #dee2e6;
        transform: scale(1.01); 
    }

    </style>
        <div class="header-container">
            <div class="top-section">
                <div class="sosial-title">Sosial</div>
                <div class="evaluasi-badge">
                    <div class="icon-circle"><i class="bi bi-clipboard-data"></i></div>
                    <div class="evaluasi-text">EVALUASI</div>
                </div>
            </div>

            <div class="tahun-wrapper">
                <select class="btn-tahun" id="tahunFilter">
                    <option value="2026">Tahun 2026</option>
                    <option value="2025">Tahun 2025</option>
                    <option value="2024">Tahun 2024</option>
                </select>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-title">Jumlah Penduduk</div>
                <div class="stat-value"></div>
            </div>

            <div class="stat-card">
                <div class="stat-title">Jenis Kelamin</div>
                <div class="stat-value"></div>
            </div>

            <div class="stat-card">
                <div class="stat-title">Pekerja Produktif</div>
                <div class="stat-value"></div>
            </div>

            <div class="stat-card">
                <div class="stat-title">Jumlah Balita</div>
                <div class="stat-value"></div>
            </div>
        </div>

        <div class="chart-section">
            <div class="chart-box">
                <canvas id="lineChart"></canvas>
            </div>

            <div class="chart-box">
                <canvas id="barChart"></canvas>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

Chart.defaults.devicePixelRatio = 3;

const dataSosial = {
    2026: {
        penduduk: 12548,
        laki: 6360,
        perempuan: 6188,
        produktif: 7890,
        balita: 1230,

        tahun: ['2020','2021','2022','2023','2024'],
        kelahiran: [120,130,150,170,190],
        kematian: [70,80,85,90,100],

        kategori: ['Bayi','Balita','Remaja','Dewasa','Lansia'],
        jumlah_kategori: [800,1230,2500,6000,2018]
    },

    2025: {
        penduduk: 12000,
        laki: 6000,
        perempuan: 6000,
        produktif: 7500,
        balita: 1100,

        tahun: ['2020','2021','2022','2023','2024'],
        kelahiran: [100,120,140,160,180],
        kematian: [60,70,80,85,90],

        kategori: ['Bayi','Balita','Remaja','Dewasa','Lansia'],
        jumlah_kategori: [700,1100,2300,5800,2100]
    },

    2024: {
        penduduk: 11500,
        laki: 5800,
        perempuan: 5700,
        produktif: 7000,
        balita: 1000,

        tahun: ['2020','2021','2022','2023','2024'],
        kelahiran: [90,110,130,150,170],
        kematian: [50,60,70,80,85],

        kategori: ['Bayi','Balita','Remaja','Dewasa','Lansia'],
        jumlah_kategori: [650,1000,2100,5600,2150]
    }
};

const lineChart = new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: { labels: [], datasets: [
        {
            label: 'Kelahiran',
            data: [],
            borderColor: '#22c55e',
            backgroundColor: 'rgba(34,197,94,0.2)',
            borderWidth: 3,
            tension: 0.4
        },
        {
            label: 'Kematian',
            data: [],
            borderColor: '#ef4444',
            backgroundColor: 'rgba(239,68,68,0.2)',
            borderWidth: 3,
            tension: 0.4
        }
    ]},
    options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: { duration: 1000 }
    }
});

const barChart = new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: [],
        datasets: [{
            label: 'Jumlah Penduduk',
            data: [],
            backgroundColor: [
                '#22c55e',
                '#3b82f6',
                '#f59e0b',
                '#6366f1',
                '#ef4444'
            ],
            borderRadius: 8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: { duration: 1000 },
        plugins: {
            legend: { display: false }
        }
    }
});

function updateDashboard(tahun) {
    const d = dataSosial[tahun];

    document.querySelectorAll('.stat-value')[0].innerText = d.penduduk + " Jiwa";
    document.querySelectorAll('.stat-value')[1].innerHTML =
        d.laki + " Laki-laki<br>" + d.perempuan + " Perempuan";
    document.querySelectorAll('.stat-value')[2].innerText = d.produktif + " Orang";
    document.querySelectorAll('.stat-value')[3].innerText = d.balita + " Balita";

    lineChart.data.labels = d.tahun;
    lineChart.data.datasets[0].data = d.kelahiran;
    lineChart.data.datasets[1].data = d.kematian;
    lineChart.update();

    barChart.data.labels = d.kategori;
    barChart.data.datasets[0].data = d.jumlah_kategori;
    barChart.update();
}

document.getElementById('tahunFilter').addEventListener('change', function(){
    updateDashboard(this.value);
});

updateDashboard('2026');

</script>

@endsection

@section('bottom_navigation')
<a href="{{ route('evaluasi') }}" class="btn-nav">
    <i class="bi bi-arrow-left"></i>
    KEMBALI
</a>
@endsection