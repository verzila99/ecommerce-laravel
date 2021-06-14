<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
  use HasFactory;

  protected $guarded = [];


  public static function orderBanners($countBanners,$location): void
  {

    for ($i = 2; $i <= $countBanners; $i++) {

      if (!self::where('location',$location)->where('position',$i-1)->first()) {

        self::where('location',$location)->where('position', $i)->update(['position'=> $i - 1]);
      }
    }
  }
}
