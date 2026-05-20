import { By, until } from 'selenium-webdriver';
import assert from 'assert';
import fs from 'fs';
import path from 'path';

import { createDriver } from '../helpers/driver.js';

(async function productsPageTest() {

    const startTime = Date.now();

    const driver = await createDriver();

    // =========================
    // PREPARE RESULT FOLDER
    // =========================
    const resultDir =
        path.resolve('./tests/results');

    const imgDir =
        path.join(resultDir, 'img');

    const logDir =
        path.join(resultDir, 'logs');

    const reportDir =
        path.join(resultDir, 'reports');

    if (!fs.existsSync(resultDir)) {
        fs.mkdirSync(resultDir, {
            recursive: true
        });
    }

    if (!fs.existsSync(imgDir)) {
        fs.mkdirSync(imgDir, {
            recursive: true
        });
    }

    if (!fs.existsSync(logDir)) {
        fs.mkdirSync(logDir, {
            recursive: true
        });
    }

    if (!fs.existsSync(reportDir)) {
        fs.mkdirSync(reportDir, {
            recursive: true
        });
    }

    const logFile =
        path.join(
            logDir,
            'productsPageTest.log'
        );

    const reportFile =
        path.join(
            reportDir,
            'productsPageReport.html'
        );

    const timestamp =
        Date.now();

    try {

        await driver.get(
            'http://127.0.0.1:8000/products'
        );

        // =========================
        // WAIT PAGE READY
        // =========================
        await driver.wait(
            async () => {

                const state =
                    await driver.executeScript(
                        'return document.readyState'
                    );

                return state === 'complete';

            },
            10000
        );

        // =========================
        // EXTRA WAIT
        // =========================
        await driver.sleep(3000);

        // =========================
        // PAGE TITLE
        // =========================
        const title =
            await driver.getTitle();

        console.log(
            'PAGE TITLE:',
            title
        );

        assert(
            title.includes('Maw Bouquet'),
            'Title halaman products tidak sesuai'
        );

        // =========================
        // HERO TITLE
        // =========================
        const heroTitle =
            await driver.wait(
                until.elementLocated(
                    By.className('page-hero-title')
                ),
                10000
            );

        await driver.wait(
            until.elementIsVisible(heroTitle),
            10000
        );

        assert(
            await heroTitle.isDisplayed(),
            'Hero title products tidak tampil'
        );

        // =========================
        // FILTER BAR
        // =========================
        const filterBar =
            await driver.wait(
                until.elementLocated(
                    By.className('filter-bar')
                ),
                10000
            );

        assert(
            await filterBar.isDisplayed(),
            'Filter bar tidak tampil'
        );

        // =========================
        // SEARCH INPUT
        // =========================
        const searchInput =
            await driver.wait(
                until.elementLocated(
                    By.css('.catalog-search-wrap input')
                ),
                10000
            );

        assert(
            await searchInput.isDisplayed(),
            'Search input tidak tampil'
        );

        // =========================
        // PRODUCT LISTING
        // =========================
        const productsListing =
            await driver.wait(
                until.elementLocated(
                    By.id('products-listing')
                ),
                10000
            );

        assert(
            await productsListing.isDisplayed(),
            'Products listing tidak tampil'
        );

        // =========================
        // CHECK PRODUCT / EMPTY STATE
        // =========================
        const productCards =
            await driver.findElements(
                By.className('product-card')
            );

        const emptyState =
            await driver.findElements(
                By.className('empty-products-state')
            );

        assert(
            productCards.length > 0 ||
            emptyState.length > 0,
            'Tidak ada product card maupun empty state'
        );

        // =========================
        // VIEW TOGGLE BUTTON
        // =========================
        const gridViewBtn =
            await driver.wait(
                until.elementLocated(
                    By.id('grid-view-btn')
                ),
                10000
            );

        assert(
            await gridViewBtn.isDisplayed(),
            'Grid view button tidak tampil'
        );

        // =========================
        // TEST SEARCH INPUT
        // =========================
        await searchInput.clear();

        await searchInput.sendKeys(
            'Rose'
        );

        const searchValue =
            await searchInput.getAttribute(
                'value'
            );

        assert.strictEqual(
            searchValue,
            'Rose',
            'Input search gagal'
        );

        // =========================
        // SCROLL PRODUCT AREA
        // =========================
        await driver.executeScript(
            'arguments[0].scrollIntoView({block: "center"});',
            productsListing
        );

        // =========================
        // EXECUTION TIME
        // =========================
        const endTime =
            Date.now();

        const executionTime =
            (
                (endTime - startTime) / 1000
            ).toFixed(2);

        // =========================
        // SAVE SUCCESS IMAGE
        // =========================
        const successImageName =
            `products-success-${timestamp}.png`;

        const successImage =
            await driver.takeScreenshot();

        fs.writeFileSync(
            path.join(
                imgDir,
                successImageName
            ),
            successImage,
            'base64'
        );

        // =========================
        // SAVE SUCCESS LOG
        // =========================
        const successLog = `
[${new Date().toISOString()}]
STATUS : SUCCESS
TEST   : Products Page Test
TITLE  : ${title}
TIME   : ${executionTime} Seconds

`;

        fs.appendFileSync(
            logFile,
            successLog
        );

        // =========================
        // HTML REPORT
        // =========================
        const htmlReport = `
<!DOCTYPE html>
<html>

<head>

    <title>Products Page Test Report</title>

    <style>

        body{
            font-family: Arial;
            background:#f5f5f5;
            padding:40px;
        }

        h1{
            margin-bottom:30px;
        }

        table{
            width:100%;
            border-collapse:collapse;
            background:white;
        }

        th, td{
            border:1px solid #ddd;
            padding:14px;
            text-align:left;
        }

        th{
            width:250px;
            background:#222;
            color:white;
        }

        .pass{
            color:green;
            font-weight:bold;
        }

        .fail{
            color:red;
            font-weight:bold;
        }

        img{
            width:100%;
            max-width:1000px;
            margin-top:20px;
            border-radius:10px;
            border:1px solid #ccc;
        }

    </style>

</head>

<body>

    <h1>Products Page Test Report</h1>

    <table>

        <tr>
            <th>Test Name</th>
            <td>Products Page Test</td>
        </tr>

        <tr>
            <th>Status</th>
            <td class="pass">PASS</td>
        </tr>

        <tr>
            <th>Page Title</th>
            <td>${title}</td>
        </tr>

        <tr>
            <th>Total Product Card</th>
            <td>${productCards.length}</td>
        </tr>

        <tr>
            <th>Execution Time</th>
            <td>${executionTime} Seconds</td>
        </tr>

        <tr>
            <th>Execution Date</th>
            <td>${new Date().toLocaleString()}</td>
        </tr>

    </table>

    <h2>Screenshot Result</h2>

    <img src="../img/${successImageName}" />

</body>

</html>
`;

        fs.writeFileSync(
            reportFile,
            htmlReport
        );

        console.log(
            'Products page test passed'
        );

    } catch (err) {

        console.error(
            'Products page test failed'
        );

        console.error(err);

        // =========================
        // EXECUTION TIME
        // =========================
        const endTime =
            Date.now();

        const executionTime =
            (
                (endTime - startTime) / 1000
            ).toFixed(2);

        // =========================
        // SAVE FAILED IMAGE
        // =========================
        const failedImageName =
            `products-failed-${timestamp}.png`;

        const failedImage =
            await driver.takeScreenshot();

        fs.writeFileSync(
            path.join(
                imgDir,
                failedImageName
            ),
            failedImage,
            'base64'
        );

        // =========================
        // SAVE FAILED LOG
        // =========================
        const failedLog = `
[${new Date().toISOString()}]
STATUS : FAILED
TEST   : Products Page Test
ERROR  : ${err.message}
TIME   : ${executionTime} Seconds

`;

        fs.appendFileSync(
            logFile,
            failedLog
        );

        // =========================
        // HTML FAILED REPORT
        // =========================
        const htmlReport = `
<!DOCTYPE html>
<html>

<head>

    <title>Products Page Test Report</title>

    <style>

        body{
            font-family: Arial;
            background:#f5f5f5;
            padding:40px;
        }

        table{
            width:100%;
            border-collapse:collapse;
            background:white;
        }

        th, td{
            border:1px solid #ddd;
            padding:14px;
            text-align:left;
        }

        th{
            width:250px;
            background:#222;
            color:white;
        }

        .fail{
            color:red;
            font-weight:bold;
        }

        img{
            width:100%;
            max-width:1000px;
            margin-top:20px;
            border-radius:10px;
            border:1px solid #ccc;
        }

    </style>

</head>

<body>

    <h1>Products Page Test Report</h1>

    <table>

        <tr>
            <th>Test Name</th>
            <td>Products Page Test</td>
        </tr>

        <tr>
            <th>Status</th>
            <td class="fail">FAILED</td>
        </tr>

        <tr>
            <th>Error</th>
            <td>${err.message}</td>
        </tr>

        <tr>
            <th>Execution Time</th>
            <td>${executionTime} Seconds</td>
        </tr>

        <tr>
            <th>Execution Date</th>
            <td>${new Date().toLocaleString()}</td>
        </tr>

    </table>

    <h2>Failed Screenshot</h2>

    <img src="../img/${failedImageName}" />

</body>

</html>
`;

        fs.writeFileSync(
            reportFile,
            htmlReport
        );

    } finally {

        await driver.quit();

    }

})();
