<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  use HasFactory;

  protected $fillable = [
    'company',
    'client',
    'email',
    'question',
    'status',
    'created_at',
    'updated_at',
    'created_at_display',
  ];

  public function admin() {
    return $this->belongsTo('App\Models\Admin', 'in_charge', 'uid');
  }

  public function emails() {
    return $this->hasMany('App\Models\Email');
  }

  public function scopeDateAfter($query, $start) {
    return $query->where('created_at', '>=', $start);
  }

  public function scopeDateBefore($query, $end) {
    return $query->where('created_at', '<=', $end);
  }
}