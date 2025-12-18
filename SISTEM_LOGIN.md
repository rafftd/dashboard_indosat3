# Sistem Login & Password - Dashboard Indosat

## Perubahan Sistem Login

### Sebelumnya:
- Login memerlukan email, password, DAN pilihan role
- Password berbeda untuk setiap user

### Sekarang:
- Login hanya memerlukan **email dan password**
- Role otomatis terdeteksi dari database
- Password default untuk SEMUA user: **"password"**

## Fitur Baru

### 1. Password Default
- Semua user baru akan memiliki password default: `password`
- Saat login pertama kali, user **WAJIB** mengubah password
- Password baru minimal 6 karakter

### 2. Reset Password Wajib
- Jika `must_change_password = true`, user akan diarahkan ke halaman ubah password
- User tidak bisa mengakses dashboard sebelum mengubah password
- Setelah ubah password, `must_change_password` berubah menjadi `false`

### 3. Lupa Password
- User bisa klik "Lupa Password?" di halaman login
- Masukkan email untuk reset password
- Password akan di-reset ke default: `password`
- `must_change_password` akan di-set ke `true`
- Login kembali dengan password default dan ubah password

## Flow Diagram

```
Login → Email + Password
  ↓
Check Credentials
  ↓
Login Berhasil?
  ├─ Tidak → Error "Email/Password Salah"
  └─ Ya → Check must_change_password
            ├─ true → Redirect ke Change Password (WAJIB)
            └─ false → Redirect ke Dashboard sesuai role
```

## URL Routes

| Route | Fungsi |
|-------|--------|
| `/login` | Halaman login |
| `/forgot-password` | Halaman lupa password |
| `/change-password` | Halaman ubah password (setelah login) |
| `/dashboard` | Dashboard utama (redirect sesuai role) |

## User Default

| Role | Email | Password |
|------|-------|----------|
| Administrasi | administrasi@indosat.com | password |
| Designer | designer@indosat.com | password |
| Vendor | vendor@indosat.com | password |
| Marcomm Branch | marcomm@indosat.com | password |

## Database Schema

### Table: users
- `id`: Primary key
- `name`: Nama user
- `email`: Email (unique)
- `password`: Password (hashed)
- `role`: enum('administrasi','designer','vendor','marcomm_branch')
- **`must_change_password`**: boolean (default: true) ← BARU

## Security Features

✅ Password di-hash menggunakan bcrypt
✅ Reset password hanya bisa dilakukan dengan email terdaftar
✅ Password baru wajib minimal 6 karakter
✅ Konfirmasi password saat ubah password
✅ Session management dengan CSRF token
