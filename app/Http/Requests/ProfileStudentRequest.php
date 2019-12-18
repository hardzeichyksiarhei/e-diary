<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileStudentRequest extends FormRequest
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
	        'faculty_id' => 'required|not_in:null',
	        'teacher_id' => 'required|not_in:null',
	        'health_group_id' => 'required|not_in:null',
	        'birthday' => 'required|date_format:d/m/Y',
	        'gender' => 'required|in:man,woman',
	        'course' => 'required|not_in:null',
	        'group' => 'required'
        ];
    }
}
