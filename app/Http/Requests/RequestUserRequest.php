<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Core\ReturnMessage;


class RequestUserRequest extends FormRequest
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
            'email' => 'email|required|unique:users',
            'password' => 'required|min:8',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:8',
            'address' => 'max:100|required',
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
