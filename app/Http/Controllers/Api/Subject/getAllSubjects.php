<?php

namespace App\Http\Controllers\Api\Subject;

use App\UserGrades;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiController;
use App\UserTokens;
use App\Subject;
use App\User;

class getAllSubjects extends ApiController
{
  public function getAllSubjects(Request $request)
  {
    $this->validate($request,[
        'api_token'  => 'required|exists:user_tokens,api_token',
    ]);

    $userID = UserTokens::where('api_token', $request->api_token)->first()->user_id;
    $subjects = UserGrades::where('user_id',$userID)->get(['grade_id']);//->Grade()->first()->subjects();
foreach ($subjects as $subject)
{
    $subject_grade_id =  $subject->grade_id;
}
 $S = Subject::where('grade_id',$subject_grade_id)->get(['id','subject_name']);

   return $this->fire($S);
  }
}
