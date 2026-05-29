# Phase 1: Khởi tạo dự án

**Mục tiêu:** Có source Laravel chạy được và admin cơ bản

**Timeline:** 1-2 ngày

## Tasks

### 1.1 Setup Laravel Project
- [x] Tạo project Laravel mới (Laravel 13)
- [x] Cấu hình `.env` cho PostgreSQL database
- [ ] Test kết nối database thành công (chưa có PostgreSQL local)
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
- [ ] Cài Laravel Filament Admin Panel (deferred - compatibility issues with Laravel 13)
- [x] Cài Spatie Laravel Permission (v7.4)
- [ ] Cài Spatie Laravel Media Library (deferred - requires ext-exif)
- [x] Cài Cviebrock Eloquent Sluggable (v13.0)
- [x] Cài Artesaos SEO Tools (v1.4)

**Lệnh:**
```bash
composer require filament/filament
composer require spatie/laravel-permission
composer require spatie/laravel-medialibrary
composer require spatie/laravel-sluggable
composer require artesaos/seotools
```

### 1.3 Setup Filament Admin
- [ ] Chạy `php artisan filament:install --panels` (deferred - compatibility issues)
- [ ] Tạo user admin đầu tiên (deferred)
- [ ] Truy cập `/admin` kiểm tra admin panel (deferred)

**Lệnh:**
```bash
php artisan filament:install --panels
php artisan make:filament-user
```

### 1.4 Configure Frontend Layout & Design System
- [x] Tạo layout `resources/views/layouts/app.blade.php`
- [x] Tạo header component `resources/views/layouts/header.blade.php`
- [x] Tạo footer component `resources/views/layouts/footer.blade.php`
- [x] Setup Tailwind CSS (v4.0 pre-installed in Laravel 13)
- [x] **Áp dụng Design System theo DESIGN.md**
  - [x] Colors: Brand Green (#0b7f42), Brand Gold (#fbb116)
  - [x] Typography: Inter font family
  - [x] Spacing: Base unit 8px
  - [x] Border Radius: 8px (buttons/inputs), 16px (cards)
  - [x] Shadows: Green-tinted shadows

**Install Tailwind:**
```bash
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p
```

**Tailwind Config (tailwind.config.js):**
```js
module.exports = {
  theme: {
    extend: {
      colors: {
        'brand-green': '#0b7f42',
        'brand-gold': '#fbb116',
        'green-hover': '#096b39',
        'gold-hover': '#e19f14',
        'slate-text': '#2c3e36',
        'forest-deep': '#062d1c',
        'ghost-fog': '#f8fdf9',
      },
      fontFamily: {
        sans: ['Inter', 'ui-sans-serif', 'system-ui'],
      },
      borderRadius: {
        'card': '16px',
        'button': '8px',
      },
      spacing: {
        'section': '64px',
        'element': '24px',
      },
    },
  },
}
```

### 1.5 Configure Storage
- [x] Chạy `php artisan storage:link`
- [x] Cấu hình public disk trong `config/filesystems.php` (default)
- [ ] Test upload file thành công (cần sau khi có admin panel)

### 1.6 Setup Environment
- [x] Cấu hình APP_NAME ("Nhà Xe Nhật Dương")
- [x] Cấu hình APP_URL (http://localhost:8000)
- [ ] Cấu hình MAIL driver (deferred - cần sau)
- [ ] Cấu hình QUEUE driver (sử dụng sync default)
- [ ] Tạo `.env.example` backup

## Acceptance Criteria

- [x] Laravel chạy thành công trên localhost
- [ ] Admin panel truy cập được tại `/admin` (deferred - Filament compatibility)
- [ ] Database kết nối thành công (cần tạo PostgreSQL database local)
- [x] Storage link hoạt động
- [x] Layout frontend cơ bản đã có

## Notes

- Đảm bảo PHP >= 8.2
- Đảm bảo Composer đã cài đặt
- Đảm bảo Node.js và npm đã cài (cho Tailwind)
- **Đảm bảo PostgreSQL đã cài đặt và chạy**
- Tạo database trước khi chạy migration: `CREATE DATABASE nhatduonglaravel;`
- **Tham khảo DESIGN.md để áp dụng Design System nhất quán**
