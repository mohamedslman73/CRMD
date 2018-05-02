<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'email'                     =>'required|email|unique:users',
            'password'                  =>'required',
            'type_id'                   =>'required|exists:user_types,id',
            'school_id'                 =>'required|exists:schools,id',
            'class_id'                  =>'required|exists:classes,id',
            'grade_id'                  =>'required|exists:grades,id',
            'type_name'                 =>'required',
            'image'                     =>'required|image',
            'phone'                     =>'required',
            'address'                   =>'required',
        ];
    }

    public function messages()
    {
        return[
            'name.required'            =>'Name_Is_Requierd' ,
            'email.required'           =>'Email_Is_Requierd',
            'email.unique'             =>'Email_Is_Already_Taken',
            'email.email'              =>'Email_Should_Be_Valid_Email',
            'password.required'        =>'Password_Is_Required',
            'type_id.required'         =>'Type_Id_Is_Required_And_Should_Be_Valid',
            'type_id.exists'           =>'This_Type_Id_Not_Found',
            'school_id.required'       =>'School_Id_Is_Required_And_Should_Be_Valid',
            'school_id.exists'         =>'This_School_Id_Not_Found',
            'class_id.required'        =>'Class_Id_Is_Required_And_Array_Type',
            'class_id.exists'          =>'This_Class_Id_Not_Found',
            'grade_id.required'        =>'Grade_Id_Is_Required_And_Array_Type',
            'grade_id.exists'          =>'This_Grade_Id_Not_Found',
            'type_name.required'       =>'Type_Name_Is_Required',
            'phone.required'           =>'Phone_Is_Required',
            'address.required'         =>'Address_Is_Required',
            'image.required'           =>'Image_Is_Required',
            'image.image'              =>'This_Image_Should_Be_Valid_Image',
        ];
    }
}
