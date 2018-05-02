<?php

namespace App\Http\Controllers\Api\Teacher;

use App\StudentClass;
use App\StudentGrades;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeacherStudentOnClass extends Controller
{
    //

    public function TeacherStudentOnClass(Request $request)
    {
        $this->validate($request,[
            'class_id'=>'required|exists:classes,id'
        ]);

        $student = StudentClass::where('class_id',$request->class_id)->select('id','user_id','class_id')->with(['users'=>function($users){
            $users->select('id','name','email');
        }])->get();

        return response()->json(['data'=>$student]);

    }
}
