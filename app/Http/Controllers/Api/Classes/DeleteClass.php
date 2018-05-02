<?php

namespace App\Http\Controllers\Api\Classes;

use App\Classes;
use App\Division;
use App\Grade;
use App\User;
use App\UserTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteClass extends Controller
{
    public function DeleteClass(Request $request)
    {
        $this->validate($request,[
            'class_id'=>'required|exists:classes,id',
            'api_token'=>'required|exists:user_tokens,api_token',
        ]);

        $userId = UserTokens::where('api_token',$request->api_token)->value('user_id');
        $user_type_id = User::where('id',$userId)->value('type_id');
        $school_id = User::where('id',$userId)->value('school_id');
        $grade_id = Classes::where('id',$request->class_id)->value('grade_id');
        $division_id = Grade::where('id',$grade_id)->value('division_id');
        $school_class_id = Division::where('id',$division_id)->value('school_id');
        if ($user_type_id == 1 or ($user_type_id == 2 and $school_id == $school_class_id))
        {
            $class = Classes::where('id',$request->class_id)->first();
            if ($class){
                $class->delete();
                return response(['data'=>'Class_Deleted_Successfully']);
            }
        }else{
            return response()->json(['error'=>'U Can\'t Complete this process']);
        }
    }
}
