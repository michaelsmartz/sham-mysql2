<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class WorkingYearRequest extends FormRequest
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
        $working_start_year = Input::get('working_year_start');
        $valid_end_year     =  date("Y-m-d", strtotime(date("Y-m-d", strtotime($working_start_year)) . " + 365 day"));

        return [
            'working_year_start' => 'required|date|before:working_year_end',
            'working_year_end'   => 'required|date|in:'.$valid_end_year
        ];
    }

    public function messages()
    {
        return [
            'working_year_start.before' => 'Working Year Start must be before the Working Year End!',
            'working_year_end.in'     => 'Working Year Start and Working Year End must be within 1 year!'
        ];

    }
}
