<?php

namespace App\Http\Controllers\Api\School;

use App\Http\Controllers\Api\ApiController;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentList extends ApiController
{
    public function StudentList(Request $request)
    {
        $this->validate($request,[
            'school_id' =>'required|exists:schools,id'
        ]);
        $student_list = User::where('school_id',$request->school_id)
                              ->where('type_id',5)
                             ->get();
        return $this->fire($student_list);
    }
}
