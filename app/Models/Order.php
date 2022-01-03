<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'company',
    'client',
    'email',
    'question',
    'status',
    'created_at',
    'updated_at',
  ];

  public $created_at_string;

  public function scopeDateAfter($query, $start) {
    return $query->where('created_at', '>=', $start);
  }

  public function scopeDateBefore($query, $end) {
    return $query->where('created_at', '<=', $end);
  }
}
