# 🚀 Aplikasi Absensi Karyawan  
Sistem manajemen absensi berbasis web yang dibangun dengan **Laravel 11** dan **Tailwind CSS**, dirancang untuk memudahkan perusahaan dalam mengelola kehadiran karyawan secara efisien dan akurat.  

## ✨ Fitur Utama  

### 🔐 **Autentikasi & Role-Based Access**  
✅ Login **Admin** untuk mengelola data dan melihat laporan  
✅ Login **Karyawan** menggunakan **NIK/Nama**  
✅ Middleware role-based (**Admin & Karyawan**)  

### 🕒 **Absensi Karyawan**  
✅ **Check-in & Check-out** dengan timestamp otomatis  
✅ **Validasi absensi** untuk mencegah check-in ganda  
✅ **Status kehadiran** realtime  
✅ **Manajemen shift kerja**  

### 📅 **Izin & Cuti**  
✅ **Pengajuan izin/cuti** langsung dari aplikasi  
✅ **Persetujuan izin** oleh admin  
✅ **Tracking status** pengajuan izin  
✅ **Validasi periode izin/cuti** untuk menghindari konflik  

### 📊 **Laporan & Statistik**  
✅ **Rekap absensi** per karyawan  
✅ **Filter laporan** berdasarkan periode tertentu  
✅ **Export laporan** ke **Excel**  
✅ **Statistik kehadiran** dalam bentuk grafik  

### 🎛 **Dashboard Admin**  
✅ **Overview jumlah karyawan**  
✅ **Monitoring absensi harian**  
✅ **Grafik kehadiran** untuk analisis lebih dalam  
✅ **Manajemen shift kerja**  

---

## 🛠 **Teknologi yang Digunakan**  
- ⚡ Laravel 11  
- 🎨 Tailwind CSS  
- 🛢 MySQL  
- 📊 Laravel Excel  
- ⏳ Carbon (manajemen waktu)  

---

## 🚀 **Instalasi & Konfigurasi**  

### 1️⃣ Clone Repository  
```bash
git clone https://github.com/username/absensi-karyawan.git
cd absensi-karyawan
```

### 2️⃣ Install Dependencies  
```bash
composer install
npm install
```

### 3️⃣ Setup Environment  
```bash
cp .env.example .env
php artisan key:generate
```
> **Catatan:** Pastikan untuk mengkonfigurasi **database** di file `.env`

### 4️⃣ Setup Database  
```bash
php artisan migrate --seed
```

### 5️⃣ Jalankan Aplikasi  
```bash
php artisan serve
npm run dev
```
Sekarang aplikasi siap digunakan! 🎉  

---

## 🎯 **Cara Penggunaan**  

### 👨‍💼 **Admin**  
🔹 Login sebagai **Admin**  
🔹 Akses **dashboard** untuk monitoring  
🔹 **Kelola data karyawan & shift**  
🔹 **Approve pengajuan izin/cuti**  
🔹 **Generate laporan absensi**  

### 👨‍💻 **Karyawan**  
🔹 Login menggunakan **Email**  
🔹 **Check-in & Check-out** sesuai jam kerja  
🔹 **Ajukan izin/cuti** melalui aplikasi  
🔹 **Lihat riwayat absensi pribadi**  

---

## 📜 **Lisensi**  
Aplikasi ini menggunakan **Laravel Framework** yang berlisensi **MIT License**.  

💡 **Dukung proyek ini dengan memberi ⭐ di repository!** 🚀