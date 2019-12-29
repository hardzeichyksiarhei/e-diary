<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhysicalFitnessRequest extends FormRequest
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
            'age' => 'numeric|required',
            'long_jump' => 'numeric|nullable',
            'torso_inclination' => 'numeric|nullable',
            'run_shuttle' => 'numeric|nullable',
            'press' => 'numeric|nullable',
            'run_short' => 'numeric|nullable',
            'push_up' => 'numeric|nullable',
            'run_long' => 'numeric|nullable',
            'pull_up' => 'numeric|nullable',
            'swimming_s' => 'numeric|nullable',
            'swimming_m' => 'numeric|nullable'
        ];
    }
}
