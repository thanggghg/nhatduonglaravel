# Cấu trúc Laravel đề xuất

## 1. Cấu trúc thư mục app

```text
app/
├── Models/
│   ├── User.php
│   ├── Banner.php
│   ├── Post.php
│   ├── PostCategory.php
│   ├── Route.php
│   ├── Schedule.php
│   ├── PickupPoint.php
│   ├── DropoffPoint.php
│   ├── Page.php
│   ├── Faq.php
│   ├── Setting.php
│   ├── Contact.php
│   └── BookingClickLog.php
│
├── Http/
│   ├── Controllers/
│   │   ├── HomeController.php
│   │   ├── PostController.php
│   │   ├── RouteController.php
│   │   ├── ScheduleController.php
│   │   ├── PageController.php
│   │   ├── ContactController.php
│   │   └── BookingRedirectController.php
│   └── Requests/
│       ├── StoreContactRequest.php
│       └── BookingRedirectRequest.php
│
├── Filament/
│   └── Resources/
│       ├── BannerResource.php
│       ├── PostResource.php
│       ├── PostCategoryResource.php
│       ├── RouteResource.php
│       ├── ScheduleResource.php
│       ├── PageResource.php
│       ├── FaqResource.php
│       ├── ContactResource.php
│       ├── SettingResource.php
│       └── BookingClickLogResource.php
```

## 2. Routes frontend

```php
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/tin-tuc', [PostController::class, 'index'])->name('posts.index');
Route::get('/tin-tuc/{slug}', [PostController::class, 'show'])->name('posts.show');

Route::get('/tuyen-xe', [RouteController::class, 'index'])->name('routes.index');
Route::get('/tuyen-xe/{slug}', [RouteController::class, 'show'])->name('routes.show');

Route::get('/lich-trinh', [ScheduleController::class, 'index'])->name('schedules.index');

Route::get('/lien-he', [ContactController::class, 'index'])->name('contact.index');
Route::post('/lien-he', [ContactController::class, 'store'])->name('contact.store');

Route::get('/dat-ve', [BookingRedirectController::class, 'index'])->name('booking.index');
Route::get('/booking-redirect', [BookingRedirectController::class, 'redirect'])->name('booking.redirect');

Route::get('/{slug}', [PageController::class, 'show'])->name('pages.show');
```

## 3. Views frontend

```text
resources/views/
├── layouts/
│   ├── app.blade.php
│   ├── header.blade.php
│   └── footer.blade.php
│
├── home.blade.php
│
├── posts/
│   ├── index.blade.php
│   └── show.blade.php
│
├── routes/
│   ├── index.blade.php
│   └── show.blade.php
│
├── schedules/
│   └── index.blade.php
│
├── pages/
│   └── show.blade.php
│
├── contact/
│   └── index.blade.php
│
└── booking/
    └── index.blade.php
```

## 4. Package đề xuất

```bash
composer require filament/filament
composer require spatie/laravel-permission
composer require spatie/laravel-medialibrary
composer require spatie/laravel-sluggable
composer require artesaos/seotools
```

## 5. Lệnh tạo model/migration nhanh

```bash
php artisan make:model Banner -m
php artisan make:model PostCategory -m
php artisan make:model Post -m
php artisan make:model Route -m
php artisan make:model Schedule -m
php artisan make:model PickupPoint -m
php artisan make:model DropoffPoint -m
php artisan make:model Page -m
php artisan make:model Faq -m
php artisan make:model Contact -m
php artisan make:model BookingClickLog -m
```
