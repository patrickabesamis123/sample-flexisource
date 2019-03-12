<?php

namespace App\Http\Requests\Customer;

use App\Http\Requests\BaseFormRequest;

class HarmfulComplaintRequest extends BaseFormRequest
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
            'phone_number' => 'required|string',
            'email_address' => 'required|email',
            'breach_details' => 'required|string',

            'subject' => 'nullable|string',
            'message' => 'nullable|string',
            'business_name' => 'nullable|string',

            'address' => 'nullable|string',
            'communication_type' => 'nullable|string',
            'link_to_abusive_content' => 'nullable|string',
            'user_consent' => 'nullable|string'
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
            'phone_number.required' => 'Phone Number is required',
            'phone_number.string' => 'Phone Number must be a string type',
            'email_address.required' => 'Email Address is required',
            'email_address.email' => 'Not a valid email address',
            'breach_details.required' => 'Breach Details is required',
            'breach_details.string' => 'Breach Details must be a string type'
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
            'address' => 'trim|escape',
            'breach_details' => 'trim|escape',
            'link_to_abusive_content' => 'trim|escape',
            'phone_number' => 'trim|escape'
        ];
    }
}
