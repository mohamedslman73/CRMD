<?php

namespace App\Http\Controllers\Api\Behavior;

use App\Http\Controllers\Api\ApiController;
use App\StudentBehavior;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetStudentBehaviors extends ApiController
{
    public function getStudentBehaviors(Request $request)
    {
        $this->validate($request,[
            'api_token'=>'required',
        ]);
        $student_id=$this->getUserObject()->user_id;

        $data=User::find($student_id)
            ->with('behaviors')
            ->first();
        return $this->fire($data);
    }
}
