<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AbsenceTypeRequest extends FormRequest
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
        $rules =  [
            'description' => 'required|string|min:1|max:100',
        ];

        if ($this->getMethod() == 'POST') {
            // POST is for create
            $rules += [
                'duration_unit' => 'required',
                'colour_code' => 'required'
            ];
        }

        if ($this->getMethod() == 'PUT' || $this->getMethod() == 'PATCH') {
            $rules += [
                'duration_unit' => 'required',
                'duration_unit' => 'nullable',
                'eligibility_begins' => 'nullable',
                'eligibility_ends' => 'nullable',
                'accrue_period' => 'nullable',
                'amount_earns' => 'required',
            ];
        }

        return $rules;
    }
}
