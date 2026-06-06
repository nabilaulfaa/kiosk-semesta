@extends('layouts.app')

@section('title', 'Data Kependudukan')

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

<div class="page-title" style="padding-left: 15px;">Data Kependudukan</div>

<div class="card-group">
    <div class="kep-card">
        <div class="card-title">Jumlah Penduduk</div>
        <div class="card-value">{{ $data['jumlah_penduduk'] ?? '-' }}</div>
    </div>
    <div class="kep-card">
        <div class="card-title">Jumlah Kepala Keluarga</div>
        <div class="card-value">{{ $data['jumlah_kepala_keluarga'] ?? '-' }}</div>
    </div>
</div>

<div class="chart-row">
    <div class="chart-box-modul">
        <canvas id="jkChart"></canvas>
        <div class="legend legend-jk">
            <div><span class="dot" style="background:#b71c1c"></span>Jumlah Laki-laki</div>
            <div><span class="dot" style="background:#ef5350"></span>Jumlah Perempuan</div>
        </div>
        <div class="kep-data-table">
            <div class="data-row">
                <div class="lbl">Jumlah Laki-Laki</div>
                <div class="val">{{ $data['jenis_kelamin']['laki_laki'] ?? '-' }}</div>
            </div>
            <div class="data-row">
                <div class="lbl">Jumlah Perempuan</div>
                <div class="val">{{ $data['jenis_kelamin']['perempuan'] ?? '-' }}</div>
            </div>
        </div>
    </div>

    <div class="chart-box-modul">
        <canvas id="usiaChart"></canvas>
        <div class="legend">
            <div><span class="dot" style="background:#c62828"></span>Jumlah Remaja</div>
            <div><span class="dot" style="background:#1565c0"></span>Jumlah Dewasa</div>
            <div><span class="dot" style="background:#2e7d32"></span>Jumlah Balita</div>
            <div><span class="dot" style="background:#6d4c41"></span>Jumlah Lansia</div>
        </div>
        <div class="kep-data-table">
            <div class="data-row">
                <div class="lbl">Jumlah Remaja</div>
                <div class="val">{{ $data['usia']['remaja'] ?? '-' }}</div>
            </div>
            <div class="data-row">
                <div class="lbl">Jumlah Dewasa</div>
                <div class="val">{{ $data['usia']['dewasa'] ?? '-' }}</div>
            </div>
            <div class="data-row">
                <div class="lbl">Jumlah Balita</div>
                <div class="val">{{ $data['usia']['balita'] ?? '-' }}</div>
            </div>
            <div class="data-row">
                <div class="lbl">Jumlah Lansia</div>
                <div class="val">{{ $data['usia']['lansia'] ?? '-' }}</div>
            </div>
        </div>
    </div>
</div>

<div class="bar-section">
    <div class="bar-title">Statistik Penduduk Per Tahun</div>
    <div class="bar-box">
        <div class="bar-legend">
            <div><span class="bar-dot" style="background:#ffed29"></span>Kematian</div>
            <div><span class="bar-dot" style="background:#ef9aa5"></span>Penduduk Masuk</div>
            <div><span class="bar-dot" style="background:#c62828"></span>Penduduk Keluar</div>
            <div><span class="bar-dot" style="background:#1b8f3a"></span>Kelahiran</div>
        </div>
        <canvas id="barChart"></canvas>
    </div>
</div>

<div class="table-section">
    <div class="table-title">Rata-Rata Pekerjaan</div>
    <div class="table-wrapper">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Pekerjaan</th>
                    <th>Jumlah</th>
                    <th>Laki-laki</th>
                    <th>Perempuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach(($data['pekerjaan'] ?? []) as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}.</td>
                    <td>{{ $item['jenis_pekerjaan'] ?? '-' }}</td>
                    <td>{{ $item['jumlah'] ?? '-' }}</td>
                    <td>{{ $item['laki_laki'] ?? '-' }}</td>
                    <td>{{ $item['perempuan'] ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/kiosk-semesta.js') }}"></script>
@endpush