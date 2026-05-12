import { Builder } from "selenium-webdriver";
import chrome from "selenium-webdriver/chrome.js";

export async function createDriver() {

    // =========================================================
    // CHROME OPTIONS
    // =========================================================
    const options = new chrome.Options();

    options.addArguments(
        "--disable-notifications",
        "--disable-background-networking",
        "--disable-dev-shm-usage",
        "--disable-popup-blocking",
        "--disable-gcm",
        "--disable-features=MediaRouter",
    );

    // =========================================================
    // BUILD DRIVER
    // =========================================================
    return await new Builder()
        .forBrowser("chrome")
        .setChromeOptions(options)
        .build();
}
