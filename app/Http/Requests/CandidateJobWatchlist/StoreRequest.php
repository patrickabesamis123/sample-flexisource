<?php

namespace App\Http\Requests\CandidateJobWatchlist;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
        $candidateId = 3;
        return [
            'job_id' => 'required|unique:c_job_watchlist,job_id,NULL,id,candidate_id,' . $candidateId
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return ['job_id.unique' => 'The job is already in the watchlist.'];
    }
}
