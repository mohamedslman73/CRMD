<?php

namespace App\Http\Controllers\Api\Schedule;

use App\Classes;
use App\Division;
use App\Grade;
use App\User;
use App\UserTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class getClassesOnCreateSchedule extends Controller
{
    //
    public function getClassesOnCreateSchedule (Request $request)
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

         $classes = Classes::whereIn('grade_id',$grade_id)->get();
        return response()->json(['Classes'=>$classes]);
    }
}
