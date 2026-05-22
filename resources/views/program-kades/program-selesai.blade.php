@extends('layouts.app')

@section('title', 'Program Selesai - Kelurahan Jatimulyo')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/kiosk-semesta.css') }}">
@endpush

@section('content')

<div class="modul-header">
    <div class="modul-icon"><i class="bi bi-award"></i></div>
    <div class="modul-title">PROGRAM KADES</div>
</div>

<div class="px-3">

    <p class="fw-bold mb-2 mt-1" style="font-size:14px;">Program Selesai</p>

    <div class="d-flex flex-column gap-2 mb-3">
        @forelse($programs as $p)
        <div class="program-card">
            <span class="badge-program selesai">Selesai</span>
            <div class="pc-icon"><img src="{{ asset('images/proker.png') }}" alt="proker"></div>
            <div class="pc-body">
                <div class="pc-info">
                    <div class="pc-nama">{{ $p['nama'] }}</div>
                    <div class="pc-tahun">{{ $p['tahun'] }}</div>
                </div>
                <div class="flex-shrink-0 d-flex flex-column align-items-end gap-1">
                    <span class="pc-persen">{{ $p['persen'] }} %</span>
                    @if($p['laporan'])
                    {{-- Ganti data-bs-toggle → openModal dengan id dinamis --}}
                    <button class="pc-detail-link" onclick="openModal('laporan{{ $p['id'] }}')">
                        Detail Laporan
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <p class="text-center text-muted" style="font-size:13px;">Tidak ada program selesai.</p>
        @endforelse
    </div>


</div>

@endsection

@section('bottom_navigation')
    <a href="javascript:history.back()" class="btn-nav">
        <i class="bi bi-arrow-left"></i> KEMBALI
    </a>
@endsection

@section('modal_content')

{{-- Modal Laporan dinamis per program --}}
@foreach($programs as $p)
    @if($p['laporan'])
    <div class="modal-overlay" id="laporan{{ $p['id'] }}">
        <div class="modal-box">
            <div class="modal-header-kiosk">
                <h2>Laporan Program</h2>
                <button class="btn-close-modal" onclick="closeModal('laporan{{ $p['id'] }}')">✕</button>
            </div>
            <div class="modal-body-kiosk">
                <div class="lap-row"><span class="lap-key">Tanggal Laporan</span><span class="lap-sep">:</span><span class="lap-val">{{ $p['laporan']['tanggal'] }}</span></div>
                <div class="lap-row"><span class="lap-key">Hasil</span><span class="lap-sep">:</span><span class="lap-val">{{ $p['laporan']['hasil'] }}</span></div>
                <div class="lap-row"><span class="lap-key">Kendala</span><span class="lap-sep">:</span><span class="lap-val">{{ $p['laporan']['kendala'] }}</span></div>
                <div class="lap-row"><span class="lap-key">Rekomendasi</span><span class="lap-sep">:</span><span class="lap-val">{{ $p['laporan']['rekomendasi'] }}</span></div>
                <div class="lap-desc-title">Deskripsi Laporan</div>
                <div class="lap-desc">{{ $p['laporan']['deskripsi'] }}</div>
            </div>
        </div>
    </div>
    @endif
@endforeach

@endsection