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
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AdminController extends Controller
{
  public function show($uid) {
    $admin = Admin::where('uid', $uid)->first();
    $orders = Order::where('in_charge', $uid)->get();
    return view('admin.show', ['admin' => $admin, 'orders' => $orders]);
  }

  public function config() {
    $admin = Auth::user();
    $admin_users = $admin->role == "1" ? Admin::get() : array();
    return view('admin.config', ['admin_users' => $admin_users]);
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

  public function update_avatar(Request $request, $uid) {
    DB::beginTransaction();

    try {
      $profile_path = "admins/$uid/profile";
      $folderPath = storage_path("app/public/$profile_path/");

      $image_parts = explode(";base64,", $request->image);
      // $image_type_aux = explode("image/", $image_parts[0]);
      // $image_type = $image_type_aux[1];
      $image_base64 = base64_decode($image_parts[1]);
      $file_name = date('YmdHis') . '.png';

      $admin = Admin::where('uid', $uid)->first();

      $old_file = $admin->avatar;

      $admin->avatar = $file_name;
      $admin->save();

      Log::debug("Path : $folderPath/$old_file");
      if (File::exists("$folderPath/$old_file")) {
        Log::debug("Delete : $old_file");
        Storage::disk('public')->delete("$profile_path/$old_file");
      } elseif(!File::exists($folderPath)) {
        File::makeDirectory($folderPath, $mode = 0777, true, true);
      }

      $file_put = file_put_contents($folderPath . $file_name, $image_base64);

      if (!$file_put) {
        $data = 'error';
      } else {
        $data = 'success';
      }
    } catch (Exception $e) {
      DB::rollBack();
      $data = 'error';
      Log::error($e);
    }

    DB::commit();

    return response()->json($data);
  }

  public function destroy(Request $request) {
    $admin = Auth::user();
    if ($admin->role != "1") {
      return redirect()
        ->route('admin.config')
        ->withInput()
        ->withErrors(['message' => '不正な操作です。']);
    }

    $users = $request->input('users');

    DB::beginTransaction();
    try {
      foreach ($users as $uid) {
        Admin::where('uid', $uid)->delete();
        Log::debug("Deleted user : $uid");
      }
      DB::commit();
      Log::info("Delete action, root user uid : $admin->uid");

      $address = $admin->email;
      Mail::send('emails.delete-notify', ['admin' => $admin], function($message) use ($address) {
        $message->to($address)->subject('あなたのアカウントで管理者ユーザーが削除されました。');
      });
    } catch (Exception $e) {
      DB::rollBack();
      Log::error($e);
    }

    return redirect()->route('admin.config')->with('success', '選択したユーザーを削除しました。');
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
