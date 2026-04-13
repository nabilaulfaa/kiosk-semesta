@extends('layouts.app')

@section('content')
<style>
    .main-page-container {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        background-color: #ffffff;
    }

    .header-top-style {
        display: flex;
        flex-direction: row-reverse; 
        align-items: center;
        padding: 40px 80px;
        gap: 20px;
    }

    .header-icon-circle {
        width: 65px;
        height: 65px;
        background: #E72128;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(231, 33, 40, 0.3);
    }

    .header-icon-circle i {
        font-size: 30px;
        color: white;
    }

    .header-text-title {
        font-size: 35px;
        font-weight: 800;
        color: #333;
        text-transform: uppercase;
    }

    .content-area {
        padding: 0 80px 100px 80px;
    }

    .left-section-title {
        font-size: 28px;
        font-weight: 700;
        color: #B51016;
        margin-bottom: 25px;
        text-align: left; 
    }

    .surat-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
        max-width: 1000px; 
    }

    .surat-item {
        background: #E72128;
        color: white;
        height: 80px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 30px;
        font-size: 20px;
        font-weight: 700;
        text-decoration: none;
        transition: .3s ease;
    }

    .surat-item:hover {
        background: #c9181f;
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        color: white;
        text-decoration: none;
    }

    .arrow {
        font-size: 28px;
        font-weight: 900;
    }
</style>

<div class="main-page-container">
    
    <div class="header-top-style">
        <div class="header-text-title">LAYANAN SURAT</div>
        <div class="header-icon-circle">
            <i class="bi bi-file-earmark-text"></i>
        </div>
    </div>

    <div class="content-area">
        <div class="left-section-title">
            Persyaratan dan Blanko Surat
        </div>

        <div class="surat-list" id="suratList">
            </div>
    </div>
</div>

<script>
const mockSurat = [
    { id:1, nama:"Surat Keterangan Penduduk" },
    { id:2, nama:"Surat Pengantar SKCK" },
    { id:3, nama:"Surat Keterangan Usaha" },
    { id:4, nama:"Surat Permohonan Kartu Keluarga" },
    { id:5, nama:"Surat Permohonan KTP" },
    { id:6, nama:"Surat Keterangan Pindah Penduduk" },
    { id:7, nama:"Surat Keterangan Kelahiran" },
    { id:8, nama:"Surat Keterangan Kematian" },
    { id:9, nama:"Surat Keterangan Untuk Nikah" }
];

const container = document.getElementById("suratList");

const baseUrl = "{{ route('cek.surat') }}"; 

mockSurat.forEach(item => {
    const link = `${baseUrl}?jenis=${encodeURIComponent(item.nama)}`;
    
    container.innerHTML += `
        <a href="${link}" class="surat-item">
            <div>${item.nama}</div>
            <div class="arrow">›</div>
        </a>
    `;
});
</script>

@endsection