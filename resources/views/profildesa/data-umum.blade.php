@extends('layouts.app')

@section('title', 'Data Umum')

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

<div class="page-title" style="padding-left: 15px;">Data Umum</div>


<div class="top-info">
    <div><b>Kode Desa :</b> {{ $kode_desa ?? '-' }}</div>
    @include('layouts.partials.year-picker', ['tahun' => $tahun])
</div>

<div class="table-wrap">
    <div class="table-header">
        <div>Nama Dusun</div>
        <div>Jumlah KK</div>
        <div>Jumlah RT</div>
        <div>Jumlah RW</div>
    </div>
    @foreach($data as $item)
    <div class="table-row">
        <div>{{ $item['nama_dusun'] }}</div>
        <div>{{ $item['jumlah_kk'] }}</div>
        <div>{{ $item['jumlah_rt'] }}</div>
        <div>{{ $item['jumlah_rw'] }}</div>
    </div>
    @endforeach
</div>

@endsection

@push('scripts')
<script>
    window.__yearRoute = '{{ route('data.umum') }}';
</script>
<script src="{{ asset('js/kiosk-semesta.js') }}"></script>
@endpush