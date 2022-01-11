<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Order;
use App\Models\EmailReset;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AdminController extends Controller
{
  public function show($uid) {
    $admin = Admin::where('uid', $uid)->first();
    $orders = Order::where('in_charge', $uid)->get();
    return view('admin.show', ['admin' => $admin, 'orders' => $orders]);
  }

  public function config($uid) {
    $admin = Auth::user();
    return view('admin.config', ['admin' => $admin]);
  }

  public function update(Request $request, $uid) {
    $admin = Auth::user();
    $email_now = $admin->email;
    $tel_no_now = $admin->tel_no;

    $new_email = $request->email;
    $new_tel_no = $request->tel_no;

    if ($email_now != $new_email) {
      $token = hash_hmac(
        'sha256',
        Str::random(40) . $new_email,
        config('app.key')
      );

      DB::beginTransaction();

      try {
        $param = [];
        $param['admin_uid'] = Auth::user()->uid;
        $param['new_email'] = $new_email;
        $param['token'] = $token;

        $email_reset_old = EmailReset::where('admin_uid', $admin->uid);

        if ($email_reset_old->exists()) {
          $email_reset_old->delete();
        }

        $email_reset = EmailReset::create($param);

        DB::commit();

        $email_reset->sendEmailResetNotification($token);

        return redirect()
          ->route('admin.config', ['uid' => $uid])
          ->with('success', '確認メールを送信しました。メールのリンクからメールアドレスの認証を行ってください。');
      } catch (Exception $e) {
        Log::error($e);
        DB::rollback();

        return redirect()
          ->route('admin.config', ['uid' => $uid])
          ->withInput()
          ->withErrors(['message' => 'メールの変更でエラーが発生しました。']);
      }
    }

    return redirect()->route('admin.config', ['uid' => $uid]);
  }

  public function email_reset(Request $request, $token) {
    $email_resets = DB::table('email_resets')
      ->where('token', $token)
      ->first();

    $admin = Admin::where('uid', $email_resets->admin_uid)->first();

    // トークンが存在している、かつ、有効期限が切れていないかチェック
    if ($email_resets && !$this->tokenExpired($email_resets->created_at)) {
      // ユーザーのメールアドレスを更新
      $admin->email = $email_resets->new_email;
      $admin->save();

      // レコードを削除
      DB::table('email_resets')
        ->where('token', $token)
        ->delete();

      return redirect()->route('admin.config', ['uid' => $admin->uid])
        ->with('success', 'メールアドレスを更新しました。');
    } else {
      // レコードが存在していた場合削除
      if ($email_resets) {
        DB::table('email_resets')
          ->where('token', $token)
          ->delete();
      }
      return redirect()->route('admin.config', ['uid' => $admin->uid]);
    }
  }

  public function destroy(Request $request) {
    return redirect()->route('admin.config')->with('success', 'ユーザーを削除しました。');
  }

  /**
   * トークンが有効期限切れかどうかチェック
   *
   * @param  string  $createdAt
   * @return bool
   */
  protected function tokenExpired($createdAt)
  {
      // トークンの有効期限は60分に設定
      $expires = 60 * 60;
      return Carbon::parse($createdAt)->addSeconds($expires)->isPast();
  }
}
