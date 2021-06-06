<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  use HasFactory;

  protected $fillable = ['username', 'email', 'phone_number', 'user_id', 'message', 'sum'];

  public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'id')->withPivot('quantity');
  }


}
