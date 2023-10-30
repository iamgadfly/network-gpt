<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendDataChatGptRequest extends FormRequest
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
            'message'           => 'required|string',
            'is_synchronous'    => 'required|bool',
            'callback_url'      => 'nullable|string',
            'temperature'       => 'numeric|nullable',
            'top_p'             => 'numeric|nullable',
            'functions'         => 'array|nullable',
            'function_call'     => 'string|nullable',
            'stream'            => 'bool|nullable',
            'n'                 => 'numeric|nullable',
            'stop'              => 'string|array|nullable',
            'max_tokens'        => 'int|nullable',
            'presence_penalty'  => 'numeric|nullable',
            'frequency_penalty' => 'numeric|nullable',
        ];
    }

}
