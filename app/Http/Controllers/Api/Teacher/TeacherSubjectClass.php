<?php

namespace App\Http\Controllers\Api\Teacher;

use App\TeacherSubjects;
use App\UserTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeacherSubjectClass extends Controller
{
    //
    public function TeacherSubjectClass(Request $request)
    {
        $this->validate($request,[
            'api_token'     =>'required',
        ]);

        $userID = UserTokens::where('api_token',$request->api_token)
            ->first()
            ->user_id;
        $subject_id = TeacherSubjects::where('user_id',$userID)
                                      ->select('id','user_id','class_id','subject_id')
                                      ->with('classes')
                                      ->with('subjects')
                                      ->get();
        /*  foreach ($subject_id as $id)
  {
        $arr[]=$id->subject_id;
       $class_id []=$id->class_id;
  }
     $subject = Subject::whereIn('id',$subject_id)->get();
     $class = Classes::where();*/
        return response()->json(['data'=>$subject_id]);
    }
}
