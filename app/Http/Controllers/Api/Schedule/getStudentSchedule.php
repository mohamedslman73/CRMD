<?php

namespace App\Http\Controllers\Api\Schedule;

use App\Day;
use App\Division;
use App\Http\Controllers\Api\ApiController;
use App\Schedule;
use App\StudentClass;
use App\Subject;
use App\User;
use App\UserTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class getStudentSchedule extends ApiController
{
    //
    public function getStudentSchedule(Request $request)
    {
        $this->validate($request,[
            'api_token'=>'required',
        ]);


        $userID = UserTokens::where('api_token',$request->api_token)
            ->first()
            ->user_id;

        $school_id = User::where('id',$userID)->first()->school_id;
        $division = Division::where('school_id',$school_id)->with('divisionBreaks')->first();
        $class_id = StudentClass::where('user_id',$userID)->first()->class_id;

            $day_start_at  = $division->day_start_at;
            $lesson_duration = $division->lesson_duration;
            $lessons_per_day = $division->lessons_per_day;
            $start_lesson_times[0] = $day_start_at;

            $divisionBreaks=$division->divisionBreaks->first();
            $break_duration = Carbon::parse($divisionBreaks->duration)->format('i');
            $after_period_number = $divisionBreaks->after_period_number;

/*            dump($break_duration,$after_period_number);*/
                $lessons_times['lesson1']=$start_lesson_times[0];
                $lesson_duration = Carbon::parse( $lesson_duration)->format('i');

             for ($i=0;$i<$lessons_per_day-1;$i++) {

                $addLessonTime = Carbon::parse($start_lesson_times[$i])->addMinutes($lesson_duration)->format('H:i:s');
                $start_lesson_times[$i+1]= (string)$addLessonTime;
                 if($after_period_number==$i+1){
                     $lessons_times['break']=$addLessonTime;
                     $start_lesson_times[$i+1]=Carbon::parse($addLessonTime)->addMinutes($break_duration)->format('H:i:s');
                    $lessons_times['lesson'.($i+2)]= $start_lesson_times[$i+1];
                    }else{

                        $lessons_times['lesson'.($i+2)]= (string)$addLessonTime;
                     }
                 }



       $schedules =  Schedule::where('class_id',$class_id)->with('day')->get();
       foreach ($schedules as $key=>$schedule)
       {
           $arr= $schedule->subject_id;
           $subject =  Subject::where('id',$arr)->first()->subject_name;
           $schedule->subject_name = $subject;
           if($key==0){
           $schedule->dayTimes = $lessons_times;
           }
       }

        return response()->json(['Division'=>$division,'Schedule'=>$schedule]);
    }
}
