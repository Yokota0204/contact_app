<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class AdminController extends Controller
{
  public function show($uid) {
    $admin = Admin::where('uid', $uid)->first();
    // $orders = $admin->orders();
    // return view('admin.show', ['admin' => $admin, 'orders' => $orders]);
    return view('admin.show', ['admin' => $admin]);
  }

  public function config() {
    return view('admin.config');
  }

  public function destroy(Request $request) {
    return redirect()->route('admin.config')->with('success', 'ユーザーを削除しました。');
  }
}
