@extends('layouts.app')

@section('content')

<style>
    .evaluasi-section {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        padding: 40px 80px;
        gap: 20px;
        animation: fadeInRight 0.8s ease-out;
    }

    .evaluasi-icon {
        width: 65px;
        height: 65px;
        background: #E72128;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(231, 33, 40, 0.3);
    }

    .evaluasi-title {
        font-size: 35px;
        font-weight: 700;
        letter-spacing: 1px;
        color: #333;
        font-family: 'Poppins', sans-serif;
    }

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

    .kategori-icon-section {
        margin-top: 120px;
        display: flex;
        justify-content: center;
        gap: 80px;
        text-align: center;
    }

    .kategori-icon-item {
        display: flex;
        flex-direction: column;
        align-items: center;  
        justify-content: center;
        text-decoration: none;
        color: #000;
        width: 160px;
        transition: all 0.3s ease;
    }

    .icon-circle {
        width: 161px;
        height: 161px;
        background: #E72128;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        transition: 0.2s;
        overflow: hidden;
    }

    .icon-circle i {
        font-size: 70px;
        color: white;
        line-height: 1;
        margin: 0;
        padding: 0;
        display: block;
    }

    .kategori-icon-item:hover {
        transform: translateY(-15px); 
    }

    .kategori-icon-item:hover .icon-circle {
        background: #c20d12;
        box-shadow: 0 15px 30px rgba(231, 33, 40, 0.4); 
    }

    .kategori-icon-item:active {
        transform: scale(0.95);
        transition: 0.1s;
    }

    .kategori-icon-item span {
        font-size: 28px;
        font-weight: 700;
        text-align: center;
        line-height: 1.3;
        height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 140px;
        font-family: 'Poppins', sans-serif;
        text-shadow: 0 1px 3px rgba(0,0,0,0.15);
        transform: translateZ(0);
    }

    .kategori-icon-item:active {
        transform: scale(0.9);
    }
</style>

<div class="evaluasi-section">
    <div class="evaluasi-icon">
        <i class="bi bi-clipboard-data text-white fs-3"></i>
    </div>
    <div class="evaluasi-title">EVALUASI</div>
</div>

<div class="hero-wrapper">
    <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef" class="hero-img">
    <div class="hero-accent"></div>
</div>

<div class="kategori-icon-section">
    <a href="{{ route('evaluasi.infrastruktur') }}" class="kategori-icon-item">
        <div class="icon-circle">
            <i class="bi bi-bar-chart"></i>
        </div>
        <span>PEMBANGUNAN<br>INFRASTRUKTUR</span>
    </a>

    <a href="{{ route('evaluasi.sarana') }}" class="kategori-icon-item">
        <div class="icon-circle">
            <i class="bi bi-building"></i>
        </div>
        <span>SARANA DAN<br>PRASARANA</span>
    </a>

    <a href="{{ route('evaluasi.ekonomi') }}" class="kategori-icon-item">
        <div class="icon-circle">
            <i class="bi bi-cash-coin"></i>
        </div>
        <span>EKONOMI</span>
    </a>

    <a href="{{ route('evaluasi.sosial') }}" class="kategori-icon-item">
        <div class="icon-circle">
            <i class="bi bi-people"></i>
        </div>
        <span>SOSIAL</span>
    </a>
</div>

@endsection