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

  public function order() {
    return $this->belongsTo('App\Models\Order');
  }

  public function admin() {
    return $this->belongsTo('App\Models\Admin', 'sender_id', 'uid');
  }

  public function destinations() {
    return $this->hasMany('App\Models\EmailDestination');
  }

  public function files() {
    return $this->hasMany('App\Models\EmailFile');
  }
}
