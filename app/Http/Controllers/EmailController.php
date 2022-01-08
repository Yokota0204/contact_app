<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\EmailDestination;
use App\Models\EmailFile;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmailController extends Controller
{
  public function reply(Request $request, $order_id) {
    $admin = Auth::user();
    $admin_uid = $admin->uid;

    $request->validate(Email::$rules, Email::$messages);

    $subject = $request->input('subject');
    $to = str_replace(" ", "", $request->input('to'));
    $cc = str_replace(" ", "", $request->input('cc'));
    $bcc = str_replace(" ", "", $request->input('bcc'));
    $body = $request->input('body');
    $files = $request->file();
    $file_count = $request->input('file_count');
    $file_count = $file_count > count($files) ? count($files) : $file_count;

    $tos = explode(',', $to);
    $ccs = explode(',', $cc);
    $bccs = explode(',', $bcc);

    DB::beginTransaction();

    try {
      $email = new Email();
      $email->order_id = $order_id;
      $email->sender_id = $admin_uid;
      $email->subject = $subject;
      $email->body = $body;
      $email->save();

      $destination_values = array();
      $reg_email = "/^([a-zA-Z0-9])+([a-zA-Z0-9._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9._-]+)+$/";

      foreach ($tos as $to) {
        if (preg_match($reg_email, $to)) {
          $destination = array(
            'email_id' => $email->id,
            'admin_id' => $admin_uid,
            'destination_type' => 1,
            'destination_address' => $to,
          );
          $destination_values[] = $destination;
        }
      }

      foreach ($ccs as $cc) {
        if (preg_match($reg_email, $cc)) {
          $destination = array(
            'email_id' => $email->id,
            'admin_id' => $admin_uid,
            'destination_type' => 2,
            'destination_address' => $cc,
          );
          $destination_values[] = $destination;
        }
      }

      foreach ($bccs as $bcc) {
        if (preg_match($reg_email, $bcc)) {
          $destination = array(
            'email_id' => $email->id,
            'admin_id' => $admin_uid,
            'destination_type' => 3,
            'destination_address' => $bcc,
          );
          $destination_values[] = $destination;
        }
      }

      if (count($destination_values) > 0) EmailDestination::insert($destination_values);

      $file_values = array();

      for ($i = 1; $i <= $file_count; $i++) {
        $file = $files["file".$i];
        $file_name = $file->getClientOriginalName();
        $file->storeAS("public/reply/$order_id/$email->id", $file_name);
        $file_value = array(
          'email_id' => $email->id,
          'admin_id' => $admin_uid,
          'file_name' => $file_name,
        );
        $file_values[] = $file_value;
      }

      if (count($file_values) > 0) EmailFile::insert($file_values);

      $order = Order::find($order_id);
      $order->status = "99";
      $order->save();
    } catch (Exception $e) {
      Log::debug($e);
      DB::rollBack();
    }

    DB::commit();
    Log::debug('メールを保存完了');

    return redirect()->route("admin.orders.show", ['id' => $order_id])
      ->with(['success' => 'メールを送信しました。']);
  }
}
