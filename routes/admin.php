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
use App\Http\Controllers\EmailController;


Route::get('/', [OrderController::class, 'index'])
->middleware(['auth:admin'])
->name('orders.index');

Route::get('/orders', [OrderController::class, 'index'])
->middleware(['auth:admin'])
->name('orders.index');

Route::get('/orders/search', [OrderController::class, 'search'])
->middleware(['auth:admin'])
->name('orders.search');

Route::post('/orders/{order_id}/reply', [EmailController::class, 'reply'])
->middleware('auth:admin')
->name('orders.reply');

Route::get('/orders/{id}', [OrderController::class, 'show'])
->middleware('auth:admin')
->name('orders.show');

Route::post('/orders/update/status', [OrderController::class, 'update_status'])
->middleware('auth:admin')
->name('orders.update.status');

Route::post('/orders/update/in_charge', [OrderController::class, 'update_in_charge'])
->middleware('auth:admin')
->name('orders.update.in_charge');

Route::get('/config', [AdminController::class, 'config'])
->middleware('auth:admin')
->name('config');

Route::post('/update/auth', [AdminController::class, 'update_auth'])
->middleware('auth:admin')
->name('update.auth');

Route::get('/register', [RegisteredUserController::class, 'create'])
->middleware('auth:admin')
->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
->middleware('auth:admin');

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

Route::get("/email_reset/{token}", [AdminController::class, 'email_reset'])
->name('email_reset');

Route::post("/update_avatar/{uid}", [AdminController::class, 'update_avatar'])
->name('update_avatar');

Route::delete('/destroy', [AdminController::class, 'destroy'])
->middleware('auth:admin')
->name('destroy');

Route::post('/{uid}/update', [AdminController::class, 'update'])
->middleware('auth:admin')
->name('update');

Route::get('/{uid}', [AdminController::class, 'show'])
->middleware('auth:admin')
->name('show');