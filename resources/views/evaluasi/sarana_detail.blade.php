@extends('layouts.app')

@section('content')

<div class="modul-header">
    <div class="modul-icon"><i class="bi bi-search"></i></div>
    <div class="modul-title">EVALUASI</div>
</div>
<div class="page-title">{{ strtoupper($data['nama']) }}</div>

<div style="padding: 0 5vw 4vh; display: flex; flex-direction: column; gap: 2vh;">
    @if(count($data['item']) === 0)
        <p style="padding:2vh;color:#666;font-size:clamp(14px,1.3vw,20px);">Rincian data belum tersedia.</p>
    @else
        @foreach($data['item'] as $i => $item)
        <div class="kiosk-card" style="border:1px solid transparent;">
            <div style="font-size:clamp(15px,1.5vw,24px);font-weight:800;margin-bottom:1.5vh;">
                {{ $i + 1 }}. {{ $item['nama'] }}
            </div>
            <img src="{{ asset('images/' . $item['gambar']) }}"
                style="width:100%;height:clamp(140px,20vh,280px);object-fit:cover;border-radius:15px;margin-bottom:1.5vh;">
            <div style="font-size:clamp(13px,1.2vw,18px);font-weight:500;margin-bottom:0.8vh;">
                <b>Status Kondisi :</b>
                <span class="badge-status {{ $item['kondisi'] }}">{{ $item['kondisi'] }}</span>
            </div>
            <div style="font-size:clamp(13px,1.2vw,18px);font-weight:500;color:#333;line-height:1.6;">
                {{ $item['deskripsi'] }}
            </div>
        </div>
        @endforeach
    @endif
</div>

@endsection

@section('bottom_navigation')
<a href="{{ route('evaluasi.sarana') }}" class="btn-nav">
    <i class="bi bi-arrow-left"></i> KEMBALI
</a>
@endsection
