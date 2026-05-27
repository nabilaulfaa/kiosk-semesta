@extends('layouts.app')

@section('hide_bottom_nav', '1')

@section('content')
<div class="hero-wrapper">
    <div class="hero-accent"></div>
    <img src="{{ asset('images/hero-desa.jpg') }}" class="hero-img" alt="Desa Jatimulyo">
</div>

<div style="
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 3vw;
    padding: 10vh 5vw 4vh;
    margin-top: 8vh;
    justify-items: center;
">
    @php
    $menus = [
        ['route' => 'profil.desa',    'icon' => 'bi-houses',          'label' => 'Profil Desa'],
        ['route' => 'apbdes',         'icon' => 'bi-bar-chart-line',   'label' => 'APBDes'],
        ['route' => 'bumdes',         'icon' => 'bi-buildings',        'label' => 'BUMDes'],
        ['route' => 'evaluasi',       'icon' => 'bi-search',           'label' => 'Evaluasi'],
        ['route' => 'program.kades',  'icon' => 'bi-award',            'label' => 'Program Kades'],
        ['route' => 'pkk.posyandu',   'icon' => 'bi-people',           'label' => 'PKK Posyandu'],
        ['route' => 'peta.wilayah',   'icon' => 'bi-map',              'label' => 'Peta Wilayah'],
        ['route' => 'layanan.surat',  'icon' => 'bi-envelope-paper',   'label' => 'Layanan Surat'],
    ];
    @endphp

    @foreach($menus as $menu)
    <a href="{{ route($menu['route']) }}" style="
        text-decoration: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1.5vh;
    ">
        <div class="icon-circle">
            <i class="bi {{ $menu['icon'] }}"></i>
        </div>
        <div style="
            color: #333;
            font-size: clamp(14px, 1.6vw, 28px);
            font-weight: 800;
            text-align: center;
            text-transform: uppercase;
            line-height: 1.3;
        ">{{ $menu['label'] }}</div>
    </a>
    @endforeach
</div>
@endsection