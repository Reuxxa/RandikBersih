# RandikBersih

Sistem Informasi Pelaporan Sampah berbasis Web untuk Asrama Putri Randik. Aplikasi ini dirancang untuk memudahkan masyarakat dalam melaporkan masalah sampah, serta menyediakan panel admin untuk mengelola dan memantau laporan tersebut.

## Fitur Utama
- **Halaman Publik (User)**: Halaman utama, edukasi, pendaftaran akun, login, dan fitur pelaporan sampah lengkap dengan lampiran foto.
- **Halaman Admin (Petugas)**: Dashboard manajemen data pelapor, penyesuaian jenis/kategori sampah, lokasi, dan verifikasi serta pengelolaan status laporan (Masuk, Diproses, Selesai).

## Persyaratan Sistem
- Web Server lokal (Laragon / XAMPP / WAMP)
- PHP Native
- MySQL Database

## Cara Instalasi
1. Pindahkan atau *clone* folder `RandikBersih` ke dalam direktori root server lokal Anda:
   - Jika menggunakan **Laragon**: letakkan di `C:\laragon\www\`
   - Jika menggunakan **XAMPP**: letakkan di `C:\xampp\htdocs\`
2. Buka aplikasi Laragon/XAMPP Anda, lalu jalankan (Start) layanan **Apache** dan **MySQL**.
3. Buka pengelola database Anda (HeidiSQL atau phpMyAdmin) dan buat database baru dengan nama yang harus persis seperti ini: **`website_pelaporan_sampah`**
4. Lakukan **Import** file `website_pelaporan_sampah.sql` (yang ada di folder ini) ke dalam database tersebut.
5. Selesai! Buka browser Anda dan akses aplikasi melalui:
   - `http://localhost/RandikBersih` atau `http://randikbersih.test` (untuk pengguna Laragon).
   - Untuk halaman admin, akses `http://localhost/RandikBersih/admin`
