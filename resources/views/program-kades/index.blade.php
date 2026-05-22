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

<div class="px-3 mt-2">
    <p class="mb-2" style="font-weight:800; font-size:13px;">Profil Kepala Desa</p>

    <div class="d-flex gap-3">
        <div class="profil-foto flex-shrink-0">
            @if($data['profil']['foto'])
                <img src="{{ $data['profil']['foto'] }}" alt="Foto Kades">
            @else
                <img src="{{ asset('images/kades.png') }}" alt="Foto Kades">
            @endif
        </div>
        <div class="flex-grow-1">
            <table class="profil-tabel">
                <tr><td class="td-key">Nama</td><td class="td-val">{{ $data['profil']['nama'] }}</td></tr>
                <tr><td class="td-key">Lahir</td><td class="td-val">{{ $data['profil']['lahir'] }}</td></tr>
                <tr><td class="td-key">Agama</td><td class="td-val">{{ $data['profil']['agama'] }}</td></tr>
                <tr><td class="td-key">Pendidikan</td><td class="td-val">{{ $data['profil']['pendidikan'] }}</td></tr>
            </table>
        </div>
    </div>

    <div class="acc-item">
        <button class="acc-header" onclick="toggleAcc(this)">Periode Menjabat</button>
        <div class="acc-body">{{ $data['profil']['periode'] }}</div>
    </div>

    <div class="acc-item">
        <button class="acc-header" onclick="toggleAcc(this)">Visi</button>
        <div class="acc-body">{{ $data['visi'] }}</div>
    </div>

    <div class="acc-item">
        <button class="acc-header" onclick="toggleAcc(this)">Misi</button>
        <div class="acc-body">
            @foreach($data['misi'] as $m)
                - {{ $m }}<br>
            @endforeach
        </div>
    </div>

    <div class="row g-2 mt-2 mb-3">
        <div class="col-6">
            {{-- Ganti data-bs-toggle → openModal --}}
            <button class="btn-kades" onclick="openModal('modalRiwayat')">
                Riwayat Kerja
            </button>
        </div>
        <div class="col-6">
            <button class="btn-kades" onclick="window.location='{{ route('program-kerja') }}'">
                Program Kerja
            </button>
        </div>
    </div>
</div>

@endsection

@section('modal_content')

{{-- Modal Riwayat Kerja --}}
<div class="modal-overlay" id="modalRiwayat">
    <div class="modal-box">
        <div class="modal-header-kiosk">
            <h2>Riwayat Kerja</h2>
            <button class="btn-close-modal" onclick="closeModal('modalRiwayat')">✕</button>
        </div>
        <div class="modal-body-kiosk">
            @foreach($data['riwayat_kerja'] as $rk)
            <div class="riwayat-card">
                <div class="rk-row"><span class="rk-key">Jabatan</span><span class="rk-sep">:</span><span class="rk-val">{{ $rk['jabatan'] }}</span></div>
                <div class="rk-row"><span class="rk-key">Instansi</span><span class="rk-sep">:</span><span class="rk-val">{{ $rk['instansi'] }}</span></div>
                <div class="rk-row"><span class="rk-key">Tahun Mulai</span><span class="rk-sep">:</span><span class="rk-val">{{ $rk['tahun_mulai'] }}</span></div>
                <div class="rk-row"><span class="rk-key">Tahun Selesai</span><span class="rk-sep">:</span><span class="rk-val">{{ $rk['tahun_selesai'] }}</span></div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script src="{{ asset('js/kiosk-semesta.js') }}"></script>
@endpush