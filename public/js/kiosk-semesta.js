// JAM REAL-TIME
function updateClock() {
    const now     = new Date();
    const hours   = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const el = document.getElementById('clock');
    if (el) el.textContent = hours + ':' + minutes;
}
setInterval(updateClock, 1000);
updateClock();

// MODAL HEALPER
function openModal(id) {
    const overlay = document.getElementById(id);
    if (!overlay) return;
    overlay.classList.add('show');
    document.body.classList.add('modal-open');
}

function closeModal(id) {
    const overlay = document.getElementById(id);
    if (!overlay) return;
    overlay.classList.remove('show');
    const stillOpen = document.querySelector('.modal-overlay.show');
    if (!stillOpen) document.body.classList.remove('modal-open');
}

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.modal-overlay').forEach(function (overlay) {
        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) {
                overlay.classList.remove('show');
                const stillOpen = document.querySelector('.modal-overlay.show');
                if (!stillOpen) document.body.classList.remove('modal-open');
            }
        });
    });
});

function checkTableScroll(tbodyId, wrapperId, maxRows = 5) {
    const tbody   = document.getElementById(tbodyId);
    const wrapper = document.getElementById(wrapperId);
    if (!tbody || !wrapper) return;
    const rowCount = tbody.querySelectorAll('tr').length;
    if (rowCount > maxRows) {
        wrapper.classList.remove('no-scroll');
    } else {
        wrapper.classList.add('no-scroll');
    }
}

function formatRupiah(num) {
    return 'Rp ' + Number(num).toLocaleString('id-ID');
}

function rupiah(n) {
    if (!n && n !== 0) return '-';
    if (Math.abs(n) >= 1e9) return 'Rp ' + (n / 1e9).toFixed(2) + 'M';
    if (Math.abs(n) >= 1e6) return 'Rp ' + (n / 1e6).toFixed(1) + 'jt';
    return 'Rp ' + Number(n).toLocaleString('id-ID');
}

function showSkeleton(id) {
    const el = document.getElementById(id);
    if (!el) return;
    el.innerHTML = `<tr><td colspan="2"><div class="skeleton w-75"></div></td></tr>`;
}

// MODUL LAYANAN SURAT

// RENDER DAFTAR SURAT DARI API
async function renderDaftarSurat() {
    try {
        const res  = await fetch('/api/desa/layanan-surat');
        const data = await res.json();
        const container = document.getElementById('suratList');
        if (!container) return;

        const baseUrl = container.dataset.baseUrl;
        container.innerHTML = data.jenis_surat.map(item => {
            const link = `${baseUrl}?jenis=${encodeURIComponent(item.nama)}&id=${item.id}`;
            return `
                <a href="${link}" class="surat-item">
                    <div style="display:flex;align-items:center;gap:1.5vw;">
                        <i class="bi ${item.icon}"></i>
                        <span>${item.nama}</span>
                    </div>
                    <div class="arrow">›</div>
                </a>
            `;
        }).join('');
    } catch (err) {
        console.error('Gagal fetch data layanan surat:', err);
        const container = document.getElementById('suratList');
        if (container) container.innerHTML = '<p style="color:#999;padding:2vh;">Gagal memuat data surat.</p>';
    }
}

// CEK SURAT, BLANKO, POPUP STATUS
let _suratData = {};

async function _fetchSuratData() {
    try {
        const res = await fetch('/api/desa/layanan-surat');
        _suratData = await res.json();
    } catch (err) {
        console.error('Gagal fetch data surat:', err);
    }
}

function _setBtn(btn, enabled) {
    btn.disabled         = !enabled;
    btn.style.background = enabled ? '#E72128' : '#999';
    btn.style.cursor     = enabled ? 'pointer'  : 'not-allowed';
}

function _initFormCek() {
    const input = document.getElementById('inputCek');
    const btn   = document.getElementById('btnCek');
    if (!input || !btn) return;

    _setBtn(btn, false);

    input.addEventListener('input', () => {
        const nik   = input.value.trim();
        const valid = nik !== '' && _suratData.mock_status?.[nik] !== undefined;
        _setBtn(btn, valid);
    });

    btn.addEventListener('click', () => {
        const nik    = input.value.trim();
        const status = _suratData.mock_status?.[nik];
        if (status) {
            _showPopupStatus(status);
        } else {
            alert('NIK tidak ditemukan dalam sistem.');
        }
    });
}

function _initBlanko() {
    const blankoUrl = window.blankoUrl || '';

    document.getElementById('btnLihat')?.addEventListener('click', () => {
        if (blankoUrl) window.open(blankoUrl, '_blank');
        else alert('Blanko surat belum tersedia.');
    });

    document.getElementById('btnUnduh')?.addEventListener('click', () => {
        if (blankoUrl) {
            const win = window.open(blankoUrl, '_blank');
            if (win) win.onload = () => win.print();
        } else {
            alert('Blanko surat belum tersedia.');
        }
    });
}

function _showPopupStatus(status) {
    const config = {
        pengajuan: { fill: '0%',   active: 0, warna: '#f59e0b', label: 'PENGAJUAN' },
        proses:    { fill: '50%',  active: 1, warna: '#3b82f6', label: 'DIPROSES'  },
        selesai:   { fill: '100%', active: 2, warna: '#16a34a', label: 'SELESAI'   }
    };

    const c = config[status.status] || config.proses;

    document.getElementById('popupNama').innerText      = status.nama;
    document.getElementById('popupJenis').innerText     = status.jenis;
    document.getElementById('popupUpdate').innerText    = status.update;
    document.getElementById('popupEstimasi').innerText  = status.estimasi;
    document.getElementById('progressFill').style.width = c.fill;

    const badge = document.getElementById('popupBadge');
    if (badge) {
        badge.innerText        = c.label;
        badge.style.background = c.warna;
    }

    document.querySelectorAll('#popupStatus .step-item').forEach((el, i) => {
        el.classList.remove('active', 'completed');
        if (i < c.active)   el.classList.add('completed');
        if (i === c.active) el.classList.add('active');
    });

    const btnCetak = document.getElementById('btnCetak');
    if (btnCetak) btnCetak.style.display = status.status === 'selesai' ? 'block' : 'none';

    document.getElementById('popupStatus').classList.add('show');
    document.body.classList.add('modal-open');
}

function cetakSurat() {
    const blankoUrl = window.blankoUrl || '';
    if (blankoUrl) {
        const win = window.open(blankoUrl, '_blank');
        if (win) win.onload = () => win.print();
    } else {
        alert('File surat belum tersedia untuk dicetak.');
    }
}

function closePopupSurat() {
    const popup = document.getElementById('popupStatus');
    if (popup) popup.classList.remove('show');
    document.body.classList.remove('modal-open');

    const input = document.getElementById('inputCek');
    const btn   = document.getElementById('btnCek');
    if (input) input.value = '';
    if (btn)   _setBtn(btn, false);
}

window.cetakSurat      = cetakSurat;
window.closePopupSurat = closePopupSurat;

// MODUL APBDes, PETA, KEPENDUDUKAN, PROFIL DESA

// WARNA DUSUN/RTRW
const WARNA_DUSUN = [
    '#B71C1C', '#7B1F1F', '#4E342E',
    '#3E2723', '#880E4F', '#1A237E'
];

//DROPDOWN TAHUN
function toggleYear() {
    const menu = document.getElementById('yearMenu');
    if (!menu) return;
    const isOpen = menu.style.display === 'flex';
    menu.style.display = isOpen ? 'none' : 'flex';
    if (!isOpen) menu.style.flexDirection = 'column';
}

function goToYear(year) {
    if (!window.__yearRoute) return;
    const url = new URL(window.__yearRoute, window.location.origin);
    url.searchParams.set('tahun', year);
    window.location.href = url.toString();
}

function applyYear() {
    const input = document.getElementById('inputYear');
    if (!input || !input.value) return;
    const year = parseInt(input.value);
    if (isNaN(year) || year < 1900 || year > 2100) {
        alert('Masukkan tahun yang valid');
        return;
    }
    goToYear(year);
}

// ─────────────────────────────────────────────────────────────
// APBDes — RENDER (murni tampilkan data, tanpa fetch)
// ─────────────────────────────────────────────────────────────

function renderStatistik(json) {
    const s = json.statistik;

    document.getElementById('gridTahun').textContent      = json.tahun;
    document.getElementById('gridPendapatan').textContent = rupiah(s.pendapatan.anggaran);
    document.getElementById('gridBelanja').textContent    = rupiah(s.belanja.realisasi);
    document.getElementById('gridSilpa').textContent      = rupiah(s.silpa.realisasi);

    const pct = s.pendapatan.anggaran > 0
        ? Math.min((s.belanja.realisasi / s.pendapatan.anggaran) * 100, 100)
        : 0;
    const barBelanja = document.getElementById('barBelanja');
    if (barBelanja) barBelanja.style.width = pct.toFixed(1) + '%';

    document.getElementById('tabelPendapatan').innerHTML = `
     <tr>
        <td class="td-nama" style="font-size:clamp(13px,1.1vw,18px);font-weight:500;">
            Anggaran
        </td>
        <td class="td-nilai" style="font-size:clamp(13px,1.1vw,18px);font-weight:500;">
            ${rupiah(s.pendapatan.anggaran)}
        </td>
     </tr>
     <tr>
        <td class="td-nama" style="font-size:clamp(13px,1.1vw,18px);font-weight:500;">
            Realisasi
        </td>
        <td class="td-nilai" style="font-size:clamp(13px,1.1vw,18px);font-weight:500;">
            ${rupiah(s.pendapatan.realisasi)}
        </td>
     </tr>
       <tr class="tr-total">
        <td class="td-nama" style="font-size:clamp(13px,1.1vw,18px);font-weight:700;">
            Persentase
        </td>
        <td class="td-nilai" style="font-size:clamp(13px,1.1vw,18px);font-weight:700;">
            ${s.pendapatan.persentase}%
        </td>
     </tr>
    `;
    document.getElementById('tabelBelanja').innerHTML = `
        <tr>
            <td class="td-nama" style="font-size:clamp(13px,1.1vw,18px);font-weight:500;">
                Anggaran
            </td>
            <td class="td-nilai" style="font-size:clamp(13px,1.1vw,18px);font-weight:500;">
                ${rupiah(s.belanja.anggaran)}
            </td>
        </tr>
        <tr>
            <td class="td-nama" style="font-size:clamp(13px,1.1vw,18px);font-weight:500;">
                Realisasi
            </td>
            <td class="td-nilai" style="font-size:clamp(13px,1.1vw,18px);font-weight:500;">
                ${rupiah(s.belanja.realisasi)}
            </td>
        </tr>
        <tr class="tr-total">
            <td class="td-nama" style="font-size:clamp(13px,1.1vw,18px);font-weight:700;">
                Persentase
            </td>
            <td class="td-nilai" style="font-size:clamp(13px,1.1vw,18px);font-weight:700;">
                ${s.belanja.persentase}%
            </td>
        </tr>
    `;
}

function renderPeriodeData(json) {
    const body = document.getElementById('bodyPeriode');
    if (!body) return;
    body.innerHTML = json.data.map(d => `
        <div class="table-row">
            <div>${d.tahun}</div>
            <div>${rupiah(d.pendapatan.realisasi)}</div>
            <div>${rupiah(d.belanja.realisasi)}</div>
            <div>${rupiah(d.pembiayaan.realisasi)}</div>
            <div>${rupiah(d.silpa.realisasi)}</div>
        </div>
    `).join('');
}

function renderPembangunan(list, tahun) {
    const el = document.getElementById('listPembangunan');
    if (!el) return;
    if (!list.length) {
        el.innerHTML = `<div class="text-center py-3 text-secondary small">Tidak ada program pembangunan${tahun ? ' tahun ' + tahun : ''}</div>`;
        return;
    }
    el.innerHTML = list.map(d => {
        const wilayah = d.wilayah?.dusun
            ? `${d.wilayah.dusun} RW ${d.wilayah.rw} RT ${d.wilayah.rt}`
            : d.lokasi || '-';
        return `
            <div class="project-card kiosk-card d-flex gap-3 mb-2">
                <img src="/images/pembangunan.png"
                    style="width:clamp(150px,16vw,250px);height:clamp(100px,12vh,180px);object-fit:contain;border-radius:15px;flex-shrink:0;background:#ddd;padding:10px;">
                <div style="flex:1;display:flex;flex-direction:column;justify-content:space-between;">
                    <div>
                        <div style="color:var(--merah-tua);font-size:clamp(16px,1.6vw,28px);font-weight:700;margin-bottom:0.5vh;">
                            ${d.judul}
                        </div>
                        <div style="font-size:clamp(13px,1.1vw,18px);font-weight:500;margin-bottom:0.3vh;">Lokasi : ${wilayah}</div>
                        <div style="font-size:clamp(13px,1.1vw,18px);font-weight:500;margin-bottom:0.3vh;">Pelaksana : ${d.pelaksana}</div>
                        <div style="font-size:clamp(13px,1.1vw,18px);font-weight:500;">Anggaran : ${rupiah(d.anggaran)}</div>
                    </div>
                </div>
            </div>
        `;
    }).join('');
}

// ─────────────────────────────────────────────────────────────
// APBDes — FETCH (dipakai saat ganti tahun via JS)
// ─────────────────────────────────────────────────────────────

async function loadStatistik(tahun) {
    if (!document.getElementById('tabelPendapatan')) return;
    showSkeleton('tabelPendapatan');
    showSkeleton('tabelBelanja');
    try {
        const res  = await fetch(`${API_STATISTIK}?tahun=${tahun}`);
        const json = await res.json();
        renderStatistik(json);
    } catch (err) {
        console.error('Gagal load statistik:', err);
        document.getElementById('tabelPendapatan').innerHTML = `<tr><td colspan="2" style="color:#999;padding:12px;text-align:center;">Gagal memuat data</td></tr>`;
        document.getElementById('tabelBelanja').innerHTML    = `<tr><td colspan="2" style="color:#999;padding:12px;text-align:center;">Gagal memuat data</td></tr>`;
    }
}

async function loadPeriode() {
    const body = document.getElementById('bodyPeriode');
    if (!body) return;
    body.innerHTML = `<div class="table-row"><div style="text-align:center;color:#999;">Memuat data...</div></div>`;
    try {
        const res  = await fetch(API_PERIODE);
        const json = await res.json();
        renderPeriodeData(json);
    } catch (err) {
        console.error('Gagal load periode:', err);
        body.innerHTML = `<div class="table-row"><div style="text-align:center;color:#999;">Gagal memuat data</div></div>`;
    }
}

async function loadPembangunan(tahun) {
    const el = document.getElementById('listPembangunan');
    if (!el) return;
    el.innerHTML = `<div class="text-center py-3 text-secondary small">Memuat data...</div>`;
    try {
        const res  = await fetch(`${API_PEMBANGUNAN}?tahun=${tahun}`);
        const json = await res.json();
        renderPembangunan(json.data || [], tahun);
    } catch (err) {
        console.error('Gagal load pembangunan:', err);
        el.innerHTML = `<div class="text-center py-3 text-secondary small">Gagal memuat data</div>`;
    }
}

// KEPENDUDUKAN - Chart.js
function initCharts() {
    const jkChart = document.getElementById('jkChart');
    if (jkChart) {
        new Chart(jkChart, {
            type: 'pie',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{ data: [1300, 1200], backgroundColor: ['#b71c1c', '#ef5350'], borderWidth: 0 }]
            },
            options: { plugins: { legend: { display: false } }, animation: false }
        });
    }

    const usiaChart = document.getElementById('usiaChart');
    if (usiaChart) {
        new Chart(usiaChart, {
            type: 'pie',
            data: {
                labels: ['Remaja', 'Dewasa', 'Balita', 'Lansia'],
                datasets: [{ data: [630, 240, 630, 240], backgroundColor: ['#c62828', '#1565c0', '#2e7d32', '#6d4c41'], borderWidth: 0 }]
            },
            options: { plugins: { legend: { display: false } }, animation: false }
        });
    }

    const barChart = document.getElementById('barChart');
    if (barChart) {
        new Chart(barChart, {
            type: 'bar',
            data: {
                labels: ['2023', '2024', '2025'],
                datasets: [
                    { data: [20, 22, 25], backgroundColor: '#ffed29' },
                    { data: [40, 45, 50], backgroundColor: '#ef9aa5' },
                    { data: [55, 60, 62], backgroundColor: '#c62828' },
                    { data: [70, 75, 78], backgroundColor: '#1b8f3a' }
                ]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: {
    x: {
        grid: { display: false },
        border: { display: false },
        ticks: {
            font: { size: 16, weight: 'bold' },
            color: '#333'
        }
    },
    y: { display: false }
}
            }
        });
    }
}

function scrollRight(id) {
    const el = document.getElementById(id);
    if (!el) return;
    el.scrollBy({ left: 200, behavior: 'smooth' });
}

function initDisabledMenu() {
    document.querySelectorAll('.menu-item.disabled').forEach(el => {
        el.addEventListener('click', function (e) {
            e.preventDefault();
            const circle = this.querySelector('.menu-circle');
            if (!circle) return;
            circle.style.animation = 'shake .3s ease';
            setTimeout(() => { circle.style.animation = ''; }, 300);
        });
    });
}

// PETA WILAYAH
let map          = null;
let wilayahLayer = null;
const infraLayers = new Map();
const dusunLayers = new Map();

function initMap() {
    if (!document.getElementById('map')) return;
    map = L.map('map', {
        center: MAP_CENTER, zoom: MAP_ZOOM,
        minZoom: 14, maxZoom: 17,
        zoomSnap: 0.25, zoomDelta: 0.25,
        wheelPxPerZoomLevel: 120,
        zoomControl: true, attributionControl: false
    });
    map.scrollWheelZoom.enable();
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19, updateWhenIdle: true, keepBuffer: 2
    }).addTo(map);
    initData();
}

async function loadDusun() {
    const res  = await fetch(API.dusun);
    const json = await res.json();
    const list = (json.data?.[0] || {}).data_dusun || [];
    const legendDusun = document.getElementById('legendDusun');
    if (!legendDusun) return;

    legendDusun.innerHTML = list.map(d => {
        const nama  = d.nama || (d.dusun.charAt(0).toUpperCase() + d.dusun.slice(1));
        const warna = d.warna || WARNA_DUSUN[list.indexOf(d) % WARNA_DUSUN.length];
        return `
            <label class="chk-item">
                <input type="checkbox" class="dusun-chk" data-dusun="${d.dusun}" checked>
                <span class="chk-box" style="background:${warna};"></span>
                <span class="chk-label">${nama}</span>
            </label>
        `;
    }).join('');

    list.forEach(d => {
        if (!d.coordinates) return;
        const warna = d.warna || '#E72128';
        const nama  = d.nama  || d.dusun;
        const layer = L.geoJSON({
            type: 'Feature',
            geometry: { type: 'Polygon', coordinates: [d.coordinates] }
        }, {
            style: { color: warna, weight: 2, fillColor: warna, fillOpacity: 0.35 }
        });

        layer.bindPopup(`
            <div class="popup-header">📍 ${nama}</div>
            <div class="popup-body">
                <div class="popup-row"><span class="key">Dusun</span><span class="val">${nama}</span></div>
                <div class="popup-row"><span class="key">Kepala Dusun</span><span class="val">${d.kepala_dusun || '-'}</span></div>
            </div>
        `);

        layer.addTo(map);
        dusunLayers.set(d.dusun, layer);
    });

    document.querySelectorAll('.dusun-chk').forEach(chk => {
        chk.addEventListener('change', function () {
            const layer = dusunLayers.get(this.dataset.dusun);
            if (!layer) return;
            this.checked ? layer.addTo(map) : map.removeLayer(layer);
        });
    });
}

async function loadWilayah() {
    const res  = await fetch(API.geojson);
    const json = await res.json();
    const features = json.desa?.geojson?.features || [];
    const warna    = json.desa?.warna || '#E72128';

    const wilayahFeatures = features.filter(f => f.properties.tipe === 'wilayah');

    wilayahLayer = L.geoJSON(
        { type: 'FeatureCollection', features: wilayahFeatures },
        {
            style: { color: warna, weight: 2.5, fillColor: warna, fillOpacity: 0.10, opacity: 1 },
            onEachFeature: (feature, layer) => {
                layer.bindPopup(`
                    <div class="popup-header">🗺️ ${feature.properties.nama}</div>
                    <div class="popup-body">
                        <div class="popup-row"><span class="key">Wilayah</span><span class="val">${feature.properties.nama}</span></div>
                    </div>
                `);
            }
        }
    ).addTo(map);
}

async function loadInfrastruktur() {
    const res  = await fetch(API.infrastruktur);
    const json = await res.json();

    (json.features || []).forEach(f => {
        const props    = f.properties;
        const tipe     = props.tipe;
        const kategori = props.kategori;

        if (tipe === 'tanah') {
            if (!infraLayers.has('Tanah Warga')) {
                infraLayers.set('Tanah Warga', L.layerGroup().addTo(map));
            }
            const layer = L.geoJSON(f, {
                style: { color: '#5D4037', weight: 1.5, fillColor: '#795548', fillOpacity: 0.55 }
            });
            layer.bindPopup(`
                <div class="popup-header">🏠 Tanah Warga</div>
                <div class="popup-body">
                    <div class="popup-row"><span class="key">Pemilik</span><span class="val">${props.nama}</span></div>
                    <div class="popup-row"><span class="key">Luas</span><span class="val">${props.luas}</span></div>
                </div>
            `);
            infraLayers.get('Tanah Warga').addLayer(layer);
            return;
        }

        if (!infraLayers.has(kategori)) {
            infraLayers.set(kategori, L.layerGroup().addTo(map));
        }
        const coords = f.geometry.coordinates;
        const marker = L.marker([coords[1], coords[0]], {
            icon: L.divIcon({
                html: `<div style="background:#E72128;border-radius:50%;width:32px;height:32px;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 6px rgba(0,0,0,.35);"><i class="${props.icon}" style="font-size:15px;color:#fff;"></i></div>`,
                className: '', iconAnchor: [16, 16], iconSize: [32, 32]
            })
        });
        marker.bindPopup(`
            <div class="popup-header"><i class="${props.icon}" style="margin-right:6px;"></i>${props.nama}</div>
            <div class="popup-body">
                <div class="popup-row"><span class="key">Kategori</span><span class="val">${kategori}</span></div>
            </div>
        `);
        infraLayers.get(kategori).addLayer(marker);
    });

    document.querySelectorAll('.infra-chk').forEach(chk => {
        chk.addEventListener('change', function () {
            const layer = infraLayers.get(this.dataset.kategori);
            if (!layer) return;
            this.checked ? layer.addTo(map) : map.removeLayer(layer);
        });
    });
}

function checkAll(state) {
    document.querySelectorAll('.layer-chk, .infra-chk, .dusun-chk').forEach(chk => {
        chk.checked = state;
        chk.dispatchEvent(new Event('change'));
    });
    if (wilayahLayer) state ? wilayahLayer.addTo(map) : map.removeLayer(wilayahLayer);
}

function refreshAll() {
    map.setView(MAP_CENTER, MAP_ZOOM);
    if (wilayahLayer) { map.removeLayer(wilayahLayer); wilayahLayer = null; }
    infraLayers.forEach(g => map.removeLayer(g)); infraLayers.clear();
    dusunLayers.forEach(g => map.removeLayer(g)); dusunLayers.clear();
    initData();
}

async function initData() {
    try {
        await Promise.all([loadWilayah(), loadInfrastruktur(), loadDusun()]);
        const chkWilayah = document.querySelector('.layer-chk[data-layer="wilayah"]');
        if (chkWilayah && wilayahLayer) {
            chkWilayah.addEventListener('change', function () {
                this.checked ? wilayahLayer.addTo(map) : map.removeLayer(wilayahLayer);
            });
        }
    } catch (err) {
        console.error('Gagal memuat data peta:', err);
    } finally {
        const spinner = document.getElementById('mapSpinner');
        if (spinner) spinner.style.display = 'none';
    }
}

//profil desa
function toggleMonografi() {
    const menu  = document.getElementById('monografiMenu');
    const arrow = document.getElementById('arrowIcon');
    if (!menu || !arrow) return;
    const isOpen = menu.style.display === 'flex';
    menu.style.display = isOpen ? 'none' : 'flex';
    arrow.textContent  = isOpen ? '›' : '∧';

    if (!isOpen) {
        menu.querySelectorAll('a').forEach(function(link) {
            const linkPath = new URL(link.href, window.location.origin).pathname;
            const currPath = window.location.pathname;
            if (linkPath === currPath) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    }
}

// Auto-highlight
document.addEventListener('DOMContentLoaded', function() {
    const menu = document.getElementById('monografiMenu');
    if (!menu) return;
    menu.querySelectorAll('a').forEach(function(link) {
        const linkPath = new URL(link.href, window.location.origin).pathname;
        const currPath = window.location.pathname;
        if (linkPath === currPath) {
            link.classList.add('active');
        }
    });
    
});

function toggleZoom(img) { img.classList.toggle('zoomed'); }
function toggleAcc(el)   { el.nextElementSibling.classList.toggle('open'); }

// global event listeners
document.addEventListener('click', function (e) {
    const wrapper = document.querySelector('.year-wrapper');
    if (wrapper && !wrapper.contains(e.target)) {
        const menu = document.getElementById('yearMenu');
        if (menu) menu.style.display = 'none';
    }
});

document.addEventListener('keydown', function (e) {
    if (e.key !== 'Escape') return;
    ['modalDetail', 'modalBaru', 'modalSelesai', 'modalRiwayat'].forEach(function (id) {
        const el = document.getElementById(id);
        if (!el) return;
        const modal = bootstrap.Modal.getInstance(el);
        if (modal) modal.hide();
    });
});

// INIT — DOMContentLoaded 
document.addEventListener('DOMContentLoaded', function () {

    // Layanan surat
    if (document.getElementById('suratList')) {
        renderDaftarSurat();
    }

    if (document.getElementById('inputCek')) {
        (async () => {
            await _fetchSuratData();
            _initFormCek();
            _initBlanko();
        })();
    }

    // APBDes
    const urlTahun = new URLSearchParams(window.location.search).get('tahun');
    if (urlTahun && typeof tahunAktif !== 'undefined') {
        tahunAktif = parseInt(urlTahun);
    }

    if (
        typeof API_STATISTIK !== 'undefined' &&
        document.getElementById('tabelPendapatan')
    ) {
        if (window.__serverData) {
            renderStatistik(window.__serverData.statistik);
            renderPeriodeData(window.__serverData.periode);
            renderPembangunan(window.__serverData.pembangunan.data || [], tahunAktif);
        } else {
            loadStatistik(tahunAktif);
            loadPeriode();
            loadPembangunan(tahunAktif);
        }
    }

    // Kependudukan charts
    initCharts();

    // Menu beranda
    initDisabledMenu();

    // Peta wilayah
    initMap();
});