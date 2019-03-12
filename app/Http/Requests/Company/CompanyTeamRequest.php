<?php

namespace App\Http\Requests\Company;

use App\Http\Requests\BaseFormRequest;

class CompanyTeamRequest extends BaseFormRequest
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
            'created_by_id' => 'required|numeric',
            'team_name' => 'required|string',
            'company_id' => 'required|numeric'
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
            'created_by_id.required' => 'Employer Id is required',
            'created_by_id.numeric' => 'Employer Id must be an integer type',
            'team_name.required' => 'Team Name is required',
            'team_name.string' => 'Team Name must be a string type',
            'company_id.required' => 'Company Id is required',
            'company_id.numeric' => 'Company Id must be an integer',
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
            'team_name' => 'trim|escape'
        ];
    }
}
