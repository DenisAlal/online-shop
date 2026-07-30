<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Index')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

Route::middleware('admin')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::resource('/admin/categories', CategoryController::class)
        ->names('admin.categories');
    Route::resource('/admin/products', ProductController::class)
        ->names('admin.products');
    Route::resource('/admin/promo', PromoController::class)
        ->names('admin.promo');
    Route::resource('/admin/order', OrderController::class)
        ->names('admin.order');
});

Route::get('/media/{mediaId}/{filename}', function (int $mediaId) {
    $media = \Spatie\MediaLibrary\MediaCollections\Models\Media::findOrFail($mediaId);

    return response()->file($media->getPath());
})->where('mediaId', '\d+')->name('media');

Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');
