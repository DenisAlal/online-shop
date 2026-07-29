<?php

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
    Route::get('/admin', [LoginController::class, 'create'])->name('admin');
});



Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');
