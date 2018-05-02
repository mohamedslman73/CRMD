<?php

namespace App\Http\Controllers\Api\Attendance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiController;
use App\Attendance;
use App\UserTokens;
use App\UserGrades;
use Validator;

class getStudentAttendance extends ApiController{

  // Request Parameters : 'token'

  public function getStudentAttendance(Request $request){

    $this->validate($request,[
        'api_token' => 'required|exists:user_tokens,api_token',
    ]);

    $absence_days_array = array();
    $data = array();

    $userID = UserTokens::where('api_token', $request->api_token)
                            ->first()
                            ->user_id;

    $userID = UserTokens::where('api_token', $request->api_token)->first()->user_id;


    $lessons_per_day = UserGrades::where('user_id', $userID)
                            ->first()->Grade()->first()->division()->first()
                            ->lessons_per_day;

    $absence_days_collection = Attendance::select('absence_date')->where('user_id', $userID)->distinct()->get();

    foreach ($absence_days_collection as $object){
      $subjects_array = array();
      $subjects = Attendance::where('user_id', $userID)->where('absence_date', $object->absence_date)
      ->select('attendances.id', 'attendances.absence_date', 'subjects.subject_name')
      ->join('subjects', 'attendances.subject_id', '=', 'subjects.id')
      ->get();

      foreach ($subjects as $subject) { $subjects_array[] = $subject->subject_name; }

      $data[] = array('date' => $object->absence_date, 'subjects' => $subjects_array);
    }

    $response = array('lessons_per_day' => $lessons_per_day, 'absence_dates' => $data);

    return $this->fire($response);



  }

}
