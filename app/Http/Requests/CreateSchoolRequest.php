<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSchoolRequest extends FormRequest
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
            'name'                              => 'required',
            'logo'                              => 'required|image',
            'vision'                            => 'required',
            'mission'                           => 'required',
            'address'                           => 'required',
            // 'longitude'                      => 'required',
            //  'latitude'                      => 'required',
            'district_id'                       =>'required|numeric|exists:districts,id',
            'emails'                            =>'required',
            'numbers'                           =>'required',
            'schoolyears'                       =>'required',
            'schooltypes'                       =>'required',

        ];
    }
    public function messages()
    {
        return [
            'name.required'                    =>'Name_Is_Required',
            'logo.required'                    =>'Logo_Is_Required',
            'logo.image'                       =>'Logo_Must_Be_Image',
            'vision.required'                  =>'Vision_Is_Required',
            'mission.required'                 =>'Mission_Is_Required',
            'address.required'                 =>'Address_Is_Required',
            'district_id.required'             =>'District_Id_Is_Required',
            'district_id.numeric'              =>'District_Id_Must_Be_Numeric_Value',
            'district_id.exists'               =>'District_Id_Not_Found',
            'emails.required'                  =>'Emails_Is_Required_And_must_Be_Array_Type',
            'numbers.required'                 =>'Numbers_Is_Required_And_must_Be_Array_Type',
            'schoolyears.required'             =>'SchoolYears_Is_Required_And_must_Be_Array_Type',
            'schooltypes.required'             =>'SchoolTypes_Is_Required_And_must_Be_Array_Type',
        ];
    }
}
