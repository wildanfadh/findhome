<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class PerumahanRequest extends FormRequest
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
            'nama' => 'required',
            'alamat' => 'required',
            'keterangan' => 'required',
        ];

        $specificRules = [];
        switch ($method) {
            case Request::METHOD_POST:
                return array_merge($commonRules, $specificRules);
            case Request::METHOD_PUT:
                return $commonRules;
        }
    }
}
