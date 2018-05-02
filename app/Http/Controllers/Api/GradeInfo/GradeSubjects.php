<?php

namespace App\Http\Controllers\Api\GradeInfo;

use App\Classes;
use App\Grade;
use App\Subject;
use App\UserGrades;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GradeSubjects extends Controller
{
    //

    public function GradeSubjects(Request $request)
    {
        $this->validate($request,[
            'grade_id'=>'required|exists:grades,id'
        ]);
        $subject = Subject::where('grade_id',$request->grade_id)->get();

        $students = UserGrades::where('grade_id',$request->grade_id)
                                     ->select('id','user_id','grade_id')
                                     ->with(['user'=>function($user){
                                         $user->select('id','name');
                                     }])->get();
        return response(['subjects'=>$subject,'students'=>$students]);
    }
}
