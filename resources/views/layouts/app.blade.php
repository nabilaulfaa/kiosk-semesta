<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiosk Pemerintah Kota Malang - Jatimulyo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/kiosk-semesta.css') }}" rel="stylesheet">

    <style>
        /* Sticky modul header */
        

        /* Modul title jadi tombol kalau ada href */
        .modul-title-link {
            text-decoration: none;
            color: inherit;
            cursor: pointer;
            transition: opacity 0.2s;
        }
        .modul-title-link:hover {
            opacity: 0.75;
        }

        /* Footer redesign */
        .footer-bottom-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 3vw;
            gap: 2vw;
        }
        .footer-beranda-btn {
            display: flex;
            align-items: center;
            gap: 0.8vw;
            background: var(--merah-tua);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: clamp(8px,1.2vh,18px) clamp(16px,2vw,32px);
            font-size: clamp(13px,1.2vw,20px);
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .footer-beranda-btn:hover { opacity: 0.85; color: #fff; }

        .footer-welcome {
            flex: 1;
            text-align: center;
            font-size: clamp(11px,1vw,16px);
            font-weight: 700;
            color: var(--merah-tua);
        }

        .footer-time {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            flex-shrink: 0;
        }

        /* Header logo klikable */
        .header-logo-link {
            display: flex;
            align-items: center;
            gap: 1vw;
            text-decoration: none;
        }
    </style>

    @stack('styles')
</head>

<body>

<div class="kiosk-wrapper">

    <div id="main-layout-content">

        {{-- ===== HEADER ===== --}}
        <div class="header-top">
            <a href="{{ route('beranda') }}" class="header-logo-link">
                <img src="{{ asset('images/logo-malang.png') }}" class="header-logo" alt="Logo Malang">
                <div>
                    <div class="text-dark-blue">PEMERINTAH KOTA MALANG</div>
                    <div class="text-blue">JATIMULYO</div>
                </div>
            </a>
        </div>

        {{-- ===== KONTEN HALAMAN ===== --}}
        <div class="page-content">
            @yield('content')
        </div>

        {{-- ===== FOOTER ===== --}}
        <div class="footer-section">

            {{-- Navigasi KEMBALI (opsional, hanya halaman isi) --}}
            @if(!$__env->hasSection('hide_bottom_nav'))
                @hasSection('bottom_navigation')
                <div class="footer-nav-wrapper">
                    @yield('bottom_navigation')
                </div>
                @endif
            @endif

            {{-- Bar bawah: BERANDA | SELAMAT DATANG | JAM --}}
            <div class="footer-bottom-bar">
                <a href="{{ route('beranda') }}" class="footer-beranda-btn">
                    <i class="bi bi-house-door-fill"></i> BERANDA
                </a>

                <div class="footer-welcome" style="font-size: clamp(13px,1.3vw,20px);">
                    SELAMAT DATANG DI DESA JATIMULYO KECAMATAN LOWOKWARU
                </div>

                <div class="footer-time">
                    <span class="date-val" style="color: var(--merah-tua);">{{ date('d-m-Y') }}</span>
                    <span class="hour-val" id="clock" style="color: var(--merah-tua);">--:--</span>
                </div>
            </div>

        </div>

    </div>

    {{-- ===== MODAL ===== --}}
    @yield('modal_content')

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/kiosk-semesta.js') }}"></script>

@stack('scripts')

</body>
</html>