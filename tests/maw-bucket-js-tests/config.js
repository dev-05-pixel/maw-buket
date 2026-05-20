// ============================================================
//  config.js — Konfigurasi Automation Testing Maw-Bucket
// ============================================================

module.exports = {
  // URL aplikasi Laravel (sesuaikan jika berbeda)
  BASE_URL: 'http://127.0.0.1:8000',

  // Kredensial admin Firebase
  ADMIN_EMAIL:    'devmossteam05@gmail.com',
  ADMIN_PASSWORD: '12345678',

  // Timeout (milidetik)
  IMPLICIT_WAIT:  30000,
  EXPLICIT_WAIT:  35000,
  PAGE_LOAD_WAIT: 40000,

  // Browser: 'chrome' | 'firefox' | 'edge'
  BROWSER: 'chrome',

  // Headless: true = tanpa jendela browser
  HEADLESS: false,

  // Data dummy produk
  PRODUCT_DATA: {
    name:        'Buket Mawar Merah Premium',
    price:       '150000',
    category:    'Buket Segar',
    description: 'Buket mawar merah segar pilihan untuk hadiah spesial.',
  },

  PRODUCT_DATA_EDIT: {
    name:        'Buket Tulip Putih Elegan',
    price:       '200000',
    category:    'Buket Kering',
    description: 'Buket tulip putih kering yang tahan lama.',
  },

  // Data dummy form kontak
  CONTACT_DATA: {
    name:    'Siti Rahayu',
    phone:   '081234567890',
    email:   'siti.rahayu@email.com',
    message: 'Halo, saya ingin memesan buket untuk pernikahan saya bulan depan. Mohon informasi lebih lanjut.',
  },

  // Kategori produk yang valid
  VALID_CATEGORIES: ['Buket Segar', 'Buket Kering', 'Pampas', 'Mini Bouquet'],
};
