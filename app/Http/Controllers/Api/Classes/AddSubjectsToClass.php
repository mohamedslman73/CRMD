<?php

namespace App\Http\Controllers\Api\Classes;

use App\ClassSubject;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddSubjectsToClass extends ApiController
{
    public function AddSubjectsToClass(Request $request)
    {
        $this->validate($request,[
            'class_id'=>'required|exists:classes,id',
            'subject_id'=>'required|array|exists:subjects,id',
        ]);

        if (is_array($request->subject_id)){
            foreach ($request->subject_id as $subject){
                $class_subject = new ClassSubject;
                $class_subject->class_id = $request->class_id;
                $class_subject->subject_id = $subject;
                $class_subject->save();
            }
        }
        return $this->fire($class_subject);
    }
}
