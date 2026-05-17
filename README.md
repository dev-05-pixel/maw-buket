# 🌸 Maw Buket  
## E-Commerce Buket Bunga Berbasis Laravel & Filament

<p align="center">
  <img src="public/assets/icons8-flower-96.png" width="120" alt="Maw Buket Logo">
</p>

<p align="center">
  <b>Menghadirkan Keindahan dalam Setiap Rangkaian Bunga 💐</b>
</p>

---

## 📖 Tentang Project

**Maw Buket** adalah aplikasi e-commerce berbasis web yang dikembangkan untuk membantu usaha buket bunga dalam mengelola produk, kategori, serta transaksi penjualan secara digital.

Sistem ini memungkinkan pelanggan untuk memesan buket bunga secara online dan admin untuk mengelola produk melalui dashboard modern menggunakan **Filament Admin Panel**.

---

## 🚀 Teknologi yang Digunakan

| Teknologi | Keterangan |
|-----------|------------|
| Laravel 10 | Framework backend utama |
| Filament v3 | Admin Panel |
| MySQL | Database |
| Blade | Template Engine |
| Bootstrap / Tailwind | Styling Frontend |
| PHP 8+ | Bahasa Pemrograman |

---

## ✨ Fitur Utama

### 👤 Customer Features
- 🛍️ Melihat daftar produk buket bunga
- 🔍 Melihat detail produk
- 🛒 Menambahkan produk ke keranjang
- 💳 Checkout pesanan
- 🔐 Login & Register akun

### 🛠️ Admin Panel (Filament)
- 📊 Dashboard Statistik
- 🗂️ CRUD Kategori
- 🌸 CRUD Produk
- 👥 Manajemen User
- 📦 Monitoring Pesanan

### AI Chatbot FAQ Service

Service AI chatbot ini menggunakan semantic similarity berbasis embedding dari model transformer untuk mencocokkan pertanyaan user dengan dataset FAQ.

### Chatbot dibangun menggunakan:

Flask
Sentence Transformers
SQLAlchemy
MySQL
Features
Semantic FAQ chatbot
Fast cosine similarity search
FAQ cache system
Automatic embedding generation
Auto refresh cache after CRUD FAQ
Environment-based configuration
Automatic model change detection
Automatic embedding regeneration when model changes
Multilingual embedding support
REST API integration with Laravel

---

## Setup

### Laravel
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate

### Flask AI
pip install --upgrade pip
python -m venv venv
venv\Scripts\activate
pip install -r requirements.txt
python chatbot_api.py

## 🏗️ Struktur Project

```
MAW-BUCKET/
│
├── app/
│   │
│   ├── Filament/
│   │   │
│   │   ├── Resources/
│   │   │   │
│   │   │   ├── CategoryResource.php --> tampilan menu kategori
│   │   │   ├── ProductResource.php  --> tampilan menu produk
│   │   │   │
│   │   │   ├── CategoryResource/
│   │   │   │   └── Pages/
│   │   │   │       ├── CreateCategory.php --> buat kategori
│   │   │   │       ├── EditCategory.php --> edit kategori
│   │   │   │       └── ListCategories.php --> daftar kategori yang sudah dibuat
│   │   │   │
│   │   │   └── ProductResource/
│   │   │       └── Pages/
│   │   │           ├── CreateProduct.php --> buat produk
│   │   │           ├── EditProduct.php --> edit produk
│   │   │           └── ListProducts.php --> daftar produk yang sudah dibuat
│   │   │
│   │   └── Widgets/
│   │       └── AdminStats.php --> stat di dashboard admin
│   │
│   ├── Http/
│   │   │
│   │   ├── Controllers/
│   │   │   ├── Controller.php
│   │   │   ├── CartController.php --> backend (controller) cart - pemesanan
│   │   │   └── ProductController.php --> backend (controller) produk
│   │   │
│   │   ├── Middleware/
│   │   │
│   │   └── Kernel.php
│   │
│   ├── Models/
│   │   ├── Category.php --> backend (model) kategori
│   │   ├── Product.php --> backend (model) produk
│   │   └── User.php --> backend (model) user
│   │
│   └── Providers/
│       │
│       ├── AppServiceProvider.php
│       ├── AuthServiceProvider.php
│       ├── BroadcastServiceProvider.php
│       ├── EventServiceProvider.php
│       ├── RouteServiceProvider.php
│       │
│       └── Filament/
│           └── AdminPanelProvider.php --> panel utama di dashboard admin
│
├── database/
│   │
│   ├── factories/
│   │
│   ├── migrations/ --> migrasi untuk pengaturan database
│   │   ├── 2014_10_12_000000_create_users_table.php
│   │   ├── 2014_10_12_100000_create_password_reset_tokens_table.php
│   │   ├── 2019_08_19_000000_create_failed_jobs_table.php
│   │   ├── 2019_12_14_000001_create_personal_access_tokens_table.php
│   │   ├── 2026_02_18_152832_create_categories_table.php
│   │   ├── 2026_02_18_152925_create_products_table.php
│   │   └── 2026_02_19_002524_add_description_to_products_table.php
│   │
│   └── seeders/
│       ├── AdminUserSeeder.php --> seeder untuk data dummy admin
│       ├── CategorySeeder.php --> seeder untuk data dummy kategori
│       └── DatabaseSeeder.php --> untuk menjalankan semua data dummy sekaligus
│
├── public/
│   │
│   ├── .htaccess
│   │
│   ├── assets/
│   │   └── icons8-flower-96.png
│   │
│   ├── css/
│   │
│   ├── js/
│   │
│   └── storage/
│
├── resources/
│   │
│   └── views/
│       │
│       ├── layouts/
│       │   └── app.blade.php --> layout 
│       │
│       ├── cart/
│       │   └── index.blade.php --> halaman kart
│       │
│       ├── product/
│       │   └── detail.blade.php --> halaman detail produk
│       │  
│       ├── home.blade.php --> halaman utama pembeli/pengunjung
│       └── welcome.blade.php
│
├── routes/
│   ├── web.php --> routes untuk web
│   └── api.php --> API
│
├── storage/
│
├── bootstrap/
│
├── config/
│
├── vendor/
│
├── .env --> environtment laravel
├── .env.example
├── .gitignore
├── artisan
├── composer.json
├── composer.lock
└── package.json
```
