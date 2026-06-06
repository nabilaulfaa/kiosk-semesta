@extends('layouts.app')

@section('title', 'Program Selesai - Kelurahan Jatimulyo')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/kiosk-semesta.css') }}">
@endpush

@section('content')

<div class="modul-header">
    <div class="modul-icon"><i class="bi bi-award"></i></div>
    <a href="{{ route('program.kades') }}" class="modul-title modul-title-link">PROGRAM KADES</a>
</div>

<div class="px-3">

    <div class="section-title" style="font-size: clamp(18px, 2vw, 32px); margin: 2vh 0 1.5vh;">Program Selesai</div>

    <div class="program-list">
        @forelse($programs as $p)
        <div class="program-card" style="min-height: clamp(60px, 8vh, 110px);">
            <span class="badge-program selesai" style="font-size: clamp(11px, 1vw, 16px);">Selesai</span>
            <div class="pc-icon" style="width: clamp(55px, 6vw, 90px);">
                <img src="{{ asset('images/proker.png') }}" alt="proker"
                    style="width: clamp(30px, 3.5vw, 55px); height: clamp(30px, 3.5vw, 55px);">
            </div>
            <div class="pc-body" style="padding: clamp(20px, 2.5vh, 36px) clamp(10px, 1.2vw, 18px) clamp(10px, 1.2vh, 16px);">
                <div class="pc-info">
                    <div class="pc-nama" style="font-size: clamp(14px, 1.5vw, 24px);">{{ $p['nama'] }}</div>
                    <div class="pc-tahun" style="font-size: clamp(12px, 1.2vw, 18px);">{{ $p['tahun'] }}</div>
                </div>
                <div class="pc-right d-flex flex-column align-items-end gap-1">
                    <span class="pc-persen" style="font-size: clamp(20px, 2.5vw, 40px);">{{ $p['persen'] }} %</span>
                    @if($p['laporan'])
                    <button class="pc-detail-link" onclick="openModal('laporan{{ $p['id'] }}')"
                        style="font-size: clamp(12px, 1.2vw, 18px);">
                        Detail Laporan
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <p class="text-center text-muted" style="font-size: clamp(14px, 1.4vw, 22px); padding: 3vh 0;">
            Tidak ada program selesai.
        </p>
        @endforelse
    </div>

</div>

@endsection

@section('modal_content')

@foreach($programs as $p)
    @if($p['laporan'])
    <div class="modal-overlay" id="laporan{{ $p['id'] }}">
        <div class="modal-box modal-box-fullscreen">
            <div class="modal-header-kiosk">
                <h2 style="font-size: clamp(20px, 2.2vw, 36px);">Laporan Program</h2>
                <button class="btn-close-modal" onclick="closeModal('laporan{{ $p['id'] }}')">✕</button>
            </div>
            <div class="modal-body-kiosk" style="padding: clamp(20px, 3vh, 40px) clamp(24px, 4vw, 60px);">

                <div style="font-size: clamp(16px, 1.8vw, 28px); font-weight: 800; color: var(--merah-tua); margin-bottom: 2vh;">
                    {{ $p['nama'] }}
                </div>

                @foreach([
                    'Tanggal Laporan' => $p['laporan']['tanggal'],
                    'Hasil'           => $p['laporan']['hasil'],
                    'Kendala'         => $p['laporan']['kendala'],
                    'Rekomendasi'     => $p['laporan']['rekomendasi'],
                ] as $label => $nilai)
                <div class="rk-row" style="padding: clamp(10px, 1.4vh, 20px) clamp(14px, 1.8vw, 26px); margin-bottom: 0.5vh;">
                    <span class="rk-key" style="font-size: clamp(13px, 1.3vw, 20px); flex: 0 0 clamp(140px, 16vw, 240px);">{{ $label }}</span>
                    <span class="rk-sep" style="font-size: clamp(13px, 1.3vw, 20px);">:</span>
                    <span class="rk-val" style="font-size: clamp(13px, 1.3vw, 20px);">{{ $nilai }}</span>
                </div>
                @endforeach

                <div style="font-size: clamp(15px, 1.5vw, 24px); font-weight: 800; color: #111; margin: 2vh 0 1vh; padding-left: clamp(14px, 1.8vw, 26px);">
                    Deskripsi Laporan
                </div>
                <div style="font-size: clamp(14px, 1.4vw, 22px); color: #333; line-height: 1.7; padding: clamp(14px, 1.8vh, 26px) clamp(14px, 1.8vw, 26px); background: var(--abu-card); border-radius: 12px;">
                    {{ $p['laporan']['deskripsi'] }}
                </div>

            </div>
        </div>
    </div>
    @endif
@endforeach

@endsection

@push('scripts')
    <script src="{{ asset('js/kiosk-semesta.js') }}"></script>
@endpush