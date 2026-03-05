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
    font-weight: 780;
    letter-spacing: 1px;
        color: #333;
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

.kategori-section {
    margin-top: 100px;
    width: 1000px;
    position: relative;
    margin-left: auto;
    margin-right: auto;
    display: grid;
    grid-template-columns: repeat(4, 235px);
    gap: 20px;
    z-index: 20;
    padding-bottom: 50px;
}

.kategori-link {
        text-decoration: none !important;
        display: block;
        transition: transform 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

.kategori-card {
    width: 235px;
    height: 450px;
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
    border: 1px solid rgba(0,0,0,0.05);
    position: relative;   
}

.kategori-link:active {
    transform: scale(0.92);
}

.kategori-card::after {
    position: absolute;
    bottom: 15px;
    font-size: 12px;
    font-weight: bold;
    color: #B51016;
    width: 100%;
    text-align: center;
    opacity: 0.6;
}

.kategori-header {
    width: 235px;
    height: 82px;
    background: #B51016;
    color: white;
    text-align: center;
    padding: 0 10px;
    font-weight: 700;
    font-size: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.kategori-card img {
    width: 235px;
    height: 200px;
    object-fit: cover;
}

.kategori-body {
    padding: 20px 15px;
    font-size: 16px;
    text-align: center;
    line-height: 1.4;
    color: #333;
    flex-grow: 1; 
    display: flex;
    align-items: flex-start;
    justify-content: center;
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

<div class="kategori-section">
    @foreach([
        ['INFRASTRUKTUR','Peningkatan fasilitas umum.','1568605114967-8130f3a36994', 'infrastruktur'],
        ['SARANA & PRASARANA','Pengadaan balai desa & fasilitas.','1577896851231-70ef18881754', 'sarana'],
        ['EKONOMI','Pelatihan & bantuan UMKM.','1500595046743-cd271d694d30', 'ekonomi'],
        ['SOSIAL','Program pemberdayaan masyarakat.','1582213782179-e0d53f98f2ca', 'sosial']
    ] as $item)
    
    {{-- Sekarang $item[3] sudah ada isinya (infrastruktur, sarana, dll) --}}
    <a href="{{ url('/evaluasi-pembangunan/'.$item[3]) }}" class="kategori-link">
        <div class="kategori-card">
            <div class="kategori-header">{{ $item[0] }}</div>
            <img src="https://images.unsplash.com/photo-{{ $item[2] }}">
            <div class="kategori-body">{{ $item[1] }}</div>
        </div>
    </a>
    @endforeach
</div>

@endsection