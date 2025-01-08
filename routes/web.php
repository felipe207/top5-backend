<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

// Route::get('/', function () {
//     // return view('welcome');
//     redirect('/login');
// });


// Route::get('/teste', function () {
//     return json_encode(['message' => 'Hello World!']);
// });


Route::get('/', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('post.login');
Route::get('/register', [LoginController::class, 'showRegister'])->name('register');
Route::post('/register', [LoginController::class, 'register'])->name('post.register');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->get(
    '/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');
