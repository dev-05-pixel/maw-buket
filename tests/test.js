const { Builder } = require('selenium-webdriver');

async function test() {

    const driver = await new Builder()
        .forBrowser('MicrosoftEdge')
        .build();

    try {

        await driver.get('https://google.com');

        console.log('Browser berhasil dibuka');

        await driver.sleep(5000);

    } catch (err) {

        console.log(err);

    } finally {

        await driver.quit();

    }
}

test();
