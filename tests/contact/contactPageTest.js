import { By, until } from "selenium-webdriver";
import assert from "assert";
import fs from "fs";
import path from "path";

import { createDriver } from "../helpers/driver.js";

(async function contactPageTest() {

    const startTime = Date.now();

    const driver = await createDriver();

    // =========================
    // PREPARE RESULT FOLDER
    // =========================
    const resultDir =
        path.resolve("./tests/results");

    const imgDir =
        path.join(resultDir, "img");

    const logDir =
        path.join(resultDir, "logs");

    const reportDir =
        path.join(resultDir, "reports");

    if (!fs.existsSync(resultDir)) {
        fs.mkdirSync(resultDir, {
            recursive: true,
        });
    }

    if (!fs.existsSync(imgDir)) {
        fs.mkdirSync(imgDir, {
            recursive: true,
        });
    }

    if (!fs.existsSync(logDir)) {
        fs.mkdirSync(logDir, {
            recursive: true,
        });
    }

    if (!fs.existsSync(reportDir)) {
        fs.mkdirSync(reportDir, {
            recursive: true,
        });
    }

    const logFile =
        path.join(
            logDir,
            "contactPageTest.log"
        );

    const reportFile =
        path.join(
            reportDir,
            "contactPageReport.html"
        );

    const timestamp =
        Date.now();

    try {

        await driver.get(
            "http://127.0.0.1:8000/contact"
        );

        // =========================
        // WAIT PAGE READY
        // =========================
        await driver.wait(
            async () => {

                const state =
                    await driver.executeScript(
                        "return document.readyState"
                    );

                return state === "complete";

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
            "PAGE TITLE:",
            title
        );

        assert(
            title.includes("Maw Bouquet"),
            "Title halaman contact tidak sesuai",
        );

        // =========================
        // HERO TITLE
        // =========================
        const heroTitle =
            await driver.wait(
                until.elementLocated(
                    By.className("contact-hero-title")
                ),
                10000,
            );

        await driver.wait(
            until.elementIsVisible(heroTitle),
            10000
        );

        assert(
            await heroTitle.isDisplayed(),
            "Hero title contact tidak tampil",
        );

        // =========================
        // CONTACT FORM
        // =========================
        const contactForm =
            await driver.wait(
                until.elementLocated(
                    By.id("contact-form")
                ),
                10000,
            );

        await driver.wait(
            until.elementIsVisible(contactForm),
            10000
        );

        assert(
            await contactForm.isDisplayed(),
            "Form contact tidak tampil",
        );

        // =========================
        // INPUT NAME
        // =========================
        const nameInput =
            await driver.findElement(
                By.id("name")
            );

        await nameInput.sendKeys(
            "Test Selenium"
        );

        const nameValue =
            await nameInput.getAttribute(
                "value"
            );

        assert(
            nameValue === "Test Selenium",
            "Input nama gagal"
        );

        // =========================
        // INPUT PHONE
        // =========================
        const phoneInput =
            await driver.findElement(
                By.id("phone")
            );

        await phoneInput.sendKeys(
            "08123456789"
        );

        const phoneValue =
            await phoneInput.getAttribute(
                "value"
            );

        assert(
            phoneValue === "08123456789",
            "Input phone gagal"
        );

        // =========================
        // INPUT EMAIL
        // =========================
        const emailInput =
            await driver.findElement(
                By.id("email")
            );

        await emailInput.sendKeys(
            "selenium@test.com"
        );

        const emailValue =
            await emailInput.getAttribute(
                "value"
            );

        assert(
            emailValue === "selenium@test.com",
            "Input email gagal"
        );

        // =========================
        // SELECT PURPOSE
        // =========================
        const purposeSelect =
            await driver.findElement(
                By.id("purpose")
            );

        await purposeSelect.sendKeys(
            "Wisuda"
        );

        const purposeValue =
            await purposeSelect.getAttribute(
                "value"
            );

        assert(
            purposeValue.includes("Wisuda"),
            "Select purpose gagal"
        );

        // =========================
        // TEXTAREA MESSAGE
        // =========================
        const messageInput =
            await driver.findElement(
                By.id("message")
            );

        await messageInput.sendKeys(
            "Ini adalah pesan testing selenium."
        );

        const messageValue =
            await messageInput.getAttribute(
                "value"
            );

        assert(
            messageValue.includes(
                "testing selenium"
            ),
            "Textarea message gagal",
        );

        // =========================
        // FAQ SECTION
        // =========================
        const faqButton =
            await driver.wait(
                until.elementLocated(
                    By.className("faq-question")
                ),
                10000,
            );

        await driver.executeScript(
            'arguments[0].scrollIntoView({block: "center"});',
            faqButton,
        );

        await driver.wait(
            until.elementIsVisible(faqButton),
            10000
        );

        assert(
            await faqButton.isDisplayed(),
            "FAQ button tidak tampil",
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
            `contact-success-${timestamp}.png`;

        const successImage =
            await driver.takeScreenshot();

        fs.writeFileSync(
            path.join(
                imgDir,
                successImageName
            ),
            successImage,
            "base64",
        );

        // =========================
        // SAVE SUCCESS LOG
        // =========================
        const successLog = `
[${new Date().toISOString()}]
STATUS : SUCCESS
TEST   : Contact Page Test
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

    <title>Contact Page Test Report</title>

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

    <h1>Contact Page Test Report</h1>

    <table>

        <tr>
            <th>Test Name</th>
            <td>Contact Page Test</td>
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
            "Contact page test passed"
        );

    } catch (err) {

        console.error(
            "Contact page test failed"
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
            `contact-failed-${timestamp}.png`;

        const failedImage =
            await driver.takeScreenshot();

        fs.writeFileSync(
            path.join(
                imgDir,
                failedImageName
            ),
            failedImage,
            "base64",
        );

        // =========================
        // SAVE FAILED LOG
        // =========================
        const failedLog = `
[${new Date().toISOString()}]
STATUS : FAILED
TEST   : Contact Page Test
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

    <title>Contact Page Test Report</title>

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

    <h1>Contact Page Test Report</h1>

    <table>

        <tr>
            <th>Test Name</th>
            <td>Contact Page Test</td>
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
