# Phase 1: Khởi tạo dự án

**Mục tiêu:** Có source Laravel chạy được và admin cơ bản

**Timeline:** 1-2 ngày

## Tasks

### 1.1 Setup Laravel Project
- [ ] Tạo project Laravel mới (Laravel 11+)
- [ ] Cấu hình `.env` cho PostgreSQL database
- [ ] Test kết nối database thành công
- [ ] Tạo git repository và commit initial

**Lệnh:**
```bash
composer create-project laravel/laravel nhatduonglaravel
cd nhatduonglaravel
php artisan storage:link
git init
```

**Cấu hình Database (.env):**
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=nhatduonglaravel
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

### 1.2 Install Required Packages
- [ ] Cài Laravel Filament Admin Panel
- [ ] Cài Spatie Laravel Permission
- [ ] Cài Spatie Laravel Media Library
- [ ] Cài Spatie Laravel Sluggable
- [ ] Cài Artesaos SEO Tools

**Lệnh:**
```bash
composer require filament/filament
composer require spatie/laravel-permission
composer require spatie/laravel-medialibrary
composer require spatie/laravel-sluggable
composer require artesaos/seotools
```

### 1.3 Setup Filament Admin
- [ ] Chạy `php artisan filament:install --panels`
- [ ] Tạo user admin đầu tiên
- [ ] Truy cập `/admin` kiểm tra admin panel

**Lệnh:**
```bash
php artisan filament:install --panels
php artisan make:filament-user
```

### 1.4 Configure Frontend Layout
- [ ] Tạo layout `resources/views/layouts/app.blade.php`
- [ ] Tạo header component `resources/views/layouts/header.blade.php`
- [ ] Tạo footer component `resources/views/layouts/footer.blade.php`
- [ ] Setup Tailwind CSS
- [ ] Áp dụng màu brand: #0b7f42 và #fbb116

**Install Tailwind:**
```bash
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p
```

### 1.5 Configure Storage
- [ ] Chạy `php artisan storage:link`
- [ ] Cấu hình public disk trong `config/filesystems.php`
- [ ] Test upload file thành công

### 1.6 Setup Environment
- [ ] Cấu hình APP_NAME
- [ ] Cấu hình APP_URL
- [ ] Cấu hình MAIL driver (nếu cần)
- [ ] Cấu hình QUEUE driver
- [ ] Tạo `.env.example` backup

## Acceptance Criteria

- [x] Laravel chạy thành công trên localhost
- [ ] Admin panel truy cập được tại `/admin`
- [ ] Database kết nối thành công
- [ ] Storage link hoạt động
- [ ] Layout frontend cơ bản đã có

## Notes

- Đảm bảo PHP >= 8.2
- Đảm bảo Composer đã cài đặt
- Đảm bảo Node.js và npm đã cài (cho Tailwind)
- **Đảm bảo PostgreSQL đã cài đặt và chạy**
- Tạo database trước khi chạy migration: `CREATE DATABASE nhatduonglaravel;`
