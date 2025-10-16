<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\ChekIsLogged;
use App\Http\Middleware\ChekIsNotLogged;
use Illuminate\Support\Facades\Route;

Route::middleware([ChekIsLogged::class])->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('home');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/add-note', [MainController::class, 'addNote'])->name(name: 'add.note');
    Route::post('/add-note-submit', [MainController::class, 'noteSubmit'])->name('note.submit');
    Route::get('/edit-note/{id}', [MainController::class, 'editNote'])->name('edit.note');
    Route::post('/edit-note-submit', [MainController::class, 'editNoteSubmit'])->name('edit.note.submit');
    Route::get('/delet-note/{id}', [MainController::class, 'deletNote'])->name('delet.note');
});

Route::middleware([ChekIsNotLogged::class])->group(function(){
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login-submit', [AuthController::class,'loginSubmit'])->name('login.submit');
});

