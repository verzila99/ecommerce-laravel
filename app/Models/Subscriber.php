<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;
    protected $guarded=[];


  public static function createSubscription($email): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|null
  {
    if (self::where('email', $email)->first()) {

      return response('Вы уже подписаны', '422');

    }

    if (auth()->check()) {

      self::create(['user_id' => auth()->id(), 'email' => $email]);

      return null;

    }
    if (User::where('email', $email)->first()) {

      self::create(['user_id' => User::where('email', $email)->first()->id, 'email' => $email]);

    } else {

      self::create(['email' => $email]);

    }
  }
}
