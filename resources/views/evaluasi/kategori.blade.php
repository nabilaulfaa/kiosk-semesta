@extends('layouts.app')

@section('content')

<h3 class="mb-4 text-capitalize">
    Kategori: {{ $kategori }}
</h3>

@php
    $data = [];

    if ($kategori == 'infrastruktur') {
        $data = [
            [
                'nama' => 'Pembangunan Jalan Desa',
                'tahun' => 2025,
                'status' => 'Proses',
                'lokasi' => 'Dusun Krajan'
            ],
            [
                'nama' => 'Renovasi Balai Desa',
                'tahun' => 2024,
                'status' => 'Selesai',
                'lokasi' => 'Balai Desa'
            ],
        ];
    }

    elseif ($kategori == 'sarana') {
        $data = [
            [
                'nama' => 'Pembangunan Lapangan Olahraga',
                'tahun' => 2025,
                'status' => 'Perencanaan',
                'lokasi' => 'Dusun Timur'
            ],
        ];
    }

    elseif ($kategori == 'ekonomi') {
        $data = [
            [
                'nama' => 'Program Bantuan UMKM',
                'tahun' => 2025,
                'status' => 'Proses',
                'lokasi' => 'Desa'
            ],
        ];
    }

    elseif ($kategori == 'sosial') {
        $data = [
            [
                'nama' => 'Pelatihan Digitalisasi Desa',
                'tahun' => 2024,
                'status' => 'Selesai',
                'lokasi' => 'Balai Desa'
            ],
        ];
    }
@endphp

<div class="row g-4">

@foreach ($data as $item)
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">

                <h5>{{ $item['nama'] }}</h5>
                <p class="mb-1"><strong>Lokasi:</strong> {{ $item['lokasi'] }}</p>
                <p class="mb-1"><strong>Tahun:</strong> {{ $item['tahun'] }}</p>

                <span class="badge 
                    @if($item['status'] == 'Selesai') bg-success
                    @elseif($item['status'] == 'Proses') bg-warning text-dark
                    @else bg-secondary
                    @endif
                ">
                    {{ $item['status'] }}
                </span>

                <div class="mt-3">
                    <a href="/evaluasi-pembangunan/detail/1" class="btn btn-sm btn-outline-primary">
                        Lihat Detail
                    </a>
                </div>

            </div>
        </div>
    </div>
@endforeach

</div>

@endsection