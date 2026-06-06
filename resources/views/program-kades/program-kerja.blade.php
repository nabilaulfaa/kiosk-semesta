@extends('layouts.app')

@section('title', 'Program Kerja - Kelurahan Jatimulyo')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/kiosk-semesta.css') }}">
@endpush

@section('content')

<div class="modul-header">
    <div class="modul-icon"><i class="bi bi-award"></i></div>
    <a href="{{ route('program.kades') }}" class="modul-title modul-title-link">PROGRAM KADES</a>
</div>

<div class="px-3">

    <div class="section-title" style="font-size: clamp(18px, 2vw, 32px); margin: 2vh 0 1.5vh;">Program Kerja</div>

    <div class="progress-card">
        <span class="pc-update" style="font-size: clamp(11px, 1vw, 16px);">Update {{ $data['progress']['update'] }}</span>
        <span class="pc-top-label" style="font-size: clamp(14px, 1.4vw, 22px); font-weight: 700;">Progress Kerja</span>


        @php
            $berjalan = $data['progress']['berjalan'];
            $selesai  = $data['progress']['selesai'];
            $tertunda = $data['progress']['tertunda'];
            $total    = $berjalan + $selesai + $tertunda;
            $total    = $total > 0 ? $total : 1;
            $circum   = 2 * pi() * 26;
            $segBerjalan = ($berjalan / $total) * $circum;
            $segSelesai  = ($selesai  / $total) * $circum;
            $segTertunda = ($tertunda / $total) * $circum;
        @endphp

        <div class="pc-inner">
            <div class="donut-wrap" style="width: clamp(80px, 9vw, 140px); height: clamp(80px, 9vw, 140px);">
                <svg width="100%" height="100%" viewBox="0 0 80 80">
                    <circle cx="40" cy="40" r="26" fill="none" stroke="#eee" stroke-width="14"/>
                    <circle cx="40" cy="40" r="26" fill="none" stroke="#00923F" stroke-width="14"
                        stroke-dasharray="{{ round($segBerjalan, 1) }} {{ round($circum - $segBerjalan, 1) }}"
                        stroke-dashoffset="0"/>
                    <circle cx="40" cy="40" r="26" fill="none" stroke="#077DC1" stroke-width="14"
                        stroke-dasharray="{{ round($segSelesai, 1) }} {{ round($circum - $segSelesai, 1) }}"
                        stroke-dashoffset="-{{ round($segBerjalan, 1) }}"/>
                    <circle cx="40" cy="40" r="26" fill="none" stroke="#E72128" stroke-width="14"
                        stroke-dasharray="{{ round($segTertunda, 1) }} {{ round($circum - $segTertunda, 1) }}"
                        stroke-dashoffset="-{{ round($segBerjalan + $segSelesai, 1) }}"/>
                </svg>
                <div class="donut-center" style="font-size: clamp(14px, 1.6vw, 26px);">{{ $data['progress']['persen'] }}%</div>
            </div>
            <div class="pc-legend">
                <div class="legend-bar bar-berjalan" style="font-size: clamp(12px, 1.2vw, 20px); padding: clamp(8px, 1.2vh, 18px) 0;">Berjalan {{ $berjalan }}</div>
                <div class="legend-bar bar-selesai"  style="font-size: clamp(12px, 1.2vw, 20px); padding: clamp(8px, 1.2vh, 18px) 0;">Selesai {{ $selesai }}</div>
                <div class="legend-bar bar-tertunda" style="font-size: clamp(12px, 1.2vw, 20px); padding: clamp(8px, 1.2vh, 18px) 0;">Tertunda {{ $tertunda }}</div>
            </div>
        </div>

        <button class="pc-detail-link" onclick="openModal('modalDetail')"
            style="font-size: clamp(13px, 1.3vw, 20px); margin-top: 1.5vh;">
            Lihat Detail Program Kerja
        </button>
    </div>

    <div class="section-title" style="font-size: clamp(18px, 2vw, 32px); margin: 2vh 0 1.5vh;">Program Berjalan</div>


    <div class="program-list">
        @foreach(collect($data['semua_program'])->where('status', 'berjalan') as $p)
        <div class="program-card" style="min-height: clamp(60px, 8vh, 110px);">
            <span class="badge-program berjalan" style="font-size: clamp(11px, 1vw, 16px);">Berjalan</span>
            <div class="pc-icon" style="width: clamp(55px, 6vw, 90px);">
                <img src="{{ asset('images/proker.png') }}" alt="proker" style="width: clamp(30px, 3.5vw, 55px); height: clamp(30px, 3.5vw, 55px);">
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
        @endforeach
    </div>

    <div class="row g-2 mt-1 mb-3">
    <div class="col-6">
        <button class="btn-prog w-100" style="font-size: clamp(14px, 1.4vw, 22px); padding: clamp(12px, 1.6vh, 24px);"
            onclick="window.location.href='{{ route('program-baru') }}'">
            Program Baru
        </button>
    </div>
    <div class="col-6">
        <button class="btn-prog w-100" style="font-size: clamp(14px, 1.4vw, 22px); padding: clamp(12px, 1.6vh, 24px);"
            onclick="window.location.href='{{ route('program-selesai') }}'">
            Program Selesai
        </button>
        </div>
    </div>

</div>

@endsection

@section('modal_content')

{{-- Modal Detail Program --}}
<div class="modal-overlay" id="modalDetail">
    <div class="modal-box modal-box-fullscreen">
        <div class="modal-header-kiosk">
            <h2>Detail Program Kerja</h2>
            <button class="btn-close-modal" onclick="closeModal('modalDetail')">✕</button>
        </div>
        <div class="modal-body-kiosk" style="padding: clamp(20px, 3vh, 40px) clamp(24px, 4vw, 60px);">
            <ol style="margin:0; padding-left: clamp(20px, 2.5vw, 40px); display:flex; flex-direction:column; gap: clamp(10px, 1.5vh, 20px);">
                @foreach($data['semua_program'] as $p)
                <li style="font-size: clamp(16px, 1.6vw, 26px); font-weight: 600; color: #111; line-height: 1.5;">
                    {{ $p['nama'] }}
                </li>
                @endforeach
            </ol>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script src="{{ asset('js/kiosk-semesta.js') }}"></script>
@endpush