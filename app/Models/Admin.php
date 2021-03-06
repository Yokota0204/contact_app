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
    'uid',
    'name',
    'email',
    'tel_no',
    'role',
    'avatar',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array
   */
  protected $hidden = [
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
    return $this->uid = $this->generate_uid();
  }

  public function emails() {
    return $this->hasMany('App\Models\Email', 'sender_id', 'uid');
  }

  public function orders() {
    return $this->hasMany('App\Models\Order', 'in_charge', 'uid');
  }

  public function role() {
    return $this->hasOne('App\Models\Role', 'id', 'role');
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