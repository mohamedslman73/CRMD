<?php

namespace App\Http\Controllers\Api\Behavior;

use App\Behavior;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class getAllBehaviorForClassSubject extends Controller
{
    public function getAllBehaviorForClassSubject(Request $request)
    {
        $this->validate($request,[
           'class_id'=>'required',
           'subject_id'=>'required',
        ]);

        $behavior = Behavior::where('class_id',$request->class_id)
                             ->where('subject_id',$request->subject_id)
                             ->get();
        return response(['scode'=>200,'data'=>$behavior]);
    }
}
