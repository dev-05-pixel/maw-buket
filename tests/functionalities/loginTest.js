import { Builder, By } from 'selenium-webdriver';

async function loginTest() {

    const driver = await new Builder()
        .forBrowser('MicrosoftEdge')
        .build();

    try {

        // buka halaman login Laravel
        await driver.get('http://127.0.0.1:8000/login');

        // isi email
        await driver.findElement(By.name('email'))
            .sendKeys('admin@gmail.com');

        // isi password
        await driver.findElement(By.name('password'))
            .sendKeys('password');

        // klik tombol login
        await driver.findElement(By.css('button[type="submit"]'))
            .click();

        // tunggu 3 detik
        await driver.sleep(3000);

        console.log('Login berhasil');

    } catch (err) {

        console.log(err);

    } finally {

        await driver.quit();

    }
}

loginTest();
