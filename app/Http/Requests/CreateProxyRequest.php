<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProxyRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'login'      => 'required|string',
            'password'   => 'required|string',
            'ip'         => 'required|string',
            'expires_at' => 'date_format:Y-m-d|nullable',
            'is_active'  => 'bool|nullable',
        ];
    }

}