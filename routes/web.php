<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\UserManagementController;
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

    /*Logout*/

    Route::post('/logout', [LoginController::class, 'destroy'])
        ->name('logout');


    /*Admin Routes*/

    Route::middleware('role:Admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            /*Admin Dashboard*/

            Route::get('/dashboard', function () {
                return view('admin.dashboard');
            })->name('dashboard');


            /*User Management*/

            // User list
            Route::get('/users', [UserManagementController::class, 'index']
            )->name('users.index');


            // Add User page
            Route::get('/users/create', [UserManagementController::class, 'create']
            )->name('users.create');


            // Save new user
            Route::post('/users', [UserManagementController::class, 'store']
            )->name('users.store');


            // View one user
            Route::get('/users/{user}', [UserManagementController::class, 'show']
            )->name('users.show');


            // Edit User page
            Route::get('/users/{user}/edit', [UserManagementController::class, 'edit']
            )->name('users.edit');


            // Save edited user
            Route::put('/users/{user}', [UserManagementController::class, 'update']
            )->name('users.update');
        });


    /*Developer Routes*/

    Route::middleware('role:Developer')
        ->prefix('developer')
        ->name('developer.')
        ->group(function () {

            Route::get('/dashboard', function () {
                return view('developer.dashboard');
            })->name('dashboard');
        });
});

/*
**Default route
*/

Route::get('/', function () {
    return redirect()->route('login');
});