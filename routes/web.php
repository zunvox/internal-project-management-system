<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\AdminProjectController;
use App\Http\Controllers\Admin\PaymentVoucherController;
use App\Http\Controllers\DeveloperProjectController;
use App\Http\Controllers\DeveloperInvoiceController;
use App\Http\Controllers\DeveloperClaimController;
use Illuminate\Support\Facades\Route;

/*These routes are only for users who are not logged in.*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])
    ->name('login');

    Route::post('/login', [LoginController::class, 'store'])
    ->name('login.store');

/*These routes are for users who have forgotten their password*/

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

            /*Admin Project*/

            //Display project list
            Route::get('/projects', [AdminProjectController::class, 'index'])
            ->name('projects.index');

            //Create project page
            Route::get('/projects/create', [AdminProjectController::class, 'create'])
            ->name('projects.create');

            //Save new project
            Route::post('/projects', [AdminProjectController::class, 'store'])
            ->name('projects.store');

            //Edit project page
            Route::get('/projects/{project}/edit', [AdminProjectController::class, 'edit'])
            ->name('projects.edit');

            //Update project page
            Route::put('/projects/{project}', [AdminProjectController::class, 'update'])
            ->name('projects.update');

            //Add project milestone comment
            Route::post( '/projects/{project}/milestones', [AdminProjectController::class, 'storeMilestone'])
            ->name('projects.milestones.store');
            
            //Delete project milestone comment
            Route::delete('/projects/{project}/milestones/{milestone}', [AdminProjectController::class, 'destroyMilestone'])
            ->name('projects.milestones.destroy');

            //Delete project page
            Route::delete('/projects/{project}', [AdminProjectController::class, 'destroy'])
            ->name('projects.destroy');

            /* Payment Voucher Management */

            // Payment Voucher request list
            Route::get('/payment-vouchers', [PaymentVoucherController::class, 'index'])
            ->name('payment-vouchers.index');

            // View one invoice request
            Route::get('/payment-vouchers/invoices/{invoice}', [PaymentVoucherController::class, 'showInvoice'])
            ->name('payment-vouchers.invoices.show');

            // Approve submitted invoice
            Route::put('/payment-vouchers/invoices/{invoice}/approve', [PaymentVoucherController::class, 'approveInvoice'])
            ->name('payment-vouchers.invoices.approve');

            // Reject submitted invoice
            Route::put('/payment-vouchers/invoices/{invoice}/reject', [PaymentVoucherController::class, 'rejectInvoice'])
            ->name('payment-vouchers.invoices.reject');

            Route::post('/payment-vouchers/invoices/{invoice}/generate', [PaymentVoucherController::class, 'generateVoucher'])
            ->name('payment-vouchers.invoices.generate');

            /*Claim Expenses Management*/

            //View one claim request
            Route::get('/payment-vouchers/claims/{claim}', [PaymentVoucherController::class, 'showClaim'])
            ->name('payment-vouchers.claims.show');

            //Approve submitted claim
            Route::put('/payment-vouchers/claims/{claim}/approve', [PaymentVoucherController::class, 'approveClaim'])
            ->name('payment-vouchers.claims.approve');

            //Reject submitted claim
            Route::put('/payment-vouchers/claims/{claim}/reject', [PaymentVoucherController::class, 'rejectClaim'])
            ->name('payment-vouchers.claims.reject');

            //Generate payment voucher for claim
            Route::post('/payment-vouchers.claims/{claim}/generate', [PaymentVoucherController::class, 'generateClaimVoucher'])
            ->name('payment-vouchers.claims.generate');



        });

    /*Developer Routes*/

    Route::middleware('role:Developer')
    ->prefix('developer')
    ->name('developer.')
    ->group(function () {

            Route::get('/dashboard', function () {return view('developer.dashboard');})
            ->name('dashboard');

            /*Project Management*/

            Route::get('/projects', [DeveloperProjectController::class, 'index'])
            ->name('projects.index');

            Route::post('/projects/{project}/milestones', [DeveloperProjectController::class, 'storeMilestone'])
            ->name('projects.milestones.store');

            Route::delete('/projects/{project}/milestones/{milestone}', [DeveloperProjectController::class, 'destroyMilestone'])
            ->name('projects.milestones.destroy');

            /*Invoice Management*/

            Route::get('/invoices', [DeveloperInvoiceController::class, 'index'])
            ->name('invoices.index');

            Route::get('/invoices/create', [DeveloperInvoiceController::class, 'create'])
            ->name('invoices.create');

            Route::post('/invoices', [DeveloperInvoiceController::class, 'store'])
            ->name('invoices.store');

            Route::get('/invoices/{invoice}', [DeveloperInvoiceController::class, 'show'])
            ->name('invoices.show');

            Route::get('/invoices/{invoice}/edit', [DeveloperInvoiceController::class, 'edit'])
            ->name('invoices.edit');

            Route::put('/invoices/{invoice}', [DeveloperInvoiceController::class, 'update'])
            ->name('invoices.update');

            Route::delete('/invoices/{invoice}', [DeveloperInvoiceController::class, 'destroy'])
            ->name('invoices.destroy');

            /*Claim Expenses Management*/

            // Claim list
            Route::get('/claims', [DeveloperClaimController::class, 'index'])
                ->name('claims.index');

            // Create claim page
            Route::get('/claims/create', [DeveloperClaimController::class, 'create'])
            ->name('claims.create');

            // Submit claim
            Route::post('/claims', [DeveloperClaimController::class, 'store'])
            ->name('claims.store');

            // View one claim
            Route::get('/claims/{claim}', [DeveloperClaimController::class, 'show'])
            ->name('claims.show');

            // Delete claim
            Route::delete('/claims/{claim}', [DeveloperClaimController::class, 'destroy'])
            ->name('claims.destroy');
            });
});

/*Preview Route*/

Route::get('/preview-user', function () {
    return view('admin.create-user');
});

/*Default route*/

Route::get('/', function () {
    return redirect()->route('login');
});