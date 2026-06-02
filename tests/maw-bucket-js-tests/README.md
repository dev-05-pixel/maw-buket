# 🌸 Maw-Bucket — Automation Testing (JavaScript + Selenium)

Proyek pengujian otomatis berbasis **Selenium WebDriver** dan **Mocha** untuk aplikasi **Maw-Bucket** (Laravel).

---

## 📁 Struktur Proyek

```
maw-bucket-js-tests/
├── config.js                          ← URL, kredensial, data uji
├── package.json                       ← Dependensi & script npm
│
├── utils/
│   ├── driver.js                      ← Factory WebDriver (Chrome/Firefox/Edge)
│   └── helpers.js                     ← Fungsi bantu: login, tunggu, screenshot
│
├── tests/
│   ├── 01_halaman_publik.test.js      ← Home, Produk, Detail, AI
│   ├── 02_form_kontak.test.js         ← Form kontak (submit & validasi)
│   ├── 03_admin_auth.test.js          ← Login, logout, proteksi admin
│   ├── 04_admin_produk.test.js        ← CRUD produk admin
│   ├── 05_admin_pesan.test.js         ← Manajemen pesan admin
│   └── 06_responsif_navigasi.test.js  ← Responsivitas & navigasi
│
├── assets/
│   └── dummy_product.jpg              ← Gambar dummy upload (dibuat otomatis)
│
└── reports/
    ├── laporan_pengujian.html          ← Laporan HTML (setelah npm run test:report)
    └── screenshots/                    ← Screenshot otomatis saat test gagal
```

---

## ⚙️ Prasyarat

- **Node.js** v18+ (kamu sudah v22 ✅)
- **Google Chrome** versi terbaru
- **Aplikasi Laravel** berjalan di `http://127.0.0.1:8000`

---

## 🚀 Instalasi

```powershell
# Masuk ke folder proyek
cd C:\laragon\www\Maw-Buket\maw-bucket-js-tests

# Install semua dependensi
npm install
```

---

## ⚙️ Konfigurasi

Edit `config.js` sesuaikan dengan environment kamu:

```js
BASE_URL:       'http://127.0.0.1:8000',  // URL Laravel kamu
ADMIN_EMAIL:    'admin@mawbouquet.id',     // Email admin Firebase
ADMIN_PASSWORD: 'password123',             // Password admin Firebase
BROWSER:        'chrome',                  // chrome | firefox | edge
HEADLESS:       false,                     // true = tanpa jendela
```

---

## ▶️ Menjalankan Test

### Semua test sekaligus
```powershell
npm test
```

### Per modul (lebih cepat)
```powershell
npm run test:publik      # Halaman publik
npm run test:kontak      # Form kontak
npm run test:auth        # Login/logout admin
npm run test:produk      # CRUD produk
npm run test:pesan       # Manajemen pesan
npm run test:navigasi    # Responsivitas & navigasi
```

### Dengan laporan HTML
```powershell
npm run test:report
```
### Langsung buat report
```
npm run report

# Buka: reports/laporan_pengujian.html
```

---

## 🧪 Daftar Test Case (~45 Test)

| ID | Modul | Deskripsi |
|----|-------|-----------|
| TC-PUB-01~04 | Halaman Publik | Home, navigasi produk & kontak |
| TC-PUB-05~09 | Daftar Produk | Tampil, filter, klik detail, harga |
| TC-PUB-10    | AI Rekomendasi | Akses halaman |
| TC-KON-01~04 | Form Kontak Valid | Submit lengkap, email opsional |
| TC-KON-05~09 | Validasi Kontak | Nama/telepon/pesan kosong, format email, batas karakter |
| TC-AUTH-01~03 | Tampilan Login | Field tersedia, placeholder |
| TC-AUTH-04~05 | Login Berhasil | Redirect dashboard |
| TC-AUTH-06~09 | Login Gagal | Email/password salah, field kosong |
| TC-AUTH-10~11 | Logout & Proteksi | Logout, middleware admin |
| TC-PROD-01~03 | Daftar Produk Admin | Akses, tabel, tombol tambah |
| TC-PROD-04~07 | Tambah Produk | Form, validasi, berhasil tambah |
| TC-PROD-08~10 | Edit Produk | Buka form, data lama, berhasil edit |
| TC-PROD-11~12 | Hapus & Kategori | Hapus produk, validasi kategori |
| TC-MSG-01~04 | Daftar Pesan | Akses, tampil, kolom, server error |
| TC-MSG-05~07 | Detail & Hapus Pesan | Detail, info lengkap, hapus |
| TC-RES | Responsivitas | Desktop HD, Laptop, Tablet, Mobile |
| TC-NAV-01~09 | Navigasi | Semua halaman publik & admin |
