<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('posts');
});

Route::view('/about', 'about');
Route::view('/contact', 'contact');

// Authentication Routes
Route::get('/register', [App\Http\Controllers\AuthController::class, 'register'])->middleware('guest');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'store'])->middleware('guest');
Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'authenticate'])->middleware('guest');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->middleware('auth');
