# Website Peminjaman buku

## Penjelasan Singkat

Aplikasi ini dibuat dengan memakai laravel framework dan berfungsi untuk melakukan pinjaman buku. Ada dua role user disini
admin dan user, admin bisa melakukan penambahan buku dan & menghapus buku sekaligus mengelola user, sementara user hanya bisa
melakukan pengembalian dan peminjaman buku sekaligus sistem denda bagi user jika telat mengembalikan buku

## Fitur Utama

* CRUD Data Buku (Tambah, Edit, Hapus, Tampilkan)
* Upload Gambar Buku
* Sistem Peminjaman Buku
* Sistem Pengembalian Buku
* Sistem Denda jika user telat melakukan pengembalian buku
* Manajemen user (Admin & User)

## Teknologi yang Digunakan

* PHP
* Laravel
* MySQL
* Bootstrap

## Cara Menjalankan Project

1. Clone repository, dibawah ini adalah Clone untuk repository saya
   ```
   git clone https://github.com/ZeroPoint90/Peminjaman-buku.git
   ```

3. Masuk ke folder project

   ```
   cd projek ukk
   ```

4. Install dependency

   ```
   composer install
   ```

5. Copy file environment

   ```
   cp .env.example .env
   ```

6. Generate key

   ```
   php artisan key:generate
   ```

7. Migrasi database

   ```
   php artisan migrate
   ```

8. Jalankan server

   ```
   php artisan serve
   ```

## Struktur Database

* users → menyimpan data pengguna
* buku → menyimpan data buku
* transaksi → menyimpan data peminjaman buku


## Role Pengguna

* Admin → mengelola data buku, transaksi & data user
* User → melakukan peminjaman buku & pengembalian buku
