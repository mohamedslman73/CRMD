<?php

namespace App\Http\Controllers\Api\Subject;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserTokens;
use App\TeacherSubjects;
use App\Subject;
class getTeacherSubject extends ApiController
{
    //

    public function getsubject(Request $request)
    {   $this->validate($request,[
        'api_token'=>'required|exists:user_tokens,api_token',
    ]);

        $userID = UserTokens::where('api_token', $request->api_token)
            ->first()
            ->user_id;

        $var = TeacherSubjects::where('user_id',$userID)->get(['subject_id']);
        //$val = array();
        foreach ($var as $a)
        {
            $value[] = $a->subject_id;
        }

        $subject = Subject::whereIn('id',$value)->get();
     /*   foreach ($subject as $s) {
            $val []= $s->subject_name;
            $val []= $s->id;
        }*/
     return $this->fire($subject);
         return $this->fire(['Subject name'=>$val]);
    }
}
