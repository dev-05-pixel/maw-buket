// ============================================================
//  Pengujian halaman publik: Home, Produk, Detail, AI
// ============================================================

const { By, until }  = require('selenium-webdriver');
const assert         = require('assert');
const { getDriver }  = require('../utils/driver');
const {
  bukaHalaman, tungguElemen, ambilScreenshot, tungguURL
} = require('../utils/helpers');
const config = require('../config');

describe('Halaman Publik', function () {
  this.timeout(30000);
  let driver;

  before(async () => { driver = await getDriver(); });
  after(async  () => { await driver.quit(); });

afterEach(async function () {

  const namaTest = this.currentTest.title
    .split(':')[0]
    .trim();

    await driver.sleep(2000);
  // Screenshot semua testcase
  await ambilScreenshot(driver, namaTest);

  // Tambahan screenshot khusus gagal
  if (this.currentTest.state === 'failed') {

    await ambilScreenshot(
      driver,
      `GAGAL_${namaTest}`
    );

  }

});

  // --------------------------------------------------------
  //  Home
  // --------------------------------------------------------

  describe('Halaman Home', () => {

    it('TC-PUB-01: Halaman home berhasil dimuat', async () => {
      await bukaHalaman(driver, '/');
      const url = await driver.getCurrentUrl();
      // Tunggu 5 detik
      await driver.sleep(10000);
      assert.ok(url.includes('127.0.0.1') || url.includes('localhost'), `URL tidak sesuai: ${url}`);
    //   await ambilScreenshot(driver, 'TC-PUB-01_home');
    });

    it('TC-PUB-02: Judul halaman home mengandung kata kunci brand', async () => {
      await bukaHalaman(driver, '/');
      await driver.sleep(10000);
      const title = (await driver.getTitle()).toLowerCase();
      const valid = ['maw', 'bucket', 'bouquet'].some(k => title.includes(k));
      assert.ok(valid, `Judul tidak relevan: "${title}"`);
    });

    it('TC-PUB-03: Link navigasi ke halaman produk berfungsi', async () => {
      await bukaHalaman(driver, '/');
      await driver.sleep(10000);
      const link = await tungguElemen(driver, By.css("a[href*='/products']"));
      await link.click();
      await tungguURL(driver, '/products');
      const url = await driver.getCurrentUrl();
      assert.ok(url.includes('/products'), `URL tidak mengandung /products: ${url}`);
    });

    it('TC-PUB-04: Link navigasi ke halaman kontak berfungsi', async () => {
      await bukaHalaman(driver, '/');
      await driver.sleep(10000);
      const link = await tungguElemen(driver, By.css("a[href*='/contact']"));
      await link.click();
      await tungguURL(driver, '/contact');
      const url = await driver.getCurrentUrl();
      assert.ok(url.includes('/contact'), `URL tidak mengandung /contact: ${url}`);
    });

  });

  // --------------------------------------------------------
  //  Produk
  // --------------------------------------------------------

  describe('Halaman Daftar Produk', () => {

    it('TC-PUB-05: Halaman /products dapat diakses', async () => {
      await bukaHalaman(driver, '/products');
      await driver.sleep(10000);
      const url = await driver.getCurrentUrl();
      assert.ok(url.includes('/products'), `Gagal membuka /products: ${url}`);
      //   await ambilScreenshot(driver, 'TC-PUB-05_daftar_produk');
    });

    it('TC-PUB-06: Setidaknya ada satu elemen produk tampil', async () => {
      await bukaHalaman(driver, '/products');
      await driver.sleep(10000);
      const selectors = ['article', '.product-card', '.card', "a[href*='/products/']", 'img[alt]'];
      let ditemukan = false;
      for (const sel of selectors) {
        const els = await driver.findElements(By.css(sel));
        if (els.length > 0) { ditemukan = true; break; }
      }
      assert.ok(ditemukan, 'Tidak ada elemen produk yang ditemukan');
    });

    it('TC-PUB-07: Opsi filter/kategori tersedia', async () => {
      await bukaHalaman(driver, '/products');
      await driver.sleep(10000);
      const src = (await driver.getPageSource()).toLowerCase();
      const ada = ['segar', 'kering', 'pampas', 'mini', 'semua', 'all'].some(k => src.includes(k));
      assert.ok(ada, 'Tidak ada elemen filter kategori');
    });

    it('TC-PUB-08: Klik produk membuka halaman detail', async () => {
      await bukaHalaman(driver, '/products');
      await driver.sleep(10000);

const products = await driver.findElements(
  By.css("a[href*='/products/']")
);

assert.ok(products.length > 0, 'Tidak ada link produk');

await driver.sleep(2000);

// klik produk pertama
await driver.executeScript(
  "arguments[0].click();",
  products[0]
);

await driver.wait(async () => {

  const currentUrl = await driver.getCurrentUrl();

  return currentUrl.includes('/products/')
      && !currentUrl.includes('page=');

}, 10000);

      const url = await driver.getCurrentUrl();
      assert.ok(url.includes('/products/'), `URL detail salah: ${url}`);
      await ambilScreenshot(driver, 'TC-PUB-08_detail_produk');
    });


it('TC-PUB-09: Halaman detail menampilkan harga produk', async () => {

    await bukaHalaman(driver, '/products');

    await driver.sleep(3000);

    const products = await driver.findElements(
        By.css("a[href*='/products/']")
    );

    assert.ok(products.length > 0, 'Produk tidak ditemukan');

    // Klik produk pertama
    await driver.executeScript(
        "arguments[0].click();",
        products[0]
    );

    // Tunggu pindah halaman detail
    await driver.wait(async () => {

        const url = await driver.getCurrentUrl();

        return url.includes('/products/')
            && !url.includes('page=');

    }, 10000);

    // Scroll sedikit ke bawah
    await driver.executeScript(
        "window.scrollBy(0, 400)"
    );

    await driver.sleep(3000);

    await driver.wait(
    until.elementLocated(
        By.xpath("//*[contains(text(),'Rp')]")
    ),
    10000
);

    // Cari teks harga
    const harga = await driver.findElement(
        By.xpath("//*[contains(text(),'Rp')]")
    );

    const teksHarga = await harga.getText();

    assert.ok(
        teksHarga.includes('Rp'),
        'Harga produk tidak ditemukan'
    );

});

  });

  // --------------------------------------------------------
  //  AI Rekomendasi
  // --------------------------------------------------------

  describe('Halaman AI Rekomendasi', () => {

    it('TC-PUB-10: Halaman /ai-recommendation dapat diakses', async () => {
      await bukaHalaman(driver, '/ai-recommendation');
      await driver.sleep(10000);
      const title = (await driver.getTitle()).toLowerCase();
      assert.ok(!title.includes('404') && !title.includes('error'), `Halaman error: ${title}`);
      await ambilScreenshot(driver, 'TC-PUB-10_ai_rekomendasi');
    });

  });

});
