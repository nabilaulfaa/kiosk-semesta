@extends('layouts.app')

@section('title', 'Program Baru - Kelurahan Jatimulyo')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/kiosk-semesta.css') }}">
@endpush

@section('content')

<div class="modul-header">
    <div class="modul-icon"><i class="bi bi-award"></i></div>
    <div class="modul-title">PROGRAM KADES</div>
</div>

<div class="px-3">

    <p class="fw-bold mb-2 mt-1" style="font-size:14px;">Program Baru</p>

    <div class="d-flex flex-column gap-2 mb-3">
        @forelse($programs as $p)
        <div class="program-card">
            {{-- Ganti .badge-status.badge-baru → .badge-program.baru --}}
            <span class="badge-program baru">Baru</span>
            <div class="pc-icon"><img src="{{ asset('images/proker.png') }}" alt="proker"></div>
            <div class="pc-body">
                <div class="pc-info">
                    <div class="pc-nama">{{ $p['nama'] }}</div>
                    <div class="pc-tahun">{{ $p['tahun'] }}</div>
                </div>
                <div class="flex-shrink-0">
                    <span class="pc-persen">{{ $p['persen'] }} %</span>
                </div>
            </div>
        </div>
        @empty
        <p class="text-center text-muted" style="font-size:13px;">Tidak ada program baru.</p>
        @endforelse
    </div>


</div>

@endsection

@section('bottom_navigation')
    <a href="javascript:history.back()" class="btn-nav">
        <i class="bi bi-arrow-left"></i> KEMBALI
    </a>
@endsection