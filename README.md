# E-Library - App mini catatan perpustakaan (PHP)
Bookshelf adalah sebuah aplikasi mini crud tentang catatan perpustakaan. 

## Role
- admin: semua bisa akses
- petugas : semua bisa akses kecuali menu petugas
- siswa : hanya bisa melihat history peminjaman

## Testing 
- admin

username: admin

password: 123 

- petugas

username: test_petugas

password: test

- siswa

username: test

password: test


## Persiapan 
1. Node.js v20.18.2 ([ Node.js](https://nodejs.org/en/download)) 
2. PHP 8.0+ atau 8.3.8 (([xampp](https://www.apachefriends.org/download.html) atau [laragon](https://laragon.org/download/)))
3. MySQL atau MariaDB 
4. GIT (Opsional) 

### - Clone Repository   
1. Buka file manager / Finder / file explorer
2. Kemudian masuk ke folder tempat `xampp\htdocs` (XAMPP) atau `laragon\www` (Laragon)
3. Lalu klik kanan pada area kosong lalu pilih `Open in Terminal` atau pilih `git bash`
4. Kemudian, jalankan perintah dibawah ini : 

```bash
git clone https://github.com/ArielGwd/UTS_IMK_KELOMPOK1.git
cd UTS_IMK_KELOMPOK1
``` 

jangan lupa import database [e-library.sql](e-library.sql)

kemudian ke browser buka `http://localhost/UTS_IMK_KELOMPOK1/`

### - Install Dependency
jika node_modules dan css tidak ada atau beberapa fungsi tidak bisa digunakan, jalankan perintah dibawah ini :
```bash
npm install
npm run watch 

// atau 

npm run build 

``` 

kemudian buka browser kembali `http://localhost/UTS_IMK_KELOMPOK1/`. Setelah itu, cek kembali apakah bisa digunakan tombol-tombol dan beberapa fungsi lainnya

## Fitur
- Create
- Read
- Update
- Delete
- Search ([datatables library](https://datatables.net/))
- Pagination ([datatables library](https://datatables.net/)) 

## Tech stack
[![Tech](https://skillicons.dev/icons?i=tailwind,php,mysql,js,nodejs&perline=6)](https://skillicons.dev) 

## Preview  
1. Dashboard
![Dashboard Page](https://github.com/ArielGwd/UTS_IMK_KELOMPOK1/blob/0abc995f4b93b3ae993c27b0740ba7ab7c261513/assets/img/preview/dashboard.png)
 
2. Book Page
![Dashboard Page](assets/img/preview/buku.png)

3. Add Book Modal
![Dashboard Page](assets/img/preview/tambah-buku.png)

4. Edit Book Modal
![Dashboard Page](https://github.com/ArielGwd/UTS_IMK_KELOMPOK1/blob/2acb6bd015258a86c3bd98f4512952f00974ae4f/assets/img/preview/ubah-buku.png)

5. Category Page
![Category Page](assets/img/preview/kategori.png)

6. Add Category Modal
![Category Page](assets/img/preview/tambah-kategori.png)

7. Edit Category Modal
![Category Page](assets/img/preview/ubah-kategori.png)

8. Siswa Page
![Siswa Page](assets/img/preview/siswa.png)

9. Add Siswa Modal
![Siswa Page](assets/img/preview/tambah-siswa.png)

10. Edit Siswa Modal
![Siswa Page](assets/img/preview/ubah-siswa.png)

11. Petugas Page
![Petugas Page](assets/img/preview/petugas.png)

12. Add Petugas Modal
![Petugas Page](assets/img/preview/tambah-petugas.png)

13. Edit Petugas Modal
![Petugas Page](assets/img/preview/ubah-petugas.png)

14. Peminjaman Page
![Petugas Page](assets/img/preview/peminjaman.png)

15. Add Peminjaman Modal
![Petugas Page](assets/img/preview/tambah-peminjaman.png)

16. Edit Peminjaman Modal
![Petugas Page](assets/img/preview/ubah-peminjaman.png)

17. Login Page
![Petugas Page](assets/img/preview/login.png)

18. Logout Page
![Petugas Page](assets/img/preview/logout.png)
 
19. Menu yang tersedia dari role petugas
![Petugas Page](assets/img/preview/dashboard-petugas.png)

20. Menu yang tersedia dari role siswa
![Siswa Page](assets/img/preview/peminjaman-siswa.png)




