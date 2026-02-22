<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\AnuncioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect()->route('produtos.index');
});

#rota de login e logout
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

#rota com proteção
Route::middleware('auth')->group(function () {
    Route::resource('produtos', ProdutoController::class);
    Route::resource('anuncios', AnuncioController::class);
    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class);
    });
});
