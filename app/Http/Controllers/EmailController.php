<?php

namespace App\Http\Controllers;

use App\Mail\ReplyToOrder;
use App\Models\Email;
use App\Models\EmailDestination;
use App\Models\EmailFile;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use function Psy\debug;

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

      $order = Order::find($order_id);
      $reply_to = $order->email;

      $destination_values = array();
      $reg_email = "/^([a-zA-Z0-9])+([a-zA-Z0-9._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9._-]+)+$/";

      $validated_tos = array(
        $reply_to,
      );
      $validated_ccs = array();
      $validated_bccs = array();

      foreach ($tos as $to) {
        if (preg_match($reg_email, $to)) {
          $destination = array(
            'email_id' => $email->id,
            'admin_id' => $admin_uid,
            'type' => 1,
            'address' => $to,
          );
          $destination_values[] = $destination;
          $validated_tos[] = $to;
        }
      }

      foreach ($ccs as $cc) {
        if (preg_match($reg_email, $cc)) {
          $destination = array(
            'email_id' => $email->id,
            'admin_id' => $admin_uid,
            'type' => 2,
            'address' => $cc,
          );
          $destination_values[] = $destination;
          $validated_ccs[] = $cc;
        }
      }

      foreach ($bccs as $bcc) {
        if (preg_match($reg_email, $bcc)) {
          $destination = array(
            'email_id' => $email->id,
            'admin_id' => $admin_uid,
            'type' => 3,
            'address' => $bcc,
          );
          $destination_values[] = $destination;
          $validated_bccs[] = $bcc;
        }
      }

      if (count($destination_values) > 0) EmailDestination::insert($destination_values);

      $file_values = array();
      $attach_file_paths = array();

      for ($i = 1; $i <= $file_count; $i++) {
        $file = $files["file".$i];
        $file_name = $file->getClientOriginalName();
        $stored_file_path = $file->storeAS("public/reply/$order_id/$email->id", $file_name);
        Log::info('Stored file: '.$stored_file_path);
        $attach_file_paths[] = $stored_file_path;
        $file_value = array(
          'email_id' => $email->id,
          'admin_id' => $admin_uid,
          'name' => $file_name,
        );
        $file_values[] = $file_value;
      }

      if (count($file_values) > 0) EmailFile::insert($file_values);
      Log::debug('メールを保存完了');
      Log::info("Email: $email");

      Mail::to($validated_tos)->cc($validated_ccs)->bcc($validated_bccs)
        ->send(new ReplyToOrder($email, $attach_file_paths));
      Log::debug('メール送信完了');
      Log::info('To: '.print_r($validated_tos, true).', Cc: '.print_r($validated_ccs, true).', Bcc: '.print_r($validated_bccs, true));

      $order->status = "99";
      $order->save();
      Log::debug("order_id: $order_id : 問い合わせのステータスを「対応済み」変更");
    } catch (Exception $e) {
      Log::debug($e);
      DB::rollBack();
    }

    DB::commit();

    return redirect()->route("admin.orders.show", ['id' => $order_id])
      ->with(['success' => 'メールを送信しました。']);
  }
}
