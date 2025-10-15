<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\ChekIsLogged;
use App\Http\Middleware\ChekIsNotLogged;
use Illuminate\Support\Facades\Route;

Route::middleware([ChekIsLogged::class])->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('home');
    Route::get('/new-note', [MainController::class, 'newNote'])->name(name: 'new.note');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware([ChekIsNotLogged::class])->group(function(){
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login-submit', [AuthController::class,'loginSubmit'])->name('login.submit');
});

