<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Core\ReturnMessage;

class RequestAddToCartRequest extends FormRequest
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
            //
            'product_id' => 'required',
            'qty' => 'required',
            'user_id' => 'required',

        ];
    }
    protected function failedValidation(Validator $validator)
    {

    throw new HttpResponseException(response()->json([
    'errors' => $validator->errors(),
    'status' => true
    ], ReturnMessage::BAD_REQUEST));
    
}
}
