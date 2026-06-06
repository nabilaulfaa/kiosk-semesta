@extends('layouts.app')

@section('title', 'Program Kades - Kelurahan Jatimulyo')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/kiosk-semesta.css') }}">
@endpush

@section('content')

<div class="modul-header">
    <div class="modul-icon"><i class="bi bi-award"></i></div>
    <div class="modul-title">PROGRAM KADES</div>
</div>

<div class="px-3 mt-2 pb-4">
    <p class="section-title" style="font-size: clamp(16px, 1.8vw, 26px); font-weight: 800; margin-bottom: 1.5vh;">
        Profil Kepala Desa
    </p>

    {{-- Foto + Tabel --}}
    <div class="kiosk-card d-flex gap-3 align-items-center mb-3" style="padding: 2vh 2vw;">
        <div class="flex-shrink-0">
            <img 
                src="{{ $data['profil']['foto'] ?? asset('images/kades.png') }}" 
                alt="Foto Kades"
                style="width: clamp(110px, 11vw, 190px); height: clamp(150px, 17vw, 280px); object-fit: cover; border-radius: 15px; border: 3px solid #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.15);"
            >
        </div>
        <div style="flex:1; min-width:0;">
            <table class="profil-tabel">
    <tr>
        <td class="td-key">Nama</td>
        <td class="td-val">{{ $data['profil']['nama'] }}</td>
    </tr>
    <tr>
        <td class="td-key">Lahir</td>
        <td class="td-val">{{ $data['profil']['lahir'] }}</td>
    </tr>
    <tr>
        <td class="td-key">Agama</td>
        <td class="td-val">{{ $data['profil']['agama'] }}</td>
    </tr>
    <tr>
        <td class="td-key">Pendidikan</td>
        <td class="td-val">{{ $data['profil']['pendidikan'] }}</td>
    </tr>
</table>
        </div>
    </div>

    <div class="acc-item">
        <button class="acc-header" onclick="toggleAcc(this)" style="font-size: clamp(14px, 1.4vw, 22px); padding: 1.5vh 2vw;">
            Periode Menjabat
        </button>
        <div class="acc-body" style="font-size: clamp(13px, 1.3vw, 20px); line-height: 1.7;">
            {{ $data['profil']['periode'] }}
        </div>
    </div>

    <div class="acc-item">
        <button class="acc-header" onclick="toggleAcc(this)" style="font-size: clamp(14px, 1.4vw, 22px); padding: 1.5vh 2vw;">
            Visi
        </button>
        <div class="acc-body" style="font-size: clamp(13px, 1.3vw, 20px); line-height: 1.7;">
            {{ $data['visi'] }}
        </div>
    </div>

    <div class="acc-item">
        <button class="acc-header" onclick="toggleAcc(this)" style="font-size: clamp(14px, 1.4vw, 22px); padding: 1.5vh 2vw;">
            Misi
        </button>
        <div class="acc-body" style="font-size: clamp(13px, 1.3vw, 20px); line-height: 1.9;">
            @foreach($data['misi'] as $m)
                - {{ $m }}<br>
            @endforeach
        </div>
    </div>

    {{-- Tombol --}}
    <div class="row g-2 mt-3 mb-3">
        <div class="col-6">
            <button class="btn-kades" onclick="openModal('modalRiwayat')" 
                style="font-size: clamp(14px, 1.4vw, 22px); padding: 1.5vh; border-radius: 12px;">
                Riwayat Kerja
            </button>
        </div>
        <div class="col-6">
            <button class="btn-kades" onclick="window.location='{{ route('program-kerja') }}'"
                style="font-size: clamp(14px, 1.4vw, 22px); padding: 1.5vh; border-radius: 12px;">
                Program Kerja
            </button>
        </div>
    </div>
</div>

@endsection

@section('modal_content')

{{-- Modal Riwayat Kerja --}}
<div class="modal-overlay" id="modalRiwayat">
    <div class="modal-box modal-box-fullscreen">
        <div class="modal-header-kiosk">
            <h2>Riwayat Kerja</h2>
            <button class="btn-close-modal" onclick="closeModal('modalRiwayat')">✕</button>
        </div>
        <div class="modal-body-kiosk">
            @foreach($data['riwayat_kerja'] as $rk)
            <div class="riwayat-card">
                <div class="rk-row">
                    <span class="rk-key">Jabatan</span>
                    <span class="rk-sep">:</span>
                    <span class="rk-val">{{ $rk['jabatan'] }}</span>
                </div>
                <div class="rk-row">
                    <span class="rk-key">Instansi</span>
                    <span class="rk-sep">:</span>
                    <span class="rk-val">{{ $rk['instansi'] }}</span>
                </div>
                <div class="rk-row">
                    <span class="rk-key">Tahun Mulai</span>
                    <span class="rk-sep">:</span>
                    <span class="rk-val">{{ $rk['tahun_mulai'] }}</span>
                </div>
                <div class="rk-row">
                    <span class="rk-key">Tahun Selesai</span>
                    <span class="rk-sep">:</span>
                    <span class="rk-val">{{ $rk['tahun_selesai'] }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script src="{{ asset('js/kiosk-semesta.js') }}"></script>
@endpush