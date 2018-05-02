<?php


namespace App\Http\Controllers\Api\Attendance;

use App\Attendance;
use App\Notification;
use App\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\UserTokens;
use App\User;


class EditAttendance extends ApiController
{
    public function EditAttendance(Request $request)
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
        $attendance = Attendance::where('absence_date',$request->absence_date)->first();
        if(is_array($request->user_id) != 0)
        {
            $token = array();
            foreach ($request->user_id as $user)
            {
                $token []= User::find($user)->refresh_token;
                //  $token = User::find($user->id)->refresh_token;
                $attendance = Attendance::where('absence_date',$request->absence_date)
                    ->where('user_id',$user)->delete();
                    /*
                     * Notification Section
                     */
                    $msg = array(
                        'title' => 'Mr/'.$user_name,
                        'body' => 'There are an update in your Attendance in '.$subject_name.' subject',
                        'image' => '',/*Default Icon*/
                        'sound' => 'mySound'/*Default sound*/
                    );
                    $notification = new Notification();
                    $notification->user_id = $user;
                    $notification->title = 'Mr. '.$user_name;
                    $notification->notification_type = 2;
                    $notification->body = 'There are an update in Your Attendance in '.$subject_name.' Subject by Mr. ' .$user_name;
                    $notification->save();
                    notify1($token, $msg);
                }

            }
       // $attendance = Attendance::where('absence_date',$request->absence_date)->get();
        return response(['message'=>'Deleted Successfully']);
    }

}
