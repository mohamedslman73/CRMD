<?php

namespace App\Http\Controllers\Api\Calendar;

use App\Calendar;
use App\User;
use App\UserTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EditCalendar extends Controller
{
    public function EditCalendar(Request $request)
    {
        $this->validate($request,[
             'api_token' =>'required|exists:user_tokens,api_token',
             'calendar_id' =>'required|exists:calendars,id',
        ]);
        $userID   = UserTokens::where('api_token',$request->api_token)->value('user_id');
        $school_id = User::where('id',$userID)->value('school_id');
        $user_type_id = User::where('id',$userID)->value('type_id');
        $school_calendar_id = Calendar::where('id',$request->calendar_id)->value('school_id');
        if ($user_type_id == 2 and ($school_id == $school_calendar_id)){
            $calendar = Calendar::where('id',$request->calendar_id)->first();
            if ($calendar) {
                if ($request->has('name')) {
                    $calendar->name = $request->name;
                }
                if ($request->has('description')) {
                    $calendar->description = $request->description;
                }
                if ($request->has('start_at')) {
                    $calendar->start_at = $request->start_at;
                }
                if ($request->has('end_at')) {
                    $calendar->end_at = $request->end_at;
                }
                if ($request->has('start_time')) {
                    $calendar->start_time = $request->start_time;
                }
                $calendar->update();
                return response(['scode'=>200,'data'=>$calendar]);
            }
        }
        return response(['scode'=>404,'error'=>'U Can\'t Complete this process']);
    }
}
