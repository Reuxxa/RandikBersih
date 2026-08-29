# RandikBersih ♻️

Sistem Informasi Pelaporan Sampah berbasis Web untuk Asrama Putri Randik. Aplikasi ini dirancang untuk memudahkan masyarakat dalam melaporkan masalah penumpukan sampah, sekaligus menyediakan dasbor admin untuk melacak dan mengelola setiap laporan yang masuk.

## 🚀 Live Demo
Kunjungi versi live dari aplikasi ini melalui tautan berikut:
* **Halaman Publik (User):** [randikbersih.infinityfreeapp.com](http://randikbersih.infinityfreeapp.com)
* **Dashboard Admin:** [randikbersih.infinityfreeapp.com/admin](http://randikbersih.infinityfreeapp.com/admin)
  * *Username:* issa
  * *Password:* 12345678 
*(Catatan: Akses admin di atas menggunakan data dummy khusus untuk keperluan peninjauan UI/UX dan pengujian fitur portofolio).*

## 🛠️ Tech Stack
* **Frontend:** HTML5, CSS3, JavaScript
* **Backend:** PHP Native
* **Database:** MySQL

## ✨ Fitur Utama
**Halaman Publik (User)**
* **Manajemen Akun:** Fitur pendaftaran (Register) dan masuk (Login) untuk pelapor.
* **Formulir Pelaporan:** Pengajuan laporan masalah sampah yang terintegrasi dengan fitur unggah lampiran foto.

**Halaman Admin (Petugas)**
* **Dashboard Analitik:** Ringkasan status data pelaporan secara *real-time*.
* **Manajemen Laporan:** Verifikasi dan pembaruan status laporan (Masuk -> Diproses -> Selesai).
* **Manajemen Kategori:** Penyesuaian jenis/kategori sampah dan titik lokasi penumpukan.

## 💻 Instalasi Lokal (Development)
Jika ingin menjalankan proyek ini secara lokal di komputer Anda, ikuti langkah-langkah berikut:

1. **Clone Repositori:** Pindahkan folder `RandikBersih` ke dalam direktori *root* server lokal Anda:
   - Laragon: `C:\laragon\www\`
   - XAMPP: `C:\xampp\htdocs\`
2. **Jalankan Server:** Buka aplikasi Laragon/XAMPP, lalu jalankan layanan **Apache** dan **MySQL**.
3. **Konfigurasi Database:** 
   - Buka phpMyAdmin atau HeidiSQL.
   - Buat database baru dengan nama persis: **`website_pelaporan_sampah`**
   - Lakukan **Import** file `website_pelaporan_sampah.sql` yang tersedia di dalam folder repositori ini.
4. **Akses Aplikasi:** Buka *browser* dan kunjungi:
   - Halaman User: `http://localhost/RandikBersih` (atau `http://randikbersih.test` untuk Laragon)
   - Halaman Admin: `http://localhost/RandikBersih/admin`
