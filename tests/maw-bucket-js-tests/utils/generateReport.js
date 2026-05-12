const fs   = require('fs');
const path = require('path');

const screenshotDir = path.join(__dirname, '../reports/screenshots');
const testsDir      = path.join(__dirname, '../tests');
const outputFile    = path.join(__dirname, '../reports/laporan_pengujian.html');

// ─────────────────────────────────────────────────────────────
// 1. BACA SEMUA TEST CASE (ID + Deskripsi) dari folder tests/
// ─────────────────────────────────────────────────────────────

const MODULE_NAMES = {
  '01_halaman_publik.test.js'    : 'Halaman Publik',
  '02_form_kontak.test.js'       : 'Form Kontak',
  '03_admin_auth.test.js'        : 'Admin Autentikasi',
  '04_admin_produk.test.js'      : 'Admin — Manajemen Produk',
  '05_admin_pesan.test.js'       : 'Admin — Manajemen Pesan',
  '06_responsif_navigasi.test.js': 'Responsivitas & Navigasi',
};

function bacaSemuaTestCase() {
  const hasil = [];
  const testFiles = fs.readdirSync(testsDir).filter(f => f.endsWith('.test.js')).sort();

  for (const file of testFiles) {
    const modul  = MODULE_NAMES[file] || file;
    const konten = fs.readFileSync(path.join(testsDir, file), 'utf-8');

    for (const baris of konten.split('\n')) {
      const m = baris.match(/it\([`'](TC-[^:]+:\s*[^`'"]+)[`']/);
      if (m) {
        const teks  = m[1].trim();
        const split = teks.indexOf(':');
        hasil.push({
          id       : teks.substring(0, split).trim(),
          deskripsi: teks.substring(split + 1).trim(),
          modul,
        });
      }
    }

    // TC-RES & TC-NAV-01..04 dibuat dinamis di kode, tambah manual
    if (file === '06_responsif_navigasi.test.js') {
      const resolusi = [
        { nama: 'Desktop HD', lebar: 1920, tinggi: 1080 },
        { nama: 'Laptop',     lebar: 1366, tinggi: 768  },
        { nama: 'Tablet',     lebar: 768,  tinggi: 1024 },
        { nama: 'Mobile',     lebar: 375,  tinggi: 812  },
      ];
      const nav = [
        { tcId: 'TC-NAV-01', nama: 'Home' },
        { tcId: 'TC-NAV-02', nama: 'Produk' },
        { tcId: 'TC-NAV-03', nama: 'Kontak' },
        { tcId: 'TC-NAV-04', nama: 'AI Rekomendasi' },
      ];
      for (const r of resolusi)
        hasil.push({ id: 'TC-RES', deskripsi: `Home tampil benar di ${r.nama} (${r.lebar}x${r.tinggi})`, modul });
      for (const n of nav)
        hasil.push({ id: n.tcId, deskripsi: `Halaman ${n.nama} dapat diakses tanpa error`, modul });
    }
  }
  return hasil;
}

// ─────────────────────────────────────────────────────────────
// 2. BACA SCREENSHOT → map: NAMAFILE_UPPERCASE → base64 data URI
// ─────────────────────────────────────────────────────────────

const MIME = { '.png': 'image/png', '.jpg': 'image/jpeg', '.jpeg': 'image/jpeg' };

function bacaScreenshots() {
  const map = {};
  for (const file of fs.readdirSync(screenshotDir)) {
    const ext  = path.extname(file).toLowerCase();
    const mime = MIME[ext];
    if (!mime) continue;
    const kunci = path.basename(file, ext).toUpperCase();
    const b64   = fs.readFileSync(path.join(screenshotDir, file)).toString('base64');
    map[kunci]  = `data:${mime};base64,${b64}`;
  }
  return map;
}

// ─────────────────────────────────────────────────────────────
// 3. COCOKKAN ID → screenshot (cari key yang diawali ID test)
// ─────────────────────────────────────────────────────────────

function cariScreenshot(id, screenshotMap) {
  const idUpper = id.toUpperCase();
  for (const kunci of Object.keys(screenshotMap)) {
    if (kunci.startsWith(idUpper)) return screenshotMap[kunci];
  }
  return null;
}

// ─────────────────────────────────────────────────────────────
// 4. TENTUKAN STATUS: GAGAL jika ada file GAGAL_TC-XXX
// ─────────────────────────────────────────────────────────────

const gagalFiles = fs.readdirSync(screenshotDir)
  .filter(f => f.startsWith('GAGAL_'))
  .map(f => f.replace('GAGAL_', ''));

function statusTest(id) {
  return gagalFiles.some(f => f.startsWith(id)) ? 'GAGAL' : 'LULUS';
}

// ─────────────────────────────────────────────────────────────
// 5. BANGUN HTML
// ─────────────────────────────────────────────────────────────

const testCases     = bacaSemuaTestCase();
const screenshotMap = bacaScreenshots();

const total = testCases.length;
const gagal = testCases.filter(tc => statusTest(tc.id) === 'GAGAL').length;
const lulus = total - gagal;

// Kelompokkan per modul
const modulMap = {};
for (const tc of testCases) {
  if (!modulMap[tc.modul]) modulMap[tc.modul] = [];
  modulMap[tc.modul].push(tc);
}

function buatBaris(tc) {
  const status     = statusTest(tc.id);
  const screenshot = cariScreenshot(tc.id, screenshotMap);
  const badgeClass = status === 'LULUS' ? 'badge-lulus' : 'badge-gagal';
  const badgeText  = status === 'LULUS' ? '✓ Lulus' : '✗ Gagal';
  const imgCell    = screenshot
    ? `<img src="${screenshot}" width="420" style="border-radius:8px;border:1px solid #ddd;display:block;">`
    : `<span class="no-img">— tidak ada screenshot —</span>`;

  return `
      <tr class="row-${status.toLowerCase()}">
        <td class="td-id">${tc.id}</td>
        <td class="td-desc">${tc.deskripsi}</td>
        <td class="td-img">${imgCell}</td>
        <td class="td-status"><span class="badge ${badgeClass}">${badgeText}</span></td>
      </tr>`;
}

let modulHTML = '';
let idx = 1;
for (const [namaModul, kasus] of Object.entries(modulMap)) {
  const mLulus = kasus.filter(tc => statusTest(tc.id) === 'LULUS').length;
  const mGagal = kasus.length - mLulus;
  modulHTML += `
    <section class="module">
      <div class="module-header">
        <span class="mod-num">MOD-0${idx}</span>
        <h2 class="mod-title">${namaModul}</h2>
        <span class="mod-stat">
          <span class="ok">${mLulus} lulus</span> ·
          <span class="fail">${mGagal} gagal</span> ·
          ${kasus.length} total
        </span>
      </div>
      <table>
        <thead>
          <tr>
            <th style="width:110px">ID</th>
            <th>Deskripsi</th>
            <th style="width:440px">Screenshot</th>
            <th style="width:90px">Status</th>
          </tr>
        </thead>
        <tbody>${kasus.map(buatBaris).join('')}</tbody>
      </table>
    </section>`;
  idx++;
}

const tanggal = new Date().toLocaleDateString('id-ID', {
  weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
});

const html = `<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Pengujian — Maw Bouquet</title>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: Arial, sans-serif; background: #f0f2f5; color: #1a1a1a; }

    .header {
      background: #1a1a2e; color: white;
      padding: 24px 40px;
      display: flex; justify-content: space-between; align-items: center;
    }
    .header-brand { font-size: 1.3rem; font-weight: bold; }
    .header-brand span { color: #e8a87c; }
    .header-meta { font-size: 0.75rem; color: #aaa; text-align: right; line-height: 1.7; }

    .summary {
      background: white; border-bottom: 3px solid #e8a87c;
      padding: 24px 40px; display: flex; align-items: center; gap: 28px; flex-wrap: wrap;
    }
    .summary h1 { font-size: 1.2rem; color: #1a1a2e; flex: 1; min-width: 180px; }
    .stat-cards { display: flex; gap: 12px; flex-wrap: wrap; }
    .stat-card {
      background: #f8f9fa; border: 1px solid #e9ecef;
      border-radius: 8px; padding: 12px 20px; text-align: center; min-width: 85px;
    }
    .stat-card .val { font-size: 1.7rem; font-weight: bold; line-height: 1; }
    .stat-card .lbl { font-size: 0.65rem; color: #777; margin-top: 4px; text-transform: uppercase; }
    .val-total { color: #1a1a2e; }
    .val-lulus { color: #27ae60; }
    .val-gagal { color: #e74c3c; }

    .progress-wrap { flex-basis: 100%; }
    .progress-bar { height: 6px; background: #e9ecef; border-radius: 4px; overflow: hidden; }
    .progress-fill { height: 100%; background: linear-gradient(90deg, #2ecc71, #27ae60); border-radius: 4px; }
    .progress-label { font-size: 0.7rem; color: #888; margin-top: 5px; }

    .main { padding: 28px 40px; max-width: 1300px; margin: 0 auto; }

    .module { margin-bottom: 36px; }
    .module-header {
      display: flex; align-items: center; gap: 12px;
      padding: 12px 20px; background: #1a1a2e; color: white;
      border-radius: 8px 8px 0 0;
    }
    .mod-num {
      background: #e8a87c; color: #1a1a2e;
      font-size: 0.62rem; font-weight: bold;
      padding: 2px 8px; border-radius: 4px;
    }
    .mod-title { font-size: 0.95rem; font-weight: bold; flex: 1; }
    .mod-stat { font-size: 0.7rem; color: #aaa; }
    .mod-stat .ok   { color: #2ecc71; }
    .mod-stat .fail { color: #e74c3c; }

    table {
      width: 100%; border-collapse: collapse; background: white;
      border: 1px solid #e9ecef; border-top: none;
      border-radius: 0 0 8px 8px; overflow: hidden;
    }
    thead tr { background: #f8f9fa; }
    th {
      padding: 9px 14px; text-align: left;
      font-size: 0.68rem; color: #555; font-weight: bold;
      text-transform: uppercase; letter-spacing: 0.06em;
      border-bottom: 2px solid #e9ecef;
    }
    td { padding: 11px 14px; border-bottom: 1px solid #f0f2f5; vertical-align: middle; font-size: 0.82rem; }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover { background: #fafafa; }

    .td-id    { font-family: monospace; font-size: 0.75rem; color: #555; white-space: nowrap; }
    .td-desc  { color: #222; }
    .td-img   { padding: 10px 14px; }
    .no-img   { font-size: 0.7rem; color: #bbb; font-style: italic; }
    .row-gagal { background: #fff8f8; }
    .row-gagal:hover { background: #fff0f0 !important; }

    .badge { display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 0.68rem; font-weight: bold; white-space: nowrap; }
    .badge-lulus { background: #d4f8e8; color: #1a7a45; }
    .badge-gagal { background: #fde8e8; color: #a00; }

    .footer { text-align: center; padding: 20px; font-size: 0.7rem; color: #aaa; border-top: 1px solid #e9ecef; margin-top: 12px; }
  </style>
</head>
<body>

<header class="header">
  <div class="header-brand">🌸 Maw <span>Bouquet</span></div>
  <div class="header-meta">
    Automation Testing · Selenium WebDriver · Mocha<br>
    Dibuat: ${tanggal}
  </div>
</header>

<div class="summary">
  <h1>📋 Laporan Pengujian Otomatis</h1>
  <div class="stat-cards">
    <div class="stat-card"><div class="val val-total">${total}</div><div class="lbl">Total</div></div>
    <div class="stat-card"><div class="val val-lulus">${lulus}</div><div class="lbl">Lulus</div></div>
    <div class="stat-card"><div class="val val-gagal">${gagal}</div><div class="lbl">Gagal</div></div>
  </div>
  <div class="progress-wrap">
    <div class="progress-bar">
      <div class="progress-fill" style="width:${Math.round((lulus/total)*100)}%"></div>
    </div>
    <div class="progress-label">
      Tingkat kelulusan: ${Math.round((lulus/total)*100)}% (${lulus} dari ${total} kasus uji)
    </div>
  </div>
</div>

<main class="main">
  ${modulHTML}
</main>

<footer class="footer">
  maw-bucket-js-tests · Laporan dihasilkan otomatis oleh generateReport.js · ${tanggal}
</footer>

</body>
</html>`;

fs.writeFileSync(outputFile, html);
console.log(`✅ laporan_pengujian.html berhasil dibuat (${testCases.length} kasus uji, ${Object.keys(screenshotMap).length} screenshot)`);
