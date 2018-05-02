<?php

namespace App\Http\Controllers\Api\GradeInfo;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GradeTeachers extends Controller
{
    //
    public function GradeTeachers(Request $request)
    {
        $this->validate($request,[
            'school_id'=>'required|exists:schools,id'
        ]);

        $userTypeId  = User::where('school_id',$request->school_id)->get();
        foreach ($userTypeId as $any) {
             $array [] = $any->type_id;
        }
      //  return $array;
        if (in_array("3",$array))
        {
             $Teacher_info = User::where('school_id',$request->school_id)
                                        ->where('type_id','=',3)->get();
        }
        return response(['status'=>200,'data'=>$Teacher_info]);
    }
}
