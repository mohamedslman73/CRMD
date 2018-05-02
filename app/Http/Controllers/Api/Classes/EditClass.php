<?php

namespace App\Http\Controllers\Api\Classes;

use App\Classes;
use App\Division;
use App\Grade;
use App\User;
use App\UserTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EditClass extends Controller
{
    public function EditClass(Request $request)
    {
        $this->validate($request,[
            'api_token'=>'required|exists:user_tokens,api_token',
            'class_id'=>'required|exists:classes,id',
        ]);

        $userId = UserTokens::where('api_token',$request->api_token)->value('user_id');
        $user_type_id = User::where('id',$userId)->value('type_id');
        $school_id = User::where('id',$userId)->value('school_id');
        $grade_id = Classes::where('id',$request->class_id)->value('grade_id');
        $division_id = Grade::where('id',$grade_id)->value('division_id');
        $school_class_id = Division::where('id',$division_id)->value('school_id');
        if ($user_type_id == 1 or ($user_type_id == 2 and $school_id == $school_class_id)){
            $class = Classes::where('id',$request->class_id)->first();
            if ($class) {
                if ($request->has('name')) {
                    $class->name = $request->name;
                }
                if ($request->has('grade_id')) {
                    $class->grade_id = $request->grade_id;
                }

                $class->update();
                return response(['data'=>$class]);
            }
        }
        return response()->json(['error'=>'U Can\'t Complete this process']);
    }
}
