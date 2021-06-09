<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;

class StoreProductRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return ['title' => 'required|string',
          'category' => 'required|string',
          'price' => 'sometimes|numeric',
          'manufacturer' => 'sometimes|string',
          'vendorcode' => 'sometimes|numeric'];
    }
}
