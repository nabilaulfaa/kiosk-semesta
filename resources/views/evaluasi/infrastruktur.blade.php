@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    /* CSS ORIGINAL */
    html, body { 
        margin: 0; 
        padding: 0; 
    }

    .infra-header-container { 
        padding: 40px 80px 20px; 
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
        color: #fff; 
    }

    .evaluasi-title { 
        font-size: 35px; 
        font-weight: 800; 
    }

    .infra-title { 
        font-size: 35px; 
        font-weight: 900; 
        text-transform: uppercase; 
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
    }

    .legend-item { 
        display: flex; 
        align-items: center; 
        gap: 10px; 
        font-size: 22px; 
        font-weight: 700; 
        margin-bottom: 10px; 
    }

    .color-box { 
        width: 25px; 
        height: 25px; 
        border-radius: 4px; 
    }

    .stats-divider { 
        width: 3px; 
        height: 150px; 
        background: #F4C7C8; 
    }

    .stats-numbers { 
        font-size: 24px; 
        font-weight: 800; 
        line-height: 1.6; 
    }

    .filter-section { 
        padding: 0 80px; 
        display: flex; 
        justify-content: flex-end; 
        gap: 20px; 
        margin-bottom: 25px; 
    }

    .select-modern { 
        background: #B51016; 
        color: #fff; 
        border: none; 
        padding: 12px 20px; 
        border-radius: 10px; 
        font-size: 18px; 
        font-weight: 700; 
        cursor: pointer; 
    }

    .project-list { 
        padding: 0 80px 120px; 
        display: flex; 
        flex-direction: column; 
        gap: 25px; 
    }

    .project-card { 
        background: #F2F2F2; 
        border-radius: 25px; 
        padding: 25px; 
        display: flex; 
        gap: 25px; 
        box-shadow: 0 5px 15px rgba(0,0,0,0.1); 
        transition: 0.3s; 
    }

    .project-card:hover { 
        transform: translateY(-5px); 
    }

    .project-img { 
        width: 250px; 
        height: 180px; 
        object-fit: cover; 
        border-radius: 15px; 
    }

    .project-info { 
        flex: 1; 
        display: flex; 
        flex-direction: column; 
        justify-content: space-between; 
    }

    .project-info h3 { 
        color: #B51016; 
        font-size: 28px; 
        font-weight: 900; 
        margin-bottom: 10px; 
    }

    .info-row { 
        font-size: 18px; 
        font-weight: 600; 
        margin-bottom: 3px; 
    }

    .action-container { 
        display: flex; 
        justify-content: space-between; 
        align-items: flex-end; 
        margin-top: 15px; 
    }

    .progress-bg { 
        width: 250px; 
        height: 15px; 
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
        color: #fff; 
        padding: 10px 25px; 
        border-radius: 10px; 
        border: none; 
        font-weight: 700; 
        cursor: pointer; 
        transition: 0.2s; 
    }

    .btn-detail-card:active { 
        transform: scale(0.95); 
    }
</style>

<div class="infra-header-container">
    <div class="evaluasi-section">
        <div class="evaluasi-icon"><i class="bi bi-clipboard-data"></i></div>
        <div class="evaluasi-title">EVALUASI</div>
    </div>
    <h1 class="infra-title">PEMBANGUNAN INFRASTRUKTUR</h1>
</div>

<div class="filter-section">
    <select class="select-modern" id="statusFilter">
        <option value="all">Semua Progress</option>
        <option value="Selesai">Selesai</option>
        <option value="Proses">Proses</option>
        <option value="Belum">Belum</option>
    </select>
    <select class="select-modern" id="tahunFilter">
        <option value="all">Semua Tahun</option>
        <option value="2025">2025</option>
        <option value="2024">2024</option>
    </select>
</div>

<div class="stats-container">
    <div class="chart-wrapper" style="width: 280px; height: 280px; position: relative;">
        <canvas id="chart"></canvas>
    </div>
    <div>
        <div class="legend-item"><span class="color-box" style="background:#A31217"></span> Selesai</div>
        <div class="legend-item"><span class="color-box" style="background:#E72128"></span> Proses</div>
        <div class="legend-item"><span class="color-box" style="background:#F4A7A9"></span> Belum</div>
    </div>
    <div class="stats-divider"></div>
    <div class="stats-numbers"></div>
</div>

<hr style="margin:0 80px 30px; border:2px solid #B51016;">

<div class="project-list">
    <div class="project-card" data-status="Selesai" data-tahun="2025" data-title="Pembangunan Jalan Desa" data-lokasi="Dusun 1" data-img="https://images.unsplash.com/photo-1500382017468-9049fed747ef" data-desc="Pembangunan jalan sepanjang 17km" data-progress="100%" data-budget="Rp 20.000.000" data-img-start="https://images.unsplash.com/photo-1500382017468-9049fed747ef" data-img-progress="https://images.unsplash.com/photo-1501594907352-04cda38ebc29" data-img-finish="https://images.unsplash.com/photo-1503387762-592deb58ef4e">
        <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef" class="project-img">
        <div class="project-info">
            <div>
                <h3>Pembangunan Jalan Desa</h3>
                <div class="info-row">Lokasi : Dusun 1</div>
                <div class="info-row">Status : Selesai</div>
                <div class="info-row">Tahun : 2025</div>
            </div>
            <div class="action-container">
                <div class="progress-bg"><div class="progress-fill" style="width:100%"></div></div>
                <button class="btn-detail-card">Detail</button>
            </div>
        </div>
    </div>

    <div class="project-card" data-status="Proses" data-tahun="2025" data-title="Pembangunan Balai Desa" data-lokasi="Dusun 2" data-img="https://images.unsplash.com/photo-1500382017468-9049fed747ef" data-desc="Renovasi balai desa untuk fasilitas warga" data-progress="60%" data-budget="Rp 15.000.000" data-img-start="https://images.unsplash.com/photo-1500382017468-9049fed747ef" data-img-progress="https://images.unsplash.com/photo-1501594907352-04cda38ebc29" data-img-finish="https://images.unsplash.com/photo-1503387762-592deb58ef4e">
        <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef" class="project-img">
        <div class="project-info">
            <div>
                <h3>Pembangunan Balai Desa</h3>
                <div class="info-row">Lokasi : Dusun 2</div>
                <div class="info-row">Status : Proses</div>
                <div class="info-row">Tahun : 2025</div>
            </div>
            <div class="action-container">
                <div class="progress-bg"><div class="progress-fill" style="width:60%"></div></div>
                <button class="btn-detail-card">Detail</button>
            </div>
        </div>
    </div>

    <div class="project-card" data-status="Proses" data-tahun="2024" data-title="Pembangunan Drainase" data-lokasi="Dusun 3" data-img="https://images.unsplash.com/photo-1500382017468-9049fed747ef" data-desc="Perbaikan sistem drainase desa" data-progress="40%" data-budget="Rp 12.000.000" data-img-start="https://images.unsplash.com/photo-1500382017468-9049fed747ef" data-img-progress="https://images.unsplash.com/photo-1501594907352-04cda38ebc29" data-img-finish="https://images.unsplash.com/photo-1503387762-592deb58ef4e">
        <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef" class="project-img">
        <div class="project-info">
            <div>
                <h3>Pembangunan Drainase</h3>
                <div class="info-row">Lokasi : Dusun 3</div>
                <div class="info-row">Status : Proses</div>
                <div class="info-row">Tahun : 2024</div>
            </div>
            <div class="action-container">
                <div class="progress-bg"><div class="progress-fill" style="width:40%"></div></div>
                <button class="btn-detail-card">Detail</button>
            </div>
        </div>
    </div>

    <div class="project-card" data-status="Belum" data-tahun="2025" data-title="Pembangunan Taman Desa" data-lokasi="Dusun 4" data-img="https://images.unsplash.com/photo-1500382017468-9049fed747ef" data-desc="Rencana pembangunan taman desa" data-progress="10%" data-budget="Rp 8.000.000" data-img-start="https://images.unsplash.com/photo-1500382017468-9049fed747ef" data-img-progress="https://images.unsplash.com/photo-1501594907352-04cda38ebc29" data-img-finish="https://images.unsplash.com/photo-1503387762-592deb58ef4e">
        <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef" class="project-img">
        <div class="project-info">
            <div>
                <h3>Pembangunan Taman Desa</h3>
                <div class="info-row">Lokasi : Dusun 4</div>
                <div class="info-row">Status : Belum</div>
                <div class="info-row">Tahun : 2025</div>
            </div>
            <div class="action-container">
                <div class="progress-bg"><div class="progress-fill" style="width:10%"></div></div>
                <button class="btn-detail-card">Detail</button>
            </div>
        </div>
    </div>

    <div class="project-card" data-status="Selesai" data-tahun="2024" data-title="Perbaikan Jembatan Desa" data-lokasi="Dusun 5" data-img="https://images.unsplash.com/photo-1500382017468-9049fed747ef" data-desc="Perbaikan jembatan penghubung antar dusun" data-progress="100%" data-budget="Rp 18.000.000" data-img-start="https://images.unsplash.com/photo-1500382017468-9049fed747ef" data-img-progress="https://images.unsplash.com/photo-1501594907352-04cda38ebc29" data-img-finish="https://images.unsplash.com/photo-1503387762-592deb58ef4e">
        <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef" class="project-img">
        <div class="project-info">
            <div>
                <h3>Perbaikan Jembatan Desa</h3>
                <div class="info-row">Lokasi : Dusun 5</div>
                <div class="info-row">Status : Selesai</div>
                <div class="info-row">Tahun : 2024</div>
            </div>
            <div class="action-container">
                <div class="progress-bg"><div class="progress-fill" style="width:100%"></div></div>
                <button class="btn-detail-card">Detail</button>
            </div>
        </div>
    </div>
</div>

<script>
let myChart;

document.addEventListener('DOMContentLoaded', function() {
    
    const ctx = document.getElementById('chart');
    if (ctx) {
        myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Selesai', 'Proses', 'Belum'],
                datasets: [{
                    data: [0, 0, 0],
                    backgroundColor: ['#A31217', '#E72128', '#F4A7A9']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });
    }

    applyFilter();

    document.getElementById('statusFilter').addEventListener('change', applyFilter);
    document.getElementById('tahunFilter').addEventListener('change', applyFilter);

    document.querySelectorAll('.btn-detail-card').forEach(btn => {
        btn.addEventListener('click', function () {
            const card = this.closest('.project-card');
            const progress = parseInt(card.dataset.progress);
            
            let targetImg = card.dataset.img; 
            if (progress >= 100) targetImg = card.dataset.imgFinish;
            else if (progress >= 50) targetImg = card.dataset.imgProgress;
            else if (progress > 0) targetImg = card.dataset.imgStart;

            document.getElementById('m-title').innerText = card.dataset.title;
            document.getElementById('m-loc').innerText = "Lokasi : " + card.dataset.lokasi;
            document.getElementById('m-img').src = targetImg; 
            document.getElementById('m-desc').innerText = card.dataset.desc;
            document.getElementById('m-budget').innerText = card.dataset.budget;
            document.getElementById('m-perc').innerText = card.dataset.progress;

            document.getElementById('m-img-step1').src = card.dataset.imgStart;
            document.getElementById('m-img-step2').src = card.dataset.imgProgress;
            document.getElementById('m-img-step3').src = card.dataset.imgFinish;

            const steps = document.querySelectorAll('.step-item');
            steps.forEach(s => s.classList.remove('done'));

            if (progress >= 1) steps[0].classList.add('done');
            if (progress >= 50) steps[1].classList.add('done');
            if (progress === 100) steps[2].classList.add('done');

            openModalFull();

            setTimeout(() => {
                document.getElementById('m-bar').style.width = progress + "%";
            }, 300);
        });
    });
});

function applyFilter() {
    const status = document.getElementById('statusFilter').value;
    const tahun = document.getElementById('tahunFilter').value;
    const allCards = document.querySelectorAll('.project-card');

    let selesai = 0, proses = 0, belum = 0;

    allCards.forEach(card => {
        const s = card.dataset.status;
        const t = card.dataset.tahun;
        const show = (status === 'all' || s === status) && (tahun === 'all' || t === tahun);

        card.style.display = show ? 'flex' : 'none';

        if (show) {
            if (s === 'Selesai') selesai++;
            else if (s === 'Proses') proses++;
            else belum++;
        }
    });

    if (myChart) {
        myChart.data.datasets[0].data = [selesai, proses, belum];
        myChart.update();
    }

    const statsNumbers = document.querySelector('.stats-numbers');
    if (statsNumbers) {
        statsNumbers.innerHTML = `
            Total Program : ${selesai + proses + belum}<br>
            Selesai : ${selesai}<br>
            Proses : ${proses}<br>
            Belum : ${belum}
        `;
    }
}

function openModalFull() {
    document.getElementById("modalDetail").classList.add("show");
    if (typeof blurBackground === 'function') blurBackground();
}

function closeModalFull() {
    document.getElementById("modalDetail").classList.remove("show");
    document.getElementById('m-bar').style.width = '0%';
    if (typeof unblurBackground === 'function') unblurBackground();
}

document.getElementById('modalDetail').addEventListener('click', function(e) {
    if (e.target === this) closeModalFull();
});
</script>
@endsection

@section('modal_content')
<style>
    .modal-overlay { 
        position: fixed; 
        top: 0; 
        left: 0; 
        width: 100%; 
        height: 100%; 
        background: rgba(0,0,0,0.25); 
        backdrop-filter: blur(8px); 
        display: none; 
        justify-content: center; 
        align-items: center; 
        z-index: 99999; 
        pointer-events: none; 
    }

    .modal-overlay.show { 
        display: flex; 
        pointer-events: auto; 
    }

    .modal-content-custom { 
        background: rgba(255,255,255,0.95); 
        width: 950px; 
        border-radius: 35px; 
        overflow: hidden; 
        box-shadow: 0 40px 80px rgba(0,0,0,0.3); 
        animation: smoothScale 0.3s ease; 
    }

    @keyframes smoothScale { 
        from { 
            transform: translateY(20px) scale(0.95); 
            opacity: 0; 
        } 
        to { 
            transform: translateY(0) scale(1); 
            opacity: 1; 
        } 
    }

    .modal-header-custom { 
        background: #B51016; 
        color: #fff; 
        padding: 30px 40px; 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
    }

    .modal-header-custom h2 { 
        font-size: 32px; 
        font-weight: 900; 
        margin: 0; 
    }

    .btn-close-modal { 
        background: #fff; 
        color: #B51016; 
        border: none; 
        width: 45px; 
        height: 45px; 
        border-radius: 12px; 
        font-size: 22px; 
        cursor: pointer; 
    }

    .modal-body-custom { 
        padding: 40px; 
    }

    .detail-grid { 
        display: grid; 
        grid-template-columns: 1.2fr 1fr; 
        gap: 30px; 
    }

    .detail-img-large { 
        width: 100%; 
        height: 300px; 
        object-fit: cover; 
        border-radius: 25px; 
    }

    .modal-info-title { 
        font-size: 26px; 
        font-weight: 900; 
    }

    .modal-info-desc { 
        margin-top: 10px; 
        font-size: 18px; 
        color: #555; 
        line-height: 1.6; 
    }

    .modal-budget { 
        margin-top: 20px; 
    }

    .modal-budget span { 
        font-size: 30px; 
        font-weight: 900; 
        color: #B51016; 
    }

    .modal-timeline { 
        margin-top: 30px; 
        background: #F8F9FA; 
        padding: 25px; 
        border-radius: 25px; 
    }

    .timeline-header { 
        display: flex; 
        justify-content: space-between; 
        font-size: 20px; 
        font-weight: 800; 
    }

    .timeline-steps-container { 
        position: relative; 
        margin-top: 25px; 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
    }

    .timeline-bar-bg { 
        position: absolute; 
        top: 98px; 
        left: 10%; 
        width: 80%; 
        height: 8px; 
        background: #F4C7C8; 
        border-radius: 10px; 
    }

    .timeline-bar-fill { 
        height: 100%; 
        background: linear-gradient(90deg, #B51016, #E72128); 
        width: 0%; 
        border-radius: 10px; 
        transition: width 0.8s ease; 
    }

    .step-item { 
        display: flex; 
        flex-direction: column; 
        align-items: center; 
        text-align: center; 
        z-index: 2; 
        flex: 1; 
        position: relative; 
    }

    .step-img-container { 
        width: 100px; 
        height: 70px; 
        margin-bottom: 15px; 
        overflow: hidden; 
        border-radius: 12px; 
        box-shadow: 0 4px 10px rgba(0,0,0,0.1); 
        background: #eee; 
    }

    .step-img-container img {
        width: 100%; 
        height: 100%; 
        object-fit: cover; 
    }

    .step-circle { 
        width: 30px; 
        height: 30px; 
        border: 4px solid #B51016; 
        border-radius: 50%; 
        background: #fff; 
    }

    .step-item.done .step-circle { 
        background: #B51016; 
    }

    .step-text { 
        font-size: 14px; 
        font-weight: 800; 
        margin-top: 6px; 
    }
</style>

<div class="modal-overlay" id="modalDetail">
    <div class="modal-content-custom">
        <div class="modal-header-custom">
            <h2 id="m-title">Judul Proyek</h2>
            <button class="btn-close-modal" onclick="closeModalFull()">×</button>
        </div>
        <div class="modal-body-custom">
            <div class="detail-grid">
                <img id="m-img" class="detail-img-large">
                <div>
                    <div class="modal-info-title" id="m-loc">Lokasi</div>
                    <div class="modal-info-desc">
                        <b>Deskripsi :</b><br>
                        <span id="m-desc"></span>
                    </div>
                    <div class="modal-budget">
                        <b>Anggaran :</b><br>
                        <span id="m-budget">Rp -</span>
                    </div>
                </div>
            </div>
            <div class="modal-timeline">
                <div class="timeline-header">
                    <span>Progress Pengerjaan</span>
                    <span id="m-perc">0%</span>
                </div>
                <div class="timeline-steps-container">
                    <div class="timeline-bar-bg">
                        <div class="timeline-bar-fill" id="m-bar"></div>
                    </div>
                    <div class="step-item">
                        <div class="step-img-container"><img id="m-img-step1"></div>
                        <div class="step-circle"></div>
                        <div class="step-text">Mulai<br><small>Januari</small></div>
                    </div>
                    <div class="step-item">
                        <div class="step-img-container"><img id="m-img-step2"></div>
                        <div class="step-circle"></div>
                        <div class="step-text">Proses<br><small>Juni</small></div>
                    </div>
                    <div class="step-item">
                        <div class="step-img-container"><img id="m-img-step3"></div>
                        <div class="step-circle"></div>
                        <div class="step-text">Selesai<br><small>Desember</small></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('bottom_navigation')
<a href="{{ route('evaluasi') }}" class="btn-nav">
    <i class="bi bi-arrow-left"></i>
    KEMBALI
</a>
@endsection