<?php

namespace App\Http\Requests\Company;

use App\Http\Requests\BaseFormRequest;

class CompanyTeamInviteRequest extends BaseFormRequest
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
            'email' => 'required|email'
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
            'first_name.required' => 'Firstname is required',
            'first_name.string' => 'Firstname must be an string type',
            'last_name.required' => 'Lastname is required',
            'last_name.string' => 'Lastname must be a string type',
            'email.required' => 'Email is required',
            'email.email' => 'Not a valid Email Address',
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
            'email' => 'trim|escape'
        ];
    }
}
