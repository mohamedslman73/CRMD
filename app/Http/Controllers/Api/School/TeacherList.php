<?php

namespace App\Http\Controllers\Api\School;

use App\Http\Controllers\Api\ApiController;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeacherList extends ApiController
{
    public function TeacherList(Request $request)
    {
        $this->validate($request,[
            'school_id' =>'required|exists:schools,id'
        ]);
        $teacher_list = User::where('school_id',$request->school_id)
            ->where('type_id',3)
            ->get();
        return $this->fire($teacher_list);
    }
}
