@php
    $minTahun  = $minTahun  ?? 2020;
    $maxTahun  = $maxTahun  ?? 2026;
    $tahunList = isset($listTahun)
        ? array_map('intval', $listTahun)
        : range($maxTahun, $minTahun);
    rsort($tahunList); 
@endphp

<div class="year-wrapper" id="yearWrapper">
    <button class="year-btn" onclick="toggleYear()" type="button">
        Tahun <span id="yearText">{{ $tahun }}</span> ▼
    </button>
    <div id="yearMenu" class="year-dropdown" style="display:none;">
        <input type="number"
               id="inputYear"
               placeholder="Ketik tahun..."
               onclick="event.stopPropagation()">
        <button onclick="applyYear()" type="button">Pilih</button>
        <div class="year-list" id="yearList">
            @foreach($tahunList as $t)
                <div class="year-item {{ (string)$t == (string)$tahun ? 'active' : '' }}"
                     onclick="goToYear({{ $t }})">
                    {{ $t }}
                </div>
            @endforeach
        </div>
    </div>
</div>