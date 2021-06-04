<?php

namespace App\Http\Controllers;

use App\Models\PropsOfCategory;
use Illuminate\Http\Request;

class PropsOfCategoryController extends Controller
{
  public function show($id)
  {
    return PropsOfCategory::find($id);
  }

  public function index($id)
  {
    return PropsOfCategory::where('category_id',$id)->get();
  }
}
