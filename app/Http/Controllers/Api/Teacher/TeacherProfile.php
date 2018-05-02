<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Classes;
use App\Http\Controllers\Api\ApiController;
use App\School;
use App\TeacherSubjects;
use App\User;
use App\UserTokens;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeacherProfile extends ApiController
{
    public function TeacherProfile(Request $request)
    {
        $this->validate($request,[
            'api_token' =>'required|exists:user_tokens,api_token'
        ]);

        $userID = UserTokens::where('api_token',$request->api_token)->value('user_id');
        $teacher = User::where('id',$userID)
                         ->select('id','name','email','image','school_id','type_id','image','phone','address')
                         ->first();
         $teacher->school_name = School::find($teacher->school_id)->name;
        $array = array();
        $info = TeacherSubjects::where('user_id',$userID)
                                ->select('user_id','class_id','subject_id')
                                ->with(['subjects'=>function($subjetc){
                                    $subjetc->select('id','subject_name');
                                }])
                                ->with(['classes'=>function($classes){
                                    $classes->select('id','name');
                                }])
                                ->get();
/*        foreach ( $class as $a ) {
            $array[] =  $a->class_id;
  }
     $arr_name = array();
        $class_name = Classes::whereIn('id',$array)->get(['name']);
        foreach ($class_name as $value){
            $arr_name[]  = $value->name;
        }
        $teacher->class_name =  $arr_name;*/
          return response(['scode'=>200,'data'=>$teacher,'Info'=>$info]);
         // return $this->fire($teacher);
    }
}
