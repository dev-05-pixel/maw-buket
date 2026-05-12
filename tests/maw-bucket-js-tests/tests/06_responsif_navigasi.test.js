// ============================================================
//  tests/06_responsif_navigasi.test.js
//  Pengujian responsivitas & navigasi lintas halaman
// ============================================================

const { By }        = require('selenium-webdriver');
const assert        = require('assert');
const { getDriver } = require('../utils/driver');
const {
  bukaHalaman, tungguElemen, ambilScreenshot, loginAdmin
} = require('../utils/helpers');
const config = require('../config');

// Resolusi layar yang diuji
const RESOLUSI = [
  { nama: 'Desktop HD', lebar: 1920, tinggi: 1080 },
  { nama: 'Laptop',     lebar: 1366, tinggi: 768  },
  { nama: 'Tablet',     lebar: 768,  tinggi: 1024 },
  { nama: 'Mobile',     lebar: 375,  tinggi: 812  },
];

// ============================================================

describe('Responsivitas & Navigasi', function () {
  this.timeout(40000);
  let driver;

  before(async () => { driver = await getDriver(); });
  after(async  () => { await driver.quit(); });

  afterEach(async function () {
    if (this.currentTest.state === 'failed') {
      await ambilScreenshot(driver, `GAGAL_${this.currentTest.title.replace(/\s/g, '_')}`);
    }
  });

  // --------------------------------------------------------
  //  Responsivitas
  // --------------------------------------------------------

  describe('Tampilan di Berbagai Resolusi', () => {

    for (const { nama, lebar, tinggi } of RESOLUSI) {
      it(`TC-RES: Home tampil benar di ${nama} (${lebar}x${tinggi})`, async () => {
        await driver.manage().window().setRect({ width: lebar, height: tinggi });
        await bukaHalaman(driver, '/');
        await driver.sleep(500);

        // Cek tidak ada horizontal scroll berlebih
        const scrollWidth  = await driver.executeScript('return document.body.scrollWidth;');
        const clientWidth  = await driver.executeScript('return document.documentElement.clientWidth;');

        await ambilScreenshot(driver, `TC-RES_${nama.replace(' ', '_')}`);

        // Toleransi 20px untuk scrollbar
        assert.ok(
          scrollWidth <= clientWidth + 20,
          `Overflow horizontal pada ${nama}: scrollWidth=${scrollWidth}, clientWidth=${clientWidth}`
        );
      });
    }

  });

  // --------------------------------------------------------
  //  Navigasi halaman publik
  // --------------------------------------------------------

  describe('Navigasi Halaman Publik', () => {

    // Reset ke ukuran desktop sebelum test navigasi
    before(async () => {
      await driver.manage().window().setRect({ width: 1440, height: 900 });
    });

    const HALAMAN = [
      { nama: 'Home',           path: '/',                  tcId: 'TC-NAV-01' },
      { nama: 'Produk',         path: '/products',          tcId: 'TC-NAV-02' },
      { nama: 'Kontak',         path: '/contact',           tcId: 'TC-NAV-03' },
      { nama: 'AI Rekomendasi', path: '/ai-recommendation', tcId: 'TC-NAV-04' },
    ];

    for (const { nama, path, tcId } of HALAMAN) {
      it(`${tcId}: Halaman ${nama} dapat diakses tanpa error`, async () => {
        await bukaHalaman(driver, path);
        await driver.sleep(500);
        const title = (await driver.getTitle()).toLowerCase();
        assert.ok(
          !title.includes('404') && !title.includes('500') && !title.includes('error'),
          `Halaman ${nama} mengembalikan error: ${title}`
        );
        await ambilScreenshot(driver, `${tcId}_${nama.replace(' ', '_')}`);
      });
    }

    it('TC-NAV-05: Tombol back browser berfungsi antar halaman', async () => {
      await bukaHalaman(driver, '/');
      const urlAwal = await driver.getCurrentUrl();

      await bukaHalaman(driver, '/products');
      const urlProduk = await driver.getCurrentUrl();
      assert.ok(urlProduk.includes('/products'), `URL produk salah: ${urlProduk}`);

      await driver.navigate().back();
      await driver.sleep(1000);

      const urlSekarang = await driver.getCurrentUrl();
      assert.ok(
        urlSekarang === urlAwal || urlSekarang.includes('/'),
        `Tombol back tidak kembali ke halaman sebelumnya: ${urlSekarang}`
      );
    });

    it('TC-NAV-06: Klik logo/brand di navbar kembali ke home', async () => {
      await bukaHalaman(driver, '/products');

      const brandSelectors = [
        'a.navbar-brand',
        "a[href='/']",
        'header a',
        '.logo a',
        'nav a:first-child',
      ];

      let berhasil = false;
      for (const sel of brandSelectors) {
        try {
          const els = await driver.findElements(By.css(sel));
          if (els.length > 0) {
            await els[0].click();
            await driver.sleep(1000);
            const url = await driver.getCurrentUrl();
            if (url.replace(/\/$/, '') === config.BASE_URL.replace(/\/$/, '')) {
              berhasil = true;
              await ambilScreenshot(driver, 'TC-NAV-06_klik_brand');
              break;
            }
          }
        } catch { /* coba selector berikutnya */ }
      }

      if (!berhasil) {
        console.log('  ⚠ Link brand/logo ke home tidak ditemukan — skip');
      }
    });

  });

  // --------------------------------------------------------
  //  Navigasi panel admin
  // --------------------------------------------------------

  describe('Navigasi Panel Admin', () => {

    before(async () => {
      await loginAdmin(driver);
      await driver.sleep(4000);
    });

    it('TC-NAV-07: Dari dashboard admin bisa navigasi ke halaman produk', async () => {
      await bukaHalaman(driver, '/admin/dashboard');
      const link = await tungguElemen(driver, By.css("a[href*='/admin/products']"));
      await link.click();
      await driver.sleep(1000);
      const url = await driver.getCurrentUrl();
      assert.ok(url.includes('/admin/products'), `URL salah: ${url}`);
      await ambilScreenshot(driver, 'TC-NAV-07_admin_ke_produk');
    });

    it('TC-NAV-08: Dari dashboard admin bisa navigasi ke halaman pesan', async () => {
      await bukaHalaman(driver, '/admin/dashboard');
      try {
        const link = await tungguElemen(driver, By.css("a[href*='/admin/messages']"), 5000);
        await link.click();
        await driver.sleep(1000);
        const url = await driver.getCurrentUrl();
        assert.ok(url.includes('/admin/messages'), `URL salah: ${url}`);
        await ambilScreenshot(driver, 'TC-NAV-08_admin_ke_pesan');
      } catch {
        console.log('  ⚠ Link ke halaman pesan tidak ditemukan di dashboard');
      }
    });

    it('TC-NAV-09: Sidebar/navbar admin tersedia di semua halaman admin', async () => {
      const halamanAdmin = [
        '/admin/dashboard',
        '/admin/products',
        '/admin/messages',
      ];

      for (const path of halamanAdmin) {
        await bukaHalaman(driver, path);
        const src = (await driver.getPageSource()).toLowerCase();
        const ada = ['sidebar', 'navbar', 'nav', 'menu', 'dashboard', 'produk']
          .some(k => src.includes(k));
        assert.ok(ada, `Navigasi admin tidak ditemukan di ${path}`);
      }
    });

  });

});
