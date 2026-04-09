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
        cursor: pointer;
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

    /* Unit Usaha */
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

    .modal-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.6);
        backdrop-filter: blur(5px);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    .modal-content-box {
        background: white;
        width: 750px;
        border-radius: 15px;
        overflow: hidden;
        position: relative;
        box-shadow: 0 20px 50px rgba(0,0,0,0.3);
        animation: zoomIn 0.3s ease;
    }

    @keyframes zoomIn {
        from { transform: scale(0.8); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    .modal-header-custom {
        background: #B51016;
        color: white;
        padding: 15px 25px;
        font-weight: 800;
        font-size: 22px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .close-modal-btn {
        background: none; 
        border: 1px solid white; 
        color: white;
        width: 35px; 
        height: 35px; 
        border-radius: 5px;
        font-size: 24px; 
        cursor: pointer; 
        display: flex; 
        align-items: center; 
        justify-content: center;
    }

    .modal-body-custom {
        display: flex;
        padding: 30px;
        gap: 20px;
    }

    .profile-side { 
        width: 30%; 
        text-align: center; 
    }
    .photo-box-modal { 
        width: 100%; 
        height: 220px; 
        background: #333; 
        border-radius: 15px; 
        overflow: hidden; 
        margin-bottom: 10px;
    }
    .photo-box-modal img { 
        width: 100%; 
        height: 100%; 
        object-fit: cover; 
    }
    .profile-label-modal { 
        font-size: 16px; 
        color: #333; 
        line-height: 1.4; 
    }

    .info-side { 
        width: 70%; 
    }
    .detail-table { 
        width: 100%; 
        border-collapse: separate; 
        border-spacing: 0 8px; 
    }
    .detail-table td { 
        padding: 12px 15px; 
        font-size: 18px; 
        background: #ececec; 
        color: #333; 
        font-weight: 600; 
    }
    .detail-table td.lbl { 
        background: #B51016; 
        color: white; 
        width: 30%; 
        border-top-left-radius: 5px; 
        border-bottom-left-radius: 5px; 
    }
    .detail-table td:last-child { 
        border-top-right-radius: 5px; 
        border-bottom-right-radius: 5px; 
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
                <div class="card-pengurus" onclick="showDetail('{{ $p['jabatan'] }}', '{{ $p['nama'] }}', '{{ asset('img/pengurus/' . $p['foto']) }}')">
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
            <div class="col-3" onclick="updateChartByUnit('air');openStatistik('air')">
                <div class="card-unit blue">
                    <div class="unit-label">AIR BERSIH</div>
                    <div class="unit-icon"><i class="bi bi-droplet-fill"></i></div>
                    <button class="btn-detail">Detail</button>
                </div>
            </div>
            <div class="col-3" onclick="updateChartByUnit('ternak');openStatistik('ternak')">
                <div class="card-unit red">
                    <div class="unit-label">PETERNAKAN</div>
                    <div class="unit-icon"><i class="bi bi-tencent-qq"></i></div>
                    <button class="btn-detail">Detail</button>
                </div>
            </div>
            <div class="col-3" onclick="updateChartByUnit('tani');openStatistik('tani')">
                <div class="card-unit green">
                    <div class="unit-label">PERTANIAN</div>
                    <div class="unit-icon"><i class="bi bi-tree-fill"></i></div>
                    <button class="btn-detail">Detail</button>
                </div>
            </div>
            <div class="col-3" onclick="updateChartByUnit('sembako');openStatistik('sembako')">
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
            <canvas id="chartBumdes"></canvas>
        </div>
    </div>
</div>

 @section('modal_content')

<style>
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.4);
        backdrop-filter: blur(8px); 
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .modal-overlay.show {
        display: flex;
    }
</style>

<div id="modalPengurus" class="modal-overlay">
    <div class="modal-content-box">
        <div class="modal-header-custom">
            <span id="modalTitle">DETAIL</span>
            <button class="close-modal-btn" onclick="closeModal()">&times;</button>
        </div>

        <div class="modal-body-custom">
            <div class="profile-side">
                <div class="photo-box-modal">
                    <img id="modalFoto">
                </div>
                <div class="profile-label-modal">
                    <strong id="modalNamaLabel"></strong><br>
                    <span id="modalJabatanLabel"></span>
                </div>
            </div>

            <div class="info-side">
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

<div id="modalStatistik" class="modal-overlay">
    <div class="modal-content-box" style="width:800px">

        <div class="modal-header-custom">
            <span id="modalStatTitle">AIR BERSIH</span>
            <button class="close-modal-btn" onclick="closeStatModal()">&times;</button>
        </div>

        <div style="padding:25px">

            <div style="margin-bottom:15px">
                <select id="filterTahun" class="select-jenis" 
                style="padding:8px 20px;font-size:16px"
                onchange="updateStatistik()">
                    <option value="2024">Tahun 2024</option>
                    <option value="2025">Tahun 2025</option>
                    <option value="2026" selected>Tahun 2026</option>
                </select>
            </div>

            <div style="height:250px;background:#f5f5f5;border-radius:15px;padding:10px">
                <canvas id="chartStatistik"></canvas>
            </div>

            <div style="margin-top:15px">
                <b>Info Keuangan :</b>

                <table class="detail-table" style="margin-top:10px;width:350px">
                    <tr>
                        <td class="lbl">Income</td>
                        <td id="statIncome"></td>
                    </tr>
                    <tr>
                        <td class="lbl">Pengeluaran</td>
                        <td id="statExpense"></td>
                    </tr>
                    <tr>
                        <td class="lbl">Keuntungan</td>
                        <td id="statProfit"></td>
                    </tr>
                </table>

            </div>

        </div>
    </div>
</div>

@endsection
@endsection

@section('bottom_navigation')
<a href="{{ route('beranda') }}" class="btn-nav">
    <i class="bi bi-arrow-left"></i> KEMBALI
</a>
@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let myChart;
    let statChart;
    let currentUnitStat = "air";

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

    const detailData = {
        'Kepala BUMDES': { lahir: 'Malang, 10-06-1979', agama: 'Islam', pendidikan: 'S2', periode: '2022-2026', sk: '666.999' },
        'Wakil Kepala': { lahir: 'Malang, 15-08-1982', agama: 'Islam', pendidikan: 'S1', periode: '2022-2026', sk: '666.999' },
        'Sekretaris': { lahir: 'Malang, 20-01-1985', agama: 'Islam', pendidikan: 'S1', periode: '2022-2026', sk: '666.999' },
        'Bendahara': { lahir: 'Malang, 05-03-1988', agama: 'Islam', pendidikan: 'D3', periode: '2022-2026', sk: '666.999' }
    };

    const mockStatistik = {
        air: {
            2026: { bulanan: [20, 40, 60, 80, 70, 90, 50, 60, 75, 85, 95, 100], income: "25 JT", expense: "10 JT", profit: "15 JT" },
            2025: { bulanan: [15, 30, 50, 70, 60, 75, 45, 55, 65, 70, 80, 85], income: "20 JT", expense: "8 JT", profit: "12 JT" },
            2024: { bulanan: [10, 20, 30, 40, 50, 60, 40, 30, 20, 50, 60, 70], income: "15 JT", expense: "5 JT", profit: "10 JT" }
        },
        ternak: {
            2026: { bulanan: [10, 25, 40, 60, 75, 85, 65, 70, 80, 85, 90, 95], income: "40 JT", expense: "15 JT", profit: "25 JT" },
            2025: { bulanan: [8, 15, 20, 30, 40, 50, 45, 50, 55, 60, 70, 80], income: "30 JT", expense: "10 JT", profit: "20 JT" },
            2024: { bulanan: [5, 10, 15, 20, 25, 30, 20, 25, 30, 40, 50, 60], income: "20 JT", expense: "8 JT", profit: "12 JT" }
        },
        tani: {
            2026: { bulanan: [5, 20, 35, 55, 70, 80, 60, 65, 75, 85, 90, 100], income: "30 JT", expense: "12 JT", profit: "18 JT" },
            2025: { bulanan: [10, 15, 25, 40, 50, 60, 55, 60, 65, 70, 75, 80], income: "25 JT", expense: "10 JT", profit: "15 JT" },
            2024: { bulanan: [5, 10, 20, 30, 40, 50, 45, 40, 35, 45, 50, 55], income: "15 JT", expense: "7 JT", profit: "8 JT" }
        },
        sembako: {
            2026: { bulanan: [30, 45, 60, 75, 80, 85, 75, 80, 90, 95, 100, 100], income: "50 JT", expense: "20 JT", profit: "30 JT" },
            2025: { bulanan: [25, 35, 45, 55, 65, 70, 60, 65, 70, 80, 85, 90], income: "45 JT", expense: "18 JT", profit: "27 JT" },
            2024: { bulanan: [20, 30, 40, 50, 55, 60, 50, 55, 60, 65, 70, 75], income: "35 JT", expense: "15 JT", profit: "20 JT" }
        }
    };

    document.addEventListener("DOMContentLoaded", function() {
        const canvas = document.getElementById('chartBumdes');
        const ctx = canvas.getContext('2d');

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
                devicePixelRatio: window.devicePixelRatio,
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1a1a1a',
                        padding: 15,
                        callbacks: { label: (ctx) => `${ctx.raw}%` }
                    }
                },
                scales: {
                    y: { beginAtZero: true, max: 100, ticks: { callback: v => v + "%" } },
                    x: { grid: { display: false } }
                }
            }
        });
    });

    function openStatistik(unit) {
        currentUnitStat = unit;
        const title = { air: "AIR BERSIH", ternak: "PETERNAKAN", tani: "PERTANIAN", sembako: "SEMBAKO" };
        document.getElementById("modalStatTitle").innerText = title[unit];
        document.getElementById("modalStatistik").classList.add("show");
        updateStatistik();
    }

    function closeStatModal() {
        document.getElementById("modalStatistik").classList.remove("show");
    }

    function updateStatistik() {

        const tahun = document.getElementById("filterTahun").value;

        const data = mockStatistik[currentUnitStat][tahun];
        if(!data) return;

        document.getElementById("statIncome").innerText = data.income;
        document.getElementById("statExpense").innerText = data.expense;
        document.getElementById("statProfit").innerText = data.profit;

        const ctx = document
            .getElementById("chartStatistik")
            .getContext("2d");

        if (statChart) statChart.destroy();

        statChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    "Jan","Feb","Mar","Apr","Mei","Jun",
                    "Jul","Agu","Sep","Okt","Nov","Des"
                ],
                datasets: [{
                    data: data.bulanan,
                    backgroundColor: colorsUnit[currentUnitStat],
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio:false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });

    }

    function showDetail(jabatan, nama, fotoUrl) {
        const data = detailData[jabatan];
        document.getElementById('modalTitle').innerText = `DETAIL ${jabatan.toUpperCase()}`;
        document.getElementById('modalFoto').src = fotoUrl;
        document.getElementById('modalNamaLabel').innerText = nama;
        document.getElementById('modalJabatanLabel').innerText = jabatan;
        document.getElementById('dNama').innerText = nama;
        document.getElementById('dLahir').innerText = data.lahir;
        document.getElementById('dAgama').innerText = data.agama;
        document.getElementById('dPendidikan').innerText = data.pendidikan;
        document.getElementById('dPeriode').innerText = data.periode;
        document.getElementById('dSK').innerText = data.sk;
        document.getElementById('modalPengurus').classList.add('show');
    }

    function closeModal() {
        document.getElementById('modalPengurus').classList.remove('show');
    }

    window.onclick = function(event) {
        const modalPengurus = document.getElementById('modalPengurus');
        const modalStat = document.getElementById('modalStatistik');
        if (event.target == modalPengurus) closeModal();
        if (event.target == modalStat) closeStatModal();
    }

    function updateChartFromSelect() {
        updateChartData(document.getElementById('unitSelector').value);
    }

    function updateChartByUnit(unitKey) {
        document.getElementById('unitSelector').value = unitKey;
        updateChartData(unitKey);
    }

    function updateChartData(key) {
        if (!myChart) return;
        myChart.data.datasets[0].data = dataUnit[key];
        myChart.data.datasets[0].backgroundColor = colorsUnit[key];
        myChart.update();
    }
</script>