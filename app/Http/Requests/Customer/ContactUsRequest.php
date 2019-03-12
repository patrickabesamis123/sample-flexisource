<?php

namespace App\Http\Requests\Customer;

use App\Http\Requests\BaseFormRequest;

class ContactUsRequest extends BaseFormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email_address' => 'required|email',
            'subject' => 'nullable|string',
            'business_name' => 'nullable|string',
            'message' => 'required|string'
        ];
    }

     /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'first_name.required' => 'First Name is required',
            'first_name.string' => 'First Name must be a string type',
            'last_name.required' => 'Last Name is required',
            'last_name.string' => 'Last Name must be a string type',
            'email_address.required' => 'Email Address is required',
            'email_address.email' => 'Not a valid email address',
            'message.required' => 'Message is required',
            'message.string' => 'Message must be a string type',
        ];
    }

    /**
     *  Filters to be applied to the input.
     *
     * @return array
     */
    public function filters()
    {
        return [
            'first_name' => 'trim|escape',
            'last_name' => 'trim|escape',
            'email_address' => 'trim|escape',
            'message' => 'trim|escape',
            'business_name' => 'trim|escape'
        ];
    }
}
