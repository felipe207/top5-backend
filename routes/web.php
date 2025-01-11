<?php

use Illuminate\Support\Facades\Route;

// Route::get('/teste', function () {
//     return json_encode(['message' => 'Hello World!']);
// });

Route::get('/', function () {
    return 'Backend TOP 5 - API';
});

// Route::get('/', [LoginController::class, 'showLogin'])->name('login');
// Route::post('/login', [LoginController::class, 'login'])->name('post.login');
// Route::get('/register', [LoginController::class, 'showRegister'])->name('register');
// Route::post('/register', [LoginController::class, 'register'])->name('post.register');
// Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::middleware('auth')->get(
//     '/dashboard', [DashboardController::class, 'index'])
//     ->name('dashboard');
