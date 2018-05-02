<?php

namespace App\Http\Controllers\Api\Student;

use App\Addgrade;
use App\Classes;
use App\StudentClass;
use App\StudentGrades;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\Controller;

class StudentGradesController extends ApiController
{
    public function createStudentGrades(Request $request)
    {
        $this->validate($request,[
            'grade_name'=>'required',
            'total_score'=>'required',
            'weight'=>'required',
            'type'=>'required',
            'class_id'=>'required|exists:classes,id',
            'subject_id'=>'required|exists:subjects,id',
        ]);

        $var  = StudentClass::where('class_id', $request->class_id)->pluck('user_id');
        $studentgrade = new Addgrade();
        $studentgrade->class_id = $request->class_id;
        $studentgrade->subject_id = $request->subject_id;
        $studentgrade->grade_name = $request->grade_name;
        $studentgrade->total_score = $request->total_score;
        $studentgrade->weight = $request->weight;
        $studentgrade->type = $request->type;
        $studentgrade->save();

        foreach ($var as $student) {
            //   return $student;
            //   return 'salman';
            $student_grades = new StudentGrades;
            $student_grades->total_score = 0;
            $student_grades->user_id = $student;
            $student_grades->addgrade_id = $studentgrade->id;
            $student_grades->save();
        }
        $students  = Addgrade::where('id',$studentgrade->id)
            ->select('id','class_id','subject_id','grade_name','total_score','weight','type')
            ->with(['students.user'=>function($user){
                $user->select('id','name');
            }])
            ->get();
        return $this->fire($students);
       // return response(['scode'=>200,'studentgrade'=>$studentgrade,'students'=>$students]);
    }

    public function getGrades()
    {
        $grades=StudentGrades::with('user')->get();
        return $this->fire($grades);
    }

    public function edit(Request $request)
    {
        $this->validate($request,
            [
                'user_id'=>'required',
            ]);
        $grades = StudentGrades::where('id',$request->id)->first();
        $grades->total_score = $request->total_score;
        $grades->weight = $request->weight;
        $grades->save();
        return $this->fire($grades);

    }

    public function Delete(Request $request)
    {
            $this->validate($request,[
                'id'=>'required|exists:student_grades,id'
            ]);
        $studentGrades =StudentGrades::find($request->id);
    // return $grades;
       $grades = $studentGrades->delete();
       if ($grades) {
           return response()->json(['status' => 200, 'message' => 'Deleted Successfully']);
       }
       else
       {
           return response()->json(['status'=>400,'message'=>'Some Errors Happened']);

       }
    }
}
