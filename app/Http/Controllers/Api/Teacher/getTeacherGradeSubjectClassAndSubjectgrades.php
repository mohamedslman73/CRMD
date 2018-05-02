<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Attendance;
use App\Classes;
use App\Grade;
use App\Subject;
use App\TeacherSubjects;
use App\UserTokens;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class getTeacherGradeSubjectClassAndSubjectgrades extends Controller
{
    public function getTeacherGradeSubjectClassAndSubjectgrades(Request $request)
    {
        {
            $this->validate($request,[
                'api_token'=>'required|exists:user_tokens,api_token'
            ]);
            $userID = UserTokens::where('api_token',$request->api_token)->value('user_id');
            $student_class = TeacherSubjects::where('user_id',$userID)->with('classes.students')->with('subjects')->get();
            $class_id = TeacherSubjects::where('user_id',$userID)->value('class_id');//4
            $grade_id = Classes::where('id',$class_id)->value('grade_id');//1
            $class_name = Classes::where('id',$class_id)->value('name');
            $grade_name = Grade::where('id',$grade_id)->value('name');
            $subject_name = Subject::where('grade_id',$grade_id)
                ->select('id','subject_name')
                ->get();
            $subject = Subject::where('grade_id',$grade_id)->first();
            $tt = Subject::where('grade_id',$grade_id);

                        // return $student_class;
                      foreach ($student_class as $row)
                      {
                         // return $row->classes->students;


                              foreach ($row->classes->students as $student) {

                                  $current = Carbon::now();
                                  $start_of_month = $current->startOfMonth()->format('y-m-d');
                                  $end_of_month = $current->endOfMonth()->format('y-m-d');
                                  // add 30 days to the current time
                                  $trialExpires = $current->addDays(30);
                                  $a = Attendance::where('user_id', $student->id)
                                      ->where('absence_date', '>=', $start_of_month)
                                      ->where('absence_date', '<=', $end_of_month)
                                      ->where('subject_id', $subject->id)
                                      ->count();
                                  $student->Absence_count = $a;
                              }

                      }
//                ->select('id','subject_name')
//                ->get();
//            $Student = Subject::where('grade_id',$grade_id)
//                ->select('id','subject_name')
//                ->with(['addgrade.students'])
//                ->get();


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
            foreach ($student_class as $var)
            {
                $var->Grade_Year = $grade_name;
                $var->Class_name = $class_name;
            }
            // return $this->fire($Student);
            //  $Student->grade_name = $grade_name;
            // $Student->class_name = $class_name  ;
            return response(['grades'=>$student_class,'subjects'=>$subject_name]);
            //  return $this->fire($Student);
        }
    }
}

