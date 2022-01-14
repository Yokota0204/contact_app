<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AdminServiceProvider extends ServiceProvider
{
  public function boot()
  {
    View::composer(['components.header', 'admin.show'], function($view) {
      $view->with('login_user', Auth::user());
    });
  }
}
