<?php

namespace App\Http\Requests\Employer;

use App\Http\Requests\BaseFormRequest;

class UpdateBasicInformationRequest extends BaseFormRequest
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
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'nickname' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'mobile_number' => 'nullable|string',
            'work_title' => 'nullable|string',
            'work_dept' => 'nullable|string',
        ];
    }

     /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [ ];
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
            'nickname' => 'trim|escape',
            'phone_number' => 'trim|escape',
            'mobile_number' => 'trim|escape',
            'work_title' => 'trim|escape',
            'work_dept' => 'trim|escape',
        ];
    }
}
