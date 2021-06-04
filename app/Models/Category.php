<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

  use HasFactory;

  protected $table = 'categories';

  protected $fillable = ['name', 'name_ru'];


  public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(Product::class, 'product_category','category_name' );

  }

  public function props_of_categories()
  {
    return $this->hasMany(PropsOfCategory::class);
  }
}
