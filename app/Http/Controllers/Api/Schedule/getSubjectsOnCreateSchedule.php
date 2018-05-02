<?php

namespace App\Http\Controllers\Api\Schedule;

use App\Division;
use App\Grade;
use App\Http\Controllers\Api\ApiController;
use App\Subject;
use App\User;
use App\UserTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpParser\Node\Expr\AssignOp\Div;

class getSubjectsOnCreateSchedule extends ApiController
{
    //
    public function getSubjectsOnCreateSchedule(Request $request)
    {
        $this->validate($request,[
            'api_token'=>'required',
        ]);
        $userID = UserTokens::where('api_token', $request->api_token)
            ->first()
            ->user_id;
        $school_id = User::where('id', $userID)
            ->first()
            ->school_id;
        $division_id = Division::where('school_id',$school_id)->get(['id']);
        foreach ($division_id as $item)
        {
            $id []= $item->id;

        }
        // return $id;
        $grades_id = Grade::whereIn('division_id',$id)->get(['id']);
        foreach ($grades_id as $value)
        {
            $grade_id []= $value->id;
        }
        $subjects = Subject::whereIn('grade_id',$grade_id)->get();
      /*  foreach ($subjects as $subject)
        {
            $sub [] = $subject->subject_name;
        }*/
       return response()->json(['Subjects'=>$subjects]);
       // return $this->fire($sub );

    }
}
