<?php

namespace App\Http\Controllers\Api\Classes;

use App\Classes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CreateClasses extends Controller
{
    //
    public function CreateClasses(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'grade_id'=>'required|exists:grades,id',
        ]);

        $class = new Classes();

        $class->name = $request->name;
        $class->grade_id = $request->grade_id;
        $class->save();

        return response()->json(['data'=>$class]);
    }
}
