# Kredensial Login Dashboard Indosat

## URL Akses
- **Local**: http://127.0.0.1:8000
- **Login Page**: http://127.0.0.1:8000/login

---

## Daftar User

### 1. **Administrasi** (Admin PO)
- **Email**: `administrasi@indosat.com`
- **Password**: `password`
- **Role**: Administrasi
- **Akses**: Kelola Purchase Order, Lihat Matpro Receipts, Lihat Vendor Shipments

### 2. **Designer** (Tim Designer)
- **Email**: `designer@indosat.com`
- **Password**: `password`
- **Role**: Designer
- **Akses**: Approval POSM Request, Update Status Produksi, Lihat Vendor Shipments

### 3. **Marcomm Branch** (Marketing Communication Branch)
- **Email**: `marcomm@indosat.com`
- **Password**: `password`
- **Role**: Marcomm Branch
- **Akses**: Buat POSM Request, Upload Bukti Penerimaan

### 4. **Vendor** (Tim Vendor)
- **Email**: `vendor@indosat.com`
- **Password**: `password`
- **Role**: Vendor
- **Akses**: Input Resi Pengiriman

---

## Cara Login

1. Buka browser dan akses: `http://127.0.0.1:8000`
2. Masukkan salah satu email di atas
3. Masukkan password: `password`
4. Klik tombol **Masuk**
5. ⚠️ **PENTING**: Setelah login pertama kali, Anda akan diminta untuk **mengganti password default**

---

## Troubleshooting

### Jika Tidak Bisa Login
1. Pastikan server Laravel sudah berjalan:
   ```bash
   php artisan serve
   ```

2. Periksa koneksi database di file `.env`:
   ```
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=dashboard_indosat3
   DB_USERNAME=postgres
   DB_PASSWORD=shahna21
   ```

3. Reset password jika diperlukan:
   ```bash
   php artisan db:seed --class=ResetPasswordSeeder
   ```

### Error "Email atau password tidak sesuai"
- Pastikan menggunakan password: `password` (huruf kecil semua)
- Cek apakah Caps Lock aktif
- Coba reset password dengan perintah di atas

---

## Database Info

- **Database**: PostgreSQL
- **Nama DB**: dashboard_indosat3
- **Total Users**: 4
- **Port**: 5432

---

**Update Terakhir**: 24 November 2025
