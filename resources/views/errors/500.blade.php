<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Error – Kiosk Semesta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f4f8;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-card {
            background: #fff;
            border-radius: 20px;
            padding: 3rem 2.5rem;
            max-width: 520px;
            width: 100%;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0,0,0,0.10);
        }
        .error-icon {
            font-size: 4.5rem;
            color: #e74c3c;
            margin-bottom: 1rem;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .error-code {
            font-size: 4rem;
            font-weight: 800;
            color: #e74c3c;
            line-height: 1;
            margin-bottom: 0.25rem;
        }
        .error-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.75rem;
        }
        .error-desc {
            color: #718096;
            font-size: 0.95rem;
            margin-bottom: 2rem;
            line-height: 1.7;
        }
        .info-box {
            background: #fff8e1;
            border: 1px solid #ffe082;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 2rem;
            text-align: left;
        }
        .info-box .info-title {
            font-weight: 600;
            color: #b7791f;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        .info-box ul {
            margin: 0;
            padding-left: 1.25rem;
            color: #744210;
            font-size: 0.88rem;
        }
        .info-box ul li { margin-bottom: 0.25rem; }
        .btn-back {
            background: #2b6cb0;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 0.65rem 2rem;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: background 0.2s;
        }
        .btn-back:hover { background: #2c5282; color: #fff; }
        .btn-retry {
            background: #e74c3c;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 0.65rem 2rem;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: background 0.2s;
            cursor: pointer;
        }
        .btn-retry:hover { background: #c0392b; color: #fff; }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="error-icon"><i class="bi bi-wifi-off"></i></div>
        <div class="error-code">500</div>
        <div class="error-title">Gagal Mengambil Data</div>
        <div class="error-desc">
            Data tidak dapat diambil karena koneksi internet terputus<br>
            atau server sedang tidak dapat dijangkau.
        </div>
        <div class="info-box">
            <div class="info-title">
                <i class="bi bi-exclamation-triangle-fill me-1"></i> Kemungkinan penyebab:
            </div>
            <ul>
                <li>Koneksi internet perangkat ini terputus</li>
                <li>Server hosting sedang dalam perbaikan</li>
                <li>Koneksi ke jaringan hosting lambat atau timeout</li>
            </ul>
        </div>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ url('/') }}" class="btn-back">
                <i class="bi bi-house-fill"></i> Kembali ke Beranda
            </a>
            <button class="btn-retry" onclick="window.location.reload()">
                <i class="bi bi-arrow-clockwise"></i> Coba Lagi
            </button>
        </div>
    </div>
</body>
</html>