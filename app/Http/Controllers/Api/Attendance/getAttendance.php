<?php

namespace App\Http\Controllers\Api\Attendance;

use App\Attendance;
use App\Http\Controllers\Api\ApiController;
use App\User;
use App\UserTokens;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class getAttendance extends ApiController
{
    public function getAttendance(Request $request)
    {
        $this->validate($request,[
            'absence_date'=>'required',
            'api_token'=>'required|exists:user_tokens,api_token',
           // 'user_id'=>'required|exists:users,id',
            'subject_id'=>'required|exists:subjects,id',
        ]);

        $userID = UserTokens::where('api_token', $request->api_token)->first()->user_id;
        $school_id = User::where('id',$userID)->first()->school_id;
        $attendance = Attendance::where('absence_date',$request->absence_date)
                                  ->where('school_id',$school_id)
                                  ->where('subject_id',$request->subject_id)
                                  ->with(['users'=>function($users){
                                      $users->select('id','name');
                                  }])
                                  ->get()->toArray();

        return $this->fire($attendance);
    }
}
