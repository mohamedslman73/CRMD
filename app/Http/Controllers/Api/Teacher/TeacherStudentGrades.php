<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Addgrade;
use App\Http\Controllers\Api\ApiController;
use App\StudentClass;
use App\StudentGrades;
use App\User;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeacherStudentGrades extends ApiController
{
    //
    public function TeacherStudentGrades(Request $request)
    {
        $this->validate($request, [
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

//         $student = StudentClass::where('class_id',$request->class_id)->get();
//     foreach ($student as $id)
//     {
//          $a [] =$id->user_id;
//
//     }
//       // return $a;
//        $Student =  StudentGrades::whereIn('user_id',$a)->select('id','grade_name','total_score','user_id')->with(['user'=>function($user){
//            $user->select('id','name');
//        }])->get();
////        for ($i=0;$i<count($Student);$i++)
////        {
////            $user_name = User::find($Student[$i]['user_id'])->name;
////            $Student[$i]['user'] =$user_name;
////        }
//
//        return response()->json(['Grades'=>$Student]);
$a =array();
$name = array();
        $student = StudentClass::where('class_id', $request->class_id)->get();
        $student_name = StudentClass::where('user_id', $request->class_id)->get();
        foreach ($student as $id) {
            $a [] = $id->class_id;
        }

         $Student = Addgrade::whereIn('class_id', $a)
                             ->where('subject_id',$request->subject_id)
                             ->select('id','class_id','subject_id','grade_name','total_score','weight','type')
                             ->with(['students.user'=>function($user){
                                $user->select('id','name');
                             }])
                             ->get();
        return $this->fire($Student);
    }
}
