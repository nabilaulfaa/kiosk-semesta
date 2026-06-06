@extends('layouts.app')

@section('content')

<div class="modul-header">
    <div class="modul-icon"><i class="bi bi-search"></i></div>
    <div class="modul-title">EVALUASI</div>
</div>

<div class="hero-wrapper">
    <div class="hero-accent"></div>
    <img src="{{ asset('images/evaluasi.png') }}" class="hero-img" alt="Evaluasi">
</div>

<div style="
    margin-top: 8vh;
    display: flex;
    justify-content: center;
    gap: 6vw;
    padding: 0 5vw 4vh;
    flex-wrap: wrap;
">
    @php
    $kategori = [
        ['route' => 'evaluasi.infrastruktur', 'icon' => 'bi-bar-chart',  'label' => 'PEMBANGUNAN INFRASTRUKTUR'],
        ['route' => 'evaluasi.sarana',        'icon' => 'bi-building',   'label' => 'SARANA DAN PRASARANA'],    
    ];
    @endphp

    @foreach($kategori as $k)
    <a href="{{ route($k['route']) }}" style="
        text-decoration: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1.5vh;
        width: clamp(120px, 15vw, 200px);
    ">
        <div class="icon-circle">
            <i class="bi {{ $k['icon'] }}"></i>
        </div>
        <div style="
            color: #333;
            font-size: clamp(13px, 1.4vw, 24px);
            font-weight: 800;
            text-align: center;
            text-transform: uppercase;
            line-height: 1.3;
        ">{{ $k['label'] }}</div>
    </a>
    @endforeach
</div>

@endsection