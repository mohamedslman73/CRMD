<?php

namespace App\Http\Controllers\Api\GradeInfo;

use App\TeacherSubjects;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddSubjectToClass extends Controller
{
    public function AddSubjectToClass(Request $request)
    {
        $this->validate($request,[
          'user_id'=>'required|exists:users,id',
          'class_id'=>'required|exists:classes,id',
          'subject_id'=>'required|exists:subjects,id',
        ]);
        $teacher_subject = new TeacherSubjects();
        $teacher_subject->user_id = $request->user_id;
        $teacher_subject->class_id = $request->class_id;
        $teacher_subject->subject_id = $request->subject_id;
        $teacher_subject->save();
        return response(['data'=>$teacher_subject]);
    }
}
