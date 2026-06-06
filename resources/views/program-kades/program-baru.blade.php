@extends('layouts.app')

@section('title', 'Program Baru - Kelurahan Jatimulyo')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/kiosk-semesta.css') }}">
@endpush

@section('content')

<div class="modul-header">
    <div class="modul-icon"><i class="bi bi-award"></i></div>
    <a href="{{ route('program.kades') }}" class="modul-title modul-title-link">PROGRAM KADES</a>
</div>

<div class="px-3">

    <div class="section-title" style="font-size: clamp(18px, 2vw, 32px); margin: 2vh 0 1.5vh;">Program Baru</div>

    <div class="program-list">
        @forelse($programs as $p)
        <div class="program-card" style="min-height: clamp(60px, 8vh, 110px);">
            <span class="badge-program baru" style="font-size: clamp(11px, 1vw, 16px);">Baru</span>
            <div class="pc-icon" style="width: clamp(55px, 6vw, 90px);">
                <img src="{{ asset('images/proker.png') }}" alt="proker"
                    style="width: clamp(30px, 3.5vw, 55px); height: clamp(30px, 3.5vw, 55px);">
            </div>
            <div class="pc-body" style="padding: clamp(20px, 2.5vh, 36px) clamp(10px, 1.2vw, 18px) clamp(10px, 1.2vh, 16px);">
                <div class="pc-info">
                    <div class="pc-nama" style="font-size: clamp(14px, 1.5vw, 24px);">{{ $p['nama'] }}</div>
                    <div class="pc-tahun" style="font-size: clamp(12px, 1.2vw, 18px);">{{ $p['tahun'] }}</div>
                </div>
                <div class="pc-right">
                    <span class="pc-persen" style="font-size: clamp(20px, 2.5vw, 40px);">{{ $p['persen'] }} %</span>
                </div>
            </div>
        </div>
        @empty
        <p class="text-center text-muted" style="font-size: clamp(14px, 1.4vw, 22px); padding: 3vh 0;">
            Tidak ada program baru.
        </p>
        @endforelse
    </div>

</div>

@endsection
