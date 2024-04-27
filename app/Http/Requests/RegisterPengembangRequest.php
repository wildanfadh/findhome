<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class RegisterPengembangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $method = $this->method();
        $commonRules = [
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
            'sertifikat' => 'required',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6',
        ];

        $specificRules = ['username' => 'required|unique:users',];
        switch ($method) {
            case Request::METHOD_POST:
                return array_merge($commonRules, $specificRules);
            case Request::METHOD_PUT:
                return $commonRules;
        }
    }
}
