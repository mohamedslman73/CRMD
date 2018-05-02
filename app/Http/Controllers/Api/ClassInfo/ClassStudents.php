<?php

namespace App\Http\Controllers\Api\ClassInfo;

use App\Classes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClassStudents extends Controller
{
    //
    public function ClassStudents(Request $request)
    {
        $this->validate($request,[
            'class_id'=>'required|exists:classes,id'
        ]);

        $class = Classes::where('id',$request->class_id)
                          ->select('id','name','grade_id')
                          ->with(['students'=>function($students){
                              $students->select('users.id','name');
                          }])
                          ->get();
      return response(['data'=>$class]);
    }
}
