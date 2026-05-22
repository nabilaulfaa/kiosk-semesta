@extends('layouts.app')

@section('title', 'Program Kerja - Kelurahan Jatimulyo')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/kiosk-semesta.css') }}">
@endpush

@section('content')

<div class="modul-header">
    <div class="modul-icon"><i class="bi bi-award"></i></div>
    <div class="modul-title">PROGRAM KADES</div>
</div>

<div class="px-3">

    <div class="section-title">Program Kerja</div>

    <div class="progress-card">
        <span class="pc-update">Update {{ $data['progress']['update'] }}</span>
        <span class="pc-top-label">Progress Kerja</span>

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
            <div class="donut-wrap">
                <svg width="80" height="80" viewBox="0 0 80 80">
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
                <div class="donut-center">{{ $data['progress']['persen'] }}%</div>
            </div>
            <div class="pc-legend">
                <div class="legend-bar bar-berjalan">Berjalan {{ $berjalan }}</div>
                <div class="legend-bar bar-selesai">Selesai {{ $selesai }}</div>
                <div class="legend-bar bar-tertunda">Tertunda {{ $tertunda }}</div>
            </div>
        </div>

        {{-- Ganti data-bs-toggle → openModal --}}
        <button class="pc-detail-link" onclick="openModal('modalDetail')">
            Lihat Detail Program Kerja
        </button>
    </div>

    <div class="section-title">Program Berjalan</div>

    <div class="program-list">
        @foreach(collect($data['semua_program'])->where('status', 'berjalan') as $p)
        <div class="program-card">
            <span class="badge-program berjalan">Berjalan</span>
            <div class="pc-icon"><img src="{{ asset('images/proker.png') }}" alt="proker"></div>
            <div class="pc-body">
                <div class="pc-info">
                    <div class="pc-nama">{{ $p['nama'] }}</div>
                    <div class="pc-tahun">{{ $p['tahun'] }}</div>
                </div>
                <div class="pc-right"><span class="pc-persen">{{ $p['persen'] }} %</span></div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row g-2 mt-1 mb-3">
        <div class="col-6">
            <button class="btn-prog w-100" onclick="window.location.href='{{ route('program-baru') }}'">
                Program Baru
            </button>
        </div>
        <div class="col-6">
            <button class="btn-prog w-100" onclick="window.location.href='{{ route('program-selesai') }}'">
                Program Selesai
            </button>
        </div>
    </div>

</div>

@endsection

@section('bottom_navigation')
    <a href="javascript:history.back()" class="btn-nav">
        <i class="bi bi-arrow-left"></i> KEMBALI
    </a>
@endsection

@section('modal_content')

{{-- Modal Detail Program --}}
<div class="modal-overlay" id="modalDetail">
    <div class="modal-box">
        <div class="modal-header-kiosk">
            <h2>Detail Program Kerja</h2>
            <button class="btn-close-modal" onclick="closeModal('modalDetail')">✕</button>
        </div>
        <div class="modal-body-kiosk">
            <ol style="margin:0; padding-left:20px; display:flex; flex-direction:column; gap:10px;">
                @foreach($data['semua_program'] as $p)
                <li style="font-size:clamp(12px,1.2vw,18px); font-weight:600; color:#111; line-height:1.4;">
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