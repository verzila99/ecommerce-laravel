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


  public function index($category)
  {
    return Property::where('category_id',$category)->get();
  }


  public static function store($request,$category,$product)
  {
    $propertiesOfCategory = Property::where('category_id', $category->id)->get();

    foreach ($propertiesOfCategory as $property) {

    $name= $property->name;

      if ($request->has($name)) {

        $product->properties()->attach($property,['value'=>$request->$name]);
      }
    }
  }


  public static function update($request,$category,$product)
  {
    $propertiesOfCategory = Property::where('category_id', $category->id)->get();

    foreach ($propertiesOfCategory as $property) {

    $name= $property->name;

      if ($request->has($name)) {

        $product->properties()->updateExistingPivot($property,['value'=>$request->$name]);
      }
    }
  }
}
