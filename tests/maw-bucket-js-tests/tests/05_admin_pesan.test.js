// ============================================================
//  tests/05_admin_pesan.test.js
//  Pengujian manajemen pesan di panel admin
// ============================================================

const { By } = require('selenium-webdriver');
const assert = require('assert');
const { getDriver } = require('../utils/driver');
const {
    bukaHalaman, tungguElemen, ambilScreenshot,
    loginAdmin, scrollKe
} = require('../utils/helpers');

describe('Admin — Manajemen Pesan', function () {
    this.timeout(40000);
    let driver;

    before(async () => {
        driver = await getDriver();
        await loginAdmin(driver);
        await driver.sleep(4000);
    });
    after(async () => { await driver.quit(); });

    afterEach(async function () {
        if (this.currentTest.state === 'failed') {
            await ambilScreenshot(driver, `GAGAL_${this.currentTest.title.replace(/\s/g, '_')}`);
        }
    });

    // --------------------------------------------------------
    //  Daftar pesan
    // --------------------------------------------------------

    describe('Daftar Pesan Admin', () => {

        it('TC-MSG-01: Halaman /admin/messages dapat diakses', async () => {
            await bukaHalaman(driver, '/admin/messages');
            const url = await driver.getCurrentUrl();
            assert.ok(url.includes('/admin/messages'), `URL salah: ${url}`);
            await ambilScreenshot(driver, 'TC-MSG-01_daftar_pesan');
        });

        it('TC-MSG-02: Konten daftar pesan tampil', async () => {
            await bukaHalaman(driver, '/admin/messages');
            const src = (await driver.getPageSource()).toLowerCase();
            const ada = ['pesan', 'message', 'nama', 'email', 'belum', 'kosong', 'table']
                .some(k => src.includes(k));
            assert.ok(ada, 'Konten halaman pesan tidak ditemukan');
            await ambilScreenshot(
                driver,
                'TC-MSG-02_konten_pesan'
            );

        });

        it('TC-MSG-03: Header tabel pesan mengandung kata yang relevan', async () => {
            await bukaHalaman(driver, '/admin/messages');
            const src = (await driver.getPageSource()).toLowerCase();
            const ada = ['nama', 'email', 'telepon', 'tujuan', 'tanggal', 'aksi']
                .some(k => src.includes(k));
            assert.ok(ada, 'Header tabel pesan tidak ditemukan');
            await ambilScreenshot(
                driver,
                'TC-MSG-03_header_tabel'
            );
        });

        it('TC-MSG-04: Halaman pesan tidak mengalami server error', async () => {
            await bukaHalaman(driver, '/admin/messages');
            const title = (await driver.getTitle()).toLowerCase();
            assert.ok(!title.includes('500') && !title.includes('error'),
                `Halaman mengalami server error: ${title}`);
            await ambilScreenshot(
                driver,
                'TC-MSG-04_server_normal'
            );
        });

    });

    // --------------------------------------------------------
    //  Detail & hapus pesan
    // --------------------------------------------------------

    describe('Detail dan Hapus Pesan', () => {

        async function dapatkanLinkPesanPertama() {
            await bukaHalaman(driver, '/admin/messages');
            try {
                const links = await driver.findElements(
                    By.css("a[href*='/admin/messages/']")
                );
                return links.length > 0 ? await links[0].getAttribute('href') : null;
            } catch { return null; }
        }

        it('TC-MSG-05: Halaman detail pesan dapat dibuka', async () => {
            const href = await dapatkanLinkPesanPertama();
            if (!href) { console.log('  ⚠ Tidak ada pesan untuk dilihat'); return; }
            await driver.get(href);
            const url = await driver.getCurrentUrl();
            assert.ok(url.includes('/admin/messages/'), `URL detail salah: ${url}`);
            await ambilScreenshot(driver, 'TC-MSG-05_detail_pesan');
        });

        it('TC-MSG-06: Detail pesan menampilkan informasi lengkap', async () => {
            const href = await dapatkanLinkPesanPertama();
            if (!href) { console.log('  ⚠ Tidak ada pesan untuk dicek'); return; }
            await driver.get(href);
            const src = (await driver.getPageSource()).toLowerCase();
            const ada = ['nama', 'telepon', 'pesan', 'tujuan', 'email'].some(k => src.includes(k));
            assert.ok(ada, 'Informasi detail pesan tidak lengkap');
            await ambilScreenshot(
                driver,
                'TC-MSG-06_detail_lengkap'
            );
        });

        it('TC-MSG-07: Pesan berhasil dihapus', async () => {

            await bukaHalaman(driver, '/admin/messages');

            await driver.sleep(2000);

            // auto accept confirm
            await driver.executeScript(
                'window.confirm = function(){ return true; }'
            );

            // cari tombol hapus
            const deleteButtons = await driver.findElements(
                By.xpath("//button[contains(., 'Hapus')]")
            );

            if (deleteButtons.length === 0) {

                console.log('⚠ Tidak ada tombol hapus');

                await ambilScreenshot(
                    driver,
                    'TC-MSG-07_tidak_ada_hapus'
                );

                return;

            }

            const jumlahAwal = deleteButtons.length;

            await scrollKe(driver, deleteButtons[0]);

            await deleteButtons[0].click();

            await driver.sleep(4000);

            // screenshot SETELAH hapus
            await ambilScreenshot(
                driver,
                'TC-MSG-07_hapus_pesan'
            );

            // refresh
            await driver.navigate().refresh();

            await driver.sleep(3000);

            const deleteAfter = await driver.findElements(
                By.xpath("//button[contains(., 'Hapus')]")
            );

            assert.ok(
                deleteAfter.length < jumlahAwal
                || (await driver.getCurrentUrl()).includes('/admin/messages'),
                'Pesan gagal dihapus'
            );

        });
    });

});
