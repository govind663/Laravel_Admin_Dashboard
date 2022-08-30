<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

// ======== User RegisterController
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'store'])->name('register.store');

// User LoginController
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'authenticate'])->name('login.store');
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// ======== User ForgotPasswordController
Route::get('/forget-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'getEmail'])->name('forget-password');
Route::post('/forget-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'postEmail'])->name('password.email');


// ======== User ResetPasswordController
Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'getPassword'])->name('reset-password');
Route::post('/reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'updatePassword'])->name('password.update');

// ======== Start HomeController
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth')->name('home');
