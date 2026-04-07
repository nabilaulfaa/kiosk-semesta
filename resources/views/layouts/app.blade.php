<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiosk Pemerintah Kota Malang - Jatimulyo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }
        
        body {
            background-color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }

        .kiosk-wrapper {
            width: 1080px;
            height: 1920px;
            background: #f6f6f6;
            position: relative;
            overflow: hidden;
            box-shadow: 0 0 50px rgba(0,0,0,0.5);
            display: flex;
            flex-direction: column;
        }

        .header-top {
            height: 300px;
            position: relative;
            padding: 0 80px;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        .header-top::before {
            content: "";
            position: absolute;
            left: -400px; 
            top: -200px;
            width: 1550px;
            height: 1200px;
            background: url('{{ asset("images/logo-semesta-putih.png") }}') no-repeat center;
            background-size: contain;
            filter: brightness(0) opacity(0.06); 
            transform: rotate(180deg); 
            z-index: 0;
            pointer-events: none;
        }

        .header-top::after {
            content: "";
            position: absolute;
            right: -150px;
            top: -305px;
            width: 500px;
            height: 500px;
            background: url('{{ asset("images/logo-semesta.png") }}') no-repeat center;
            background-size: contain;
            filter: brightness(0) saturate(100%) invert(18%) sepia(93%) saturate(5422%) hue-rotate(353deg);
            opacity: 0.9;
            z-index: 1;
        }

        .header-left-content {
            display: flex;
            align-items: center; 
            gap: 25px;           
            z-index: 10;
        }

        .header-logo {
            height: 140px;
            width: auto;
        }

        .text-dark-blue {
            color: #190370;
            font-size: 40px;
            font-weight: 800;
            line-height: 1.2;
            margin: 0;
        }

        .text-blue {
            color: #0771d5;
            font-size: 36px;
            font-weight: 800;
            line-height: 1.2;
            margin: 0;
        }

        .page-content {
            position: relative;
            z-index: 5;
            flex: 1; 
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .footer-section {
            width: 1080px;
            display: flex;
            flex-direction: column;
            align-items: center;
            flex-shrink: 0;
            z-index: 100;
        }

        .footer-nav-wrapper{
            width:1080px;
            margin-bottom:30px;
            padding: 0 40px; 
            display:flex;
            justify-content:center;
        }

        .btn-nav {
            width: 934px;  
            height: 85px;
            background: #B51016;
            color: white;
            border-radius: 22px;
            font-size: 28px;
            font-weight: 750;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            text-decoration: none;
        }

        .footer-bottom-bar {
            width: 1080px;
            height: 100px; 
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 50px; 
            box-shadow: 0 -5px 20px rgba(0,0,0,0.08);
        }

        ::-webkit-scrollbar {
            display: none;
        }

        .welcome-msg {
            font-size: 23px;
            font-weight: 800;
            color: #B51016;
            max-width: 800px;
            text-transform: uppercase;
        }

        .time-widget {
            background: #E72128;
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            text-align: center;
            min-width: 100px;
        }

        .date-val { 
            font-size: 18px; 
            font-weight: 600; 
            display: block; 
        }

        .hour-val { 
            font-size: 33px; 
            font-weight: 900; 
            display: block; 
            line-height: 1; 
        }

        .blur-all {
            filter: blur(8px);
            pointer-events: none;
            user-select: none;
            transition: .25s;
        }

        #main-layout-content {
            display: flex;
            flex-direction: column;
            height: 100%;
            width: 100%;
        }

    </style>
</head>

<body>

<div class="kiosk-wrapper">
        
<div id="main-layout-content">

    <div class="header-top">
        <div class="header-left-content">
            <img src="{{ asset('images/logo-malang.png') }}" class="header-logo">
            <div class="header-text-wrapper">
                <div class="text-dark-blue">PEMERINTAH KOTA MALANG</div>
                <div class="text-blue">JATIMULYO</div>
            </div>
        </div>
    </div>

    <div class="page-content">
        @yield('content')
    </div>

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

@yield('modal_content')

</div>

<script>
function updateClock() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const clockElement = document.getElementById('clock');
    if(clockElement) {
        clockElement.textContent = hours + ':' + minutes;
    }
}
setInterval(updateClock, 1000);
updateClock();

function blurBackground(){
    document.getElementById('main-layout-content')
    .classList.add('blur-all');
}

function unblurBackground(){
    document.getElementById('main-layout-content')
    .classList.remove('blur-all');
}
</script>

</body>
</html>