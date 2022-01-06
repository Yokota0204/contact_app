<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
  use HasFactory;

  protected $fillable = [
    'order_id',
    'sender_id',
    'subject',
    'body',
  ];

  public static $rules = [
    'subject' => 'required',
    'body' => 'required',
  ];

  public static $messages = [
    'subject.required' => '件名を入力してください。',
    'body.required' => '本文を入力してください。',
  ];

  public function email_destinations() {
    return $this->hasMany('App\Models\EmailDestination');
  }

  public function email_files() {
    return $this->hasMany('App\Models\EmailFile');
  }
}
