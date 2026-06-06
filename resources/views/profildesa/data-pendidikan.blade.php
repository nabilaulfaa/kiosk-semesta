@extends('layouts.app')

@section('title', 'Data Pendidikan')

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

<div class="page-title" style="padding-left: 15px;">Data Pendidikan</div>

<div class="pend-wrap">

    <div class="stat-grid">
        <div class="sd-card">
        <div class="sd-label">SD/Sederajat</div>
        <div class="sd-value">{{ $data['statistik']['sd'] ?? '-' }} Gedung</div>
    </div>
    <div class="sd-card">
        <div class="sd-label">SMP/Sederajat</div>
        <div class="sd-value">{{ $data['statistik']['smp'] ?? '-' }} Gedung</div>
    </div>
    <div class="sd-card">
        <div class="sd-label">SMA/Sederajat</div>
        <div class="sd-value">{{ $data['statistik']['sma'] ?? '-' }} Gedung</div>
    </div>
    <div class="sd-card">
        <div class="sd-label">Perguruan Tinggi</div>
        <div class="sd-value">{{ $data['statistik']['pt'] ?? '-' }} Gedung</div>
    </div>
    </div>

    <div class="top-info">
        <div></div>
        @include('layouts.partials.year-picker', ['tahun' => $tahun])
    </div>

<div class="table-wrap">
    <div class="table-header">
        <div>Tingkat Pendidikan</div>
        <div>Siswa Masuk</div>
        <div>Siswa Lulus</div>
        <div>Buta Aksara</div>
    </div>
    @if($data && isset($data['tabel']))
        @foreach($data['tabel'] as $row)
        <div class="table-row">
            <div>{{ $row['tingkat'] }}</div>
            <div>{{ $row['siswa_masuk'] }}</div>
            <div>{{ $row['siswa_lulus'] }}</div>
            <div>{{ $row['buta_aksara'] }}</div>
        </div>
        @endforeach
    @else
        <div class="table-row">
            <div style="grid-column:1/-1; justify-content:center; color:#999; padding:16px;">
                Tidak ada data tahun {{ $tahun }}
            </div>
        </div>
    @endif
</div>

</div>

@endsection

@push('scripts')
<script>
    window.__yearRoute = '{{ route('data.pendidikan') }}';
</script>
<script src="{{ asset('js/kiosk-semesta.js') }}"></script>
@endpush