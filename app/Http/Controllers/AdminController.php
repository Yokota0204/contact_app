<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
  public function show() {
    return view('admin.show');
  }

  public function config() {
    return view('admin.config');
  }

  public function destroy(Request $request) {
    return redirect()->route('admin.config')->with('success', 'ユーザーを削除しました。');
  }
}
