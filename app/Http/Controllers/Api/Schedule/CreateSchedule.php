<?php

namespace App\Http\Controllers\Api\Schedule;
use Carbon\Carbon;
use App\Classes;
use App\Day;
use App\Division;
use App\DivisionBreaks;
use App\Grade;
use App\Http\Controllers\Api\ApiController;
use App\Schedule;
use App\User;
use App\UserTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpParser\Builder\Class_;

class CreateSchedule extends ApiController
{
    //

    public function CreateSchedule(Request $request)
    {
        $this->validate($request,[
          //  'api_token'=>'required',
            'class_id' =>'required|exists:classes,id',
            'day_id'   =>'required',
            'period'   =>'required',
            'subject_id'   =>'required|exists:subjects,id',
        ]);
/*
          $userID = UserTokens::where('api_token',$request->api_token)
                               ->first()
                               ->user_id;
         $school_id = User::where('id',$userID)
                           ->first()
                           ->school_id;
         $grade = Classes::where('id',$request->class_id)->first()->grade_id;
         $division_id = Grade::where('id',$grade)->first()->division_id;
         $division = Division::where('id',$division_id)->get();

         $division_breaks = DivisionBreaks::where('division_id',$division_id)->get();*/
        for($i=0;$i<count($request->subject_id); $i++){
            $schedule = new Schedule();
            $schedule->class_id = $request->class_id;
            $schedule->subject_id = $request->subject_id[$i];
            $schedule->day_id = $request->day_id[$i];
            $schedule->period = $request->period[$i];

            $schedule->save();
        }
         return response()->json(['schedule'=>$schedule]);

    }
}
