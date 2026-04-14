@extends('layouts.app')

@section('content')

@php
$jenis = request('jenis');
@endphp

<style>
    .header-top-style {
        display: flex;
        flex-direction: row-reverse;
        align-items: center;
        padding: 40px 80px 0 80px; /* atas aja biar ga tabrakan */
        gap: 20px;
    }

    .header-icon-circle {
        width: 65px;
        height: 65px;
        background: #E72128;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(231, 33, 40, 0.3);
    }

    .header-icon-circle i {
        font-size: 30px;
        color: white;
    }

    .header-text-title {
        font-size: 35px;
        font-weight: 800;
        color: #333;
        text-transform: uppercase;
    }

    .container-surat {
        padding: 20px 80px 40px 80px;
    }

    .judul-surat {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 25px;
    }

    label {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 8px;
        display: block;
    }

    .input-surat {
        width: 100%;
        font-size: 18px;
        padding: 16px;
        border-radius: 10px;
        border: none;
        background: #ddd;
        margin-bottom: 20px;
    }

    .btn-cek {
        width: 100%;
        font-size: 20px;
        padding: 16px;
        background: #E72128;
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        margin-bottom: 30px;
    }

    .label-blanko {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .preview-blanko {
        height: 180px;
        background: #ddd;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .btn-row {
        display: flex;
        gap: 15px;
    }

    .btn-merah {
        flex: 1;
        font-size: 18px;
        padding: 15px;
        background: #E72128;
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 700;
    }

    .container-surat {
        padding:20px 80px 60px 80px;
        animation: fadeSlide .5s ease;
    }

    @keyframes fadeSlide {
        from{
            opacity:0;
            transform:translateY(30px);
        }
        to{
            opacity:1;
            transform:translateY(0);
        }
    }

    .input-surat {
        transition:.2s ease;
    }

    .input-surat:focus {
        outline:none;
        background:#f5f5f5;
        box-shadow:0 0 0 3px rgba(231,33,40,.15);
    }

    .btn-cek {
        transition:.2s ease;
    }

    .btn-cek:hover:not(:disabled) {
        transform:translateY(-1px);
        box-shadow:0 6px 15px rgba(231,33,40,.25);
    }

    .preview-blanko {
        height:180px;
        background:#ddd;
        border-radius:10px;
        margin-bottom:20px;
        transition:.2s ease;
    }

    .preview-blanko:hover {
        transform:scale(1.01);
        box-shadow:0 8px 20px rgba(0,0,0,.08);
    }

    .btn-merah {
        transition:.2s ease;
    }

    .btn-merah:hover {
        transform:translateY(-1px);
        box-shadow:0 6px 15px rgba(231,33,40,.25);
    }
</style>

<div class="header-top-style">
    <div class="header-text-title">LAYANAN SURAT</div>
    <div class="header-icon-circle">
        <i class="bi bi-file-earmark-text"></i>
    </div>
</div>

<div class="container-surat">
    <div class="judul-surat">
        {{ $jenis }}
    </div>

    <label>Masukkan NIK atau No Surat Anda</label>
    <input type="text" id="inputCek" class="input-surat" placeholder="Contoh: 3573XXXXXXXXXXXX">

    <button id="btnCek" class="btn-cek">
        Cek Status
    </button>

    <div style="margin-bottom:10px;font-weight:600;">
        Blanko {{ $jenis }}
    </div>

    <div class="preview-blanko"></div>

    <div class="btn-row">
        <button class="btn-merah">Lihat</button>
        <button class="btn-merah">Unduh</button>
    </div>
</div>

@endsection

@section('modal_content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap');

    .popup-status {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        display: none;
        justify-content: center;
        align-items: flex-start;
        padding-top: 550px;
        z-index: 9999;
        font-family: 'Inter', sans-serif;
    }

    .popup-status.show {
        display: flex;
    }

    .popup-box {
        background: white;
        padding: 40px;
        border-radius: 24px;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        text-align: center;
        animation: popupIn .25s ease;
    }

    @keyframes popupIn {
        from{
            opacity:0;
            transform:translateY(30px) scale(.95);
        }
        to{
            opacity:1;
            transform:translateY(0) scale(1);
        }
    }

    .popup-box h3 {
        font-size: 24px;
        font-weight: 800;
        color: #333;
        margin-bottom: 20px;
    }

    .progress-wrapper {
        position: relative;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 40px 0 20px 0;
    }

    .progress-line {
        position: absolute;
        top: 15px; 
        left: 0;
        width: 100%;
        height: 4px;
        background: #e0e0e0;
        z-index: 1;
    }

    .progress-line-fill {
        position: absolute;
        top: 15px;
        left: 0;
        width: 50%; 
        height: 4px;
        background: #E72128;
        z-index: 2;
        transition: width 0.5s ease;
    }

    .step-item {
        position: relative;
        z-index: 3;
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .step-icon {
        width: 34px;
        height: 34px;
        background: white;
        border: 3px solid #e0e0e0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }

    .step-item.active .step-icon {
        border-color: #E72128;
        background: #E72128;
        color: white;
        box-shadow: 0 0 10px rgba(231, 33, 40, 0.3);
    }

    .step-item.completed .step-icon {
        border-color: #4CAF50; 
        background: #4CAF50;
        color: white;
    }

    .step-label {
        font-weight: 700;
        font-size: 14px;
        color: #999;
    }

    .step-item.active .step-label {
        color: #E72128;
    }

    .status-detail {
        background: #f8f8f8;
        padding: 15px;
        border-radius: 12px;
        margin-bottom: 25px;
        text-align: left;
        font-size: 13px;
        line-height: 1.5;
        color: #555;
    }

    .status-detail b {
        color: #333;
    }
</style>

<div class="popup-status" id="popupStatus">
    <div class="popup-box">
        <h3>Lacak Status Surat Anda</h3>
        
        <hr style="border: 0; border-top: 1px solid #eee;">

        <div class="progress-wrapper">
            <div class="progress-line"></div>
            <div class="progress-line-fill"></div>
            <div class="step-item completed">
                <div class="step-icon">✓</div>
                <div class="step-label">Pengajuan</div>
            </div>

            <div class="step-item active">
                <div class="step-icon">⚙</div>
                <div class="step-label">Proses</div>
            </div>

            <div class="step-item">
                <div class="step-icon">✓</div>
                <div class="step-label">Selesai</div>
            </div>
        </div>

        <div class="status-detail">
            <div><b>Posisi:</b> Sedang diproses oleh staf Dinas Dukcapil</div>
            <div><b>Update terakhir:</b> 01 Okt 2023, 10:30</div>
            <div style="margin-top:5px; color:#E72128;"><i>Estimasi waktu: 1-2 hari kerja.</i></div>
        </div>

        <button onclick="closePopup()" class="btn-merah" style="width:100%; cursor:pointer;">
            Tutup
        </button>
    </div>
</div>

<script>
    const input = document.getElementById("inputCek");
    const btn = document.getElementById("btnCek");
    const popup = document.getElementById("popupStatus");

    let sudahCek = false;

    btn.disabled = true;
    btn.style.background = "#999";

    input.addEventListener("input", function(){

        if(input.value.trim() !== ""){
            sudahCek = false;
            btn.disabled = false;
            btn.style.background = "#E72128";
        }else{
            btn.disabled = true;
            btn.style.background = "#999";
        }

    });

    btn.addEventListener("click", function(){

        if(input.value.trim() === "" || sudahCek) return;

        popup.classList.add("show");

        sudahCek = true;
        btn.disabled = true;
        btn.style.background = "#999";

    });

    function closePopup(){
        popup.classList.remove("show");
    }
</script>

@endsection

@section('bottom_navigation')
<a href="{{ route('layanan.surat') }}" class="btn-nav">
    <i class="bi bi-arrow-left"></i>
    KEMBALI
</a>
@endsection