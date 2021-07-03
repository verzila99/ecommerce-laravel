<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class SubscribeForNewsRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize(): bool
  {
    return true;
  }


  /**
   * Get the error messages for the defined validation rules.
   *
   * @return array
   */
  #[ArrayShape(['email.required'           => "string",
                'email.email'              => "string",
                'email.unique:subscribers' => "string"
  ])]
  public function messages(): array
  {
    return [
      'email.required' => 'A email is required',
      'email.email'    => 'a valid email address should be provided',
      'email.unique:subscribers'   => 'provided email is already used'
    ];
  }


  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  #[ArrayShape(['email' => "string"])]
  public function rules(): array
  {
    return ['email' => 'required|email|unique:subscribers'];
  }


}
