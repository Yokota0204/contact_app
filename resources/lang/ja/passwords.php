<?php

return [

  /*
  |--------------------------------------------------------------------------
  | Password Reset Language Lines
  |--------------------------------------------------------------------------
  |
  | The following language lines are the default lines which match reasons
  | that are given by the password broker for a password update attempt
  | has failed, such as for an invalid token or invalid new password.
  |
  */

  'reset' => 'パスワードがリセットされました。',
  'sent' => 'パスワードリセット用のリンクをメールで送信しました。',
  'throttled' => 'しばらく時間を空けて再度お試しください。',
  'token' => 'パスワードリセットトークンが不正です。',
  'user' => "入力されたメールアドレスは登録されていません。",
  'reset_mail' => [
    'subject' => 'パスワード変更用リンクからで認証を行ってください。',
    'app_title' => '福岡システム開発',
    'line1' => 'システムよりパスワード変更の要求を受けたため、パスワード変更用のリンクを送信しております。',
    'action' => 'パスワード変更フォームへ移動する',
    'line2' => '上記ボタンをクリックすると、パスワード変更フォームへ遷移します。',
    'line3' => 'このパスワードリンクは :count 秒で無効になります。',
    'line4' => '本メールにお心当たりがない場合は、何もせずに無視してください。',
    'copyright' => '© 2021 福岡システム開発 All rights reserved.',
  ]

];
