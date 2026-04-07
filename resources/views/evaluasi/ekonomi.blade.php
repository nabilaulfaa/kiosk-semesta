@extends('layouts.app')

@section('content')

<style>
    .evaluasi-wrapper {
        padding: 40px 80px;
        animation: fadeIn .4s ease;
    }

    .evaluasi-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .evaluasi-title {
        font-size: 40px;
        font-weight: 800;
    }

    .filter-tahun {
        background: #B51016;
        color: white;
        padding: 14px 26px;
        border-radius: 20px;
        font-size: 22px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .filter-tahun:hover {
        background: #8e0d11;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    @media (min-width: 600px) {
        .summary-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (min-width: 1024px) {
        .summary-grid { grid-template-columns: repeat(2, 1fr); }
        .evaluasi-wrapper { padding: 40px; } 
    }

    .summary-card {
        background: #f0f0f0;
        padding: 22px;
        border-radius: 14px;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        cursor: pointer;
        position: relative;
        overflow: hidden;
        border: 1px solid transparent;

    }

    .summary-card:hover { 
        transform: translateY(-10px);
        background: #ffffff;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        border-color: #B51016;
    }

    .summary-card::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 4px;
        background: #B51016;
        transition: width 0.3s ease;
    }

    .summary-card:hover::after {
        width: 100%;
    }

    .summary-title {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
        transition: color 0.3s ease;
    }

    .summary-card:hover .summary-title {
        color: #B51016;
    }

    .summary-value {
        font-size: 28px;
        font-weight: 800;
        color: #B51016;
    }

    .chart-box {
        background: #F4F6F8;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 30px;
        height: 400px;
        position: relative;
        transition: all 0.4s ease;
        border: 1px solid transparent;
    }

    .chart-box:hover {
        background: #ffffff;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border-color: #dee2e6;
        transform: scale(1.01);
    }

    .chart-title {
        text-align: center;
        font-weight: 700;
        margin-bottom: 10px;
        font-size: 18px;
        padding-left: 10px;
        border-left: 5px solid #B51016;
    }

    .summary-card:active {
        transform: scale(0.95);
        transition: 0.1s;
    }

    canvas {
        width: 100% !important;
        height: 100% !important;
    }

    @media (max-width: 1024px) {
        .evaluasi-wrapper { padding: 40px; }
    }

    @media (max-width: 600px) {
        .evaluasi-wrapper { padding: 20px; }
        .evaluasi-title { font-size: 24px; }
        .summary-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="evaluasi-wrapper">
    <div class="evaluasi-header">
        <div class="evaluasi-title">Ekonomi</div>
        <select id="filterTahun" class="filter-tahun" onchange="loadData()">
            <option value="2026">Tahun 2026</option>
            <option value="2025">Tahun 2025</option>
            <option value="2024">Tahun 2024</option>
        </select>
    </div>

    <div class="summary-grid">
        <div class="summary-card">
            <div class="summary-title">Pendapatan Desa Tahun ini</div>
            <div class="summary-value" id="pendapatanCard">-</div>
        </div>
        <div class="summary-card">
            <div class="summary-title">Pengeluaran Anggaran Tahun ini</div>
            <div class="summary-value" id="pengeluaranCard">-</div>
        </div>
        <div class="summary-card">
            <div class="summary-title">Jumlah Pengusaha Desa</div>
            <div class="summary-value" id="pengusahaCard">-</div>
        </div>
        <div class="summary-card">
            <div class="summary-title">Program Ekonomi Desa</div>
            <div class="summary-value" id="programCard">-</div>
        </div>
    </div>

    <div class="chart-box">
        <div class="chart-title">Pendapatan vs Pengeluaran</div>
        <canvas id="chartKeuangan"></canvas>
    </div>

    <div class="chart-box">
        <div class="chart-title">Perkembangan Jumlah Pengusaha</div>
        <canvas id="chartPengusaha"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
let chart1;
let chart2;
const bulanLabels = ["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"];

const mockAPI = {
    2026: {
        summary: { pendapatan: 1500000000, pengeluaran: 900000000, pengusaha: 60, program: 10 },
        bulanan: {
            pendapatan: [100, 150, 200, 250, 300, 350, 400, 450, 500, 550, 600, 700], 
            pengeluaran: [80, 100, 120, 150, 180, 200, 220, 250, 280, 300, 320, 350],
            pengusaha: [40, 42, 45, 48, 50, 52, 53, 55, 57, 58, 59, 60]
        }
    },
    2025: {
        summary: { pendapatan: 900000000, pengeluaran: 850000000, pengusaha: 38, program: 6 },
        bulanan: {
            pendapatan: [300, 280, 350, 200, 400, 150, 300, 250, 450, 200, 350, 400], 
            pengeluaran: [250, 240, 300, 180, 350, 130, 280, 220, 400, 180, 320, 380],
            pengusaha: [20, 25, 22, 28, 24, 30, 26, 32, 28, 35, 30, 38]
        }
    },
    2024: {
        summary: { pendapatan: 500000000, pengeluaran: 400000000, pengusaha: 20, program: 4 },
        bulanan: {
            pendapatan: [50, 60, 55, 70, 65, 80, 75, 90, 85, 100, 95, 110], 
            pengeluaran: [40, 45, 42, 50, 48, 60, 55, 70, 65, 80, 75, 90],
            pengusaha: [5, 7, 8, 10, 12, 13, 15, 16, 17, 18, 19, 20]
        }
    }
};

function formatRupiah(num) {
    return "Rp " + num.toLocaleString("id-ID");
}

function loadData() {
    const tahun = document.getElementById("filterTahun").value;
    const data = mockAPI[tahun];

    document.getElementById("pendapatanCard").innerText = formatRupiah(data.summary.pendapatan);
    document.getElementById("pengeluaranCard").innerText = formatRupiah(data.summary.pengeluaran);
    document.getElementById("pengusahaCard").innerText = data.summary.pengusaha + " UMKM";
    document.getElementById("programCard").innerText = data.summary.program + " Program";

    if (chart1) chart1.destroy();
    if (chart2) chart2.destroy();

    chart1 = new Chart(document.getElementById("chartKeuangan"), {
        type: 'line',
        data: {
            labels: bulanLabels,
            datasets: [
                {
                    label: "Pendapatan",
                    data: data.bulanan.pendapatan,
                    borderColor: '#B51016',
                    backgroundColor: 'transparent',
                    borderWidth: 3,
                    tension: 0.1 
                },
                {
                    label: "Pengeluaran",
                    data: data.bulanan.pengeluaran,
                    borderColor: '#555',
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    borderDash: [5, 5],
                    tension: 0.1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            devicePixelRatio: 3,
            layout: {
                padding: {
                    bottom:15
                }
            },
            scales: {
                y: { beginAtZero: true },
                x: {
                    ticks: {
                        padding:10
                    }
                }
            }
        }
    });

    chart2 = new Chart(document.getElementById("chartPengusaha"), {
        type: 'bar',
        data: {
            labels: bulanLabels,
            datasets: [{
                label: "Jumlah UMKM",
                data: data.bulanan.pengusaha,
                backgroundColor: '#B51016'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            devicePixelRatio: 3,
            layout: {
                padding: {
                    bottom:15
                }
            },
            scales: {
                y: { beginAtZero: true },
                x: {
                    ticks: {
                        padding:10
                    }
                }
            }
        }
    });
}

loadData();
</script>

@endsection

@section('bottom_navigation')
<a href="{{ route('evaluasi') }}" class="btn-nav">
    <i class="bi bi-arrow-left"></i> KEMBALI
</a>
@endsection