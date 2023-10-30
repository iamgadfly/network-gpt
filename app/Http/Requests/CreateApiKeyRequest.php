<?php

namespace App\Http\Requests;

use App\Enums\V1\StatusWorkEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateApiKeyRequest extends FormRequest
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
            'name'             => 'string|nullable',
            'value'            => 'string',
            'url'              => 'string',
            'max_requests'     => 'int',
            'status'           => [
                'required',
                Rule::in(
                    [
                        StatusWorkEnum::WORKED,
                        StatusWorkEnum::NOT_WORKED,
                        StatusWorkEnum::BROKEN,
                    ]
                ),
            ],
            'network_id'       => 'int',
            'current_requests' => 'int|nullable',
        ];
    }

}
