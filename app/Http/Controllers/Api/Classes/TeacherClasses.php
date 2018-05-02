<?php

namespace App\Http\Controllers\Api\Classes;

use App\Classes;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserTokens;
use App\TeacherSubjects;

class TeacherClasses extends ApiController
{
    //
    public function TeacherClasses(Request $request)
    {
        $this->validate($request,[
           'api_token'=>'required|exists:user_tokens,api_token',
        ]);

         $userID = UserTokens::where('api_token', $request->api_token)
            ->first()
            ->user_id;

        $var = TeacherSubjects::where('user_id',$userID)->get(['class_id']);
        foreach ($var as $a)
        {
             $value[] = $a->class_id;
        }
        $class = Classes::whereIn('id',$value)->get(['name']);
         foreach ($class as $single)
         {
             $class_name[] = $single->name;
         }
        return $this->fire($class_name);
    }
}
