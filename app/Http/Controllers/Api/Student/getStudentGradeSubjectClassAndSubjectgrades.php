<?php

namespace App\Http\Controllers\Api\Student;

use App\Addgrade;
use App\Classes;
use App\Grade;
use App\Http\Controllers\Api\ApiController;
use App\StudentClass;
use App\StudentGrades;
use App\Subject;
use App\UserTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class getStudentGradeSubjectClassAndSubjectgrades extends ApiController
{
    public function getStudentGradeSubjectClassAndSubjectgrades(Request $request)
    {
        $this->validate($request,[
            'api_token'=>'required|exists:user_tokens,api_token'
        ]);
        $userID = UserTokens::where('api_token',$request->api_token)->value('user_id');
        $student_class = StudentClass::where('user_id',$userID)->with('classes')->with('users')->get();
       $class_id = StudentClass::where('user_id',$userID)->value('class_id');//4
       $grade_id = Classes::where('id',$class_id)->value('grade_id');//1
       $class_name = Classes::where('id',$class_id)->value('name');
       $grade_name = Grade::where('id',$grade_id)->value('name');
       $subject = Subject::where('grade_id',$grade_id)
                          ->select('id','subject_name')
                          ->get();
        $Student = Subject::where('grade_id',$grade_id)
            ->select('id','subject_name')
            ->with(['addgrade.students'=>function($students) use ($userID) {
                $students->where('user_id', $userID);
            }])
            ->get();


      /*  $a =array();
        $name = array();
      //  $student = StudentClass::where('class_id', $request->class_id)->get();
        foreach ($subject as $id) {
             $a [] = $id->id;
        }
        $addgrade_id = Addgrade::where('class_id', $class_id)->whereIn('subject_id',$a)
            ->get(['id']);
        foreach ($addgrade_id as $add)
        {
            $name [] = $add->id  ;
        }*/
//        $Student = StudentGrades::where('user_id',$userID)
//                                 ->whereIn('addgrade_id',$name)
//                                 ->with('addgrade')   //.subject
//                                 ->get();
//        $Student = Subject::whereIn('id',$a)->select('id','subject_name')
//                            ->with('addgrade.students')
//                            ->get();
        foreach ($Student as $var)
        {
            $var->Grade_Year = $grade_name;
            $var->Class_name = $class_name;
        }
       // return $this->fire($Student);
      //  $Student->grade_name = $grade_name;
       // $Student->class_name = $class_name  ;
       return response(['grades'=>$Student,'subjects'=>$subject]);
      //  return $this->fire($Student);
    }

}
