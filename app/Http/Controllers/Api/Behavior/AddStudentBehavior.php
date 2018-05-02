<?php

namespace App\Http\Controllers\Api\Behavior;

use App\Behavior;
use App\Http\Controllers\Api\ApiController;
use App\StudentBehavior;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddStudentBehavior extends ApiController
{
    public function addStudentDegree(Request $request)
    {
        $this->validate($request,[
            'user_id'     =>'required',
            'behavior_id'   =>'required',
            'degree'         =>'required'
        ]);
        $student_id=$request->user_id;
        $behavior_id=$request->behavior_id;
        $degree=$request->degree;
        $exits=StudentBehavior::where('behavior_id',$behavior_id)
            ->where('student_id',$student_id)->exists();
        $token = User::find($request->user_id)->refresh_token;
        $name = User::find($request->user_id)->name;
        $msg = array(
            'title' => $name,
            'body' => 'There are now behaviour for you',
            'image' => '',/*Default Icon*/
            'sound' => 'mySound'/*Default sound*/
        );
        if($exits){
            $query=StudentBehavior::where('behavior_id',$behavior_id)
                    ->where('student_id',$student_id);
            $total=$query->first()->total;
            $data=$query->update(['total'=>$total+$degree]);
            notify1([$token], $msg);
            }else{
                  $data=StudentBehavior::create([
                      'total'=>$degree,
                      'student_id'=>$student_id,
                      'behavior_id'=>$behavior_id
                      ]);
            notify1([$token], $msg);
            }
        return $this->fire($data);
    }
}
