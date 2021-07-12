<?php

use App\Http\Controllers\Admin\RegisteredAdminController;
use App\Http\Controllers\Admin\AuthenticatedSessionController;


Route::get('/admin/register', [RegisteredAdminController::class, 'create'])
            ->middleware('admin')
            ->name('admin.register');

Route::post('/admin/register', [RegisteredAdminController::class, 'store'])
            ->middleware('admin');

Route::get('/admin/login', [AuthenticatedSessionController::class, 'create'])
            ->middleware('admin')
            ->name('admin.login');

Route::post('/admin/login', [AuthenticatedSessionController::class, 'authenticate'])
            ->middleware('admin');
            
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth.admin'])->name('admin.dashboard');