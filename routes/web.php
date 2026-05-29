<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BookingRedirectController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminRouteController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminPostCategoryController;
use App\Http\Controllers\Admin\AdminBannerController;
use App\Http\Controllers\Admin\AdminScheduleController;
use App\Http\Controllers\Admin\AdminFaqController;
use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminContactController;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Posts
Route::get('/tin-tuc', [PostController::class, 'index'])->name('posts.index');
Route::get('/tin-tuc/{slug}', [PostController::class, 'show'])->name('posts.show');

// Routes
Route::get('/tuyen-xe', [RouteController::class, 'index'])->name('routes.index');
Route::get('/tuyen-xe/{slug}', [RouteController::class, 'show'])->name('routes.show');

// Schedules
Route::get('/lich-trinh', [ScheduleController::class, 'index'])->name('schedules.index');

// Contact
Route::get('/lien-he', [ContactController::class, 'index'])->name('contact');
Route::post('/lien-he', [ContactController::class, 'store'])->name('contact.store');

// Booking
Route::get('/dat-ve', [BookingRedirectController::class, 'index'])->name('booking.index');
Route::get('/booking-redirect', [BookingRedirectController::class, 'redirect'])->name('booking.redirect');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Auth (guest only)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    });

    // Protected admin routes
    Route::middleware(['auth', \App\Http\Middleware\IsAdmin::class])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        // Content
        Route::resource('routes', AdminRouteController::class);
        Route::resource('posts', AdminPostController::class);
        Route::resource('post-categories', AdminPostCategoryController::class)->except(['show']);
        Route::resource('banners', AdminBannerController::class)->except(['show']);
        Route::resource('schedules', AdminScheduleController::class)->except(['show']);
        Route::resource('faqs', AdminFaqController::class)->except(['show']);
        Route::resource('pages', AdminPageController::class)->except(['show']);

        // Contacts (read-only + delete)
        Route::get('/contacts', [AdminContactController::class, 'index'])->name('contacts.index');
        Route::get('/contacts/{id}', [AdminContactController::class, 'show'])->name('contacts.show');
        Route::delete('/contacts/{id}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');

        // Settings
        Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
    });
});

// Static Pages (must be last)
Route::get('/ve-chung-toi', function () {
    return (new PageController)->show('ve-chung-toi');
})->name('about');

Route::get('/{slug}', [PageController::class, 'show'])->name('pages.show');
