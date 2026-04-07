@extends('layouts.app')

@section('content')
<style>
    .hero-wrapper {
        position: relative;
        width: 100%;
        text-align: center;
        perspective: 1000px;
    }

    .hero-img {
        width: 1081px;
        height: 608px;
        object-fit: cover;
        position: relative;
        z-index: 2;
    }

    .hero-accent {
        width: 1000px;
        height: 424px;
        background: #4B0003;
        position: absolute;
        bottom: -35px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    }

    .menu-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 40px;
        padding: 80px 80px 60px 80px;
        justify-items: center;
        margin-top: 120px;
    }

    .menu-item {
        text-decoration: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
        transition: all 0.3s ease;
    }

    .menu-item:hover {
        transform: translateY(-15px);
    }

    .menu-item:active {
        transform: scale(0.9);
    }

    .menu-item:hover .icon-circle {
        background: #c20d12;
        box-shadow: 0 15px 30px rgba(231, 33, 40, 0.4);
    }

    .icon-circle {
        width: 140px;
        height: 140px;
        background: #E72128;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 20px rgba(181, 16, 22, 0.2);
        transition: 0.2s ease;
    }

    .icon-circle img {
        width: 70px;
        height: 70px;
        filter: brightness(0) invert(1); /* Membuat icon putih */
    }

    .icon-circle i {
        font-size: 60px;
        color: white;
    }

    .menu-label {
        color: #333;
        font-size: 22px;
        font-weight: 800;
        text-align: center;
        text-transform: uppercase;
        line-height: 1.2;
    }
</style>

<div class="hero-wrapper">
    <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=1920&auto=format&fit=crop" class="hero-img">
    <div class="hero-accent"></div>
</div>

<div class="menu-grid">
    <a href="{{ route('profil.desa') }}" class="menu-item">
        <div class="icon-circle"><i class="bi bi-houses"></i></div>
        <div class="menu-label">Profil Desa</div>
    </a>
    <a href="{{ route('apbdes') }}" class="menu-item">
        <div class="icon-circle"><i class="bi bi-bar-chart-line"></i></div>
        <div class="menu-label">APBDes</div>
    </a>
    <a href="{{ route('bumdes') }}" class="menu-item">
        <div class="icon-circle"><i class="bi bi-buildings"></i></div>
        <div class="menu-label">BUMDes</div>
    </a>
    <a href="{{ route('evaluasi') }}" class="menu-item">
        <div class="icon-circle"><i class="bi bi-search"></i></div>
        <div class="menu-label">Evaluasi</div>
    </a>

    <a href="{{ route('program.kades') }}" class="menu-item">
        <div class="icon-circle"><i class="bi bi-award"></i></div>
        <div class="menu-label">Program Kades</div>
    </a>
    <a href="{{ route('pkk.posyandu') }}" class="menu-item">
        <div class="icon-circle"><i class="bi bi-people"></i></div>
        <div class="menu-label">PKK<br>Posyandu</div>
    </a>
    <a href="{{ route('peta.wilayah') }}" class="menu-item">
        <div class="icon-circle"><i class="bi bi-map"></i></div>
        <div class="menu-label">Peta Wilayah</div>
    </a>
    <a href="{{ route('layanan.surat') }}" class="menu-item">
        <div class="icon-circle"><i class="bi bi-envelope-paper"></i></div>
        <div class="menu-label">Layanan Surat</div>
    </a>
</div>
@endsection