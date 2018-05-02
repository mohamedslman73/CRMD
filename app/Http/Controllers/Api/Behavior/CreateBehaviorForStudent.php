<?php

namespace App\Http\Controllers\Api\Behavior;

use App\Behavior;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CreateBehaviorForStudent extends ApiController
{
    public function createSubjectBehavior(Request $request)
    {
        $this->validate($request,[
            'class_id'=>'required',
            'subject_id'=>'required',
            'school_id'=>'required',
            'title'=>'required',
            'icon'=>'required',
            'type'=>'required',
            'grade'=>'required',
        ]);



        $behavior = new Behavior();
        $behavior->class_id = $request->class_id;
        $behavior->subject_id = $request->subject_id;
        $behavior->school_id = $request->school_id;
        $behavior->title = $request->title;
        $behavior->type = $request->type;
        $behavior->grade = $request->grade;

        if ($request->hasFile('icon')){
            $behavior->icon=$request->file('icon')->store('behaviorIcons');
        }
        $behavior->save();
        return $this->fire($behavior);
    }
}
