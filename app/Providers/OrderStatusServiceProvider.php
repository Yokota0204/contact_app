<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class OrderStatusServiceProvider extends ServiceProvider
{
    public $status_arr = [
        '1' => ['val' => '1', 'label' => '未開封'],
        '2' => ['val' => '2', 'label' => '未対応'],
        '3' => ['val' => '3', 'label' => '対応中（未返信）'],
        '4' => ['val' => '4', 'label' => '保留中（返信済み）'],
        '5' => ['val' => '5', 'label' => '対応中（返信済み）'],
        '99' => ['val' => '99', 'label' => '対応済み'],
    ];

    public function boot()
    {
        View::composer(['orders.index', 'orders.show', 'admin.show'], function($view) {
            $view->with('status_arr', $this->status_arr);
        });
    }
}
