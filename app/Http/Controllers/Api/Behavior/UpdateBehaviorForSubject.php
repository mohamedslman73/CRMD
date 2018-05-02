<?php

namespace App\Http\Controllers\Api\Behavior;

use App\Behavior;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdateBehaviorForSubject extends ApiController
{
    public function updateSubjectBehavior(Request $request)
    {
        $this->validate($request,[
            'behavior_id'=>'required'
        ]);
        if ($request->hasFile('img')){

            $icon=$request->icon->store('behaviorIcons');
            $request->merge(['icon'=>$icon]);

        }

            $update=Behavior::find($request->behavior_id)->update($request->all());
        return $this->fire($update);
    }
}
