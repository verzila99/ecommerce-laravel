<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateProductRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @param Request $request
   * @return bool
   */
    public function authorize(Request $request): bool
    {
      if ($request->user()->cannot('updateProduct', Product::class)) {
        abort(403);
      }

      return true;
    }


  /**
   * Get the validation rules that apply to the request.
   *
   * @param Request $request
   * @return array
   * @throws ValidationException
   */
    public function rules(Request $request)
    {

    }


  public static function updateProductRequest($request): \Illuminate\Contracts\Validation\Validator|\Illuminate\Http\RedirectResponse
  {
   $validator = Validator::make($request->except([
     $request->name === null ? 'name' : null,
     $request->email === null ? 'email' : null,
    $request->password === null ? 'password' : null]),
     ['name' => 'string|max:20',
       'email' => 'email|' . Rule::unique('users')->ignore(auth()->id()),
       'password' => 'confirmed|min:6']);

    if ($validator->fails()) {

      return redirect()->back()->withErrors($validator)->withInput();
    }
    return  $validator;
  }
}
