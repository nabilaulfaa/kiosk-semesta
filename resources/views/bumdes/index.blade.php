@extends('layouts.app')

<style>
    .bumdes-page { 
        padding-top: 20px; 
        padding-bottom: 50px; 
    }
    .main-title { 
        font-weight: 900; 
        font-size: 40px; 
        color: #1a1a1a; 
        letter-spacing: -1px; 
    }
    .section-title { 
        color: #B51016; 
        font-weight: 800; 
        font-size: 34px; 
        margin-bottom: 25px; 
    }

    .bumdes-badge { 
        display: flex; 
        flex-direction: column; 
        align-items: center; 
        justify-content: center;
    }
    .badge-icon { 
        background: #B51016; 
        color: white; 
        width: 70px; 
        height: 70px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        border-radius: 50%; 
        font-size: 35px; 
        box-shadow: 0 4px 10px rgba(181, 16, 22, 0.3);
        margin-bottom: 5px;
    }
    .badge-text { 
        color: #1a1a1a; 
        line-height: 1;
     }

    .card-pengurus { 
        background: #ececec; 
        border-radius: 25px; 
        padding: 20px 30px; 
        display: flex; 
        align-items: center; 
        gap: 25px; 
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 2px solid transparent;
    }
    .card-pengurus:hover { 
        transform: scale(1.03); 
        background: #fff; 
        border-color: #B51016; 
        box-shadow: 0 15px 35px rgba(0,0,0,0.1); 
    }
    
    .photo-container { 
        width: 110px; 
        height: 110px; 
        background: #ddd; 
        border-radius: 20px; 
        overflow: hidden; 
        flex-shrink: 0; 
        border: 3px solid #fff; 
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .photo-img { 
        width: 100%; 
        height: 100%; 
        object-fit: cover; 
        object-position: center; 
    }
    
    .jabatan { 
        font-weight: 800; 
        font-size: 26px; 
        color: #111; 
        line-height: 1.2; 
    }
    .nama { 
        font-size: 22px; 
        color: #555; 
    }

    .card-unit { 
        border-radius: 25px; 
        overflow: hidden; 
        text-align: center; 
        padding-bottom: 25px; 
        transition: 0.3s; 
        cursor: pointer; 
    }
    .card-unit:hover { 
        transform: translateY(-12px); 
        box-shadow: 0 20px 40px rgba(0,0,0,0.15); 
    }
    .unit-label { 
        color: white; 
        padding: 15px; 
        font-weight: 800; 
        font-size: 22px; 
        margin-bottom: 10px; 
    }
    .unit-icon { 
        height: 160px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-size: 80px; 
    }
    .btn-detail { 
        background: white; 
        border: none; 
        padding: 10px 45px; 
        border-radius: 35px; 
        font-weight: 800; 
        font-size: 20px; 
        transition: 0.2s; 
    }
    
    .blue { 
        background: #C5E1FF; 
    } 
    .blue .unit-label { 
        background: #007bff; 
    } 
    .blue .unit-icon { 
        color: #007bff; 
    }
    .red { 
        background: #F8B4B4; 
    } 
    .red .unit-label { 
        background: #ff4d4d; 
    } 
    .red .unit-icon { 
        color: #ff4d4d; 
    }
    .green { 
        background: #C1E1C1; 
    } 
    .green .unit-label { 
        background: #28a745; 
    } 
    .green .unit-icon { 
        color: #28a745; 
    }
    .yellow { 
        background: #FFE4B5; 
    } 
    .yellow .unit-label { 
        background: #ffa500; 
    } 
    .yellow .unit-icon { 
        color: #ffa500; 
    }

    .select-jenis { 
        background: #B51016; 
        color: white; 
        border: none; 
        padding: 12px 30px; 
        border-radius: 15px; 
        font-size: 22px; 
        font-weight: 800; 
        cursor: pointer;
    }
    .chart-wrapper { 
        background: #ffffff; 
        padding: 40px; 
        border-radius: 35px; 
        height: 500px; 
        border: 1px solid #eee; 
        box-shadow: inset 0 0 20px rgba(0,0,0,0.02);
        position: relative; 
    }
   
    #chartBumdes {
        width: 100% !important;
        height: 100% !important;
    }
</style>

@section('content')
<div class="bumdes-page">
    <div class="container-fluid px-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2 class="main-title m-0">BADAN USAHA MILIK DESA</h2>
            <div class="bumdes-badge">
                <div class="badge-icon"><i class="bi bi-people-fill"></i></div>
                <span class="badge-text fw-bold fs-3">BUMDES</span>
            </div>
        </div>

        <div class="section-title">Struktur Pengurus</div>
        <div class="row g-4">
            @php
                $pengurus = [
                    ['jabatan' => 'Kepala BUMDES', 'nama' => 'Sumanto', 'foto' => 'sumanto.jpg'],
                    ['jabatan' => 'Wakil Kepala', 'nama' => 'Sumarni', 'foto' => 'sumarni.jpg'],
                    ['jabatan' => 'Sekretaris', 'nama' => 'Suman', 'foto' => 'suman.jpg'],
                    ['jabatan' => 'Bendahara', 'nama' => 'Sumar', 'foto' => 'sumar.jpg']
                ];
            @endphp
            @foreach($pengurus as $p)
            <div class="col-6">
                <div class="card-pengurus">
                    <div class="photo-container">
                        <img src="{{ asset('img/pengurus/' . $p['foto']) }}" alt="{{ $p['nama'] }}" class="photo-img">
                    </div>
                    <div class="pengurus-info">
                        <div class="jabatan">{{ $p['jabatan'] }}</div>
                        <div class="nama">{{ $p['nama'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
        <div class="section-title mt-5">Unit Usaha</div>
        <div class="row g-3">
            <div class="col-3" onclick="updateChartByUnit('air')">
                <div class="card-unit blue">
                    <div class="unit-label">AIR BERSIH</div>
                    <div class="unit-icon"><i class="bi bi-droplet-fill"></i></div>
                    <button class="btn-detail">Detail</button>
                </div>
            </div>
            <div class="col-3" onclick="updateChartByUnit('ternak')">
                <div class="card-unit red">
                    <div class="unit-label">PETERNAKAN</div>
                    <div class="unit-icon"><i class="bi bi-tencent-qq"></i></div>
                    <button class="btn-detail">Detail</button>
                </div>
            </div>
            <div class="col-3" onclick="updateChartByUnit('tani')">
                <div class="card-unit green">
                    <div class="unit-label">PERTANIAN</div>
                    <div class="unit-icon"><i class="bi bi-tree-fill"></i></div>
                    <button class="btn-detail">Detail</button>
                </div>
            </div>
            <div class="col-3" onclick="updateChartByUnit('sembako')">
                <div class="card-unit yellow">
                    <div class="unit-label">SEMBAKO</div>
                    <div class="unit-icon"><i class="bi bi-basket2-fill"></i></div>
                    <button class="btn-detail">Detail</button>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-5 mb-3">
            <div class="section-title m-0">Statistik Tahunan Pendapatan</div>
            <select class="select-jenis" id="unitSelector" onchange="updateChartFromSelect()">
                <option value="air">Jenis : Air Bersih</option>
                <option value="ternak">Jenis : Peternakan</option>
                <option value="tani">Jenis : Pertanian</option>
                <option value="sembako">Jenis : Sembako</option>
            </select>
        </div>
        
        <div class="chart-wrapper">
            <canvas id="chartBumdes" width="1200" height="500"></canvas>
        </div>
    </div>
</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let myChart;

    const dataUnit = {
        air: [30, 65, 95],
        ternak: [45, 40, 70],
        tani: [20, 55, 80],
        sembako: [60, 75, 90]
    };

    const colorsUnit = {
        air: '#007bff',
        ternak: '#ff4d4d',
        tani: '#28a745',
        sembako: '#ffa500'
    };

    document.addEventListener("DOMContentLoaded", function() {
        const canvas = document.getElementById('chartBumdes');
        const ctx = canvas.getContext('2d');

        Chart.defaults.devicePixelRatio = 3;
        const dpr = window.devicePixelRatio || 3;

        myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['2023', '2024', '2025'],
                datasets: [{
                    label: 'Pendapatan (%)',
                    data: dataUnit.air,
                    backgroundColor: colorsUnit.air,
                    borderRadius: 12,
                    barThickness: 85,
                    borderWidth: 2,
                    hoverBackgroundColor: '#111'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: { padding: 10 },
                animation: { duration: 1000, easing: 'easeOutQuart' },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1a1a1a',
                        titleFont: { size: 18, weight: 'bold' },
                        bodyFont: { size: 16 },
                        padding: 15,
                        cornerRadius: 10,
                        displayColors: false,
                        callbacks: { label: (ctx) => `${ctx.raw}%` }
                    }
                },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        max: 100,
                        grid: { color: '#f5f5f5', drawBorder: false },
                        ticks: { 
                            font: { size: 15, weight: '600' }, 
                            color: '#bbb',
                            callback: v => v + "%" 
                        } 
                    },
                    x: { 
                        grid: { display: false },
                        ticks: { 
                            font: { size: 20, weight: '800' }, 
                            color: '#333' 
                        } 
                    }
                }
            }
        });
    });

    function updateChartFromSelect() {
        updateChartData(document.getElementById('unitSelector').value);
    }

    function updateChartByUnit(unitKey) {
        document.getElementById('unitSelector').value = unitKey;
        updateChartData(unitKey);
    }

    function updateChartData(key) {
        if(!myChart) return;
        myChart.data.datasets[0].data = dataUnit[key];
        myChart.data.datasets[0].backgroundColor = colorsUnit[key];
        myChart.update();
    }
</script>

@section('bottom_navigation')
<a href="{{ route('beranda') }}" class="btn-nav">
    <i class="bi bi-arrow-left"></i> KEMBALI
</a>
@endsection