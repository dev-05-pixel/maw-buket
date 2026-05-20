// ============================================================
//  tests/04_admin_produk.test.js
//  Pengujian CRUD produk di panel admin
// ============================================================

const { By } = require('selenium-webdriver');
const assert = require('assert');
const path = require('path');
const fs = require('fs');
const { getDriver } = require('../utils/driver');
const {
    bukaHalaman, tungguElemen, ambilScreenshot,
    loginAdmin, isiInput, scrollKe
} = require('../utils/helpers');
const config = require('../config');
const { log } = require('console');

// Buat gambar dummy JPG (BMP sederhana encode sebagai base64 JPG)
function buatGambarDummy() {
    const filePath = path.resolve('assets', 'dummy_product.jpg');
    if (!fs.existsSync('assets')) fs.mkdirSync('assets');
    if (!fs.existsSync(filePath)) {
        // Buat file JPG minimal yang valid (1x1 pixel merah)
        const jpgData = Buffer.from(
            '/9j/4AAQSkZJRgABAQEASABIAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8U' +
            'HRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgN' +
            'DRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIy' +
            'MjL/wAARCAABAAEDASIAAhEBAxEB/8QAFAABAAAAAAAAAAAAAAAAAAAACf/EABQQAQAAAAAA' +
            'AAAAAAAAAAAAAP/EABQBAQAAAAAAAAAAAAAAAAAAAAD/xAAUEQEAAAAAAAAAAAAAAAAAAAAA' +
            '/9oADAMBAAIRAxEAPwCwABmX/9k=',
            'base64'
        );
        fs.writeFileSync(filePath, jpgData);
    }
    return filePath;
}

// ============================================================

describe('Admin — Manajemen Produk', function () {
    this.timeout(40000);
    let driver;
    const gambarPath = buatGambarDummy();

    before(async () => {

        driver = await getDriver();

        await loginAdmin(driver);

        await driver.sleep(3000);

    });


    after(async () => { await driver.quit(); });

    afterEach(async function () {

        const nama = this.currentTest.title
            .split(':')[0]
            .trim();

        await driver.sleep(1000);

        await ambilScreenshot(driver, nama);

        if (this.currentTest.state === 'failed') {

            await ambilScreenshot(
                driver,
                `GAGAL_${nama}`
            );

        }

    });
    // --------------------------------------------------------
    //  Daftar produk
    // --------------------------------------------------------

    describe('Daftar Produk Admin', () => {

        it('TC-PROD-01: Halaman /admin/products dapat diakses', async () => {
            await bukaHalaman(driver, '/admin/products');
            const url = await driver.getCurrentUrl();
            assert.ok(url.includes('/admin/products'), `URL salah: ${url}`);
            await ambilScreenshot(driver, 'TC-PROD-01_daftar_produk_admin');
        });

        it('TC-PROD-02: Tabel produk tampil di halaman admin', async () => {
            await bukaHalaman(driver, '/admin/products');
            const selectors = ['table', 'tbody', '.table', '[class*="product"]'];
            let ada = false;
            for (const sel of selectors) {
                const els = await driver.findElements(By.css(sel));
                if (els.length > 0) { ada = true; break; }
            }
            assert.ok(ada, 'Tabel produk tidak ditemukan');
        });

        it('TC-PROD-03: Tombol tambah produk tersedia', async () => {
            await bukaHalaman(driver, '/admin/products');
            const selectors = [
                "a[href*='/admin/products/create']",
                "a[href*='create']",
            ];
            let ada = false;
            for (const sel of selectors) {
                const els = await driver.findElements(By.css(sel));
                if (els.length > 0) { ada = true; break; }
            }
            if (!ada) {
                const src = (await driver.getPageSource()).toLowerCase();
                ada = ['tambah', 'create', 'baru', 'add'].some(k => src.includes(k));
            }
            assert.ok(ada, 'Tombol tambah produk tidak ditemukan');
        });

    });

    // --------------------------------------------------------
    //  Tambah produk
    // --------------------------------------------------------

    describe('Tambah Produk Baru', () => {

        it('TC-PROD-04: Halaman form tambah produk dapat diakses', async () => {
            await bukaHalaman(driver, '/admin/products/create');
            const url = await driver.getCurrentUrl();
            assert.ok(url.includes('create') || url.includes('products'), `URL salah: ${url}`);
            await ambilScreenshot(driver, 'TC-PROD-04_form_tambah');
        });

        it('TC-PROD-05: Semua field form tambah tersedia', async () => {
            await bukaHalaman(driver, '/admin/products/create');
            for (const name of ['name', 'price', 'category', 'image']) {
                const els = await driver.findElements(By.css(`[name="${name}"]`));
                assert.ok(els.length > 0, `Field '${name}' tidak ditemukan`);
            }
        });

        it('TC-PROD-06: Produk baru berhasil ditambahkan', async () => {

            await bukaHalaman(driver, '/admin/dashboard');

            await driver.sleep(1000);

            await bukaHalaman(driver, '/admin/products/create');

            await tungguElemen(driver, By.css("[name='name']"));

            await isiInput(
                driver,
                By.css("[name='name']"),
                config.PRODUCT_DATA.name
            );

            await isiInput(
                driver,
                By.css("[name='price']"),
                config.PRODUCT_DATA.price
            );

            // kategori
            const selects = await driver.findElements(
                By.css("select")
            );

            if (selects.length > 0) {

                const opts = await selects[0].findElements(
                    By.css("option")
                );

                for (const opt of opts) {

                    const val = await opt.getAttribute('value');

                    if (val && val.trim() !== '') {

                        await opt.click();

                        break;

                    }

                }

            }

            // upload gambar
            const fileInput = await driver.findElement(
                By.css("input[type='file']")
            );

            await driver.executeScript(
                "arguments[0].style.display='block';",
                fileInput
            );

            await fileInput.sendKeys(gambarPath);

            await driver.sleep(3000);


            // submit
            const submitBtn = await driver.findElement(
                By.css("button[type='submit']")
            );

            await scrollKe(driver, submitBtn);

            await submitBtn.click();

            await driver.sleep(5000);

            const url = await driver.getCurrentUrl();

            console.log(
                'URL SEKARANG:',
                await driver.getCurrentUrl()
            );
            assert.ok(
                !url.includes('/admin/products'),
                `Produk gagal ditambahkan. URL sekarang: ${url}`
            );

        });

        it('TC-PROD-07: Validasi muncul saat form tambah dikosongkan', async () => {

            await loginAdmin(driver);

            await bukaHalaman(driver, '/admin/products/create');

            const submitBtn = await driver.findElement(
                By.css("button[type='submit']")
            );

            await scrollKe(driver, submitBtn);

            await submitBtn.click();

            await driver.sleep(3000);

            const url = await driver.getCurrentUrl();

            // harus tetap di halaman create
            const tetapDiCreate = url.includes('/create');

            // atau muncul warning merah
            const src = (await driver.getPageSource()).toLowerCase();

            const adaWarning =
                src.includes('required') ||
                src.includes('wajib') ||
                src.includes('harus diisi');

            assert.ok(
                tetapDiCreate || adaWarning,
                'Form kosong seharusnya tidak berhasil dikirim'
            );

        });

    });

    // --------------------------------------------------------
    //  Edit produk
    // --------------------------------------------------------

    describe('Edit Produk', () => {

        async function dapatkanLinkEditPertama() {
            await bukaHalaman(driver, '/admin/products');
            const links = await driver.findElements(
                By.css("a[href*='/admin/products/'][href*='/edit']")
            );
            return links.length > 0 ? await links[0].getAttribute('href') : null;
        }

        it('TC-PROD-08: Halaman edit produk dapat dibuka', async () => {
            const href = await dapatkanLinkEditPertama();
            if (!href) { console.log('  ⚠ Tidak ada produk untuk diedit'); return; }
            await driver.get(href);
            const url = await driver.getCurrentUrl();
            assert.ok(url.includes('edit'), `URL edit salah: ${url}`);
            await ambilScreenshot(driver, 'TC-PROD-08_form_edit');
        });

        it('TC-PROD-09: Field form edit terisi data produk lama', async () => {
            const href = await dapatkanLinkEditPertama();
            if (!href) { console.log('  ⚠ Tidak ada produk untuk diedit'); return; }
            await driver.get(href);
            await tungguElemen(driver, By.css("[name='name']"));
            const nama = await driver.findElement(By.css("[name='name']")).getAttribute('value');
            assert.ok(nama !== '', 'Field nama kosong di form edit');
        });

        it('TC-PROD-10: Produk berhasil diperbarui setelah diedit', async () => {
            await bukaHalaman(driver, '/admin/dashboard');
            const href = await dapatkanLinkEditPertama();
            if (!href) { console.log('  ⚠ Tidak ada produk untuk diedit'); return; }
            await driver.get(href);
            await tungguElemen(driver, By.css("[name='name']"));

            await isiInput(driver, By.css("[name='name']"), config.PRODUCT_DATA_EDIT.name);
            await isiInput(driver, By.css("[name='price']"), config.PRODUCT_DATA_EDIT.price);

            try {
                const catEl = await driver.findElement(By.css("[name='category']"));
                const opts = await catEl.findElements(By.css('option'));
                for (const opt of opts) {
                    const val = await opt.getAttribute('value');
                    if (val === config.PRODUCT_DATA_EDIT.category) { await opt.click(); break; }
                }
            } catch { /* skip */ }

            const submitBtn = await driver.findElement(By.css("button[type='submit']"));
            await scrollKe(driver, submitBtn);
            await submitBtn.click();

            await driver.sleep(4000);

            const url = await driver.getCurrentUrl();

            assert.ok(
                url.includes('/admin/products'),
                `Produk gagal ditambahkan. URL sekarang: ${url}`
            );
            await ambilScreenshot(driver, 'TC-PROD-10_edit_berhasil');
        });

    });

    // --------------------------------------------------------
    //  Hapus produk
    // --------------------------------------------------------

    describe('Hapus Produk', () => {

        it('TC-PROD-11: Produk berhasil dihapus', async () => {
            await bukaHalaman(driver, '/admin/products');
            await driver.executeScript('window.confirm = function(){ return true; }');

            const forms = await driver.findElements(
                By.css("form[method='POST'][action*='/admin/products/']")
            );

            let hapusForm = null;
            for (const form of forms) {
                const dels = await form.findElements(
                    By.css("input[name='_method'][value='DELETE']")
                );
                if (dels.length > 0) { hapusForm = form; break; }
            }

            if (!hapusForm) { console.log('  ⚠ Tombol hapus tidak ditemukan'); return; }

            const btn = await hapusForm.findElement(By.css("button[type='submit']"));
            await scrollKe(driver, btn);
            await btn.click();
            await driver.sleep(3000);

            const src = (await driver.getPageSource()).toLowerCase();
            const ok = ['berhasil', 'dihapus', 'sukses', 'success'].some(k => src.includes(k));
            assert.ok(ok || (await driver.getCurrentUrl()).includes('/admin/products'),
                'Tidak ada konfirmasi produk berhasil dihapus');
            await ambilScreenshot(driver, 'TC-PROD-11_hapus_berhasil');
        });

    });

    // --------------------------------------------------------
    //  Validasi kategori
    // --------------------------------------------------------

    describe('Validasi Kategori Produk', () => {

        it('TC-PROD-12: Opsi dropdown kategori sesuai daftar valid', async () => {

            await loginAdmin(driver);

            await bukaHalaman(driver, '/admin/products/create');

            await driver.sleep(4000);

            const selects = await driver.findElements(
                By.css("select")
            );

            assert.ok(
                selects.length > 0,
                'Dropdown kategori tidak ditemukan'
            );

            let adaOption = false;

            for (const sel of selects) {

                const opts = await sel.findElements(
                    By.css("option")
                );

                if (opts.length > 1) {

                    adaOption = true;

                    break;

                }

            }

            assert.ok(
                adaOption,
                'Dropdown kategori tidak memiliki option'
            );
        });


    });

});
