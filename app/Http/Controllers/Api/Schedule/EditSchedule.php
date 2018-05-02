<?php

namespace App\Http\Controllers\Api\Schedule;

use App\Classes;
use App\Grade;
use App\Schedule;
use App\User;
use App\UserTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class EditSchedule extends Controller
{
    public function EditSchedule(Request $request)
    {
        $this->validate($request, [
            'schedule_id' => 'required|exists:schedules,id',
            'api_token' => 'required|exists:user_tokens,api_token'
        ]);

        $schedule = Schedule::where('id', $request->schedule_id)->first();

        $userID = UserTokens::where('api_token', $request->api_token)->value('user_id');//22
        $user_type_id = User::where('id', $userID)->value('type_id');//2
        $school_id = User::where('id', $userID)->value('school_id');//40
        $class_id = Schedule::where('id', $request->schedule_id)->value('class_id');//3
        $grade_id = Classes::where('id', $class_id)->value('grade_id');//8
        $division_id = Grade::where('id', $grade_id)->value('division_id');//1
        $school_shedule_id = Division::where('id', $division_id)->value('school_id');//40
        if ($user_type_id == 1 or ($user_type_id == 2 and $school_id == $school_shedule_id)) {
            if ($schedule) {
                for ($i = 0; $i < count($request->subject_id); $i++) {

                    if ($request->has('class_id')) {
                        $schedule->class_id = $request->class_id;
                    }
                    if ($request->has('subject_id')) {
                        $schedule->subject_id = $request->subject_id[$i];
                    }
                    if ($request->has('day_id')) {
                        $schedule->day_id = $request->day_id[$i];
                    }
                    if ($request->has('period')) {
                        $schedule->period = $request->period[$i];
                    }

                    $schedule->update();
                }
            }
            return response()->json(['schedule' => $schedule]);
        }
    }

}
