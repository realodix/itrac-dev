<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\User\ChangePasswordController;
use App\Http\Controllers\Dashboard\User\UserController;
use App\Http\Controllers\IssueController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'issue.index')->name('home');
Route::get('/issues/{issue}', [IssueController::class, 'show'])->name('issue.show');
Route::get('/issues/{issue}/edit', [IssueController::class, 'edit'])->name('issue.edit');
Route::post('/issues/{issue}/edit', [IssueController::class, 'update'])->name('issue.update');
Route::get('/issues/{issue}/delete', [IssueController::class, 'destroy'])->name('issue.delete');
Route::post('/issues/{issue}/comment', [CommentController::class, 'store'])->name('comment.store');
Route::get('/comment/{comment}/delete', [CommentController::class, 'destroy'])->name('comment.delete');
Route::get('/comment/{comment}/edit', [CommentController::class, 'edit'])->name('comment.edit');
Route::post('/comment/{comment}/edit', [CommentController::class, 'update'])->name('comment.update');

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
