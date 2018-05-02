<?php

namespace App\Http\Controllers\Api\Grades;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiController;
use App\UserTokens;
use App\StudentGrades;

class getSubjectGradesForStudent extends ApiController{

  // Request Parameters : 'token', 'subject_id'

  public function getSubjectGradesForStudent(Request $request){
    $this->validate($request,[
        'api_token'  => 'required|exists:user_tokens,api_token',
       // 'subject_id' => 'required|exists:subjects,id'
    ]);
        /*
         * in this api i will get the student degree with the quiz details
         */
    $userID = UserTokens::where('api_token', $request->api_token)->first()->user_id;
    $grades = StudentGrades::where('user_id', $userID)
              ->with('addgrade')
              ->get();
    return $this->fire($grades);

  }
}
