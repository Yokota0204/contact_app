<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReplyToOrder extends Mailable
{
  use Queueable, SerializesModels;

  public $email;
  public $file_paths;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($email, $file_paths)
  {
    $this->email = $email;
    $this->file_paths = $file_paths;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    $mail = $this->view('emails.reply-to-order', ['body' => $this->email->body])
      ->subject($this->email->subject);

    foreach ($this->file_paths as $path) {
      $mail->attach(storage_path("app/$path"));
    }

    return $mail;
  }
}
