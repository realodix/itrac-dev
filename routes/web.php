<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\User\ChangePasswordController;
use App\Http\Controllers\Dashboard\User\UserController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'issue.index')->name('home');
Route::get('/issues/{issue_id}', [IssueController::class, 'show'])->name('issue.show');

Route::post('/shorten', [UrlController::class, 'create'])->name('su_create');
Route::get('/+{keyword}', [UrlController::class, 'showDetail'])->name('su_detail');
Route::get('/delete/{su_hashId}', [UrlController::class, 'delete'])->name('su_delete');
Route::get('/duplicate/{keyword}', [UrlController::class, 'duplicate'])->middleware('auth')->name('su_duplicate');

Route::namespace('Dashboard')->prefix('admin')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/', [DashboardController::class, 'view'])->name('dashboard');
        // User
        Route::namespace('User')->prefix('user')->group(function () {
            Route::get('/', [UserController::class, 'view'])->name('user.index');
            Route::get('{user}/edit', [UserController::class, 'edit'])->name('user.edit');
            Route::post('{user_hashId}/edit', [UserController::class, 'update'])->name('user.update');

            Route::get('{user}/changepassword', [ChangePasswordController::class, 'view'])->name('user.change-password');
            Route::post('{user_hashId}/changepassword', [ChangePasswordController::class, 'update'])->name('user.change-password.post');
        });
    });
});
