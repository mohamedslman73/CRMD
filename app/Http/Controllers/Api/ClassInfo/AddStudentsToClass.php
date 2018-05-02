<?php

namespace App\Http\Controllers\Api\ClassInfo;

use App\StudentClass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddStudentsToClass extends Controller
{
    //
    public function AddStudentsToClass(Request $request)
    {
        $this->validate($request,[
            'class_id'=>'required|exists:classes,id',
            'user_id'=>'required|exists:users,id',
        ]);

        if (count($request->user_id)!=0) {
            foreach ($request->user_id as $user) {
                $student_class = new StudentClass;
                   $student_class->user_id = $user;
                   $student_class->class_id = $request->class_id;
                   $student_class->save();
            }
            $data = [];
            foreach ($student_class as $class)
            {
                $data [] = $class;
            }
            return response([
                'data'=>$data
            ]);
        }
    }

}
