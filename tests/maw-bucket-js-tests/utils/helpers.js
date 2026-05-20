// ============================================================
//  utils/helpers.js — Fungsi pembantu pengujian
// ============================================================

const { By, until, Select } = require('selenium-webdriver');
const fs                    = require('fs');
const path                  = require('path');
const config                = require('../config');

// ----------------------------------------------------------
//  Navigasi
// ----------------------------------------------------------

async function bukaHalaman(driver, urlPath = '') {
  await driver.get(`${config.BASE_URL}${urlPath}`);
}

// ----------------------------------------------------------
//  Tunggu elemen
// ----------------------------------------------------------

async function tungguElemen(driver, locator, timeout = config.EXPLICIT_WAIT) {
  return await driver.wait(until.elementLocated(locator), timeout);
}

async function tungguTampil(driver, locator, timeout = config.EXPLICIT_WAIT) {
  const el = await tungguElemen(driver, locator, timeout);
  await driver.wait(until.elementIsVisible(el), timeout);
  return el;
}

async function tungguKlik(driver, locator, timeout = config.EXPLICIT_WAIT) {
  const el = await tungguElemen(driver, locator, timeout);
  await driver.wait(until.elementIsEnabled(el), timeout);
  await el.click();
  return el;
}

async function tungguURL(driver, keyword, timeout = config.EXPLICIT_WAIT) {
  await driver.wait(until.urlContains(keyword), timeout);
}

// ----------------------------------------------------------
//  Interaksi elemen
// ----------------------------------------------------------

async function isiInput(driver, locator, nilai) {
  const el = await tungguElemen(driver, locator);
  await el.clear();
  await el.sendKeys(nilai);
}

async function scrollKe(driver, elemen) {
  await driver.executeScript('arguments[0].scrollIntoView({block:"center"});', elemen);
  await driver.sleep(300);
}

async function elemenAda(driver, locator) {
  try {
    await driver.findElement(locator);
    return true;
  } catch {
    return false;
  }
}

async function ambilTeks(driver, locator) {
  const el = await tungguElemen(driver, locator);
  return await el.getText();
}

// ----------------------------------------------------------
//  Login admin
// ----------------------------------------------------------

async function loginAdmin(driver, email, password) {
  await bukaHalaman(driver, '/admin/login');
  await tungguElemen(driver, By.id('email'));
  await isiInput(driver, By.id('email'), email || config.ADMIN_EMAIL);
  await isiInput(driver, By.id('password'), password || config.ADMIN_PASSWORD);
  await driver.findElement(By.css("button[type='submit']")).click();
}

// ----------------------------------------------------------
//  ✅ SOLUSI: Matikan semua animasi & sembunyikan page-loader
//  Dipanggil sebelum ambil screenshot supaya halaman
//  tidak stuck di loading screen / animasi intro
// ----------------------------------------------------------

async function matikanAnimasi(driver) {
  await driver.executeScript(`
    // 1. Inject CSS: paksa semua animasi & transisi selesai seketika
    const style = document.createElement('style');
    style.id = '__disable-anim__';
    style.textContent = \`
      *, *::before, *::after {
        animation-duration:   0s !important;
        animation-delay:      0s !important;
        transition-duration:  0s !important;
        transition-delay:     0s !important;
      }
    \`;
    if (!document.getElementById('__disable-anim__')) {
      document.head.appendChild(style);
    }

    // 2. Sembunyikan #page-loader (overlay loading Maw Bouquet)
    const loader = document.getElementById('page-loader');
    if (loader) {
      loader.style.display    = 'none';
      loader.style.opacity    = '0';
      loader.style.visibility = 'hidden';
    }

    // 3. Paksa semua elemen .reveal/.hero muncul
    //    (biasanya opacity:0 sampai JS scroll-trigger jalan)
    document.querySelectorAll(
      '.reveal, .reveal-left, .reveal-right, ' +
      '.hero-title-inner, .hero-eyebrow-text, ' +
      '.hero-desc, .hero-actions, .hero-scroll-hint, ' +
      '.hero-img-main, .hero-badge'
    ).forEach(el => {
      el.style.opacity   = '1';
      el.style.transform = 'none';
    });
  `);

  // Jeda singkat agar browser render perubahan sebelum screenshot
  await driver.sleep(300);
}

// ----------------------------------------------------------
//  Screenshot — matikan animasi dulu, baru ambil gambar
// ----------------------------------------------------------

async function ambilScreenshot(driver, namaFile) {
  const folder = path.join('reports', 'screenshots');
  if (!fs.existsSync(folder)) fs.mkdirSync(folder, { recursive: true });

  // ✅ Matikan animasi & loader sebelum screenshot
  await matikanAnimasi(driver);

  const filePath = path.join(folder, `${namaFile}.png`);
  const data     = await driver.takeScreenshot();
  fs.writeFileSync(filePath, data, 'base64');
  return filePath;
}

// ----------------------------------------------------------
//  Cek validasi HTML5
// ----------------------------------------------------------

async function cekValidHTML5(driver, locator) {
  const el    = await driver.findElement(locator);
  const valid = await driver.executeScript('return arguments[0].validity.valid;', el);
  return valid;
}

module.exports = {
  bukaHalaman,
  tungguElemen,
  tungguTampil,
  tungguKlik,
  tungguURL,
  isiInput,
  scrollKe,
  elemenAda,
  ambilTeks,
  loginAdmin,
  ambilScreenshot,
  matikanAnimasi,   // ← export juga kalau mau dipanggil manual di test
  cekValidHTML5,
};
