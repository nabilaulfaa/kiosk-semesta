@extends('layouts.app')

@section('content')

<h2 class="mb-4 text-center">Evaluasi Pembangunan Desa</h2>

<div class="row g-4">

    <div class="col-md-6 col-lg-3">
        <a href="/evaluasi-pembangunan/infrastruktur" class="text-decoration-none">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5>Infrastruktur</h5>
                    <p class="text-muted">Jalan, jembatan, drainase, dll</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-6 col-lg-3">
        <a href="/evaluasi-pembangunan/sarana" class="text-decoration-none">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5>Sarana & Prasarana</h5>
                    <p class="text-muted">Sekolah, lapangan, dll</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-6 col-lg-3">
        <a href="/evaluasi-pembangunan/ekonomi" class="text-decoration-none">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5>Ekonomi</h5>
                    <p class="text-muted">BUMDes, UMKM, dll</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-6 col-lg-3">
        <a href="/evaluasi-pembangunan/sosial" class="text-decoration-none">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5>Sosial</h5>
                    <p class="text-muted">Pelatihan & pemberdayaan</p>
                </div>
            </div>
        </a>
    </div>

</div>

@endsection