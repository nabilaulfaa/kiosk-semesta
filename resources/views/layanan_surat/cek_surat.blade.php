@extends('layouts.app')

@section('content')

@php
    $suratItem  = collect($data['jenis_surat'])->firstWhere('nama', $jenis);
    $blankoPath = $suratItem ? asset('storage/' . $suratItem['blanko']) : '';
@endphp

{{-- Header --}}
<div class="modul-header" style="flex-direction: row-reverse; justify-content: flex-start;">
    <a href="{{ route('layanan.surat') }}" class="modul-title modul-title-link">LAYANAN SURAT</a>
    <div class="modul-icon"><i class="bi bi-envelope-paper"></i></div>
</div>

<div class="container-surat">

    <div class="judul-surat" id="judulSurat">{{ $jenis ?: 'Layanan Surat' }}</div>

    {{-- Persyaratan --}}
    @if($suratItem)
    <div class="persyaratan-box">
        <div class="persyaratan-title">Persyaratan :</div>
        @foreach($suratItem['persyaratan'] as $syarat)
        <div class="persyaratan-item">{{ $syarat }}</div>
        @endforeach
    </div>
    @endif

    {{-- Form Cek Status --}}
    <label class="form-label-surat">Masukkan Kode Pengajuan Surat Anda</label>
    <input type="text" id="inputCek" class="input-kiosk" placeholder="">
    <div style="font-size:clamp(11px,1vw,15px);color:#888;margin-bottom:2vh;margin-top:-1.5vh;">
        Kode pengajuan diberikan saat pertama kali mengajukan surat
    </div>

    <button id="btnCek" class="btn-cek" disabled>
        Cek Status
    </button>

    {{-- Preview Blanko --}}
    <div class="label-blanko">Blanko {{ $jenis }}</div>
    <div class="preview-blanko">
        @if($blankoPath)
            <iframe src="{{ $blankoPath }}" title="Preview Blanko Surat"></iframe>
            <div class="preview-label">
                <i class="bi bi-file-earmark-pdf"></i> {{ $jenis }}
            </div>
        @else
            <div style="color:#999;font-style:italic;font-size:clamp(13px,1.3vw,18px);">
                Blanko surat belum tersedia
            </div>
        @endif
    </div>

    <div class="btn-row">
        <button class="btn-merah" id="btnLihat">
            <i class="bi bi-eye"></i> Lihat
        </button>
        <button class="btn-merah" id="btnUnduh">
            <i class="bi bi-printer"></i> Cetak
        </button>
    </div>

</div>

@endsection

@section('modal_content')
<div class="popup-status" id="popupStatus">
    <div class="popup-box">

        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5vh;">
            <h3>Status Surat Anda</h3>
            <span id="popupBadge" style="background:#999;color:white;padding:6px 16px;border-radius:20px;font-size:clamp(12px,1.1vw,16px);font-weight:700;">-</span>
        </div>

        <hr style="border:0;border-top:1px solid #eee;margin-bottom:1.5vh;">

        <div class="popup-info">
            <div><b>Nama :</b> <span id="popupNama">-</span></div>
            <div><b>Jenis Surat :</b> <span id="popupJenis">-</span></div>
            <div><b>Update terakhir :</b> <span id="popupUpdate">-</span></div>
            <div style="color:var(--merah);margin-top:5px;">
                <i><b>Estimasi :</b> <span id="popupEstimasi">-</span></i>
            </div>
        </div>

        {{-- Progress tracker --}}
        <div class="progress-wrapper">
            <div class="progress-line"></div>
            <div class="progress-line-fill" id="progressFill" style="width:0%"></div>

            <div class="step-item">
                <div class="step-icon">📋</div>
                <div class="step-label">Pengajuan</div>
            </div>
            <div class="step-item">
                <div class="step-icon">⚙</div>
                <div class="step-label">Diproses</div>
            </div>
            <div class="step-item">
                <div class="step-icon">✓</div>
                <div class="step-label">Selesai</div>
            </div>
        </div>

        <button id="btnCetak" onclick="cetakSurat()" class="btn-merah"
                style="display:none;width:100%;margin-bottom:1.2vh;background:#16a34a;">
            <i class="bi bi-printer"></i> Cetak Surat
        </button>

        <button onclick="closePopupSurat()" class="btn-merah" style="width:100%;">
            Tutup
        </button>

    </div>
</div>
@endsection

@push('scripts')
<script>
    window.blankoUrl = "{{ $blankoPath }}";
</script>
@endpush