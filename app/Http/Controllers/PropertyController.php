<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{

  public function show($id)
  {
    return Property::find($id);
  }

  public function index($id)
  {
    return Property::where('category_id',$id)->get();
  }

}
