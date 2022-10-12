<?php

namespace App\Http\Requests\API\V1;

use InfyOm\Generator\Request\APIRequest;

class CreateOrderAPIRequest extends APIRequest
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
            'currency_from' => 'required|exists:currencies,symbol|string',
            'currency_to' => 'required|exists:currencies,symbol|string',
            'value' => 'required|numeric',
        ];
    }
}
