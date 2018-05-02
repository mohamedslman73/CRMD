<?php

namespace App\Http\Controllers\Api\Student;

use App\Classes;
use App\Http\Controllers\Api\ApiController;
use App\StudentClass;
use App\User;
use App\UserTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentProfile extends ApiController
{
    //
    public function StudentProfile(Request $request)
    {
        $this->validate($request,[
           'api_token'=>'required',
        ]);

        $userID = UserTokens::where('api_token',$request->api_token)
        ->first()
        ->user_id;
/*        $class_id = StudentClass::where('user_id',$userID)->first()->class_id;
       // $user = StudentClass::where('user_id',$userID)->with('users')->with('classes')->get();
         $a = Classes::where('id',$class_id)->with('students')->get(['id','name']);*/
         $user = User::where('id',$userID)->first();
         $class = StudentClass::where('user_id',$userID)->first()->class_id;
         $name = Classes::where('id',$class)->first()->name;
         $user->class_name = $name;

         return response()->json(['status' => true,'user'=>$user]);

        //return $this->fire($user);
    }
}
