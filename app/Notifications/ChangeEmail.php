<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ChangeEmail extends Notification
{
    use Queueable;
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('メールアドレス変更') // 件名
            ->view('emails.change-email') // メールテンプレートの指定
            ->action(
                'メールアドレス変更',
                url('admin/email_reset', $this->token) //アクセスするURL
            );
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
