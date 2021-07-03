<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class RegisterUserRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape(['name' => "string", 'email' => "string", 'password' => "string"])]

    public function rules(): array
    {
        return ['name' => 'required|string|max:20',
          'email' => 'required|email|max:50|unique:users',
          'password' => 'required|confirmed|string|min:6',];

    }
}
