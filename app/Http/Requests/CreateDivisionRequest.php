<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDivisionRequest extends FormRequest
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
            'name'                      =>'required',
            'lessons_per_day'           =>'required',
            'lesson_duration'           =>'required',
            'day_start_at'              =>'required',
            'day_end_at'                =>'required',
            //'api_token'               => 'required|exists:user_tokens,api_token',
            'education_type_id'         =>'required|exists:education_types,id',
            'start_date'                =>'required',
            'end_date'                  =>'required',
            'duration'                  =>'required',
            'break_name'                =>'required',
            'day'                       =>'required',
            'school_id'                 =>'required|exists:schools,id'
        ];
    }
    public function messages()
    {
        return [
            'name.required'                   =>'Divison_Name_Is_Required',
            'lessons_per_day.required'        =>'Lessons_Per_Day_Is_Required',
            'lesson_duration.required'        =>'Lessons_Duration_Is_Required',
            'day_start_at.required'           =>'Day_Start_At_Is_Required',
            'day_end_at.required'             =>'Day_End_At_Is_Required',
            'education_type_id.required'      =>'Education_Type_Id_Is_Required',
            'education_type_id.exists'        =>'Education_Type_Id_Not_Found',
            'start_date.required'             =>'Start_Date_Is_Required',
            'end_date.required'               =>'End_Date_Is_Required',
            'duration.required'               =>'Duration_Is_Required',
            'break_name.required'             =>'Break_Name_Is_Required',
            'day.required'                    =>'Day_Is_Required',
            'school_id.required'              =>'School_Id_Is_Required',
            'school_id.exists'                =>'School_Id_Is_Required',
        ];
    }
}
