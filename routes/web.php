<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\UserProfileController;

Route::get('/', [HomeController::class, 'index'])->name('dashboard');

Route::controller(PagesController::class)->name('pages.')->group(function () {
    Route::get('sign-in', 'signIn')->name('sign-in');
    Route::get('sign-up', 'signUp')->name('sign-up');
    Route::get('edit-profile', 'editProfile')->name('edit-profile');
    Route::get('profile-setting', 'profileSetting')->name('profile-setting');
    Route::get('view-archive', 'viewArchive')->name('view-archive');
});

Route::controller(AuthController::class)->name('auth.')->group(function () {
    Route::post('sign-in', 'signIn')->name('sign-in');
    Route::post('sign-up', 'signUp')->name('sign-up');
    Route::post('sign-out', 'signOut')->name('sign-out');
});

Route::post('save-user-profile', [UserProfileController::class, 'saveUserProfile'])->name('save-user-profile');
