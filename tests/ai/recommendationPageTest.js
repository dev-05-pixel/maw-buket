import { By, until } from "selenium-webdriver";
import assert from "assert";
import fs from "fs";
import path from "path";

import { createDriver } from "../helpers/driver.js";

(async function aiRecommendationPageTest() {
    const driver = await createDriver();

    // =========================================================
    // PREPARE RESULTS FOLDER
    // =========================================================
    const imgDir = path.resolve("./tests/results/img");

    const logDir = path.resolve("./tests/results/logs");

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

    const logFile = path.join(
        logDir,
        "aiRecommendationPageTest.log",
    );

    try {
        // =========================================================
        // OPEN PAGE
        // =========================================================
        await driver.get(
            "http://127.0.0.1:8000/ai-recommendation",
        );

        // =========================================================
        // WAIT PAGE READY
        // =========================================================
        await driver.wait(async () => {
            const state = await driver.executeScript(
                "return document.readyState",
            );

            return state === "complete";
        }, 10000);

        // =========================================================
        // PAGE TITLE
        // =========================================================
        const title = await driver.getTitle();

        console.log("PAGE TITLE:", title);

        assert(
            title.includes("Maw Bouquet"),
            "Title halaman AI recommendation tidak sesuai",
        );

        // =========================================================
        // HERO SECTION
        // =========================================================
        const hero = await driver.wait(
            until.elementLocated(
                By.className("ai-hero"),
            ),
            10000,
        );

        await driver.wait(
            until.elementIsVisible(hero),
            10000,
        );

        assert(
            await hero.isDisplayed(),
            "Hero section tidak tampil",
        );

        // =========================================================
        // HERO TITLE
        // =========================================================
        const heroTitle = await driver.wait(
            until.elementLocated(
                By.className("ai-hero-title"),
            ),
            10000,
        );

        assert(
            await heroTitle.isDisplayed(),
            "Hero title tidak tampil",
        );

        // =========================================================
        // FORM PANEL
        // =========================================================
        const formPanel = await driver.wait(
            until.elementLocated(
                By.className("ai-form-panel"),
            ),
            10000,
        );

        await driver.executeScript(
            'arguments[0].scrollIntoView({block:"center"});',
            formPanel,
        );

        await driver.wait(
            until.elementIsVisible(formPanel),
            10000,
        );

        assert(
            await formPanel.isDisplayed(),
            "Form panel tidak tampil",
        );

        // =========================================================
        // FORM
        // =========================================================
        const form = await driver.wait(
            until.elementLocated(By.id("ai-form")),
            10000,
        );

        assert(
            await form.isDisplayed(),
            "AI form tidak tampil",
        );

        // =========================================================
        // BUDGET SLIDER
        // =========================================================
        const budgetSlider = await driver.wait(
            until.elementLocated(
                By.id("budget-slider"),
            ),
            10000,
        );

        await driver.executeScript(
            'arguments[0].scrollIntoView({block:"center"});',
            budgetSlider,
        );

        assert(
            await budgetSlider.isDisplayed(),
            "Budget slider tidak tampil",
        );

        // =========================================================
        // UPDATE BUDGET VALUE
        // =========================================================
        await driver.executeScript(
            `
            const slider = arguments[0];

            slider.value = 300000;

            slider.dispatchEvent(
                new Event('input', { bubbles:true })
            );
            `,
            budgetSlider,
        );

        await driver.sleep(500);

        const budgetValue = await driver.findElement(
            By.id("budget-val"),
        );

        const budgetText =
            await budgetValue.getText();

        assert(
            budgetText.includes("300.000"),
            "Budget value gagal berubah",
        );

        // =========================================================
        // KATEGORI SELECT
        // =========================================================
        const kategoriSelect = await driver.wait(
            until.elementLocated(
                By.id("inp-kategori"),
            ),
            10000,
        );

        await driver.executeScript(
            `
            arguments[0].value = 'pampas';
            arguments[0].dispatchEvent(
                new Event('change', { bubbles:true })
            );
            `,
            kategoriSelect,
        );

        const kategoriValue =
            await kategoriSelect.getAttribute(
                "value",
            );

        assert.strictEqual(
            kategoriValue,
            "pampas",
            "Kategori gagal dipilih",
        );

        // =========================================================
        // COLOR PICKER
        // =========================================================
        const colorButtons =
            await driver.findElements(
                By.className("color-pick-btn"),
            );

        assert(
            colorButtons.length > 0,
            "Color picker tidak tersedia",
        );

        await driver.executeScript(
            'arguments[0].scrollIntoView({block:"center"});',
            colorButtons[0],
        );

        await driver.executeScript(
            "arguments[0].click();",
            colorButtons[0],
        );

        await driver.sleep(300);

        const selectedColor =
            await colorButtons[0].getAttribute(
                "class",
            );

        assert(
            selectedColor.includes("selected"),
            "Color picker gagal dipilih",
        );

        // =========================================================
        // SIZE DROPDOWN
        // =========================================================
        const sizeTrigger = await driver.wait(
            until.elementLocated(
                By.id("size-trigger"),
            ),
            10000,
        );

        await driver.executeScript(
            'arguments[0].scrollIntoView({block:"center"});',
            sizeTrigger,
        );

        await driver.wait(
            until.elementIsVisible(sizeTrigger),
            10000,
        );

        await driver.executeScript(
            "arguments[0].click();",
            sizeTrigger,
        );

        const sizeDropdown =
            await driver.wait(
                until.elementLocated(
                    By.id("size-dropdown"),
                ),
                10000,
            );

        await driver.wait(async () => {
            const cls =
                await sizeDropdown.getAttribute(
                    "class",
                );

            return cls.includes("active");
        }, 10000);

        const dropdownClass =
            await sizeDropdown.getAttribute(
                "class",
            );

        assert(
            dropdownClass.includes("active"),
            "Dropdown ukuran gagal terbuka",
        );

        // =========================================================
        // SELECT SIZE
        // =========================================================
        const sizeOptions =
            await sizeDropdown.findElements(
                By.css(
                    'input[type="checkbox"]',
                ),
            );

        assert(
            sizeOptions.length > 0,
            "Checkbox ukuran tidak tersedia",
        );

        await driver.executeScript(
            "arguments[0].click();",
            sizeOptions[0],
        );

        await driver.sleep(500);

        assert(
            await sizeOptions[0].isSelected(),
            "Checkbox ukuran gagal dipilih",
        );

        // =========================================================
        // CHECK LABEL UPDATED
        // =========================================================
        const sizeTriggerText =
            await driver.findElement(
                By.id("size-trigger-text"),
            );

        const selectedSizeText =
            await sizeTriggerText.getText();

        assert(
            selectedSizeText !==
                "Pilih ukuran buket",
            "Label ukuran tidak berubah",
        );

        // =========================================================
        // SKIP TOGGLE
        // =========================================================
        const skipBudget =
            await driver.findElement(
                By.id("skip-budget"),
            );

        await driver.executeScript(
            'arguments[0].scrollIntoView({block:"center"});',
            skipBudget,
        );

        await driver.executeScript(
            "arguments[0].click();",
            skipBudget,
        );

        await driver.sleep(500);

        const disabledState =
            await budgetSlider.getAttribute(
                "disabled",
            );

        assert(
            disabledState !== null,
            "Skip budget gagal disable slider",
        );

        // =========================================================
        // SUBMIT BUTTON
        // =========================================================
        const submitBtn = await driver.wait(
            until.elementLocated(
                By.id("submit-btn"),
            ),
            10000,
        );

        assert(
            await submitBtn.isDisplayed(),
            "Submit button tidak tampil",
        );

        // =========================================================
        // INFO PANEL
        // =========================================================
        const infoPanel = await driver.wait(
            until.elementLocated(
                By.className("ai-info-panel"),
            ),
            10000,
        );

        assert(
            await infoPanel.isDisplayed(),
            "Info panel tidak tampil",
        );

        // =========================================================
        // SCROLL INFO PANEL
        // =========================================================
        await driver.executeScript(
            'arguments[0].scrollIntoView({block:"center"});',
            infoPanel,
        );

        // =========================================================
        // SAVE SUCCESS IMAGE
        // =========================================================
        const successImage =
            await driver.takeScreenshot();

        fs.writeFileSync(
            path.join(
                imgDir,
                "ai-recommendation-success.png",
            ),
            successImage,
            "base64",
        );

        // =========================================================
        // SAVE SUCCESS LOG
        // =========================================================
        const successLog = `
        [${new Date().toISOString()}]
        STATUS : SUCCESS
        TEST   : AI Recommendation Page Test
        TITLE  : ${title}

        `;

        fs.appendFileSync(
            logFile,
            successLog,
        );

        console.log(
            "AI recommendation page test passed",
        );
    } catch (err) {
        console.error(
            "AI recommendation page test failed",
        );

        console.error(err);

        // =========================================================
        // SAVE FAILED IMAGE
        // =========================================================
        const failedImage =
            await driver.takeScreenshot();

        fs.writeFileSync(
            path.join(
                imgDir,
                "ai-recommendation-failed.png",
            ),
            failedImage,
            "base64",
        );

        // =========================================================
        // SAVE FAILED LOG
        // =========================================================
        const failedLog = `
        [${new Date().toISOString()}]
        STATUS : FAILED
        TEST   : AI Recommendation Page Test
        ERROR  : ${err.message}

        `;

        fs.appendFileSync(
            logFile,
            failedLog,
        );
    } finally {
        await driver.quit();
    }
})();
