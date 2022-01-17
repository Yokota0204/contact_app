<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailDestination extends Model
{
  use HasFactory;

  protected $fillable = [
    'email_id',
    'admin_id',
    'type',
    'address',
  ];

  public function email() {
    return $this->belongsTo('App\Models\Email');
  }
}
