#  Skynet Logistics - Premium Expedition Management System

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Docker](https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white)](https://www.docker.com)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com)

**Skynet Logistics** adalah platform manajemen ekspedisi modern yang dirancang untuk efisiensi tinggi, skalabilitas, dan keamanan. Aplikasi ini mencakup seluruh alur operasional logistik, mulai dari penjemputan paket (*pickup*), pengiriman (*delivery*), hingga manajemen cabang dan keuangan.

---

##  Fitur Utama

###  Multi-Role Dashboard
Sistem terintegrasi untuk berbagai peran operasional:
*   **Admin Central:** Monitoring seluruh jaringan ekspedisi dan persetujuan aplikasi staff.
*   **Manager Cabang:** Manajemen staff cabang, omzet, dan audit operasional harian.
*   **Kasir:** Pencatatan transaksi, pembuatan resi, dan manajemen *shift*.
*   **Kurir (Pickup & Delivery):** Navigasi penjemputan barang dan konfirmasi pengiriman paket.
*   **Kurir Transit:** Manajemen perpindahan barang antar gudang (*manifest*).

###  Tracking & Pelayanan
*   **Real-time Tracking:** Lacak posisi paket menggunakan nomor resi secara instan.
*   **Cek Tarif:** Perhitungan biaya kirim berdasarkan berat dan volume paket.
*   **Gabung Tim:** Landing page premium untuk pendaftaran calon staff.

###  Integrasi Pembayaran
*   **Midtrans Core API:** Integrasi gerbang pembayaran otomatis untuk keamanan transaksi.

###  Infrastructure as Code (DevOps)
*   **Docker Ready:** Konfigurasi container terpisah untuk App, Web (Nginx), dan Database.
*   **Load Balancing:** Deployment menggunakan Nginx sebagai reverse proxy ke beberapa replika aplikasi.

---

##  Tech Stack

*   **Backend:** Laravel 11 / PHP 8.2
*   **Frontend:** Vanilla CSS (Premium Dark Mode), Blade, Vite
*   **Database:** MySQL 8.0
*   **Server:** Nginx + PHP-FPM
*   **Infrastructure:** Docker & Docker Compose
*   **Automation:** Ansible (Ujikom Scenarios)

---

##  Setup dengan Docker (Rekomendasi Ujikom)

### 1. Persiapan
Pastikan Docker dan Docker Compose sudah terinstal di mesin Anda.

### 2. Konfigurasi Environment
```bash
cp .env.example .env
# Masukkan App Key dan Kredensial Midtrans di .env
```

### 3. Build dan Jalankan
```bash
docker-compose up -d --build
```

### 4. Inisialisasi Database
```bash
docker-compose exec app php artisan migrate --seed
docker-compose exec app php artisan storage:link
```

Aplikasi dapat diakses di: **http://localhost**

---

## 📋 Akun Demo (Default)

| Role | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@skynet.com` | `password123` |
| **Manager** | `manager@skynet.com` | `password123` |
| **Kasir** | `cashier@skynet.com` | `password123` |
| **Kurir** | `courier@skynet.com` | `password123` |

---

##  Struktur Proyek

```text
app/
├── Http/Controllers/      # Logika Bisnis (Admin, Manager, Kasir, Kurir)
├── Models/                # Struktur Database (Shipment, User, Branch)
├── Services/              # Layanan Eksternal (Midtrans, Rate Calculation)
resources/
├── views/                 # Tampilan UI (Blade Templates)
├── css/                   # Styling Custom (Dark Mode Premium)
docker/
├── nginx.conf             # Konfigurasi Load Balancer
Dockerfile                 # Resi perakitan container aplikasi
docker-compose.yml         # Orkestrasi sistem
```

---

##  Author
**Padli** - *Software Development & DevOps Engineer*
*(redmiyahya15@gmail.com)*

---
*Dikembangkan untuk Ujian Kompetensi (Ujikom) - 2026*
