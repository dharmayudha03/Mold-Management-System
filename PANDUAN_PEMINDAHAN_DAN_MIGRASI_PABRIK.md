# PANDUAN PEMINDAHAN & MIGRASI DATA KE KOMPUTER PABRIK 🏭

Dokumen ini berisi panduan langkah-demi-langkah saat Anda memindahkan project **Mold Management System** ke komputer pabrik dan mengimpor seluruh data dari aplikasi **Filament PostgreSQL lama**.

---

## 🚀 LANGKAH 1: Salin Project ke Komputer Pabrik
1. Copy seluruh folder project ini (`project`) ke komputer pabrik (misal ke `C:\xampp\htdocs\project`).
2. Buka terminal di folder project tersebut (`c:\xampp\htdocs\project`).

---

## ⚙️ LANGKAH 2: Konfigurasi File `.env` di Komputer Pabrik
Buka file `.env` di project ini, lalu sesuaikan koneksi database:

1. **Database Project Baru (Target)**:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=project_cetakan
DB_USERNAME=postgres
DB_PASSWORD=password_postgres_pabrik
```

2. **Database Filament Lama (Sumber Data)**:
Tambahkan konfigurasi database Filament lama di bagian bawah file `.env`:
```env
FILAMENT_DB_HOST=127.0.0.1
FILAMENT_DB_PORT=5432
FILAMENT_DB_DATABASE=nama_database_filament_lama
FILAMENT_DB_USERNAME=postgres
FILAMENT_DB_PASSWORD=password_postgres_pabrik
```

---

## 🗄️ LANGKAH 3: Jalankan Migration & Seeder Sistem Baru
Di terminal komputer pabrik, jalankan perintah berikut untuk menyiapkan tabel & role bawaan:

```bash
php artisan migrate:fresh --seed
```

---

## 🔄 LANGKAH 4: Impor Seluruh Data dari Filament Lama (1-Click)
Jalankan perintah khusus yang telah dibuatkan berikut untuk memindahkan seluruh data transaksi (*Setup Cetakan Naik/Turun, Sandblasting, PEJO, Schedule, & MJO*) dari database Filament lama ke sistem baru:

```bash
php artisan migrate:from-filament
```

Sistem akan otomatis:
- Menghubungkan ke database Filament lama.
- Membaca dan mencocokkan data transaksi.
- Memindahkan data secara aman tanpa merusak struktur relasi.
- Menampilkan laporan sukses di terminal.

## 🎉 LANGKAH 5: Akses Aplikasi via XAMPP
Pastikan Apache & PostgreSQL di XAMPP sudah berjalan, lalu buka browser dan langsung akses URL:

`http://localhost/project`

---
*Dibuat otomatis oleh Antigravity AI Assistant.*
