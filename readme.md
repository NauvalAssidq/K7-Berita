# K7-Berita

**K7-Berita** adalah aplikasi manajemen berita berbasis web yang dikembangkan menggunakan framework **CodeIgniter**. Aplikasi ini memungkinkan pengguna untuk mengelola konten berita secara efisien melalui antarmuka web yang sederhana dan ringan.

## Fitur

- Autentikasi pengguna (login/logout)
- CRUD berita (tambah, ubah, hapus, tampilkan)
- Manajemen kategori berita
- Komentar pengguna pada berita
- Dashboard statistik dan overview berita
- Manajemen profil pengguna
- Struktur modular menggunakan MVC (Model-View-Controller)

## Instalasi

1. **Clone repositori ini**

   ```bash
   git clone https://github.com/NauvalAssidq/K7-Berita.git
   cd K7-Berita
   ```

2. **Pindahkan folder ke direktori server lokal kamu (misal XAMPP / LAMPP)**

   ```bash
   mv K7-Berita /opt/lampp/htdocs/
   ```

3. **Konfigurasi Database**

   - Edit file `application/config/database.php` dan sesuaikan dengan kredensial database kamu.
   - Contoh:
     ```php
     'hostname' => 'mysql.railway.internal',
     'username' => 'root',
     'password' => '********',
     'database' => 'railway',
     'dbdriver' => 'mysqli',
     ```

4. **Import database**

   Import file `.sql` jika tersedia atau buat skema database secara manual.

5. **Jalankan di browser**

   ```
   http://localhost/K7-Berita/
   ```

## Struktur Direktori

```
application/
├── config/         # Konfigurasi aplikasi dan database
├── controllers/    # File controller untuk menangani request
├── models/         # File model untuk operasi database
├── views/          # File view (HTML + PHP)
├── ...
```

## Persyaratan Sistem

- PHP 7.4 atau lebih baru
- MySQL/MariaDB
- Apache/Nginx
- CodeIgniter 3.x

## Kontribusi

Pull request sangat diterima! Untuk perubahan besar, silakan buka issue terlebih dahulu untuk mendiskusikan apa yang ingin Anda ubah.

## Lisensi

MIT License

Hak Cipta (c) 2025 Nauval Assidq

Izin diberikan, secara gratis, kepada siapa pun yang mendapatkan salinan perangkat lunak ini dan file dokumentasi terkait ("Perangkat Lunak"), untuk menangani Perangkat Lunak tanpa batasan, termasuk tanpa batasan hak untuk menggunakan, menyalin, mengubah, menggabungkan, menerbitkan, mendistribusikan, memberikan lisensi, dan/atau menjual salinan Perangkat Lunak, dan untuk mengizinkan orang yang diberikan Perangkat Lunak melakukannya, tunduk pada ketentuan berikut:

Pemberitahuan hak cipta di atas dan pemberitahuan izin ini harus disertakan dalam semua salinan atau bagian penting dari Perangkat Lunak.

PERANGKAT LUNAK DIBERIKAN "SEBAGAIMANA ADANYA", TANPA JAMINAN APA PUN, BAIK TERSURAT MAUPUN TERSIRAT, TERMASUK NAMUN TIDAK TERBATAS PADA JAMINAN DIPERDAGANGKAN, KESESUAIAN UNTUK TUJUAN TERTENTU DAN TANPA PELANGGARAN. DALAM HAL APA PUN PARA PENULIS ATAU PEMEGANG HAK CIPTA TIDAK BERTANGGUNG JAWAB ATAS KLAIM, KERUSAKAN ATAU KEWAJIBAN LAIN, BAIK DALAM TINDAKAN KONTRAK, KESALAHAN ATAU LAINNYA, YANG TIMBUL DARI, DARI ATAU SEHUBUNGAN DENGAN PERANGKAT LUNAK ATAU PENGGUNAAN ATAU TRANSAKSI LAIN DALAM PERANGKAT LUNAK.