@extends('layouts.app')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')

<div style="padding: 0 5vw;">

    <div class="modul-header" style="padding: 3vh 0 1vh;">
        <div class="modul-icon"><i class="bi bi-people"></i></div>
        <div class="modul-title">PKK POSYANDU</div>
    </div>

    <div style="font-size:clamp(18px,2vw,32px);font-weight:800;margin-bottom:2vh;">MENU PKK</div>

    {{-- Filter Kegiatan Pokja --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5vh;">
        <div style="color:var(--merah-tua);font-size:clamp(16px,1.8vw,30px);font-weight:800;">KEGIATAN POKJA PKK</div>
        <form action="{{ route('pkk.index') }}" method="GET">
            <input type="hidden" name="tahun_statistik" value="{{ $tahunStatistik }}">
            <select name="tahun" class="select-merah" onchange="this.form.submit()">
                <option value="all" {{ $tahun === 'all' ? 'selected' : '' }}>Semua Tahun</option>
                @foreach($tahunTersediaKegiatan as $th)
                    <option value="{{ $th }}" {{ $tahun == $th ? 'selected' : '' }}>Tahun {{ $th }}</option>
                @endforeach
            </select>
        </form>
    </div>

    {{-- Tabel: thead stay, tbody scroll jika > 5 baris --}}
    <div style="margin-bottom:2vh;border-radius:12px;overflow:hidden;">
        <table class="tabel-kiosk" style="margin-bottom:0;">
            <thead>
                <tr>
                    <th>Pokja</th>
                    <th>Nama Kegiatan</th>
                    <th>Tanggal</th>
                    <th>Lokasi</th>
                </tr>
            </thead>
        </table>
        <div class="{{ count($kegiatanPkk) > 5 ? 'tabel-scroll-wrapper' : 'tabel-scroll-wrapper no-scroll' }}">
            <table class="tabel-kiosk" style="margin-top:0;">
                <tbody>
                    @forelse($kegiatanPkk as $k)
                    <tr>
                        <td style="text-align:center;">{{ $k['pokja'] }}</td>
                        <td>{{ $k['nama'] }}</td>
                        <td style="text-align:center;">{{ $k['tanggal'] }}</td>
                        <td>{{ $k['lokasi'] }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="text-align:center;color:#666;">Tidak ada data kegiatan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Data Umum PKK --}}
    <div style="color:var(--merah-tua);font-size:clamp(16px,1.8vw,30px);font-weight:800;margin-bottom:1.5vh;">DATA UMUM DAN POKJA PKK</div>
    <div style="font-size:clamp(13px,1.2vw,18px);font-weight:700;color:var(--merah-tua);margin-bottom:1vh;">DATA UMUM PKK DESA</div>

    <div class="row g-3 mb-3">
        @php
        $cards = [
            ['label' => 'Total Anggota PKK',  'value' => $dataUmum['total_anggota'], 'dot' => 'orange'],
            ['label' => 'Total Kader PKK',     'value' => $dataUmum['total_kader'],   'dot' => '#007bff'],
            ['label' => 'Kelompok Dasawisma',  'value' => $dataUmum['dasawisma'],     'dot' => 'green'],
            ['label' => 'RT Aktif',            'value' => $dataUmum['rt_aktif'],      'dot' => 'red'],
        ];
        @endphp
        @foreach($cards as $card)
        <div class="col-6">
            <div class="kiosk-card" style="position:relative;padding-left:3vw;">
                <div style="width:16px;height:16px;border-radius:50%;background:{{ $card['dot'] }};position:absolute;left:1.2vw;top:1.8vh;"></div>
                <div style="font-size:clamp(13px,1.2vw,20px);margin-bottom:0.4vh;">{{ $card['label'] }}</div>
                <div style="font-size:clamp(20px,2.5vw,36px);font-weight:900;color:var(--merah-tua);">{{ $card['value'] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Chart Distribusi Pokja --}}
    <div class="row g-3 mb-3">
        <div class="col-7">
            <div style="background:#e0e0e0;border-radius:20px;overflow:hidden;">
                <div style="background:#4B0082;color:white;text-align:center;padding:1vh;font-weight:700;font-size:clamp(13px,1.2vw,18px);">Distribusi Anggota Pokja</div>
                <div style="padding:2vh;height:clamp(180px,22vh,300px);position:relative;">
                    <canvas id="chartPokjaBar"></canvas>
                    <div style="text-align:center;margin-top:1vh;font-weight:700;font-size:clamp(13px,1.2vw,18px);">Total Anggota : 85 Orang</div>
                </div>
            </div>
        </div>
        <div class="col-5">
            <div style="font-size:clamp(14px,1.4vw,22px);font-weight:700;margin-bottom:1.5vh;">Persentase Pokja</div>
            <div style="display:flex;align-items:center;gap:2vw;">
                <div style="flex:1;">
                    @foreach($distribusiPokja as $p)
                    <div style="display:flex;align-items:center;gap:1vw;font-size:clamp(12px,1.1vw,16px);font-weight:700;margin-bottom:0.8vh;">
                        <div style="width:18px;height:18px;border-radius:50%;background:{{ $p['warna'] }};flex-shrink:0;"></div>
                        {{ $p['label'] }} - {{ $p['persen'] }}%
                    </div>
                    @endforeach
                </div>
                <div style="width:clamp(80px,10vw,160px);height:clamp(80px,10vw,160px);position:relative;">
                    <canvas id="chartPokjaPie"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistik Kegiatan PKK --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5vh;">
        <div style="color:var(--merah-tua);font-size:clamp(16px,1.8vw,30px);font-weight:800;">STATISTIK KEGIATAN PKK</div>
        <form action="{{ route('pkk.index') }}" method="GET">
            <input type="hidden" name="tahun" value="{{ $tahun }}">
            <select name="tahun_statistik" class="select-merah" onchange="this.form.submit()">
                <option value="all" {{ $tahunStatistik === 'all' ? 'selected' : '' }}>Semua Tahun</option>
                @foreach($tahunTersediaStatistik as $th)
                    <option value="{{ $th }}" {{ $tahunStatistik == $th ? 'selected' : '' }}>Tahun {{ $th }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="row g-3 mb-3">
        @php
        $statCards = [
            ['label'=>'Total Kegiatan','value'=>$statistikKegiatan['total'],    'dot'=>'red'],
            ['label'=>'Pelatihan',     'value'=>$statistikKegiatan['pelatihan'],'dot'=>'orange'],
            ['label'=>'Pertemuan',     'value'=>$statistikKegiatan['pertemuan'],'dot'=>'green'],
        ];
        @endphp
        @foreach($statCards as $sc)
        <div class="col-4">
            <div class="kiosk-card" style="position:relative;padding-left:3vw;">
                <div style="width:16px;height:16px;border-radius:50%;background:{{ $sc['dot'] }};position:absolute;left:1.2vw;top:1.8vh;"></div>
                <div style="font-size:clamp(12px,1.1vw,18px);">{{ $sc['label'] }}</div>
                <div style="font-size:clamp(20px,2.5vw,36px);font-weight:900;color:var(--merah-tua);">{{ $sc['value'] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row g-3 mb-4">
        <div class="col-7">
            <div style="background:#f0f0f0;border-radius:20px;overflow:hidden;">
                <div style="background:var(--merah-tua);color:white;text-align:center;padding:1vh;font-weight:700;font-size:clamp(13px,1.2vw,18px);">Jumlah Kegiatan Per Bulan</div>
                <div style="padding:2vh;height:clamp(160px,20vh,280px);position:relative;">
                    <canvas id="chartKegiatanBulanan"></canvas>
                </div>
            </div>
        </div>
        <div class="col-5">
            <div style="font-size:clamp(14px,1.4vw,22px);font-weight:700;margin-bottom:1.5vh;">Jenis Kegiatan</div>
            <div style="display:flex;align-items:center;gap:2vw;">
                <div style="flex:1;">
                    @php
                    $jenisLegend = [
                        ['warna'=>'#B51016','label'=>'Total Kegiatan - ' . $statistikKegiatan['total']],
                        ['warna'=>'#FFB74D','label'=>'Pelatihan - '      . $statistikKegiatan['pelatihan']],
                        ['warna'=>'#109688','label'=>'Pertemuan - '      . $statistikKegiatan['pertemuan']],
                    ];
                    @endphp
                    @foreach($jenisLegend as $l)
                    <div style="display:flex;align-items:center;gap:1vw;font-size:clamp(12px,1.1vw,16px);font-weight:700;margin-bottom:0.8vh;">
                        <div style="width:18px;height:18px;border-radius:50%;background:{{ $l['warna'] }};flex-shrink:0;"></div>
                        {{ $l['label'] }}
                    </div>
                    @endforeach
                </div>
                <div style="width:clamp(80px,10vw,150px);height:clamp(80px,10vw,150px);position:relative;">
                    <canvas id="chartJenisKegiatan"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('bottom_navigation')
<a href="{{ route('pkk.posyandu') }}" class="btn-nav">
    <i class="bi bi-arrow-left"></i> KEMBALI
</a>
@endsection

@push('scripts')
<script>
const pkkColors   = @json(array_column($distribusiPokja, 'warna'));
const pokjaJumlah = @json(array_column($distribusiPokja, 'jumlah'));
const pokjaPersen = @json(array_column($distribusiPokja, 'persen'));
const dataBulanan = @json($statistikKegiatan['bulanan']);

const commonOpts = { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } };

window.onload = function () {
    new Chart(document.getElementById('chartPokjaBar'), {
        type: 'bar',
        data: { labels: ['Pokja 1','Pokja 2','Pokja 3','Pokja 4'], datasets: [{ data: pokjaJumlah, backgroundColor: pkkColors, barThickness: 15 }] },
        options: { ...commonOpts, indexAxis: 'y' }
    });

    new Chart(document.getElementById('chartPokjaPie'), {
        type: 'pie',
        data: { datasets: [{ data: pokjaPersen, backgroundColor: pkkColors }] },
        options: commonOpts
    });

    new Chart(document.getElementById('chartKegiatanBulanan'), {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
            datasets: [{ data: dataBulanan, backgroundColor: '#FF7676' }]
        },
        options: commonOpts
    });

    new Chart(document.getElementById('chartJenisKegiatan'), {
        type: 'pie',
        data: { datasets: [{ data: [{{ $statistikKegiatan['total'] }}, {{ $statistikKegiatan['pelatihan'] }}, {{ $statistikKegiatan['pertemuan'] }}], backgroundColor: ['#B51016','#FFB74D','#109688'] }] },
        options: commonOpts
    });
};
</script>
@endpush