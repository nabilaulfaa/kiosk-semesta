@extends('layouts.app')

@section('content')

{{-- Header --}}
<div class="modul-header" style="flex-direction: row-reverse; justify-content: flex-start;">
    <div class="modul-title">LAYANAN SURAT</div>
    <div class="modul-icon"><i class="bi bi-envelope-paper"></i></div>
</div>

<div class="content-area">
    <div class="left-section-title">
        Persyaratan dan Blanko Surat
    </div>

    {{-- data-base-url dipakai JS untuk build link ke cek_surat --}}
    <div class="surat-list" id="suratList"
         data-base-url="{{ route('cek.surat') }}">
        <div style="color:#999;font-size:clamp(14px,1.4vw,20px);padding:2vh;">
            Memuat data...
        </div>
    </div>
</div>

@endsection