// ============================================================
//  utils/generatePDF.js
//  Generate PDF test report with screenshots
//  Full version with embedded images for complete documentation
// ============================================================

const fs   = require('fs');
const path = require('path');

// Import PDFKit
const PDFDocument = require('pdfkit');

const screenshotDir = path.join(__dirname, '../reports/screenshots');
const testsDir      = path.join(__dirname, '../tests');
const outputPDF      = path.join(__dirname, '../reports/laporan_pengujian.pdf');

const MODULE_NAMES = {
  '01_halaman_publik.test.js'    : 'Halaman Publik',
  '02_form_kontak.test.js'       : 'Form Kontak',
  '03_admin_auth.test.js'        : 'Admin Autentikasi',
  '04_admin_produk.test.js'      : 'Admin — Manajemen Produk',
  '05_admin_pesan.test.js'       : 'Admin — Manajemen Pesan',
  '06_responsif_navigasi.test.js': 'Responsivitas & Navigasi',
  '07_product_detail.test.js'    : 'Product Detail',
  '08_dashboard_admin.test.js'  : 'Dashboard Admin',
  '09_testimonial_admin.test.js' : 'Testimonial Admin',
  '10_pesan_admin.test.js'       : 'Pesan Admin',
  '11_detail_pesan_admin.test.js': 'Detail Pesan Admin',
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
//  2. BACA SCREENSHOT
// ============================================================
function bacaScreenshots() {
  const map = {};
  if (!fs.existsSync(screenshotDir)) return map;
  
  try {
    const files = fs.readdirSync(screenshotDir);
    for (const file of files) {
      try {
        const ext = path.extname(file).toLowerCase();
        if (!['.png', '.jpg', '.jpeg'].includes(ext)) continue;
        
        const filePath = path.join(screenshotDir, file);
        const stats = fs.statSync(filePath);
        
        // Skip files larger than 1MB
        if (stats.size > 1 * 1024 * 1024) {
          console.log(`⚠️ Skipping large file: ${file} (${(stats.size/1024/1024).toFixed(2)}MB)`);
          continue;
        }
        
        const kunci = path.basename(file, ext).toUpperCase();
        const b64   = fs.readFileSync(filePath).toString('base64');
        map[kunci]  = { b64, file };
      } catch (err) {
        console.log(`⚠️ Error reading ${file}: ${err.message}`);
      }
    }
  } catch (err) {
    console.log(`⚠️ Error reading screenshots: ${err.message}`);
  }
  return map;
}

// ============================================================
//  3. CARI SCREENSHOT UNTUK TC
// ============================================================
function cariScreenshot(id, screenshotMap) {
  const idUpper = id.toUpperCase();
  for (const kunci of Object.keys(screenshotMap)) {
    if (kunci.startsWith(idUpper)) return screenshotMap[kunci];
  }
  return null;
}

// ============================================================
//  4. TENTUKAN STATUS
// ============================================================
const gagalFiles = fs.existsSync(screenshotDir)
  ? fs.readdirSync(screenshotDir).filter(f => f.startsWith('GAGAL_'))
  : [];

function statusTest(id) {
  return gagalFiles.some(f => f.replace('GAGAL_', '').startsWith(id)) ? 'GAGAL' : 'LULUS';
}

// ============================================================
//  5. GENERATE PDF
// ============================================================
async function generatePDF() {
  console.log('📄 Generating PDF Report with Screenshots...\n');
  
  const testCases = bacaSemuaTestCase();
  const screenshotMap = bacaScreenshots();
  
  const total = testCases.length;
  const gagal = testCases.filter(tc => statusTest(tc.id) === 'GAGAL').length;
  const lulus = total - gagal;
  const tanggal = new Date().toLocaleDateString('id-ID', {
    weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
  });

  // Create PDF document
  const doc = new PDFDocument({
    size: 'A4',
    margin: 40,
    info: {
      Title: 'Laporan Pengujian Otomatis - Maw Bouquet',
      Author: 'maw-bucket-js-tests',
      Subject: 'Automation Test Report'
    }
  });

  const writeStream = fs.createWriteStream(outputPDF);
  doc.pipe(writeStream);

  // ==================== COVER PAGE ====================
  doc.rect(0, 0, doc.page.width, doc.page.height).fill('#1a1a2e');
  
  doc.fillColor('white');
  doc.fontSize(32).font('Helvetica-Bold').text('📋', 0, 120, { align: 'center' });
  doc.fontSize(28).text('LAPORAN PENGUJIAN OTOMATIS', 0, 160, { align: 'center' });
  doc.fontSize(18).text('Maw Bouquet', 0, 200, { align: 'center' });
  doc.fontSize(14).text('Automation Testing with Selenium', 0, 225, { align: 'center' });
  
  doc.moveDown(8);
  doc.fontSize(12).text(tanggal, 0, 300, { align: 'center' });
  
  // Summary boxes
  const boxY = 380;
  const boxW = 120;
  const boxH = 80;
  const startX = (doc.page.width - (3 * boxW + 40)) / 2;
  
  // Total box
  doc.fillColor('#34495e').rect(startX, boxY, boxW, boxH).fill();
  doc.fillColor('white').fontSize(28).text(total, startX, boxY + 15, { align: 'center', width: boxW });
  doc.fontSize(10).text('TOTAL', startX, boxY + 55, { align: 'center', width: boxW });
  
  // Lulus box
  doc.fillColor('#27ae60').rect(startX + boxW + 20, boxY, boxW, boxH).fill();
  doc.fillColor('white').fontSize(28).text(lulus, startX + boxW + 20, boxY + 15, { align: 'center', width: boxW });
  doc.fontSize(10).text('LULUS', startX + boxW + 20, boxY + 55, { align: 'center', width: boxW });
  
  // Gagal box
  doc.fillColor('#e74c3c').rect(startX + (boxW + 20) * 2, boxY, boxW, boxH).fill();
  doc.fillColor('white').fontSize(28).text(gagal, startX + (boxW + 20) * 2, boxY + 15, { align: 'center', width: boxW });
  doc.fontSize(10).text('GAGAL', startX + (boxW + 20) * 2, boxY + 55, { align: 'center', width: boxW });
  
  // Percentage
  doc.fillColor('white').fontSize(14).text(
    `Tingkat Kelulusan: ${Math.round((lulus/total)*100)}%`,
    0, boxY + boxH + 30, { align: 'center' }
  );
  
  // Footer
  doc.fontSize(10).text(
    'Generated by maw-bucket-js-tests',
    0, doc.page.height - 60, { align: 'center' }
  );
  doc.text(
    `Report created: ${new Date().toISOString()}`,
    0, doc.page.height - 40, { align: 'center' }
  );

  // ==================== CONTENT PAGES ====================
  
  // Group by module
  const modulMap = {};
  for (const tc of testCases) {
    if (!modulMap[tc.modul]) modulMap[tc.modul] = [];
    modulMap[tc.modul].push(tc);
  }

  let modNum = 1;
  for (const [namaModul, kasus] of Object.entries(modulMap)) {
    const mLulus = kasus.filter(tc => statusTest(tc.id) === 'LULUS').length;
    const mGagal = kasus.length - mLulus;
    
    // New page for each module
    doc.addPage();
    
    // Module header
    doc.fillColor('#1a1a2e').rect(0, 0, doc.page.width, 60).fill();
    doc.fillColor('white').fontSize(18).font('Helvetica-Bold');
    doc.text(`📁 MOD-${String(modNum).padStart(2, '0')} ${namaModul}`, 40, 20);
    
    // Stats
    doc.fontSize(11).font('Helvetica');
    doc.fillColor('#aaa').text(
      `${mLulus} lulus · ${mGagal} gagal · ${kasus.length} total`,
      doc.page.width - 180, 22
    );
    
    doc.moveDown(2);
    doc.fillColor('#333');
    
    let yPos = 80;
    const maxY = doc.page.height - 80;
    const rowHeight = 75;
    
    for (const tc of kasus) {
      const st = statusTest(tc.id);
      const screenshot = cariScreenshot(tc.id, screenshotMap);
      
      // Check if we need a new page
      if (yPos + rowHeight > maxY) {
        doc.addPage();
        yPos = 40;
      }
      
      // Status indicator
      const statusColor = st === 'LULUS' ? '#27ae60' : '#e74c3c';
      doc.fillColor(statusColor).rect(40, yPos, 8, rowHeight - 10).fill();
      
      // Test info
      doc.fillColor('#333').fontSize(10).font('Helvetica-Bold');
      doc.text(tc.id, 60, yPos);
      
      doc.fontSize(9).font('Helvetica');
      doc.text(tc.deskripsi.substring(0, 50), 60, yPos + 15, { width: 280 });
      
      // Status text
      doc.fillColor(statusColor).fontSize(9).font('Helvetica-Bold');
      doc.text(st, 60, yPos + rowHeight - 25);
      
      // Screenshot
      if (screenshot && screenshot.b64) {
        try {
          const imgBuffer = Buffer.from(screenshot.b64, 'base64');
          const imgWidth = 130;
          const imgHeight = 60;
          
          // Position screenshot on right side
          const imgX = doc.page.width - imgWidth - 40;
          
          doc.image(imgBuffer, imgX, yPos + 5, {
            fit: [imgWidth, imgHeight],
            align: 'center',
            valign: 'center'
          });
        } catch (err) {
          // Draw placeholder if image fails
          doc.fillColor('#f0f0f0').rect(doc.page.width - 170, yPos + 5, 130, 60).fill();
          doc.fillColor('#999').fontSize(8).text('Image error', doc.page.width - 165, yPos + 30);
        }
      } else {
        // No screenshot placeholder
        doc.fillColor('#f8f9fa').rect(doc.page.width - 170, yPos + 5, 130, 60).fill();
        doc.fillColor('#bbb').fontSize(8).text('No screenshot', doc.page.width - 160, yPos + 30);
      }
      
      // Separator line
      doc.strokeColor('#eee').lineWidth(0.5);
      doc.moveTo(40, yPos + rowHeight - 5).lineTo(doc.page.width - 40, yPos + rowHeight - 5).stroke();
      
      yPos += rowHeight;
    }
    
    modNum++;
  }

  // Final page - Summary
  doc.addPage();
  doc.fillColor('#1a1a2e').rect(0, 0, doc.page.width, 60).fill();
  doc.fillColor('white').fontSize(18).font('Helvetica-Bold').text('📊 RINGKASAN HASIL PENGUJIAN', 40, 20);
  
  doc.moveDown(4);
  doc.fillColor('#333');
  doc.fontSize(12);
  
  let summaryY = 100;
  for (const [namaModul, kasus] of Object.entries(modulMap)) {
    const mLulus = kasus.filter(tc => statusTest(tc.id) === 'LULUS').length;
    const mGagal = kasus.length - mLulus;
    const pct = Math.round((mLulus / kasus.length) * 100);
    
    doc.font('Helvetica-Bold').text(`${namaModul}`, 50, summaryY);
    doc.font('Helvetica').text(`${mLulus}/${kasus.length} (${pct}%)`, doc.page.width - 100, summaryY);
    summaryY += 25;
    
    if (summaryY > doc.page.height - 100) {
      doc.addPage();
      summaryY = 50;
    }
  }
  
  // Footer
  doc.fontSize(10).fillColor('#999').text(
    'Generated by maw-bucket-js-tests · ' + new Date().toISOString(),
    0, doc.page.height - 40, { align: 'center' }
  );

  // End document
  doc.end();

  // Wait for write to complete
  await new Promise((resolve, reject) => {
    writeStream.on('finish', resolve);
    writeStream.on('error', reject);
  });

  console.log(`\n✅ PDF berhasil dibuat: ${outputPDF}`);
  console.log(`   Total: ${total} test cases`);
  console.log(`   Screenshots: ${Object.keys(screenshotMap).length}`);
  console.log(`   Lulus: ${lulus} | Gagal: ${gagal}`);
}

// Run
generatePDF().catch(err => {
  console.error(`\n❌ Error: ${err.message}`);
  console.error(err.stack);
  process.exit(1);
});