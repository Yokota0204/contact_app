<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Order;

class AdminController extends Controller
{
  public function show($uid) {
    $admin = Admin::where('uid', $uid)->first();
    $orders = Order::where('in_charge', $uid)->get();
    return view('admin.show', ['admin' => $admin, 'orders' => $orders]);
  }

  public function config() {
    return view('admin.config');
  }

  public function destroy(Request $request) {
    return redirect()->route('admin.config')->with('success', 'ユーザーを削除しました。');
  }
}
