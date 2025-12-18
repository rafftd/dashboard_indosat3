# CSS & Blade Files Structure

## ✅ Blade Files dengan CSS yang Sesuai

### 1. Admin Dashboard
- **Blade**: `admin.blade.php`
- **CSS**: `admin.css`, `responsive-global.css`
- **Fungsi**: Dashboard untuk Admin mengelola Purchase Order

### 2. Designer Dashboard
- **Blade**: `designer.blade.php`
- **CSS**: `designer.css`, `responsive-global.css`
- **Fungsi**: Dashboard untuk Designer approve POSM requests

### 3. Designer Vendor Shipments
- **Blade**: `designer-vendor-shipments.blade.php`
- **CSS**: `designer-vendor-shipments.css`, `responsive-global.css`
- **Fungsi**: Halaman data pengiriman vendor untuk Designer

### 4. Markom Branch (POSM Request Form)
- **Blade**: `markombranch.blade.php`
- **CSS**: `markom.css`, `responsive-global.css`
- **Fungsi**: Form permintaan POSM untuk Markom Branch

### 5. POSM Index (Daftar POSM)
- **Blade**: `posmindex.blade.php`
- **CSS**: `posmindex.css`, `responsive-global.css`
- **Fungsi**: Daftar semua permintaan POSM

### 6. Upload Matpro
- **Blade**: `upload-matpro.blade.php`
- **CSS**: `upload-matpro.css`, `responsive-global.css`
- **Fungsi**: Upload bukti penerimaan MATPRO

### 7. Dashboard (Main)
- **Blade**: `dashboard.blade.php`
- **CSS**: `dashboard.css`, `responsive-global.css`
- **Fungsi**: Dashboard utama setelah login

### 8. Login
- **Blade**: `login.blade.php`
- **CSS**: `login.css`, `responsive-global.css`
- **Fungsi**: Halaman login

### 9. Vendor Dashboard
- **Blade**: `vendor.blade.php`
- **CSS**: `vendor-shipping.css`, `responsive-global.css` (via layouts/app.blade.php)
- **Fungsi**: Dashboard untuk Vendor mengelola pengiriman

### 10. Create PO Form
- **Blade**: `create-po.blade.php`
- **CSS**: `po-form.css`, `responsive-global.css` (via layouts/app.blade.php)
- **Fungsi**: Form untuk membuat Purchase Order baru

### 11. Layouts App
- **Blade**: `layouts/app.blade.php`
- **CSS**: `responsive-global.css`
- **Fungsi**: Layout master untuk halaman yang menggunakan @extends

## 📁 Struktur CSS Files

```
public/css/
├── responsive-global.css      # Global responsive styles untuk semua halaman
├── admin.css                  # Styles untuk admin dashboard
├── designer.css               # Styles untuk designer dashboard
├── designer-vendor-shipments.css  # Styles untuk designer vendor shipments
├── markom.css                 # Styles untuk markom branch form
├── posmindex.css              # Styles untuk POSM index/list
├── upload-matpro.css          # Styles untuk upload matpro
├── dashboard.css              # Styles untuk main dashboard
├── login.css                  # Styles untuk login page
├── vendor-shipping.css        # Styles untuk vendor dashboard
├── po-form.css                # Styles untuk create PO form
└── po-list.css                # Styles untuk PO list (jika diperlukan)
```

## 🎯 File yang Bisa Dihapus (Tidak Digunakan)

- `posm.css` - Sudah digabung ke `posmindex.css`
- `po-list.css` - Jika tidak digunakan di admin.blade.php

## ✨ Prinsip Penamaan

1. **Nama CSS = Nama Blade**
   - `designer.blade.php` → `designer.css`
   - `admin.blade.php` → `admin.css`

2. **Semua halaman import `responsive-global.css` pertama**
   - Memastikan responsive di mobile dan desktop

3. **Inline styles minimal**
   - Sebagian besar styles dipindah ke file CSS terpisah
   - Hanya critical styles yang tetap inline

4. **Separation of Concerns**
   - CSS terpisah dari Blade
   - Mudah maintenance
   - Reusable components

## 🔧 Best Practices

- ✅ Setiap blade file punya CSS sendiri
- ✅ Semua menggunakan responsive-global.css
- ✅ Tidak ada duplikasi CSS
- ✅ Nama file konsisten
- ✅ Code terorganisir dengan rapi
