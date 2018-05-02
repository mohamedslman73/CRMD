<?php

namespace App\Http\Controllers\Api\Student;
use Carbon\Carbon;
use App\Attendance;
use App\Classes;
use App\StudentClass;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\ApiController;
class StudentController extends ApiController
{
    //
    public function getStudent(Request $request)
    {

        $this->validate($request,[
        'grade_id'=>'required|exists:grades,id',
        //'api_token'=>'required|exists:user_tokens,id'
        ]);

       // $userID = UserTokens::where('api_token', $request->api_token)->first()->user_id;
      //  $var = TeacherSubjects::where('user_id',$userID)->get(['class_id']);
        //4
         $asd = Subject::where('grade_id',$request->grade_id)->first();
         $students = Classes::where('grade_id',$request->grade_id)->with('students')->get();

      foreach ($students as $row)
      {

          //return $row->students;
          foreach ($row->students as $student)
          {
              $current = Carbon::now();
              $start_of_month = $current->startOfMonth()->format('y-m-d');
              $end_of_month = $current->endOfMonth()->format('y-m-d');
              // add 30 days to the current time
              $trialExpires = $current->addDays(30);
                $a= Attendance::where('user_id',$student->id)
                    ->where('absence_date','>=',$start_of_month)
                    ->where('absence_date','<=',$end_of_month)
                    ->where('subject_id',$asd->id)
                    ->count();
             $student->Absence_count=$a;
          }
      }
        return $this->fire($students);

    }

    public function getstudentclass(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:student_classes,user_id',
        ]);
        $student = StudentClass::where('user_id', $request->id)->first();
        $student->users->name;
        return $student;
        // $rr=DB::select("SELECT 'class_id' FROM 'student_classes' WHERE 'user_id'=$student");
        // return  $a = User::where('id',$student)->get();

    }


}
