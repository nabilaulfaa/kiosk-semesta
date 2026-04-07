@extends('layouts.app')

@section('content')
<style>
    /* Kontainer Utama */
    .main-page-container {
        display: flex;
        flex-direction: column;
        min-height: calc (100vh - 120px);
        background-color: #ffffff;
    }

    /* Header Section (Meniru gaya Evaluasi: Kanan Atas) */
    .header-top-style {
        display: flex;
        justify-content: flex-end; /* Mentok Kanan */
        align-items: center;
        padding: 40px 80px;
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
        font-weight: 780;
        letter-spacing: 1px;
        color: #333;
        text-transform: uppercase;
    }

    /* Container untuk Judul Kiri & Card yang ditengahkan */
    .content-centered-area {
        flex-grow: 1; /* Mengambil sisa ruang */
        display: flex;
        flex-direction: column;
        justify-content: center; /* Tengahkan Vertikal */
        padding: 0 80px 100px 80px; 
    }

    .left-section-title {
        font-size: 28px;
        font-weight: 800;
        color: #333;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 40px;
        text-align: left;
    }

   
    .menu-card-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 50px;
        max-width: 1200px;
        width: 100%;
        margin: 0 auto; 
    }

    .card-item {
        background: white;
        border-radius: 25px;
        overflow: hidden;
        text-decoration: none;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        position: relative;
        display: flex;
        flex-direction: column;
        backface-visibility: hidden;
        transform: translateZ(0);
    }

    .card-item:hover {
        transform: translateY(-15px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }


    .card-tag {
        position: absolute;
        top: 20px;
        left: 0;
        background: #B71C1C;
        color: white;
        padding: 8px 30px;
        border-radius: 0 20px 20px 0;
        font-weight: 700;
        font-size: 16px;
        z-index: 10;
    }

    .card-img-wrapper {
        width: 100%;
        height: 420px; 
        overflow: hidden;
    }

    .card-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .card-body-red {
        background: #B71C1C;
        padding: 30px;
        color: white;
        text-align: center;
        min-height: 150px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .card-body-red h3 {
        font-size: 22px;
        font-weight: 800;
        margin-bottom: 10px;
        text-transform: uppercase;
    }

    .card-body-red p {
        font-size: 16px;
        opacity: 0.9;
        margin: 0;
    }
</style>

<div class="main-page-container">
    
    <div class="header-top-style">
        <div class="header-icon-circle">
            <i class="bi bi-people-fill"></i>
        </div>
        <div class="header-text-title">PKK POSYANDU</div>
    </div>

    <div class="content-centered-area">
        
        <div class="left-section-title">
            LAYANAN PKK & POSYANDU DESA
        </div>

        <div class="menu-card-grid">
            <a href="{{ route('pkk.index') }}" class="card-item">
                <div class="card-tag">PKK</div>
                <div class="card-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?w=800" alt="PKK">
                </div>
                <div class="card-body-red">
                    <h3>PROGRAM KESEJAHTERAAN KELUARGA</h3>
                    <p>Pemberdayaan keluarga untuk meningkatkan kesejahteraan masyarakat desa.</p>
                </div>
            </a>

            <a href="{{ route('posyandu.index') }}" class="card-item">
                <div class="card-tag">POSYANDU</div>
                <div class="card-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1555252333-9f8e92e65df9?w=800" alt="Posyandu">
                </div>
                <div class="card-body-red">
                    <h3>LAYANAN KESEHATAN IBU DAN ANAK</h3>
                    <p>Penimbangan balita, imunisasi, dan pemeriksaan ibu secara rutin.</p>
                </div>
            </a>
        </div>

    </div>
</div>
@endsection