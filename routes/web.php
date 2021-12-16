<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

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

Route::get('/errors/500', function () {return view('errors/500');})
  ->name('errors.500');

require __DIR__.'/auth.php';

Route::prefix('admin')->name('admin.')->group(function(){
  require __DIR__.'/admin.php';

  Route::get('/orders', [OrderController::class, 'index'])
    ->middleware(['auth:admin'])
    ->name('orders.index');
});