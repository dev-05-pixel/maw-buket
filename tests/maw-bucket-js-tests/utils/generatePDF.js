// ============================================================
//  utils/generatePDF.js
//  Generate PDF test report from test results
//  Alternative to HTML report for faster loading
// ============================================================

const fs   = require('fs');
const path = require('path');

// Check if pdfkit is available, if not use fallback
let PDFDocument;
try {
  PDFDocument = require('pdfkit');
} catch (e) {
  PDFDocument = null;
}

const screenshotDir = path.join(__dirname, '../reports/screenshots');
const testsDir     = path.join(__dirname, '../tests');
const outputPDF     = path.join(__dirname, '../reports/laporan_pengujian.pdf');

const MODULE_NAMES = {
  '01_halaman_publik.test.js'    : 'Halaman Publik',
  '02_form_kontak.test.js'        : 'Form Kontak',
  '03_admin_auth.test.js'        : 'Admin Autentikasi',
  '04_admin_produk.test.js'       : 'Admin — Manajemen Produk',
  '05_admin_pesan.test.js'        : 'Admin — Manajemen Pesan',
  '06_responsif_navigasi.test.js': 'Responsivitas & Navigasi',
  '07_product_detail.test.js'     : 'Product Detail',
  '08_dashboard_admin.test.js'    : 'Dashboard Admin',
  '09_testimonial_admin.test.js'  : 'Testimonial Admin',
  '10_pesan_admin.test.js'        : 'Pesan Admin',
  '11_detail_pesan_admin.test.js' : 'Detail Pesan Admin',
};

// ============================================================
//  1. BACA SEMUA TEST CASE
// ============================================================
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

    // Handle dynamic tests in 06
    if (file === '06_responsif_navigasi.test.js') {
      const resolusi = [
        { nama: 'Desktop HD', width: 1920, height: 1080 },
        { nama: 'Laptop', width: 1366, height: 768 },
        { nama: 'Tablet', width: 768, height: 1024 },
        { nama: 'Mobile', width: 375, height: 812 },
      ];
      for (const r of resolusi)
        hasil.push({ id: 'TC-RES', deskripsi: `Home tampil di ${r.nama} (${r.width}x${r.height})`, modul });
    }
  }
  return hasil;
}

// ============================================================
//  2. BACA SCREENSHOT (for reference only, not embedded)
// ============================================================
function bacaScreenshots() {
  const map = {};
  if (!fs.existsSync(screenshotDir)) return map;
  
  try {
    const files = fs.readdirSync(screenshotDir);
    for (const file of files) {
      const ext = path.extname(file).toLowerCase();
      if (!['.png', '.jpg', '.jpeg'].includes(ext)) continue;
      
      const filePath = path.join(screenshotDir, file);
      const stats = fs.statSync(filePath);
      if (stats.size > 5 * 1024 * 1024) continue;
      
      const kunci = path.basename(file, ext).toUpperCase();
      map[kunci] = file;
    }
  } catch (err) {
    console.log(`⚠️ Error reading screenshots: ${err.message}`);
  }
  return map;
}

// ============================================================
//  3. TENTUKAN STATUS
// ============================================================
const gagalFiles = fs.existsSync(screenshotDir)
  ? fs.readdirSync(screenshotDir).filter(f => f.startsWith('GAGAL_'))
  : [];

function statusTest(id) {
  return gagalFiles.some(f => f.replace('GAGAL_', '').startsWith(id)) ? 'GAGAL' : 'LULUS';
}

// ============================================================
//  4. GENERATE PDF (using text-only for compatibility)
// ============================================================
async function generatePDF() {
  console.log('📄 Generating PDF Report...');
  
  const testCases = bacaSemuaTestCase();
  const screenshotMap = bacaScreenshots();
  
  const total = testCases.length;
  const gagal = testCases.filter(tc => statusTest(tc.id) === 'GAGAL').length;
  const lulus = total - gagal;
  const tanggal = new Date().toLocaleDateString('id-ID', {
    weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
  });

  // Group by module
  const modulMap = {};
  for (const tc of testCases) {
    if (!modulMap[tc.modul]) modulMap[tc.modul] = [];
    modulMap[tc.modul].push(tc);
  }

  // Create text-based PDF content (compatible with all systems)
  let content = '';
  content += '═'.repeat(70) + '\n';
  content += '          📋 LAPORAN PENGUJIAN OTOMATIS - MAW BOUQUET\n';
  content += '═'.repeat(70) + '\n\n';
  content += `Tanggal  : ${tanggal}\n`;
  content += `Total    : ${total} test cases\n`;
  content += `Lulus    : ${lulus} (${Math.round((lulus/total)*100)}%)\n`;
  content += `Gagal    : ${gagal}\n\n`;
  content += '─'.repeat(70) + '\n\n';

  let modNum = 1;
  for (const [namaModul, kasus] of Object.entries(modulMap)) {
    const mLulus = kasus.filter(tc => statusTest(tc.id) === 'LULUS').length;
    const mGagal = kasus.length - mLulus;
    
    content += `📁 MOD-${String(modNum).padStart(2, '0')} ${namaModul}\n`;
    content += `   Status : ${mLulus} lulus · ${mGagal} gagal · ${kasus.length} total\n`;
    content += '─'.repeat(50) + '\n';
    
    for (const tc of kasus) {
      const st = statusTest(tc.id);
      const icon = st === 'LULUS' ? '✅' : '❌';
      const tcId = tc.id.padEnd(20);
      const desc = tc.deskripsi.substring(0, 45).padEnd(45);
      content += `   ${icon} ${tcId} ${desc}\n`;
    }
    content += '\n';
    modNum++;
  }

  content += '═'.repeat(70) + '\n';
  content += 'Generated by maw-bucket-js-tests · automation testing\n';
  content += `Report created: ${new Date().toISOString()}\n`;
  content += '═'.repeat(70) + '\n';

  // Write PDF file (using text as fallback if pdfkit not available)
  if (PDFDocument) {
    // Use PDFKit for proper PDF
    const doc = new PDFDocument({ 
      size: 'A4',
      margin: 50,
      info: {
        Title: 'Laporan Pengujian Otomatis - Maw Bouquet',
        Author: 'maw-bucket-js-tests'
      }
    });

    const writeStream = fs.createWriteStream(outputPDF);
    doc.pipe(writeStream);

    // Title
    doc.fontSize(20).font('Helvetica-Bold').text('📋 LAPORAN PENGUJIAN OTOMATIS', { align: 'center' });
    doc.fontSize(14).text('Maw Bouquet - Automation Testing', { align: 'center' });
    doc.moveDown();

    // Summary
    doc.fontSize(12).font('Helvetica');
    doc.text(`Tanggal: ${tanggal}`);
    doc.text(`Total: ${total} test cases`);
    doc.text(`✅ Lulus: ${lulus} (${Math.round((lulus/total)*100)}%)`);
    doc.text(`❌ Gagal: ${gagal}`);
    doc.moveDown();
    doc.moveTo(50, doc.y).lineTo(550, doc.y).stroke();
    doc.moveDown();

    // Modules
    modNum = 1;
    for (const [namaModul, kasus] of Object.entries(modulMap)) {
      const mLulus = kasus.filter(tc => statusTest(tc.id) === 'LULUS').length;
      const mGagal = kasus.length - mLulus;
      
      doc.fontSize(14).font('Helvetica-Bold').text(`📁 MOD-${String(modNum).padStart(2, '0')} ${namaModul}`);
      doc.fontSize(10).font('Helvetica').text(`   Status: ${mLulus} lulus · ${mGagal} gagal`);
      doc.moveDown();

      for (const tc of kasus) {
        const st = statusTest(tc.id);
        const icon = st === 'LULUS' ? '[✓]' : '[✗]';
        doc.fontSize(9).text(`   ${icon} ${tc.id} - ${tc.deskripsi.substring(0, 60)}`);
      }
      doc.moveDown();
      modNum++;
    }

    doc.moveDown();
    doc.fontSize(8).text('Generated by maw-bucket-js-tests', { align: 'center' });
    doc.text(new Date().toISOString(), { align: 'center' });

    doc.end();

    await new Promise((resolve, reject) => {
      writeStream.on('finish', resolve);
      writeStream.on('error', reject);
    });

    console.log(`\n✅ PDF berhasil dibuat: ${outputPDF}`);
    console.log(`   ${testCases.length} test cases, ${Object.keys(screenshotMap).length} screenshots`);
  } else {
    // Fallback: create text file with .txt extension
    const txtFile = outputPDF.replace('.pdf', '.txt');
    fs.writeFileSync(txtFile, content, 'utf8');
    
    // Also create a simple HTML that loads fast
    const simpleHTML = `<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Pengujian - Maw Bouquet</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Segoe UI', Arial, sans-serif; background: #f5f5f5; color: #333; padding: 20px; }
    .container { max-width: 900px; margin: 0 auto; }
    h1 { background: #1a1a2e; color: white; padding: 20px; border-radius: 8px 8px 0 0; text-align: center; }
    .summary { background: white; padding: 20px; border-radius: 0 0 8px 8px; margin-bottom: 20px; display: flex; gap: 15px; flex-wrap: wrap; }
    .stat { background: #f8f9fa; padding: 15px 25px; border-radius: 8px; text-align: center; min-width: 100px; }
    .stat .val { font-size: 2rem; font-weight: bold; }
    .stat .lbl { font-size: 0.75rem; color: #666; }
    .val-total { color: #1a1a2e; }
    .val-lulus { color: #27ae60; }
    .val-gagal { color: #e74c3c; }
    .module { background: white; border-radius: 8px; margin-bottom: 15px; overflow: hidden; }
    .mod-header { background: #1a1a2e; color: white; padding: 12px 20px; display: flex; justify-content: space-between; align-items: center; }
    .mod-title { font-weight: bold; }
    .mod-stat { font-size: 0.8rem; color: #aaa; }
    .mod-stat .ok { color: #2ecc71; }
    .mod-stat .fail { color: #e74c3c; }
    table { width: 100%; border-collapse: collapse; }
    th { background: #f8f9fa; padding: 10px 15px; text-align: left; font-size: 0.75rem; color: #666; text-transform: uppercase; border-bottom: 2px solid #eee; }
    td { padding: 10px 15px; border-bottom: 1px solid #eee; font-size: 0.85rem; }
    tr:hover { background: #fafafa; }
    .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: bold; }
    .badge-lulus { background: #d4f8e8; color: #1a7a45; }
    .badge-gagal { background: #fde8e8; color: #a00; }
    .footer { text-align: center; padding: 20px; font-size: 0.75rem; color: #999; }
    @media (max-width: 600px) { th:nth-child(2), td:nth-child(2) { display: none; } }
  </style>
</head>
<body>
  <div class="container">
    <h1>📋 Laporan Pengujian Otomatis</h1>
    <div class="summary">
      <div class="stat"><div class="val val-total">${total}</div><div class="lbl">Total</div></div>
      <div class="stat"><div class="val val-lulus">${lulus}</div><div class="lbl">Lulus</div></div>
      <div class="stat"><div class="val val-gagal">${gagal}</div><div class="lbl">Gagal</div></div>
    </div>`;

    let modHTML = '';
    modNum = 1;
    for (const [namaModul, kasus] of Object.entries(modulMap)) {
      const mLulus = kasus.filter(tc => statusTest(tc.id) === 'LULUS').length;
      const mGagal = kasus.length - mLulus;
      
      modHTML += `<div class="module">
      <div class="mod-header">
        <span class="mod-title">📁 MOD-${String(modNum).padStart(2, '0')} ${namaModul}</span>
        <span class="mod-stat"><span class="ok">${mLulus} lulus</span> · <span class="fail">${mGagal} gagal</span></span>
      </div>
      <table><thead><tr><th>ID</th><th>Deskripsi</th><th>Status</th></tr></thead><tbody>`;
      
      for (const tc of kasus) {
        const st = statusTest(tc.id);
        const badge = st === 'LULUS' ? 'badge-lulus' : 'badge-gagal';
        const text = st === 'LULUS' ? '✓ Lulus' : '✗ Gagal';
        modHTML += `<tr><td>${tc.id}</td><td>${tc.deskripsi}</td><td><span class="badge ${badge}">${text}</span></td></tr>`;
      }
      
      modHTML += '</tbody></table></div>';
      modNum++;
    }

    const endHTML = `<div class="footer">
      maw-bucket-js-tests · Laporan: ${tanggal}
    </div></div></body></html>`;

    const htmlFile = outputPDF.replace('.pdf', '.html');
    fs.writeFileSync(htmlFile, simpleHTML + modHTML + endHTML, 'utf8');
    
    console.log(`\n✅ Laporan berhasil dibuat!`);
    console.log(`   TXT: ${txtFile} (text version)`);
    console.log(`   HTML: ${htmlFile} (fast loading version)`);
    console.log(`   ${testCases.length} test cases, ${Object.keys(screenshotMap).length} screenshots`);
  }
}

// Run
generatePDF().catch(err => {
  console.error(`❌ Error: ${err.message}`);
  process.exit(1);
});