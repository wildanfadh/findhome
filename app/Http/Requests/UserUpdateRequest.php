<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

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
            'username' => "required|unique:users,username,{$this->id},id",
            'email' => 'required',
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
