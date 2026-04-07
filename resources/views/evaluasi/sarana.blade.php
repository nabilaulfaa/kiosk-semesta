@extends('layouts.app')

@section('content')

<style>
    .sarana-header {
        padding: 40px 80px 10px 80px;
    }

    .sarana-title {
        font-size: 34px;
        font-weight: 900;
        margin-bottom: 20px;
        color: #222;
        text-transform: uppercase;
    }

    .kategori-wrapper {
        display: flex;
        gap: 15px;
        padding: 0 80px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .kategori-btn {
        background: #B51016;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 12px;
        font-size: 18px;
        font-weight: 800;
        display: flex;
        gap: 10px;
        align-items: center;
        transition: all 0.2s ease;
    }

    .kategori-btn:hover {
        transform: scale(1.05);
        background: #7f0c10;
    }

    .kategori-btn span {
        background: #0d6efd;
        padding: 3px 10px;
        border-radius: 10px;
        font-size: 14px;
    }

    .kategori-btn.active {
        background: #7f0c10;
    }

    .sarana-list {
        padding: 0 80px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .sarana-card {
        background: #efefef;
        border-radius: 20px;
        padding: 15px;
        display: flex;
        gap: 20px;
        align-items: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1); 
        cursor: pointer;
    }

    .sarana-card:active, .kategori-btn:active {
        transform: scale(0.98);
    }

    .sarana-card:hover {
        transform: translateY(-8px); 
        background: #ffffff; 
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12); 
    }

    .sarana-card:hover .sarana-img {
        filter: brightness(1.05); 
        transform: scale(1.02); 
        transition: all 0.3s ease;
    }

    .sarana-card:hover .btn-detail {
        background: #e72128; 
        box-shadow: 0 4px 10px rgba(181, 16, 22, 0.3);
        transform: scale(1.05);
    }

    .sarana-img {
        width: 180px;
        height: 120px;
        object-fit: cover;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .sarana-info {
        flex: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .sarana-info h3 {
        color: #B51016;
        font-size: 24px;
        font-weight: 900;
        margin-bottom: 5px;
    }

    .jumlah {
        font-size: 17px;
        font-weight: 700;
        color: #444;
    }

    .card-right {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .badge {
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 800;
        color: white;
        text-transform: capitalize;
    }

    .baik { background: #16a34a; }
    .cukup { background: #f59e0b; }
    .buruk { background: #dc2626; }

    .btn-detail {
        background: #B51016;
        color: white;
        border: none;
        padding: 7px 16px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
    }

    .popup-full {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #f2f2f2;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        z-index: 999999 !important;
        display: none;
        flex-direction: column;
        animation: popupFade .25s ease;
    }

    @keyframes popupFade {
        from { opacity: 0; transform: scale(.97); }
        to { opacity: 1; transform: scale(1); }
    }

    .popup-header {
        background: #B51016;
        color: white;
        padding: 25px 40px;
        font-size: 26px;
        font-weight: 900;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .popup-back {
        background: white;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 8px;
        font-weight: bold;
        color: #B51016;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .popup-back:hover {
        background: #f2f2f2;
        transform: translateX(-5px); 
        color: #E72128;
    }

    .popup-body {
        flex: 1;
        overflow-y: auto;
        padding: 30px 80px;
        scrollbar-width: thin;
        scrollbar-color: #B51016 #f2f2f2;
    }

    .detail-item {
        margin-bottom: 40px;
        background: white;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.3s ease; 
        border: 1px solid transparent;
    }

    .detail-item:hover {
        transform: translateY(-5px); 
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15); 
        border-color: #B51016; 
    }

    .detail-item h3 {
        font-size: 22px;
        font-weight: 900;
        margin-bottom: 10px;
    }

    .detail-img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 15px;
        margin-bottom: 15px;
        transition: transform 0.4s ease, filter 0.4s ease;
    }

    .detail-item:hover .detail-img {
        filter: brightness(1.1); 
        transform: scale(1.01); 
    }

    .detail-text {
        font-size: 17px;
        line-height: 1.6;
        margin-bottom: 8px;
        color: #333;
    }
</style>

<div class="sarana-header">
    <div class="sarana-title">
        SARANA DAN PRASARANA DESA
    </div>
</div>

<div class="kategori-wrapper"></div>

<div class="sarana-list" id="saranaContainer"></div>

<div class="popup-full" id="popupDetail">
    <div class="popup-header">
        <button class="popup-back" onclick="closePopup()">←</button>
        <span id="popupTitle">Detail Fasilitas</span>
    </div>
    <div class="popup-body" id="popupBody"></div>
</div>

<script>
    const mockAPI = {
        pendidikan: [
            {
                nama: "Taman Kanak-Kanak (TK)",
                jumlah: 4,
                kondisi: "baik",
                gambar: "/images/sarana/tk_default.jpg",
                detail: [
                    {
                        nama: "TK Al Islam",
                        kondisi: "baik",
                        gambar: "/images/sarana/tk_al_islam.jpg",
                        deskripsi: "TK memiliki fasilitas bermain yang aman dan ruang belajar yang nyaman bagi siswa."
                    },
                    {
                        nama: "TK Al Ikhlas",
                        kondisi: "baik",
                        gambar: "https://via.placeholder.com/400x200",
                        deskripsi: "Kondisi bangunan dalam keadaan sangat baik dan terawat secara rutin."
                    },
                    {
                        nama: "TK Al Ikhlas",
                        kondisi: "baik",
                        gambar: "https://via.placeholder.com/400x200",
                        deskripsi: "Kondisi bangunan dalam keadaan sangat baik dan terawat secara rutin."
                    },
                    {
                        nama: "TK Al Ikhlas",
                        kondisi: "baik",
                        gambar: "https://via.placeholder.com/400x200",
                        deskripsi: "Kondisi bangunan dalam keadaan sangat baik dan terawat secara rutin."
                    }
                ]
            },
            {
                nama: "Sekolah Dasar (SD)",
                jumlah: 3,
                kondisi: "baik",
                gambar: "https://via.placeholder.com/400x200",
                detail: [
                    {
                        nama: "SDN 1 Jatimulyo ",
                        kondisi: "baik",
                        gambar: "https://via.placeholder.com/400x200",
                        deskripsi: "Kondisi bangunan dalam keadaan sangat baik dan terawat secara rutin."
                    },
                    {
                        nama: "SDN 2 Jatimulyo ",
                        kondisi: "baik",
                        gambar: "https://via.placeholder.com/400x200",
                        deskripsi: "Kondisi bangunan dalam keadaan sangat baik dan terawat secara rutin."
                    },
                    {
                        nama: "SDN 3 Jatimulyo ",
                        kondisi: "baik",
                        gambar: "https://via.placeholder.com/400x200",
                        deskripsi: "Kondisi bangunan dalam keadaan sangat baik dan terawat secara rutin."
                    }
                ]
            },
            {
                nama: "Sekolah Menengah Pertama (SMP)",
                jumlah: 3,
                kondisi: "baik",
                gambar: "https://via.placeholder.com/400x200",
                detail: [
                    {
                        nama: "SMP 1 Jatimulyo ",
                        kondisi: "baik",
                        gambar: "https://via.placeholder.com/400x200",
                        deskripsi: "Kondisi bangunan dalam keadaan sangat baik dan terawat secara rutin."
                    },
                    {
                        nama: "SMP 2 Jatimulyo ",
                        kondisi: "baik",
                        gambar: "https://via.placeholder.com/400x200",
                        deskripsi: "Kondisi bangunan dalam keadaan sangat baik dan terawat secara rutin."
                    },
                    {
                        nama: "SMP 3 Jatimulyo ",
                        kondisi: "baik",
                        gambar: "https://via.placeholder.com/400x200",
                        deskripsi: "Kondisi bangunan dalam keadaan sangat baik dan terawat secara rutin."
                    }
                ]
            },
            {
                nama: "Sekolah Menengah Atas (SMA)",
                jumlah: 3,
                kondisi: "baik",
                gambar: "https://via.placeholder.com/400x200",
                detail: [
                    {
                        nama: "SMA 1 Jatimulyo ",
                        kondisi: "baik",
                        gambar: "https://via.placeholder.com/400x200",
                        deskripsi: "Kondisi bangunan dalam keadaan sangat baik dan terawat secara rutin."
                    },
                    {
                        nama: "SMA 2 Jatimulyo ",
                        kondisi: "baik",
                        gambar: "https://via.placeholder.com/400x200",
                        deskripsi: "Kondisi bangunan dalam keadaan sangat baik dan terawat secara rutin."
                    },
                    {
                        nama: "SMA 3 Jatimulyo ",
                        kondisi: "baik",
                        gambar: "https://via.placeholder.com/400x200",
                        deskripsi: "Kondisi bangunan dalam keadaan sangat baik dan terawat secara rutin."
                    }
                ]
            },
            {
                nama: "Sekolah Menengah Kejuruan (SMK)",
                jumlah: 3,
                kondisi: "baik",
                gambar: "https://via.placeholder.com/400x200",
                detail: [
                    {
                        nama: "SMK 1 Jatimulyo ",
                        kondisi: "baik",
                        gambar: "https://via.placeholder.com/400x200",
                        deskripsi: "Kondisi bangunan dalam keadaan sangat baik dan terawat secara rutin."
                    },
                    {
                        nama: "SMK 2 Jatimulyo ",
                        kondisi: "baik",
                        gambar: "https://via.placeholder.com/400x200",
                        deskripsi: "Kondisi bangunan dalam keadaan sangat baik dan terawat secara rutin."
                    },
                    {
                        nama: "SMK 3 Jatimulyo ",
                        kondisi: "baik",
                        gambar: "https://via.placeholder.com/400x200",
                        deskripsi: "Kondisi bangunan dalam keadaan sangat baik dan terawat secara rutin."
                    }
                ]
            }
        ],
        kesehatan: [
            {
                nama: "Puskesmas",
                jumlah: 1,
                kondisi: "cukup",
                gambar: "https://via.placeholder.com/400x200",
                detail: []
            }
        ],
        umum: [
            {
                nama: "Balai Desa",
                jumlah: 1,
                kondisi: "baik",
                gambar: "https://via.placeholder.com/400x200",
                detail: []
            },
            {
                nama: "Lapangan",
                jumlah: 3,
                kondisi: "baik",
                gambar: "https://via.placeholder.com/400x200",
                detail: []
            },
            {
                nama: "Pasar Desa",
                jumlah: 2,
                kondisi: "baik",
                gambar: "https://via.placeholder.com/400x200",
                detail: []
            },
            {
                nama: "Tempat Ibadah",
                jumlah: 5,
                kondisi: "baik",
                gambar: "https://via.placeholder.com/400x200",
                detail: []
            }
        ],
        lingkungan: []
    };

    async function getData() {
        /*
        const res = await fetch('/api/sarana')
        return await res.json()
        */
        return mockAPI;
    }

    let allData = {};
    let currentKategori = [];

    async function init() {
        allData = await getData();
        renderKategori();

        const firstKey = Object.keys(allData)[0];
        currentKategori = allData[firstKey];
        renderSarana(currentKategori);
    }

    init();

    function renderKategori() {
        const wrapper = document.querySelector('.kategori-wrapper');
        wrapper.innerHTML = "";

        Object.keys(allData).forEach((kategori, index) => {
            wrapper.innerHTML += `
                <button class="kategori-btn ${index == 0 ? 'active' : ''}" data-kategori="${kategori}">
                    ${kategori.toUpperCase()}
                    <span>${allData[kategori].length}</span>
                </button>
            `;
        });

        kategoriClick();
    }

    function kategoriClick() {
        document.querySelectorAll('.kategori-btn').forEach(btn => {
            btn.onclick = function() {
                document.querySelectorAll('.kategori-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const kategori = this.dataset.kategori;
                currentKategori = allData[kategori];
                renderSarana(currentKategori);
            }
        });
    }

    function renderSarana(data) {
        const container = document.getElementById('saranaContainer');
        container.innerHTML = "";

        if (data.length === 0) {
            container.innerHTML = `<p style="padding:20px; color:#666;">Data tidak ditemukan.</p>`;
            return;
        }

        data.forEach((item, index) => {
            container.innerHTML += `
                <div class="sarana-card">
                    <img src="${item.gambar}" class="sarana-img" alt="${item.nama}">
                    <div class="sarana-info">
                        <div>
                            <h3>${item.nama}</h3>
                            <div class="jumlah">Jumlah Unit: ${item.jumlah}</div>
                        </div>
                        <div class="card-right">
                            <span class="badge ${item.kondisi}">${item.kondisi}</span>
                            <button class="btn-detail" onclick="openDetail(${index})">
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                </div>
            `;
        });
    }

    function openDetail(index) {
        const data = currentKategori[index];
        document.getElementById('popupTitle').innerText = "Detail " + data.nama;

        let html = "";
        if (data.detail.length === 0) {
            html = `<p style="text-align:center; padding:50px; color:#666;">Rincian data belum tersedia.</p>`;
        } else {
            data.detail.forEach((item, i) => {
                html += `
                    <div class="detail-item">
                        <h3>${i + 1}. ${item.nama}</h3>
                        <img src="${item.gambar}" class="detail-img">
                        <div class="detail-text">
                            <b>Status Kondisi :</b>
                            <span class="badge ${item.kondisi}">${item.kondisi}</span>
                        </div>
                        <div class="detail-text">
                            ${item.deskripsi}
                        </div>
                    </div>
                `;
            });
        }

        document.getElementById('popupBody').innerHTML = html;
        document.getElementById('popupDetail').style.display = "flex";
    }

    function closePopup() {
        document.getElementById('popupDetail').style.display = "none";
    }
</script>

@endsection

@section('bottom_navigation')
<a href="{{ route('evaluasi') }}" class="btn-nav">
    <i class="bi bi-arrow-left"></i> KEMBALI
</a>
@endsection