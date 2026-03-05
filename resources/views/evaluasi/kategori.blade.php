@extends('layouts.app')

@section('content')
<style>
    .infra-header-container {
        padding: 40px 80px 20px 80px; 
        position: relative;
        display: flex;
        flex-direction: column;
        animation: fadeInRight 0.8s ease-out; 
    }

    .evaluasi-section {
        display: flex;
        justify-content: flex-end; 
        align-items: center;
        gap: 20px;
        margin-bottom: 20px; 
    }

    .evaluasi-icon {
        width: 65px;
        height: 65px;
        background: #E72128;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .evaluasi-icon i {
        font-size: 30px;
        color: white;
    }

    .evaluasi-title {
        font-size: 35px;
        font-weight: 780;
        color: #000;
    }
    
    .infra-title {
        font-size: 35px; 
        font-weight: 850;
        color: #000;
        margin: 0;
        align-self: flex-start; 
        margin-top: 10px;
        text-transform: uppercase; /* Memaksa CAPSLOCK */
        letter-spacing: 1px; 
    }

    .stats-container {
        padding: 0 80px;
        display: flex;
        align-items: center;
        gap: 60px;
        margin-bottom: 40px;
    }

    .chart-wrapper {
        width: 280px;
        height: 280px;
        position: relative;
    }

    .legend-box {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 15px;
        font-size: 24px;
        font-weight: 700;
    }

    .color-box {
        width: 35px;
        height: 35px;
        border-radius: 4px;
    }

    .stats-divider {
        width: 3px;
        height: 180px;
        background-color: #F4C7C8; 
    }

    .stats-numbers {
        font-size: 28px;
        font-weight: 850;
        line-height: 1.8;
        color: #000;
    }

    .filter-section {
        padding: 0 80px;
        display: flex;
        justify-content: flex-end;
        gap: 20px;
        margin-bottom: 25px;
    }

    .filter-wrapper {
        position: relative;
    }

    .select-modern {
        background: #B51016;
        color: white;
        border: none;
        padding: 12px 45px 12px 25px;
        border-radius: 12px;
        font-size: 20px;
        font-weight: 700;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        transition: all 0.3s ease;
        outline: none;
        min-width: 200px;
    }

    .select-modern:active {
        transform: scale(0.95);
    }

    .filter-wrapper::after {
        content: "\F282"; 
        font-family: "bootstrap-icons";
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        color: white;
    }

    .project-list {
        padding: 0 80px;
        display: flex;
        flex-direction: column;
        gap: 25px;
        margin-bottom: 40px;
    }

    .project-card {
        background: #F2F2F2; 
        border-radius: 25px;
        padding: 25px;
        display: flex;
        gap: 30px;
        position: relative;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.217);
        transition: transform 0.3s ease;
    }

    .project-img {
        width: 320px;
        height: 220px;
        object-fit: cover;
        border-radius: 20px;
    }

    .project-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between; 
    }

    .project-info h3 {
        color: #B51016;
        font-size: 34px;
        font-weight: 850;
        margin-bottom: 10px;
    }

    .info-row {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 5px;
        color: #333;
    }
    
    .action-container {
        display: flex;
        justify-content: space-between; 
        align-items: flex-end;
        margin-top: 15px;
    }

    .progress-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .progress-label {
        font-size: 20px;
        font-weight: 700;
    }

    .progress-bg {
        width: 100%;
        max-width: 350px; 
        height: 20px;
        background: #F4C7C8;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: #B51016;
        border-radius: 10px;
    }

    .btn-detail-card {
        background: #B51016;
        color: white;
        padding: 10px 35px;
        border-radius: 12px;
        text-decoration: none;
        font-size: 20px;
        font-weight: 800;
        transition: 0.3s;
        box-shadow: 0 4px 10px rgba(181, 16, 22, 0.3);
        cursor: pointer;
        border: none;
    }

    .btn-detail-card:active {
        transform: scale(0.9);
        background: #8e0d11;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: center;
        gap: 12px;
        padding-bottom: 60px;
    }

    .page-btn {
        background: #B51016;
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 12px;
        font-size: 22px;
        font-weight: 700;
    }

    .page-btn.inactive {
        background: #F4A7A9;
    }

    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.1); 
        backdrop-filter: blur(15px); 
        -webkit-backdrop-filter: blur(15px);
        display: none; 
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .modal-content-custom {
        background: white;
        width: 85%;
        max-width: 900px;
        border-radius: 35px;
        overflow: hidden;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        animation: scaleIn 0.3s ease-out;
    }

    @keyframes scaleIn {
        from { transform: scale(0.9); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    .modal-header-custom {
        background: #B51016;
        color: white;
        padding: 25px 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header-custom h2 {
        margin: 0;
        font-size: 30px;
        font-weight: 900;
    }

    .btn-close-modal {
        background: white;
        color: #B51016;
        border: none;
        width: 45px;
        height: 45px;
        border-radius: 10px;
        font-size: 25px;
        font-weight: bold;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-body-custom {
        padding: 40px;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 30px;
        margin-bottom: 30px;
    }

    .detail-img-large {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 25px;
    }

    .modal-info-title {
        font-size: 26px;
        font-weight: 850;
        margin-bottom: 10px;
    }

    .modal-info-desc {
        font-size: 18px;
        color: #555;
        line-height: 1.6;
    }

    .modal-timeline {
        background: #F8F9FA;
        padding: 25px;
        border-radius: 20px;
        margin-top: 20px;
    }

    .timeline-steps-container {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin-top: 20px;
        padding: 0 10px;
    }

    .timeline-bar-bg {
        position: absolute;
        top: 15px;
        left: 0;
        width: 100%;
        height: 6px;
        background: #F4C7C8;
        z-index: 1;
    }

    .timeline-bar-fill {
        height: 100%;
        background: #B51016;
        width: 0%;
        transition: width 0.8s ease;
    }

    .step-item {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .step-circle {
        width: 30px;
        height: 30px;
        background: white;
        border: 5px solid #B51016;
        border-radius: 50%;
        margin: 0 auto 10px;
    }

    .step-item.done .step-circle {
        background: #B51016;
    }

    .step-text {
        font-size: 14px;
        font-weight: 800;
        color: #333;
    }

    .bottom-nav-fixed {
        padding: 0 80px 40px 80px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .btn-nav-large {
        background: #B51016;
        color: white;
        padding: 20px 50px;
        border-radius: 20px;
        text-decoration: none;
        font-size: 28px;
        font-weight: 900;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
</style>

{{-- Content Tetap Sama (Tidak Ada yang Dihapus) --}}
<div class="infra-header-container">
    <div class="evaluasi-section">
        <div class="evaluasi-icon"><i class="bi bi-clipboard-data"></i></div>
        <div class="evaluasi-title">EVALUASI</div>
    </div>
    <h1 class="infra-title" id="kategoriTitle"></h1>
</div>

<div class="project-list" id="projectContainer"></div>

<div class="stats-container">
    <div class="chart-wrapper"><canvas id="infraPieChart"></canvas></div>
    <div class="legend-box">
        <div class="legend-item"><div class="color-box" style="background: #A31217;"></div> Selesai</div>
        <div class="legend-item"><div class="color-box" style="background: #E72128;"></div> Proses</div>
        <div class="legend-item"><div class="color-box" style="background: #F4A7A9;"></div> Belum</div>
    </div>
    <div class="stats-divider"></div>
    <div class="stats-numbers">Total Program : 5<br>Selesai : 4<br>Proses : 1<br>Belum : 1</div>
</div>

<hr style="border: 2px solid #B51016; opacity: 1; margin: 0 80px 35px 80px;">

<div class="filter-section">
    <div class="filter-wrapper">
        <select class="select-modern" id="statusFilter">
            <option value="all">Semua Status</option>
            <option value="Proses">Proses</option>
            <option value="Selesai">Selesai</option>
            <option value="Belum">Belum</option> 
        </select>
    </div>
    <div class="filter-wrapper">
        <select class="select-modern" id="tahunFilter">
            <option value="all">Semua Tahun</option>
            <option value="2025">2025</option>
            <option value="2024">2024</option>
        </select>
    </div>
</div>

<div class="project-list" id="projectContainer">
    {{-- Card 1 --}}
    <div class="project-card" data-status="Proses" data-tahun="2025">
        <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef" class="project-img">
        <div class="project-info">
            <div>
                <h3>Pembangunan Jalan Desa</h3>
                <div class="info-row">Lokasi : Dusun 1</div>
                <div class="info-row">Status : Proses</div>
                <div class="info-row">Tahun : 2025</div>
            </div>
            <div class="action-container">
                <div class="progress-wrapper">
                    <span class="progress-label">Progress :</span>
                    <div class="progress-bg"><div class="progress-fill" style="width: 70%;"></div></div>
                </div>
                <button onclick="openDetail('Pembangunan Jalan Desa', 'Dusun 1', '70%', 'https://images.unsplash.com/photo-1500382017468-9049fed747ef', 'Pengerjaan jalan di Dusun 1 pada Maret 2025 dengan perbaikan sejauh 17km.')" class="btn-detail-card">Detail</button>
            </div>
        </div>
    </div>

    {{-- Card 2 --}}
    <div class="project-card" data-status="Selesai" data-tahun="2025">
        <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef" class="project-img">
        <div class="project-info">
            <div>
                <h3>Pembangunan Balai Desa</h3>
                <div class="info-row">Lokasi : Dusun 2</div>
                <div class="info-row">Status : Selesai</div>
                <div class="info-row">Tahun : 2025</div>
            </div>
            <div class="action-container">
                <div class="progress-wrapper">
                    <span class="progress-label">Progress :</span>
                    <div class="progress-bg"><div class="progress-fill" style="width: 100%;"></div></div>
                </div>
                <button onclick="openDetail('Pembangunan Balai Desa', 'Dusun 2', '100%', 'https://images.unsplash.com/photo-1518005020250-ee2900c7246e', 'Renovasi total balai desa untuk fasilitas warga.')" class="btn-detail-card">Detail</button>
            </div>
        </div>
    </div>
</div>

{{-- Pagination --}}
<div class="pagination-wrapper">
    <button class="page-btn"> < </button>
    <button class="page-btn"> 1 </button>
    <button class="page-btn inactive"> 2 </button>
    <button class="page-btn inactive"> 3 </button>
    <button class="page-btn"> > </button>
</div>

{{-- MODAL DETAIL (EFEK BLUR TOTAL) --}}
<div class="modal-overlay" id="modalDetail">
    <div class="modal-content-custom">
        <div class="modal-header-custom">
            <h2 id="m-title">Judul Proyek</h2>
            <button class="btn-close-modal" onclick="closeDetail()">&times;</button>
        </div>
        <div class="modal-body-custom">
            <div class="detail-grid">
                <img src="https://images.unsplash.com/photo-1500382017468-9049fed747e" id="m-img" class="detail-img-large">
                <div>
                    <div class="modal-info-title" id="m-loc">Lokasi : -</div>
                    <div class="modal-info-desc">
                        <strong>Deskripsi :</strong><br>
                        <span id="m-desc">...</span>
                    </div>
                    <div style="margin-top:20px;">
                        <strong>Anggaran :</strong><br>
                        <span style="font-size:30px; font-weight:900; color:#B51016;">Rp. 20.000.000,00</span>
                    </div>
                </div>
            </div>
            
            <div class="modal-timeline">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:20px; font-weight:800;">Progress Pengerjaan</span>
                    <span id="m-perc" style="font-size:24px; font-weight:900; color:#B51016;">0%</span>
                </div>
                <div class="timeline-steps-container">
                    <div class="timeline-bar-bg">
                        <div class="timeline-bar-fill" id="m-bar"></div>
                    </div>
                    <div class="step-item done">
                        <div class="step-circle"></div>
                        <div class="step-text">Awal<br><small>1 Mar 2025</small></div>
                    </div>
                    <div class="step-item done">
                        <div class="step-circle"></div>
                        <div class="step-text">Jeda<br><small>2 Mei 2025</small></div>
                    </div>
                    <div class="step-item" id="step-final">
                        <div class="step-circle"></div>
                        <div class="step-text">Selesai<br><small>1 Des 2025</small></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('infraPieChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Selesai', 'Proses', 'Belum'],
            datasets: [{
                data: [4, 1, 1], 
                backgroundColor: ['#A31217', '#E72128', '#F4A7A9'],
                borderWidth: 0
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            responsive: true
        }
    });

    function openDetail(title, loc, prog, img, desc) {
        document.getElementById('m-title').innerText = title;
        document.getElementById('m-loc').innerText = "Lokasi : " + loc;
        document.getElementById('m-desc').innerText = desc;
        document.getElementById('m-img').src = img;
        document.getElementById('m-perc').innerText = prog;
        
        setTimeout(() => {
            document.getElementById('m-bar').style.width = prog;
            if(prog === '100%') {
                document.getElementById('step-final').classList.add('done');
            } else {
                document.getElementById('step-final').classList.remove('done');
            }
        }, 100);

        document.getElementById('modalDetail').style.display = 'flex';
    }

    function closeDetail() {
        document.getElementById('modalDetail').style.display = 'none';
        document.getElementById('m-bar').style.width = '0%';
    }

    window.onclick = function(e) {
        if (e.target == document.getElementById('modalDetail')) closeDetail();
    }

    const statusFilter = document.getElementById('statusFilter');
    const tahunFilter = document.getElementById('tahunFilter');
    const projectCards = document.querySelectorAll('.project-card');

    function applyFilter() {
        const selectedStatus = statusFilter.value;
        const selectedTahun = tahunFilter.value;

        projectCards.forEach(card => {
            const cardStatus = card.getAttribute('data-status');
            const cardTahun = card.getAttribute('data-tahun');

            const statusMatch = selectedStatus === 'all' || cardStatus === selectedStatus;
            const tahunMatch = selectedTahun === 'all' || cardTahun === selectedTahun;

            if (statusMatch && tahunMatch) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    statusFilter.addEventListener('change', applyFilter);
    tahunFilter.addEventListener('change', applyFilter);

    // GLOBAL STATE
    let currentData = [];
    let pieChart;

    // DUMMY DATA (SIMULASI API)
    const projectsData = [
        {
            kategori: "infrastruktur",
            judul: "Pembangunan Jalan Desa",
            lokasi: "Dusun 1",
            status: "Proses",
            tahun: "2025",
            progress: 70,
            gambar: "https://images.unsplash.com/photo-1500382017468-9049fed747ef",
            deskripsi: "Pengerjaan jalan desa sepanjang 17km."
        },
        {
            kategori: "sosial",
            judul: "Pelatihan Masyarakat",
            lokasi: "Dusun 1",
            status: "Proses",
            tahun: "2025",
            progress: 58,
            gambar: "https://images.unsplash.com/photo-1522202176988-66273c2fd55f",
            deskripsi: "Pelatihan edukasi lingkungan."
        },
        {
            kategori: "ekonomi",
            judul: "Bantuan UMKM",
            lokasi: "Dusun 1",
            status: "Selesai",
            tahun: "2025",
            progress: 100,
            gambar: "https://images.unsplash.com/photo-1507679799987-c73779587ccf",
            deskripsi: "Bantuan modal usaha masyarakat."
        }
    ];

    // LOADING & STATE
    function showLoading() {
        document.getElementById('loadingState').style.display = 'block';
        document.getElementById('projectContainer').style.display = 'none';
    }

    function showContent() {
        document.getElementById('loadingState').style.display = 'none';
        document.getElementById('projectContainer').style.display = 'block';
    }

    // SIMULASI FETCH API
    function fetchProjects() {
        showLoading();
        return new Promise((resolve) => {
            setTimeout(() => {
                resolve(projectsData);
            }, 1000);
        });
    }

    // UPDATE JUDUL KATEGORI
    function updateKategoriTitle() {
        const urlParts = window.location.pathname.split('/');
        const kategoriAktif = urlParts[urlParts.length - 1];

        document.getElementById('kategoriTitle').innerText =
            kategoriAktif.charAt(0).toUpperCase() + kategoriAktif.slice(1);
    }

    // RENDER PROJECT
    async function renderProjects() {
        const data = await fetchProjects();

        const urlParts = window.location.pathname.split('/');
        const kategoriAktif = urlParts[urlParts.length - 1];

        currentData = data.filter(p => p.kategori === kategoriAktif);

        showContent();
        applyFilter();
    }

    // FILTER LOGIKA
    function applyFilter() {
        const container = document.getElementById('projectContainer');
        container.innerHTML = "";

        const selectedStatus = document.getElementById('statusFilter').value;
        const selectedTahun = document.getElementById('tahunFilter').value;

        let filtered = currentData;

        if (selectedStatus !== 'all') {
            filtered = filtered.filter(p => p.status === selectedStatus);
        }

        if (selectedTahun !== 'all') {
            filtered = filtered.filter(p => p.tahun === selectedTahun);
        }

        filtered.forEach(project => {
            container.innerHTML += `
                <div class="project-card">
                    <img src="${project.gambar}" class="project-img">
                    <div class="project-info">
                        <div>
                            <h3>${project.judul}</h3>
                            <div class="info-row">Lokasi : ${project.lokasi}</div>
                            <div class="info-row">Status : ${project.status}</div>
                            <div class="info-row">Tahun : ${project.tahun}</div>
                        </div>
                        <div class="action-container">
                            <div class="progress-wrapper">
                                <span class="progress-label">Progress :</span>
                                <div class="progress-bg">
                                    <div class="progress-fill" style="width: ${project.progress}%"></div>
                                </div>
                            </div>
                            <button 
                                onclick="openDetail(
                                    '${project.judul}',
                                    '${project.lokasi}',
                                    '${project.progress}%',
                                    '${project.gambar}',
                                    '${project.deskripsi}'
                                )"
                                class="btn-detail-card">
                                Detail
                            </button>
                        </div>
                    </div>
                </div>
            `;
        });

        updateStats(filtered);
    }

    // UPDATE STATISTIK
    function updateStats(data) {
        const total = data.length;
        const selesai = data.filter(d => d.status === "Selesai").length;
        const proses = data.filter(d => d.status === "Proses").length;
        const belum = data.filter(d => d.status === "Belum").length;

        document.querySelector('.stats-numbers').innerHTML = `
            Total Program : ${total}<br>
            Selesai : ${selesai}<br>
            Proses : ${proses}<br>
            Belum : ${belum}
        `;

        updateChart(selesai, proses, belum);
    }

    // UPDATE CHART
    function updateChart(selesai, proses, belum) {
        if (pieChart) pieChart.destroy();

        const ctx = document.getElementById('infraPieChart').getContext('2d');

        pieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Selesai', 'Proses', 'Belum'],
                datasets: [{
                    data: [selesai, proses, belum],
                    backgroundColor: ['#A31217', '#E72128', '#F4A7A9'],
                    borderWidth: 0
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                responsive: true
            }
        });
    }

    // EVENT LISTENER
    document.getElementById('statusFilter').addEventListener('change', applyFilter);
    document.getElementById('tahunFilter').addEventListener('change', applyFilter);

    // INIT
    updateKategoriTitle();
    renderProjects();
</script>
@endsection

@section('bottom_navigation')
<a href="{{ url('/evaluasi-pembangunan') }}" class="btn-nav">
    <i class="bi bi-arrow-left"></i>
    KEMBALI
</a>
@endsection