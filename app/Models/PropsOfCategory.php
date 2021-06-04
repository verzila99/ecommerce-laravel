<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropsOfCategory extends Model
{
  use HasFactory;

  protected $guarded = [];
  protected $table = 'props_of_category';

  public function categories()
  {
    return $this->belongsTo(Category::class);
  }
}
