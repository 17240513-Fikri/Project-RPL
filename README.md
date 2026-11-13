# Portal RT/RW

Website administrasi RT/RW berbasis Laravel 10 untuk Laragon, MySQL, dan phpMyAdmin.

## Fitur

- Manajemen data warga lengkap.
- Manajemen kepala keluarga dan anggota KK.
- Surat keterangan: domisili, tidak mampu, pengantar KTP, SKCK, usaha.
- Kas RT/RW: pemasukan, pengeluaran, saldo, dan histori.
- Pengumuman atau informasi warga.
- Dashboard statistik.
- Multi role: admin dan warga.
- Registrasi akun warga memakai NIK dan nomor KK yang sudah tercatat.

## Instalasi Laragon

1. Pindahkan folder project ini ke `C:\laragon\www\portal_rtrw` jika ingin memakai auto virtual host Laragon.
2. Buat database MySQL bernama `portal_rtrw` lewat phpMyAdmin.
3. Jalankan perintah berikut dari folder project:

```bash
composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

4. Buka `http://127.0.0.1:8000`.

## Opsi Import phpMyAdmin

Jika ingin memakai import manual, gunakan file SQL:

```text
../portal_rtrw.sql
```

Import file tersebut lewat phpMyAdmin. Setelah itu pastikan `.env` memakai:

```env
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=portal_rtrw
DB_USERNAME=root
DB_PASSWORD=
```

## Akun Demo

- Admin: `admin@rtrw.local` / `password`
- Warga: `warga@rtrw.local` / `password`

## Registrasi Warga

Halaman registrasi tersedia di `/register`. Warga harus memasukkan NIK dan nomor KK yang sudah ada di tabel `warga` dan `kartu_keluarga`. Setelah valid, sistem membuat akun role `warga` dan menghubungkannya ke data warga tersebut.

Contoh data untuk mencoba registrasi:

- NIK: `3273011505850003`
- Nomor KK: `3273010101010001`
- Email: gunakan email baru apa saja
- Password: minimal 8 karakter

## Catatan Database

Skema database dibuat lewat migration Laravel dengan nama tabel dan kolom Bahasa Indonesia:

- `profil_wilayah`
- `kartu_keluarga`
- `warga`
- `jenis_surat`
- `pengajuan_surat`
- `transaksi_kas`
- `pengumuman`
- `pengguna` dengan kolom `peran` dan relasi opsional ke warga

File `.env` sudah diarahkan ke database `portal_rtrw`, user `root`, password kosong, sesuai konfigurasi umum Laragon.
