<?php

namespace App\Http\Controllers\Api\Attendance;

use App\Attendance;
use App\Subject;
use App\TeacherSubjects;
use App\User;
use App\UserTokens;
use Illuminate\Http\Request;
    use App\Http\Controllers\Api\ApiController;

class CreateAttendance extends ApiController
{
    //

    public function CreateAttendance(Request $request)
    {
        $this->validate($request,[
            'absence_date'=>'required',
            'api_token'=>'required|exists:user_tokens,api_token',
            'user_id'=>'required|exists:users,id',
            'subject_id'=>'required|exists:subjects,id',
        ]);

        $userID = UserTokens::where('api_token', $request->api_token)->first()->user_id;
        $school_id = User::where('id',$userID)->first()->school_id;
        $user_name = User::find($userID)->name;
        $subject_name = Subject::find($request->subject_id)->subject_name;

        if(count($request->user_id) != 0)
        {
            foreach ($request->user_id as $user)
            {
               // return $user;
               // return $request->user_id;
                $token = User::find($user)->refresh_token;
              //  $token = User::find($user->id)->refresh_token;
                $attendance = new Attendance;
                $attendance->user_id =$user;
                $attendance->absence_date = $request->absence_date;
                $attendance->school_id =$school_id;
                $attendance->subject_id =$request->subject_id;
                $attendance->save();
                $msg = array(
                    'title' => 'Mr/'.$user_name,
                    'body' => 'you are not in your class in '.$subject_name.' subject',
                    'image' => '',/*Default Icon*/
                    'sound' => 'mySound'/*Default sound*/
                );
                notify1([$token], $msg);
            }

        }


        return $this->fire($attendance);
    }
}
