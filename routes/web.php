<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\UserContentController;
use App\Http\Controllers\UserProfileController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Models\UserContent;

Route::get('/', [HomeController::class, 'index'])->middleware(Authenticate::class)->name('home');

Route::controller(PagesController::class)->name('pages.')->group(function () {
    Route::get('sign-in', 'signIn')->name('sign-in');
    Route::get('sign-up', 'signUp')->name('sign-up');
    Route::middleware(Authenticate::class)->group(function () {
        Route::get('edit-profile', 'editProfile')->name('edit-profile');
        Route::get('create-new-post', 'createNewPost')->name('create-new-post');
        Route::get('view-archive', 'viewArchive')->name('view-archive');
    });
});

Route::controller(AuthController::class)->name('auth.')->group(function () {
    Route::post('sign-in', 'signIn')->name('sign-in');
    Route::post('sign-up', 'signUp')->name('sign-up');
    Route::post('sign-out', 'signOut')->name('sign-out');
});

Route::post('save-user-profile', [UserProfileController::class, 'saveUserProfile'])->name('save-user-profile');
Route::post('save-user-content', [UserContentController::class, 'saveUserContent'])->name('save-user-content');

Route::controller(UserContentController::class)->name('export.')->group(function () {
    Route::get('/export/xlsx', 'exportXlsx')->name('xlsx');
    Route::get('/export/pdf', 'exportPdf')->name('pdf');
});
