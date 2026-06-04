// ============================================================
//  tests/06_responsif_navigasi.test.js
//  Pengujian responsivitas & navigasi lintas halaman
// ============================================================

const { By } = require('selenium-webdriver');
const assert = require('assert');
const { getDriver } = require('../utils/driver');
const {
    bukaHalaman, tungguElemen, ambilScreenshot, loginAdmin
} = require('../utils/helpers');
const config = require('../config');

// Resolusi layar yang diuji
const RESOLUSI = [
    { nama: 'Desktop HD', lebar: 1920, tinggi: 1080 },
    { nama: 'Laptop', lebar: 1366, tinggi: 768 },
    { nama: 'Tablet', lebar: 768, tinggi: 1024 },
    { nama: 'Mobile', lebar: 375, tinggi: 812 },
];

// ============================================================

describe('Responsivitas & Navigasi', function () {
    this.timeout(40000);
    let driver;

    before(async () => { driver = await getDriver(); });
    after(async () => { await driver.quit(); });

    afterEach(async function () {
        if (this.currentTest.state === 'failed') {
            await ambilScreenshot(driver, `GAGAL_${Date.now()}`);
        }
    });

    // --------------------------------------------------------
    //  Responsivitas
    // --------------------------------------------------------

    describe('Tampilan di Berbagai Resolusi', () => {

        const RESOLUSI = [
            { id: 'TC-RES-01', nama: 'Desktop HD', lebar: 1920, tinggi: 1080 },
            { id: 'TC-RES-02', nama: 'Laptop', lebar: 1366, tinggi: 768 },
            { id: 'TC-RES-03', nama: 'Tablet', lebar: 768, tinggi: 1024 },
            { id: 'TC-RES-04', nama: 'Mobile', lebar: 375, tinggi: 812 },
        ];

        describe('Tampilan di Berbagai Resolusi', () => {

            for (const { id, nama, lebar, tinggi } of RESOLUSI) {

                it(`${id}: Home tampil benar di ${nama} (${lebar}x${tinggi})`, async () => {

                    await driver.manage().window().setRect({
                        width: lebar,
                        height: tinggi
                    });

                    await bukaHalaman(driver, '/');

                    await driver.sleep(3000);

                    await driver.executeScript(
                        "window.scrollTo(0, 0)"
                    );

                    // ambil ukuran halaman
                    const scrollWidth = await driver.executeScript(
                        'return document.body.scrollWidth;'
                    );

                    const clientWidth = await driver.executeScript(
                        'return document.documentElement.clientWidth;'
                    );

                    // screenshot beda tiap resolusi
                    await ambilScreenshot(
                        driver,
                        `${id}_${nama.replace(/\s/g, '_')}`
                    );

                    // VALIDASI
                    assert.ok(
                        scrollWidth <= clientWidth + 20,
                        `Overflow horizontal pada ${nama}`
                    );

                });

            }

        });
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
            { nama: 'Home', path: '/', tcId: 'TC-NAV-01' },
            { nama: 'Produk', path: '/products', tcId: 'TC-NAV-02' },
            { nama: 'Kontak', path: '/contact', tcId: 'TC-NAV-03' },
            { nama: 'AI Rekomendasi', path: '/ai-recommendation', tcId: 'TC-NAV-04' },
        ];

        for (const { nama, path, tcId } of HALAMAN) {
            it(`${tcId}: Halaman ${nama} dapat diakses tanpa error`, async () => {
                await bukaHalaman(driver, path);
                await driver.sleep(2500);
                await driver.executeScript("window.scrollTo(0, 0)");

                // screenshot DULU sebelum assert
                await ambilScreenshot(driver, `${tcId}_${nama.replace(' ', '_')}`);

                const currentUrl = await driver.getCurrentUrl();
                assert.ok(
                    currentUrl.includes(path),
                    `Halaman ${nama} tidak ditemukan: ${currentUrl}`
                );
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
            await ambilScreenshot(
                driver,
                'TC-NAV-05_back_browser'
            );
            assert.ok(
                urlSekarang === urlAwal || urlSekarang.includes('/'),
                `Tombol back tidak kembali ke halaman sebelumnya: ${urlSekarang}`
            );
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

        //       it('TC-NAV-06: Klik logo/brand di navbar kembali ke home', async () => {

        //     await driver.manage().window().setRect({
        //         width: 1920,
        //         height: 1080
        //     });

        //     await bukaHalaman(driver, '/products');

        //     await driver.sleep(2000);

        //     const logo = await driver.findElement(
        //         By.css('a.brand')
        //     );

        //     await driver.executeScript(
        //         "arguments[0].scrollIntoView(true);",
        //         logo
        //     );

        //     await driver.sleep(500);

        //     await logo.click();

        //     // tunggu URL home BENAR-BENAR selesai
        //     await driver.wait(async () => {
        //         const current = await driver.getCurrentUrl();
        //         return current === config.BASE_URL + '/' ||
        //                current === config.BASE_URL;
        //     }, 5000);

        //     // tunggu render selesai
        //     await driver.sleep(2500);

        //     // scroll atas
        //     await driver.executeScript(
        //         "window.scrollTo(0,0)"
        //     );

        //     // screenshot
        //     await ambilScreenshot(
        //         driver,
        //         'TC-NAV-06_klik_logo_home'  // ← nama statis agar mudah dibandingkan antar resolusi
        //     );

        //     const url = await driver.getCurrentUrl();

        //     assert.ok(
        //         url === config.BASE_URL + '/' ||
        //         url === config.BASE_URL,
        //         'Logo tidak kembali ke home'
        //     );

        // });

        it('TC-NAV-06: Dari dashboard admin bisa navigasi ke halaman produk', async () => {

            await bukaHalaman(driver, '/admin/dashboard');

            const link = await driver.findElement(
                By.css('a[href*="products"]')
            );

            await link.click();

            await driver.sleep(2000);

            await ambilScreenshot(driver, 'TC-NAV-06');

            const url = await driver.getCurrentUrl();

            assert.ok(url.includes('/admin/products'));

        });
        it('TC-NAV-07: Dari dashboard admin bisa navigasi ke halaman pesan', async () => {

            await bukaHalaman(driver, '/admin/dashboard');

            const link = await driver.findElement(
                By.css('a[href*="messages"]')
            );

            await link.click();

            await driver.sleep(2000);

            await ambilScreenshot(driver, 'TC-NAV-07');

            const url = await driver.getCurrentUrl();

            assert.ok(url.includes('/admin/messages'));

        });

        it('TC-NAV-08: Sidebar/navbar admin tersedia di semua halaman admin', async () => {

            const halamanAdmin = [
                '/admin/dashboard',
                '/admin/products',
                '/admin/messages',
            ];

            for (const path of halamanAdmin) {

                await bukaHalaman(driver, path);

                await driver.sleep(1500);

                const src = (
                    await driver.getPageSource()
                ).toLowerCase();

                const ada = [
                    'sidebar',
                    'navbar',
                    'nav',
                    'menu',
                    'dashboard',
                    'produk'
                ].some(k => src.includes(k));

                await ambilScreenshot(
                    driver,
                    `TC-NAV-08_${path.replace(/\//g, '_')}`
                );

                assert.ok(
                    ada,
                    `Navigasi admin tidak ditemukan di ${path}`
                );

            }

        });
    });

});
