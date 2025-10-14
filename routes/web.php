<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login-submit', [AuthController::class,'loginSubmit'])->name('login.submit');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
