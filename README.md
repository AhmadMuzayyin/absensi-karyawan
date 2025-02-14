# Aplikasi Absensi Karyawan
Aplikasi web untuk manajemen absensi karyawan yang dibangun menggunakan Laravel 11 dan Tailwind CSS.
Fitur Utama

## Autentikasi (Login & Role)

Login Admin untuk melihat laporan dan mengelola data
Login Karyawan menggunakan NIK/Nama
Role berbasis middleware (Admin & Karyawan)


## Absensi Karyawan

Check-in & Check-out dengan timestamp otomatis
Validasi absensi (mencegah check-in ganda)
Status absensi realtime
Manajemen shift kerja


## Fitur Izin & Cuti

Form pengajuan izin/cuti
Persetujuan izin oleh admin
Tracking status pengajuan
Validasi periode izin/cuti


## Laporan & Rekap

Rekap absensi per karyawan
Filter berdasarkan periode
Export laporan ke Excel
Statistik kehadiran


## Dashboard Admin

Overview jumlah karyawan
Monitoring absensi harian
Grafik kehadiran
Manajemen shift kerja



## Teknologi

Laravel 11
Tailwind CSS
MySQL
Laravel Excel
Carbon untuk manajemen waktu

Instalasi

Clone repository
```bash
git clone https://github.com/username/absensi-karyawan.git
```
Install dependencies
```bash
composer install
npm install
```
Setup environment
```bash
cp .env.example .env
php artisan key:generate
```
Setup database
```bash
php artisan migrate
php artisan db:seed
```
Jalankan aplikasi
```bash
php artisan serve
npm run dev
```

## Penggunaan
Admin

Login sebagai admin
Akses dashboard untuk monitoring
Kelola data karyawan dan shift
Approve pengajuan izin/cuti
Generate laporan

Karyawan

Login dengan NIK/nama
Lakukan check-in/check-out
Ajukan izin/cuti
Lihat riwayat absensi

## Lisensi
The Laravel framework is open-sourced software licensed under the MIT license.