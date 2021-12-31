<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;


Route::get('/', [OrderController::class, 'index'])
->middleware(['auth:admin'])
->name('orders.index');

Route::get('/orders', [OrderController::class, 'index'])
->middleware(['auth:admin'])
->name('orders.index');

// Route::get('/orders/{id}', [OrderController::class, 'show'])
//   ->middleware('auth:admin')
//   ->name('orders.show');

Route::get('/orders/show', [OrderController::class, 'show'])
  ->middleware('auth:admin')
  ->name('orders.show');

Route::get('/show', [AdminController::class, 'show'])
  ->middleware('auth:admin')
  ->name('show');

Route::get('/config', [AdminController::class, 'config'])
  ->middleware('auth:admin')
  ->name('config');

Route::post('/destroy', [AdminController::class, 'destroy'])
  ->middleware('auth:admin');

Route::get('/register', [RegisteredUserController::class, 'create'])
  ->name('register');

// Route::get('/register', [RegisteredUserController::class, 'create'])
//   ->middleware('auth:admin')
//   ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store']);

// Route::post('/register', [RegisteredUserController::class, 'store'])
//   ->middleware('auth:admin');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
  ->middleware('guest:admin')
  ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
  ->middleware('guest:admin');

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
  ->middleware('guest:admin')
  ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
  ->middleware('guest:admin')
  ->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
  ->middleware('guest:admin')
  ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
  ->middleware('guest:admin')
  ->name('password.update');

Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
  ->middleware('auth:admin')
  ->name('verification.notice');

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
  ->middleware(['auth:admin', 'signed', 'throttle:6,1'])
  ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
  ->middleware(['auth:admin', 'throttle:6,1'])
  ->name('verification.send');

Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
  ->middleware('auth:admin')
  ->name('password.confirm');

Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
  ->middleware('auth:admin');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
  ->middleware('auth:admin')
  ->name('logout');