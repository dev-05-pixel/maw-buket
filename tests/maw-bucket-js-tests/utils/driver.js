// ============================================================
//  utils/driver.js — Factory WebDriver
// ============================================================

const { Builder }                        = require('selenium-webdriver');
const chrome                             = require('selenium-webdriver/chrome');
const firefox                            = require('selenium-webdriver/firefox');
const edge                               = require('selenium-webdriver/edge');
const config                             = require('../config');

/**
 * Buat dan kembalikan instance WebDriver sesuai konfigurasi.
 * Chrome/Edge/Firefox sudah include driver-nya di selenium-webdriver v4.
 */
async function getDriver() {
  const browser = config.BROWSER.toLowerCase();

  let driver;

  if (browser === 'chrome') {
    const options = new chrome.Options();
    if (config.HEADLESS) {
      options.addArguments('--headless=new');
    }
    options.addArguments('--no-sandbox');
    options.addArguments('--disable-dev-shm-usage');
    options.addArguments('--window-size=1440,900');
    options.addArguments('--disable-blink-features=AutomationControlled');
    options.excludeSwitches(['enable-automation']);

    driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();

  } else if (browser === 'firefox') {
    const options = new firefox.Options();
    if (config.HEADLESS) {
      options.addArguments('--headless');
    }
    driver = await new Builder()
      .forBrowser('firefox')
      .setFirefoxOptions(options)
      .build();

  } else if (browser === 'edge') {
    const options = new edge.Options();
    if (config.HEADLESS) {
      options.addArguments('--headless=new');
    }
    driver = await new Builder()
      .forBrowser('MicrosoftEdge')
      .setEdgeOptions(options)
      .build();

  } else {
    throw new Error(`Browser '${browser}' tidak didukung. Pilih: chrome, firefox, edge`);
  }

  await driver.manage().setTimeouts({
    implicit: config.IMPLICIT_WAIT,
    pageLoad: config.PAGE_LOAD_WAIT,
  });

  return driver;
}

module.exports = { getDriver };
