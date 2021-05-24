<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['username','email','phone_number'];

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
       return $this->hasMany(Product::class);
    }

}
