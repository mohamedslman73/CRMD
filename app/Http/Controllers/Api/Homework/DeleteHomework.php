<?php

namespace App\Http\Controllers\Api\Homework;

use App\HomeWorks;
use App\TeacherSubjects;
use App\User;
use App\UserTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteHomework extends Controller
{
    public function DeleteHomework(Request $request)
    {
        $this->validate($request,[
            'api_token'    =>'required|exists:user_tokens,api_token',
            'homework_id'  =>'required|exists:home_works,id'
        ]);

        $userID = UserTokens::where('api_token',$request->api_token)
            ->value('user_id');
        $user_type_id = User::where('id',$userID)
            ->value('type_id');
        $school_id = User::where('id',$userID)
            ->first()
            ->school_id; // 40
        $homework_subject = HomeWorks::where('id',$request->homework_id)->value('subject_id');//6
        $teacher_subject = TeacherSubjects::where('user_id',$userID)->value('subject_id');
        $homework_school = HomeWorks::where('id',$request->homework_id)->value('school_id');//40
        $homework = HomeWorks::where('id',$request->homework_id)->first();
        if ($user_type_id == 3 and ($school_id ==$homework_school) and ($teacher_subject ==$homework_subject)){
            if ($homework){
                $homework->delete();
            }
        }else{
            return response(['error'=>'U can\'t Complete This Operation']);
        }
        return response(['data'=>'Homework_Deleted_Successfully']);
    }
}
