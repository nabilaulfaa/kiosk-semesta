@extends('layouts.app')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')

{{-- Header --}}
<div class="modul-header">
    <div class="modul-icon"><i class="bi bi-search"></i></div>
    <div class="modul-title">EVALUASI</div>
</div>
<div class="page-title">PEMBANGUNAN INFRASTRUKTUR</div>

{{-- Filter --}}
<div style="padding: 0 5vw; display: flex; justify-content: flex-end; gap: 1.5vw; margin-bottom: 2vh;">
    <select class="select-merah" id="statusFilter">
        <option value="all">Semua Progress</option>
        <option value="Selesai">Selesai</option>
        <option value="Proses">Proses</option>
        <option value="Belum">Belum</option>
    </select>
    <select class="select-merah" id="tahunFilter">
        <option value="all">Semua Tahun</option>
        <option value="2025">2025</option>
        <option value="2024">2024</option>
    </select>
</div>

{{-- Stats & Chart --}}
<div style="padding: 0 5vw; display: flex; align-items: center; gap: 4vw; margin-bottom: 2vh;">
    <div style="width: clamp(150px, 16vw, 260px); height: clamp(150px, 16vw, 260px); position: relative;">
        <canvas id="chartPie"></canvas>
    </div>
    <div>
        <div style="display:flex;align-items:center;gap:1vw;font-size:clamp(13px,1.2vw,20px);font-weight:600;margin-bottom:0.8vh;">
            <span style="width:20px;height:20px;border-radius:4px;background:#A31217;display:inline-block;"></span> Selesai
        </div>
        <div style="display:flex;align-items:center;gap:1vw;font-size:clamp(13px,1.2vw,20px);font-weight:600;margin-bottom:0.8vh;">
            <span style="width:20px;height:20px;border-radius:4px;background:#E72128;display:inline-block;"></span> Proses
        </div>
        <div style="display:flex;align-items:center;gap:1vw;font-size:clamp(13px,1.2vw,20px);font-weight:600;">
            <span style="width:20px;height:20px;border-radius:4px;background:#F4A7A9;display:inline-block;"></span> Belum
        </div>
    </div>
    <div style="width:3px;height:clamp(80px,10vh,150px);background:#F4C7C8;"></div>
    <div id="statsNumbers" style="font-size:clamp(13px,1.2vw,22px);font-weight:700;line-height:1.8;"></div>
</div>

<hr style="margin: 0 5vw 2vh; border: 2px solid var(--merah-tua);">

{{-- Daftar Proyek --}}
<div style="padding: 0 5vw 4vh; display: flex; flex-direction: column; gap: 2vh;">
    @foreach($infrastruktur as $item)
    <div class="project-card kiosk-card d-flex gap-3"
        data-status="{{ $item['status'] }}"
        data-tahun="{{ $item['tahun'] }}"
        data-id="{{ $item['id'] }}"
        data-judul="{{ $item['judul'] }}"
        data-lokasi="{{ $item['lokasi'] }}"
        data-desc="{{ $item['deskripsi'] }}"
        data-progress="{{ $item['progress'] }}"
        data-anggaran="{{ number_format($item['anggaran'], 0, ',', '.') }}"
        data-img-utama="{{ asset('images/' . $item['gambar']['utama']) }}"
        data-img-awal="{{ asset('images/' . $item['gambar']['awal']) }}"
        data-img-proses="{{ asset('images/' . $item['gambar']['proses']) }}"
        data-img-selesai="{{ asset('images/' . $item['gambar']['selesai']) }}"
    >
        <img src="{{ asset('images/' . $item['gambar']['utama']) }}"
            style="width:clamp(150px,16vw,250px);height:clamp(100px,12vh,180px);object-fit:cover;border-radius:15px;flex-shrink:0;">
        <div style="flex:1;display:flex;flex-direction:column;justify-content:space-between;">
            <div>
                <div style="color:var(--merah-tua);font-size:clamp(16px,1.6vw,28px);font-weight:700;margin-bottom:0.5vh;">
                    {{ $item['judul'] }}
                </div>
                <div style="font-size:clamp(13px,1.1vw,18px);font-weight:500;margin-bottom:0.3vh;">Lokasi : {{ $item['lokasi'] }}</div>
                <div style="font-size:clamp(13px,1.1vw,18px);font-weight:500;margin-bottom:0.3vh;">Status : {{ $item['status'] }}</div>
                <div style="font-size:clamp(13px,1.1vw,18px);font-weight:500;">Tahun : {{ $item['tahun'] }}</div>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;margin-top:1vh;">
                <div class="progress-bg" style="width:clamp(120px,18vw,250px);">
                    <div class="progress-fill" style="width:{{ $item['progress'] }}%;"></div>
                </div>
                <button class="btn-merah btn-detail-card">Detail</button>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection

@section('modal_content')
<div class="modal-overlay" id="modalDetail">
    <div class="modal-box" style="max-width:85vw;">
        <div class="modal-header-kiosk">
            <h2 id="m-title">Judul Proyek</h2>
            <button class="btn-close-modal" onclick="closeModal('modalDetail')">×</button>
        </div>
        <div class="modal-body-kiosk">
            <div class="row g-3">
                <div class="col-7">
                    <img id="m-img" style="width:100%;height:clamp(160px,22vh,300px);object-fit:cover;border-radius:20px;">
                </div>
                <div class="col-5">
                    <div style="font-size:clamp(15px,1.4vw,24px);font-weight:800;" id="m-loc"></div>
                    <div style="font-size:clamp(13px,1.1vw,18px);color:#555;margin-top:1vh;line-height:1.6;">
                        <b>Deskripsi:</b><br><span id="m-desc"></span>
                    </div>
                    <div style="margin-top:1.5vh;">
                        <b>Anggaran:</b><br>
                        <span id="m-budget" style="font-size:clamp(16px,1.6vw,28px);font-weight:900;color:var(--merah-tua);"></span>
                    </div>
                </div>
            </div>

            {{-- Timeline --}}
            <div style="background:#F8F9FA;padding:2vh 2vw;border-radius:20px;margin-top:2vh;">
                <div style="display:flex;justify-content:space-between;font-size:clamp(14px,1.3vw,22px);font-weight:800;">
                    <span>Progress Pengerjaan</span>
                    <span id="m-perc">0%</span>
                </div>
                <div style="position:relative;margin-top:2vh;display:flex;justify-content:space-between;align-items:center;">
                    <div style="position:absolute;top:clamp(35px,6vh,60px);left:10%;width:80%;height:8px;background:#F4C7C8;border-radius:10px;">
                        <div id="m-bar" style="height:100%;background:linear-gradient(90deg,var(--merah-tua),var(--merah));width:0%;border-radius:10px;transition:width 0.8s ease;"></div>
                    </div>
                    @foreach([['id'=>'step1','label'=>'Mulai','sub'=>'Januari'],['id'=>'step2','label'=>'Proses','sub'=>'Juni'],['id'=>'step3','label'=>'Selesai','sub'=>'Desember']] as $step)
                    <div class="step-item" id="{{ $step['id'] }}" style="display:flex;flex-direction:column;align-items:center;text-align:center;z-index:2;flex:1;position:relative;">
                        <div style="width:clamp(60px,8vw,100px);height:clamp(45px,6vh,70px);margin-bottom:1.5vh;overflow:hidden;border-radius:12px;box-shadow:0 4px 10px rgba(0,0,0,0.1);background:#eee;">
                            <img id="m-img-{{ $step['id'] }}" style="width:100%;height:100%;object-fit:cover;">
                        </div>
                        <div style="width:clamp(20px,2vw,30px);height:clamp(20px,2vw,30px);border:4px solid var(--merah-tua);border-radius:50%;background:#fff;" class="step-circle"></div>
                        <div style="font-size:clamp(11px,1vw,16px);font-weight:800;margin-top:0.5vh;">{{ $step['label'] }}<br><small>{{ $step['sub'] }}</small></div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('bottom_navigation')
<a href="{{ route('evaluasi') }}" class="btn-nav">
    <i class="bi bi-arrow-left"></i> KEMBALI
</a>
@endsection

@push('scripts')
<script>
let myChart;
let allCards;

document.addEventListener('DOMContentLoaded', function () {
    allCards = document.querySelectorAll('.project-card');
    const ctx = document.getElementById('chartPie');
    myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Selesai', 'Proses', 'Belum'],
            datasets: [{ data: [0,0,0], backgroundColor: ['#A31217','#E72128','#F4A7A9'] }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
    });

    applyFilter();

    document.getElementById('statusFilter').addEventListener('change', applyFilter);
    document.getElementById('tahunFilter').addEventListener('change', applyFilter);

    document.querySelectorAll('.btn-detail-card').forEach(btn => {
        btn.addEventListener('click', function () {
            const card = this.closest('.project-card');
            const progress = parseInt(card.dataset.progress);

            let targetImg = card.dataset.imgUtama;
            if (progress >= 100) targetImg = card.dataset.imgSelesai;
            else if (progress >= 50) targetImg = card.dataset.imgProses;
            else if (progress > 0)  targetImg = card.dataset.imgAwal;

            document.getElementById('m-title').innerText = card.dataset.judul;
            document.getElementById('m-loc').innerText   = 'Lokasi : ' + card.dataset.lokasi;
            document.getElementById('m-img').src         = targetImg;
            document.getElementById('m-desc').innerText  = card.dataset.desc;
            document.getElementById('m-budget').innerText= 'Rp ' + card.dataset.anggaran;
            document.getElementById('m-perc').innerText  = card.dataset.progress + '%';

            document.getElementById('m-img-step1').src = card.dataset.imgAwal;
            document.getElementById('m-img-step2').src = card.dataset.imgProses;
            document.getElementById('m-img-step3').src = card.dataset.imgSelesai;

            ['step1','step2','step3'].forEach(id => {
                document.getElementById(id).querySelector('.step-circle').style.background = '#fff';
            });
            if (progress >= 1)   document.getElementById('step1').querySelector('.step-circle').style.background = 'var(--merah-tua)';
            if (progress >= 50)  document.getElementById('step2').querySelector('.step-circle').style.background = 'var(--merah-tua)';
            if (progress >= 100) document.getElementById('step3').querySelector('.step-circle').style.background = 'var(--merah-tua)';

            openModal('modalDetail');
            setTimeout(() => { document.getElementById('m-bar').style.width = progress + '%'; }, 300);
        });
    });
});

function applyFilter() {
    const status = document.getElementById('statusFilter').value;
    const tahun  = document.getElementById('tahunFilter').value;
    let selesai = 0, proses = 0, belum = 0;

    allCards.forEach(card => {
        const s = card.dataset.status;
        const t = card.dataset.tahun;
        const show = (status === 'all' || s === status) && (tahun === 'all' || t === tahun);
        
        if (show) {
            card.classList.remove('d-none');
            if (s === 'Selesai') selesai++;
            else if (s === 'Proses') proses++;
            else belum++;
        } else {
            card.classList.add('d-none');
        }
    });

    if (myChart) { myChart.data.datasets[0].data = [selesai, proses, belum]; myChart.update(); }

    document.getElementById('statsNumbers').innerHTML =
        `Total Program : ${selesai+proses+belum}<br>Selesai : ${selesai}<br>Proses : ${proses}<br>Belum : ${belum}`;
}
</script>
@endpush