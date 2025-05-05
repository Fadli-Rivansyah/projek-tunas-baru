# 🐔 Aplikasi Pengelolaan Ayam & Telur

Sistem manajemen sederhana untuk membantu peternak dalam mencatat, mengelola, dan memantau produksi ayam petelur dan hasil telur secara efisien.

## 🚀 Fitur Utama

- 📋 Pencatatan jumlah ayam dan produksi telur
- 🥚 Monitoring hasil produksi telur harian dan bulanan
- 📈 Statistik telur pada setiap bulannya
- 📦 Pencatatan stok pakan & kebutuhan pakan bulanan
- 🧾 Laporan rekap produksi telur, jumlah ayam, dan produksi telur
- 👥 Memonitoring karyawan dalam mengolah ayam dan telur

## 🛠️ Teknologi yang Digunakan

- **Backend:** Laravel
- **Frontend:**  Livewire / Blade
- **Database:** MySQL
- **Authentication:** Laravel Breeze
- **style** Tailwind CSS
- **Plugin** Flowbite
- **Chart** ApexChart

## 🧪 Cara Menjalankan (Development)

```bash
# Clone repositori
https://github.com/Fadli-Rivansyah/projek-tunas-baru.git
cd projek-tunas-baru

# Install dependency
composer install     # Jika Laravel
npm install          # Jika menggunakan frontend JS

# Konfigurasi .env
cp .env.example .env
# Edit .env sesuai konfigurasi lokal

# Generate key dan migrasi
php artisan key:generate
php artisan migrate

# Jalankan server
php artisan serve