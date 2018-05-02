<?php

namespace App\Http\Controllers\Api\Behavior;

use App\Behavior;
use App\Http\Controllers\Api\ApiController;
use App\TeacherSubjects;
use App\UserTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class studentBehavior extends ApiController
{
    public function studentBehavior(Request $request)
    {
        $this->validate($request,[
            'api_token' =>'required|exists:user_tokens,api_token',
            'student_id' => 'required',
        ]);
        $request_id = $request->student_id;
        $userID = UserTokens::where('api_token',$request->api_token)->value('user_id');
        $teacher_class = TeacherSubjects::where('user_id',$userID)->value('class_id');//60
        $teacher_subject = TeacherSubjects::where('user_id',$userID)->value('subject_id');//30
        $behavior_class = Behavior::where('student_id',$request->student_id)->value('class_id');//
        $behavior_subject = Behavior::where('student_id',$request->student_id)->value('subject_id');
        if (($teacher_class == $behavior_class) and ($teacher_subject == $behavior_subject)){
            $student_behavior = Behavior::where('student_id',$request->student_id)
                                         ->with(['studentBehavior'=>function($studentBehavior) use($request_id){
                                             $studentBehavior->where('student_id',$request_id);
                                         }])
                                         ->get()->toArray();
            return $this->fire($student_behavior);
        }
        return response(['scode'=>404,'data'=>'Sorry No Data To Show']);
    }
}
