<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiosk Pemerintah Kota Malang - Jatimulyo</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    {{-- Custom CSS (theme & override Bootstrap) --}}
    <link href="{{ asset('css/kiosk-semesta.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body>

<div class="kiosk-wrapper">

    <div id="main-layout-content">

        {{-- ===== HEADER ===== --}}
        <div class="header-top">
            <div class="header-left-content">
                <img src="{{ asset('images/logo-malang.png') }}" class="header-logo" alt="Logo Malang">
                <div>
                    <div class="text-dark-blue">PEMERINTAH KOTA MALANG</div>
                    <div class="text-blue">JATIMULYO</div>
                </div>
            </div>
        </div>

        {{-- ===== KONTEN HALAMAN ===== --}}
        <div class="page-content">
            @yield('content')
        </div>

        {{-- ===== FOOTER NAVIGASI ===== --}}
        <div class="footer-section">
            @if(!$__env->hasSection('hide_bottom_nav'))
                <div class="footer-nav-wrapper">
                    @hasSection('bottom_navigation')
                        @yield('bottom_navigation')
                    @else
                        <a href="{{ route('beranda') }}" class="btn-nav">
                            <i class="bi bi-house-door-fill"></i>
                            BERANDA
                        </a>
                    @endif
                </div>
            @endif

            <div class="footer-bottom-bar">
                <div class="welcome-msg">
                    SELAMAT DATANG DI DESA JATIMULYO KECAMATAN LOWOKWARU
                </div>
                <div class="time-widget">
                    <span class="date-val">{{ date('d-m-Y') }}</span>
                    <span class="hour-val" id="clock">--:--</span>
                </div>
            </div>
        </div>

    </div>{{-- #main-layout-content --}}

    {{-- ===== MODAL (di luar main-layout, di dalam kiosk-wrapper) ===== --}}
    @yield('modal_content')

</div>{{-- .kiosk-wrapper --}}

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
{{-- Custom JS global --}}
<script src="{{ asset('js/kiosk-semesta.js') }}"></script>

@stack('scripts')

</body>
</html>