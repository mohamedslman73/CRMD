<?php

namespace App\Http\Controllers\Api\Subject;

use App\Subject;
use App\TeacherSubjects;
use App\UserTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;

class CreateSubject extends ApiController
{
    //

    public function CreateSubject(Request $request)
    {
        $this->validate($request, [
            'api_token' => 'required',
            'grade_id' => 'required|exists:grades,id',
            'subject_name' => 'required',
            'subject_description' => 'required',
            'subject_weight' => 'required',
            'success_percentage' => 'required',
            'attendance_percentage' => 'required',
            'term' => 'required|numeric',
            'book_name' => 'required',
            //'class_id' => 'required|exists:classes,id'
        ]);

        $userID = UserTokens::where('api_token', $request->api_token)
            ->first()
            ->user_id;

        $subject = new Subject;
        $subject->grade_id = $request->grade_id;
        $subject->subject_name = $request->subject_name;
        $subject->subject_description = $request->subject_description;
        $subject->subject_weight = $request->subject_weight;
        $subject->success_percentage = $request->success_percentage;
        $subject->attendance_percentage = $request->attendance_percentage;
        $subject->term = $request->term;
        $subject->book_name = $request->book_name;

        $subject->save();

       /* $teacher_subject = new TeacherSubjects();
        $teacher_subject->user_id = $userID;
        $teacher_subject->subject_id = $subject->id;
        $teacher_subject->class_id = $request->class_id;
        $teacher_subject->save();*/

        return $this->fire($subject);

    }
}
