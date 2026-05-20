@extends('layouts.app')
 
@section('content')
 
<div class="modul-header">
    <div class="modul-icon"><i class="bi bi-search"></i></div>
    <div class="modul-title">EVALUASI</div>
</div>
<div class="page-title">SARANA DAN PRASARANA</div>
 
{{-- Filter Kategori --}}
<div style="padding: 0 5vw; display: flex; gap: 1.5vw; margin-bottom: 2vh; flex-wrap: wrap;" id="kategoriWrapper"></div>
 
{{-- List Sarana --}}
<div style="padding: 0 5vw 4vh; display: flex; flex-direction: column; gap: 1.5vh;" id="saranaContainer"></div>
 
@endsection
 
@section('bottom_navigation')
<a href="{{ route('evaluasi') }}" class="btn-nav">
    <i class="bi bi-arrow-left"></i> KEMBALI
</a>
@endsection
 
@push('scripts')
<script>
const saranaData = @json($sarana);
let kategoriKeys = Object.keys(saranaData);
let currentKategori = kategoriKeys[0];
 
function renderKategori() {
    const wrapper = document.getElementById('kategoriWrapper');
    wrapper.innerHTML = '';
    kategoriKeys.forEach((key, i) => {
        const count = saranaData[key].length;
        wrapper.innerHTML += `
            <button class="btn-merah ${i === 0 ? '' : 'opacity-75'}" 
                style="border-radius:12px;display:flex;align-items:center;gap:0.8vw;font-size:clamp(13px,1.2vw,20px);"
                onclick="switchKategori('${key}', this)">
                ${key.toUpperCase()}
                <span style="background:#0d6efd;padding:2px 10px;border-radius:10px;font-size:clamp(11px,0.9vw,14px);font-weight:700;">${count}</span>
            </button>`;
    });
}
 
function switchKategori(key, btn) {
    currentKategori = key;
    document.querySelectorAll('#kategoriWrapper button').forEach(b => b.classList.add('opacity-75'));
    btn.classList.remove('opacity-75');
    renderSarana(saranaData[key]);
}
 
function renderSarana(data) {
    const container = document.getElementById('saranaContainer');
    container.innerHTML = '';
 
    if (!data || data.length === 0) {
        container.innerHTML = `<p style="padding:2vh;color:#666;font-size:clamp(14px,1.3vw,20px);">Data tidak ditemukan.</p>`;
        return;
    }
 
    data.forEach(item => {
        container.innerHTML += `
            <div class="kiosk-card d-flex align-items-center gap-3">
                <img src="/storage/${item.gambar}"
                    style="width:clamp(120px,14vw,200px);height:clamp(80px,10vh,130px);object-fit:cover;border-radius:12px;flex-shrink:0;">
                <div style="flex:1;display:flex;justify-content:space-between;align-items:center;">
                    <div>
                        <div style="color:var(--merah-tua);font-size:clamp(15px,1.5vw,26px);font-weight:700;margin-bottom:0.4vh;">
                            ${item.nama}
                        </div>
                        <div style="font-size:clamp(12px,1.1vw,18px);font-weight:600;color:#444;">
                            Jumlah Unit: ${item.jumlah}
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:1.5vw;">
                        <span class="badge-status ${item.kondisi}">${item.kondisi}</span>
                        <a href="/kiosk/evaluasi/sarana/${item.slug}" class="btn-merah">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>`;
    });
}
 
renderKategori();
renderSarana(saranaData[currentKategori]);
</script>
@endpush
 