@extends('layouts.app')

@section('title', 'Data Geografis')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/kiosk-semesta.css') }}">
@endpush

@section('content')

<div class="modul-header">
    <div class="d-flex align-items-center gap-2">
        <div class="modul-icon"><i class="bi bi-houses"></i></div>
        <a href="{{ route('profil.desa') }}" class="modul-title modul-title-link">PROFIL DESA</a>
    </div>
</div>

<div class="page-title" style="padding-left: 15px;">Data Geografis</div>


{{-- Luas Wilayah --}}
<div class="luas-box" style="margin-top: 3vh;">
    <div class="luas-title">Luas Wilayah</div>
    <div class="luas-value">
        {{ $data['luas_wilayah'] ?? 'Data belum tersedia' }}
    </div>
</div>

{{-- Batas Wilayah --}}
<div class="batas" style="margin-bottom: 2vh;">
    @foreach([
        'Batas Utara'   => $data['batas_wilayah']['utara']   ?? '-',
        'Batas Selatan' => $data['batas_wilayah']['selatan'] ?? '-',
        'Batas Timur'   => $data['batas_wilayah']['timur']   ?? '-',
        'Batas Barat'   => $data['batas_wilayah']['barat']   ?? '-',
    ] as $label => $nilai)
    <div class="batas-row">
        <div class="batas-left">{{ $label }}</div>
        <div class="batas-right">{{ $nilai }}</div>
    </div>
    @endforeach
</div>

@endsection

@push('scripts')
    <script src="{{ asset('js/kiosk-semesta.js') }}"></script>
@endpush