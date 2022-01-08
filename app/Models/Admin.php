<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use App\Notifications\AdminResetPassword as ResetPasswordNotification;

class Admin extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var string[]
   */
  protected $fillable = [
    'name',
    'email',
    'tel_no',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array
   */
  protected $hidden = [
    'uid',
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function __construct() {
    $this->uid = $this->generate_uid();
  }

  public function emails() {
    $this->hasMany('App\Models\Email', 'sender_id', 'uid');
  }

  public function generate_uid() {
    $uid = sha1( uniqid( mt_rand() , true ) );
    if(DB::table("admins")->where("uid", $uid)->exists()) {
      $this->generate_uid();
    }
    return $uid;
  }

  public function sendPasswordResetNotification($token){
    $this->notify(new ResetPasswordNotification($token));
  }
}