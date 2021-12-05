<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return view('top');
});

Route::get('/orders/create', [OrderController::class, 'create'])
  ->name('orders.create');

Route::post('/orders/back_create', [OrderController::class, 'back_create'])
  ->name('orders.back_create');

Route::post('/orders/confirmation', [OrderController::class, 'confirmation'])
  ->name('orders.confirmation');

Route::post('/orders/store', [OrderController::class, 'store'])
  ->name('orders.store');

Route::get('/errors/500', function () {return view('errors/500');})->name('errors.500');