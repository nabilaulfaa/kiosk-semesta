@extends('layouts.app')

@section('title', 'Data Pendidikan')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/kiosk-semesta.css') }}">
@endpush

@section('content')

<div class="modul-header">
    <div class="d-flex align-items-center gap-2">
        <div class="modul-icon"><i class="bi bi-houses"></i></div>
        <span class="modul-title">PROFIL DESA</span>
    </div>
</div>

<div class="subtitle-left">Data Pendidikan</div>

<div class="pend-wrap">

    <div class="stat-grid">
        <div class="stat-card"><small>SD/Sederajat</small><b>{{ $data['statistik']['sd'] ?? '-' }}</b></div>
        <div class="stat-card"><small>SMP/Sederajat</small><b>{{ $data['statistik']['smp'] ?? '-' }}</b></div>
        <div class="stat-card"><small>SMA/Sederajat</small><b>{{ $data['statistik']['sma'] ?? '-' }}</b></div>
        <div class="stat-card"><small>Perguruan Tinggi</small><b>{{ $data['statistik']['pt'] ?? '-' }}</b></div>
    </div>

    <div class="top-info">
        <div></div>
        @include('layouts.partials.year-picker', ['tahun' => $tahun])
    </div>

    <div class="table-wrap">
        <div class="table-head">
            <div class="th">Tingkat Pendidikan</div>
            <div class="th">Siswa Masuk</div>
            <div class="th">Siswa Lulus</div>
            <div class="th">Buta Aksara</div>
        </div>
        @if($data && isset($data['tabel']))
            @foreach($data['tabel'] as $row)
            <div class="tr">
                <div class="td" style="display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:600;">{{ $row['tingkat'] }}</div>
                <div class="td" style="display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;">{{ $row['siswa_masuk'] }}</div>
                <div class="td" style="display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;">{{ $row['siswa_lulus'] }}</div>
                <div class="td" style="display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;">{{ $row['buta_aksara'] }}</div>
            </div>
            @endforeach
        @else
            <div class="tr">
                <div class="td" style="grid-column:1/-1;display:flex;align-items:center;justify-content:center;color:#999;padding:16px;">
                    Tidak ada data tahun {{ $tahun }}
                </div>
            </div>
        @endif
    </div>

</div>

@endsection

@section('bottom_navigation')
    <a href="{{ route('profil.desa') }}" class="btn-nav">
        <i class="bi bi-arrow-left"></i> KEMBALI
    </a>
@endsection

@push('scripts')
<script>
    window.__yearRoute = '{{ route('data.pendidikan') }}';
</script>
<script src="{{ asset('js/kiosk-semesta.js') }}"></script>
@endpush