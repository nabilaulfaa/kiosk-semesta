@extends('layouts.app')

@section('content')

<div class="modul-header">
    <div class="modul-icon"><i class="bi bi-people"></i></div>
    <div class="modul-title">PKK POSYANDU</div>
</div>

<div class="hero-wrapper">
    <img src="{{ asset('images/pkk-posyandu.png') }}" class="hero-img" alt="PKK Posyandu">
    <div class="hero-accent"></div>
</div>

<div style="margin-top:8vh;display:flex;justify-content:center;gap:8vw;padding:0 5vw 4vh;">
    <a href="{{ route('pkk.index') }}" style="text-decoration:none;display:flex;flex-direction:column;align-items:center;gap:1.5vh;">
        <div class="icon-circle">
            <i class="bi bi-people-fill"></i>
        </div>
        <div style="color:#333;font-size:clamp(14px,1.6vw,28px);font-weight:800;text-align:center;text-transform:uppercase;line-height:1.3;">
            PKK
        </div>
    </a>

    <a href="{{ route('posyandu.index') }}" style="text-decoration:none;display:flex;flex-direction:column;align-items:center;gap:1.5vh;">
        <div class="icon-circle">
            <i class="bi bi-heart-pulse-fill"></i>
        </div>
        <div style="color:#333;font-size:clamp(14px,1.6vw,28px);font-weight:800;text-align:center;text-transform:uppercase;line-height:1.3;">
            POSYANDU
        </div>
    </a>
</div>

@endsection