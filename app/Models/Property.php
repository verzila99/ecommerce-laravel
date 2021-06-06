<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
  use HasFactory;

  protected $guarded = [];
  protected $table = 'properties';


  public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsTo
  {

    return $this->belongsTo(Category::class);

  }


  public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {

    return $this->belongsToMany(Product::class,'product_property')->withPivot('value');

  }

}
