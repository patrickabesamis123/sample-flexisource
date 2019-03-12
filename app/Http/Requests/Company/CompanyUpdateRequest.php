<?php

namespace App\Http\Requests\Company;

use App\Http\Requests\BaseFormRequest;

class CompanyUpdateRequest extends BaseFormRequest
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
            'company_name' => 'required|min:10|max:255',
            'company_description' => 'required|min:50',
            'num_of_employees' => 'required',
            'status' => 'required',
            'logo_url' => 'nullable|string',
            'website_url' => 'nullable|string',
            'company_phone' => 'nullable|string',
            'company_fax' => 'nullable|string',
            'nz_business_num' => 'nullable|string',
            'street_address' => 'nullable|string',
            'street_address_2' => 'nullable|string',
            'company_url' => 'nullable|string',
            'company_banner_url' => 'nullable|string',
            'helper_text' => 'nullable|string'
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
            'company_name.required' => 'Company name is required!',
            'company_name.min:10' => 'Company name must contain at least 10 characters in length',
            'company_name.max:255' => 'Company name must not exceeds 255 characters in length',
            'company_description.required' => 'Company description is required!',
            'num_of_employees.required' => 'Company number of employees is required!',
            'status' => 'Company status is required'
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
            'company_name' => 'trim|escape',
            'company_description' => 'trim|escape',
            'num_of_employees' => 'trim|escape',
            'logo_url' => 'trim|escape|lowercase',
            'website_url' => 'trim|escape|lowercase',
            'company_phone' => 'trim|escape',
            'company_fax' => 'trim|escape',
            'nz_business_num' => 'trim|escape',
            'street_address' => 'trim|escape',
            'street_address_2' => 'trim|escape',
            'company_url' => 'trim|escape|lowercase',
            'company_banner_url' => 'trim|escape|lowercase',
            'helper_text' => 'trim|escape',
            'status' => 'trim|escape'
        ];
    }
}
