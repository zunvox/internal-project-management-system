<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/*
**These routes are only for users who are not logged in.
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'store'])
        ->name('login.store');
    /*
    **These routes are for users who have forgotten their password
    */
    Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])
    ->name('password.request');

    Route::post('/forgot-password', [ForgotPasswordController:: class, 'store'])
    ->name('password.email');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('/reset-password', [ResetPasswordController:: class, 'store'])
    ->name('password.update');

});

/*
** These routes require the user to be logged in.
*/

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])
        ->name('logout');

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/developer/dashboard', function () {
        return view('developer.dashboard');
    })->name('developer.dashboard');
});

Route::get('/admin/users-index', function() {
    return view('users-index');
})->name('users-list');

/*
**Default route
*/

Route::get('/', function () {
    return redirect()->route('login');
});