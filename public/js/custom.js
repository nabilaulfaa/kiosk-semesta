/* ----------------------------------------------------------
   1. JAM REAL-TIME
---------------------------------------------------------- */
function updateClock() {
    const now = new Date();
    const hours   = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const el = document.getElementById('clock');
    if (el) el.textContent = hours + ':' + minutes;
}
setInterval(updateClock, 1000);
updateClock();

/* ----------------------------------------------------------
   2. MODAL HELPER
---------------------------------------------------------- */
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
    if (!stillOpen) {
        document.body.classList.remove('modal-open');
    }
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

/* ----------------------------------------------------------
   3. TABEL AUTO-SCROLL
---------------------------------------------------------- */
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

/* ----------------------------------------------------------
   4. FORMAT RUPIAH
---------------------------------------------------------- */
function formatRupiah(num) {
    return 'Rp ' + Number(num).toLocaleString('id-ID');
}

/* ============================================================
   LAYANAN SURAT 
   ============================================================ */

// ========================
// INDEX: Render daftar surat dari API
// ========================
async function renderDaftarSurat() {
    try {
        const res  = await fetch('/api/layanan-surat/data');
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

if (document.getElementById('suratList')) {
    document.addEventListener('DOMContentLoaded', renderDaftarSurat);
}

// ========================
// CEK SURAT: Form, blanko, popup
// ========================
let _suratData = {};

async function _fetchSuratData() {
    try {
        const res = await fetch('/api/layanan-surat/data');
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
            const judulEl = document.getElementById('judulSurat');
            const nama    = judulEl ? judulEl.innerText : 'blanko';
            const a       = document.createElement('a');
            a.href        = blankoUrl;
            a.download    = nama + '.pdf';
            a.click();
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

    document.getElementById('popupNama').innerText     = status.nama;
    document.getElementById('popupJenis').innerText    = status.jenis;
    document.getElementById('popupUpdate').innerText   = status.update;
    document.getElementById('popupEstimasi').innerText = status.estimasi;
    document.getElementById('progressFill').style.width = c.fill;

    const badge = document.getElementById('popupBadge');
    if (badge) {
        badge.innerText        = c.label;
        badge.style.background = c.warna;
    }

    document.querySelectorAll('#popupStatus .step-item').forEach((el, i) => {
        el.classList.remove('active', 'completed');
        if (i < c.active)  el.classList.add('completed');
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
    if (input) { input.value = ''; }
    if (btn)   _setBtn(btn, false);
}

window.cetakSurat      = cetakSurat;
window.closePopupSurat = closePopupSurat;

if (document.getElementById('inputCek')) {
    document.addEventListener('DOMContentLoaded', async () => {
        await _fetchSuratData();
        _initFormCek();
        _initBlanko();
    });
}