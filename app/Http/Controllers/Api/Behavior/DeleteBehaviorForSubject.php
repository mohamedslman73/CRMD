<?php

namespace App\Http\Controllers\Api\Behavior;

use App\Behavior;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteBehaviorForSubject extends ApiController
{
    public function deleteSubjectBehavior(Request $request)
    {
        $this->validate($request,[
            'behavior_id'=>'required'
        ]);
        $delete=Behavior::find($request->behavior_id)->delete();
        return $this->fire($delete);
    }
}
