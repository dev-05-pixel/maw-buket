// ============================================================
//  tests/02_form_kontak.test.js
//  Pengujian form kontak: submit valid & validasi field
// ============================================================

const { By } = require('selenium-webdriver');
const assert = require('assert');
const { getDriver } = require('../utils/driver');
const {
    bukaHalaman, tungguElemen, ambilScreenshot,
    isiInput, scrollKe, cekValidHTML5
} = require('../utils/helpers');
const config = require('../config');

// Helper: buka halaman kontak & tunggu field siap
async function bukaKontak(driver) {
    await bukaHalaman(driver, '/contact');
    await tungguElemen(driver, By.id('name'));
}

// Helper: isi seluruh form kontak
async function isiFormLengkap(driver, data = {}) {
    const d = { ...config.CONTACT_DATA, ...data };

    await isiInput(driver, By.id('name'), d.name);
    await isiInput(driver, By.id('phone'), d.phone);
    await isiInput(driver, By.id('email'), d.email || '');

    // Dropdown purpose — pilih opsi pertama yang punya value
    try {
        const sel = await driver.findElement(By.id('purpose'));
        const opts = await sel.findElements(By.css('option'));
        for (const opt of opts) {
            const val = await opt.getAttribute('value');
            if (val && val.trim() !== '') { await opt.click(); break; }
        }
    } catch { /* opsional */ }

    // Radio color_pref — klik yang pertama
    try {
        const radios = await driver.findElements(By.css("input[name='color_pref']"));
        if (radios.length > 0) {
            await driver.executeScript('arguments[0].click();', radios[0]);
        }
    } catch { /* opsional */ }

    await isiInput(driver, By.id('message'), d.message);
}

// ============================================================

describe('Form Kontak', function () {
    this.timeout(120000);
    let driver;

    before(async () => { driver = await getDriver(); });
    after(async () => { await driver.quit(); });

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
    //  Submit valid
    // --------------------------------------------------------

    describe('Submit Form Valid', () => {

        it('TC-KON-01: Halaman /contact dapat diakses', async () => {
            await bukaKontak(driver);
            const url = await driver.getCurrentUrl();
            assert.ok(url.includes('/contact'), `URL salah: ${url}`);
            await ambilScreenshot(driver, 'TC-KON-01_halaman_kontak');
        });


        it('TC-KON-02: Semua field wajib tersedia di form', async () => {

            await bukaKontak(driver);

            // Scroll ke form
            await driver.executeScript(
                "window.scrollBy(0, 700)"
            );

            await driver.sleep(3000);

            const nama = await driver.findElement(By.id('name'));
            const phone = await driver.findElement(By.id('phone'));
            const email = await driver.findElement(By.id('email'));
            const pesan = await driver.findElement(By.id('message'));

            assert.ok(await nama.isDisplayed());
            assert.ok(await phone.isDisplayed());
            assert.ok(await email.isDisplayed());
            assert.ok(await pesan.isDisplayed());

        });

        it('TC-KON-03: Form berhasil dikirim dengan data valid', async () => {
            await bukaKontak(driver);
            await isiFormLengkap(driver);

            const btn = await driver.findElement(By.css("button[type='submit']"));
            await scrollKe(driver, btn);
            await btn.click();

            // Tunggu respons sukses (AJAX atau redirect)
            await driver.sleep(3000);
            const src = (await driver.getPageSource()).toLowerCase();
            const sukses = ['berhasil', 'sukses', 'terima kasih', 'success']
                .some(k => src.includes(k));
            const formSukses = await driver.findElements(By.css('#form-success, .form-success'));
            assert.ok(sukses || formSukses.length > 0, 'Tidak ada indikator keberhasilan form');
            await ambilScreenshot(driver, 'TC-KON-03_form_sukses');
        });

        it('TC-KON-04: Form dapat dikirim tanpa mengisi email (opsional)', async () => {
            await bukaKontak(driver);
            await isiFormLengkap(driver, { email: '' });

            const btn = await driver.findElement(By.css("button[type='submit']"));
            await scrollKe(driver, btn);
            await btn.click();
            await driver.sleep(2000);

            // Tidak boleh ada error yang menyebutkan field email wajib
            const src = (await driver.getPageSource()).toLowerCase();
            const adaErrorEmail = src.includes('email wajib') || src.includes('email required');
            assert.ok(!adaErrorEmail, 'Muncul error email padahal field email opsional');
        });

    });

    // --------------------------------------------------------
    //  Warning field
    // --------------------------------------------------------

    describe('Warning Field Form', () => {


        it('TC-KON-05: Validasi muncul jika nama dikosongkan', async () => {

            await bukaKontak(driver);

            // isi field lain
            await isiInput(
                driver,
                By.id('phone'),
                '08123456789'
            );

            await isiInput(
                driver,
                By.id('email'),
                'test@gmail.com'
            );

            await isiInput(
                driver,
                By.id('message'),
                'Testing validasi nama kosong'
            );

            // submit
            const submitBtn = await driver.findElement(
                By.css("button[type='submit']")
            );

            await scrollKe(driver, submitBtn);

            await submitBtn.click();

            await driver.sleep(2000);

            // ambil validation bawaan HTML5
            const nama = await driver.findElement(
                By.id('name')
            );

            const validasi = await nama.getAttribute(
                'validationMessage'
            );

            assert.ok(
                validasi.length > 0,
                'Validasi nama tidak muncul'
            );

        });

        it('TC-KON-06: Validasi muncul jika telepon dikosongkan', async () => {

            await bukaKontak(driver);

            await isiInput(driver, By.id('name'), 'Testing');
            await isiInput(driver, By.id('email'), 'test@gmail.com');
            await isiInput(driver, By.id('message'), 'Testing pesan');

            // phone kosong

            const submitBtn = await driver.findElement(
                By.css("button[type='submit']")
            );

            await scrollKe(driver, submitBtn);

            await submitBtn.click();

            await driver.sleep(2000);

            await ambilScreenshot(driver, 'TC-KON-06');

            const phone = await driver.findElement(
                By.id('phone')
            );

            const validasi = await phone.getAttribute(
                'validationMessage'
            );

            assert.ok(
                validasi.length > 0,
                'Validasi telepon tidak muncul'
            );

        });

        it('TC-KON-07: Validasi muncul jika pesan dikosongkan', async () => {

            await bukaKontak(driver);

            await isiInput(driver, By.id('name'), 'Testing');
            await isiInput(driver, By.id('phone'), '08123456789');
            await isiInput(driver, By.id('email'), 'test@gmail.com');

            // message kosong

            const submitBtn = await driver.findElement(
                By.css("button[type='submit']")
            );

            await scrollKe(driver, submitBtn);

            await submitBtn.click();

            await driver.sleep(2000);

            await ambilScreenshot(driver, 'TC-KON-07');

            const pesan = await driver.findElement(
                By.id('message')
            );

            const validasi = await pesan.getAttribute(
                'validationMessage'
            );

            assert.ok(
                validasi.length > 0,
                'Validasi pesan tidak muncul'
            );

        });
        it('TC-KON-08: Validasi muncul jika format email salah', async () => {

            await bukaKontak(driver);

            await isiInput(driver, By.id('name'), 'Testing');
            await isiInput(driver, By.id('phone'), '08123456789');

            // email salah
            await isiInput(driver, By.id('email'), 'salah-email');

            await isiInput(driver, By.id('message'), 'Testing pesan');

            const submitBtn = await driver.findElement(
                By.css("button[type='submit']")
            );

            await scrollKe(driver, submitBtn);

            await submitBtn.click();

            await driver.sleep(2000);

            await ambilScreenshot(driver, 'TC-KON-08');

            const email = await driver.findElement(
                By.id('email')
            );

            const validasi = await email.getAttribute(
                'validationMessage'
            );

            assert.ok(
                validasi.length > 0,
                'Validasi email tidak muncul'
            );

        });
        it('TC-KON-09: Validasi muncul jika pesan tidak dapat melebihi 600 karakter', async () => {

            await bukaKontak(driver);

            const pesan = await driver.findElement(
                By.id('message')
            );

            await pesan.sendKeys('A'.repeat(700));

            const value = await pesan.getAttribute('value');

            await ambilScreenshot(driver, 'TC-KON-09');

            assert.ok(
                value.length <= 600,
                'Pesan melebihi batas 600 karakter'
            );

        });
    });

});
