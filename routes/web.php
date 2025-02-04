<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagesController;

Route::get('/', [HomeController::class, 'index'])->name('dashboard');

Route::controller(PagesController::class)->name('pages.')->group(function () {
    Route::get('sign-in', 'signIn')->name('sign-in');
    Route::get('sign-up', 'signUp')->name('sign-up');
});

Route::controller(AuthController::class)->name('auth.')->group(function () {
    Route::post('/sign-in', 'signIn')->name('sign-in');
});
