<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\User\ChangePasswordController;
use App\Http\Controllers\Dashboard\User\UserController;
use App\Http\Controllers\IssueController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'sections.issue.index')->name('home');
Route::get('/issues/create', [IssueController::class, 'create'])->name('issue.create')->middleware('auth');
Route::post('/issues/create', [IssueController::class, 'store'])->name('issue.store');
Route::get('/issues/{issue}', [IssueController::class, 'show'])->name('issue.show');
Route::get('/issues/{issue}/edit', [IssueController::class, 'edit'])->name('issue.edit');
Route::post('/issues/{issue}/edit', [IssueController::class, 'update'])->name('issue.update');
Route::get('/issues/{issue}/delete', [IssueController::class, 'destroy'])->name('issue.delete');
Route::get('/issues/{issue}/close', [IssueController::class, 'close'])->name('issue.close');
Route::get('/issues/{issue}/reopen', [IssueController::class, 'reopen'])->name('issue.reopen');
Route::get('/issues/{issue}/lock', [IssueController::class, 'lock'])->name('issue.lock');
Route::get('/issues/{issue}/unlock', [IssueController::class, 'unlock'])->name('issue.unlock');

Route::post('/issues/{issue}/comment', [CommentController::class, 'store'])->name('comment.store');
Route::get('/comment/{comment}/delete', [CommentController::class, 'destroy'])->name('comment.delete');
Route::get('/comment/{comment}/edit', [CommentController::class, 'edit'])->name('comment.edit');
Route::post('/comment/{comment}/edit', [CommentController::class, 'update'])->name('comment.update');
Route::get('/issues/{issue}#comment-{id}', [CommentController::class])->name('issue.show.comment');

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
