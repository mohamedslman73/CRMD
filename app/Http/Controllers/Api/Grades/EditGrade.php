<?php

namespace App\Http\Controllers\Api\Grades;

use App\Division;
use App\Grade;
use App\User;
use App\UserTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpParser\Node\Expr\AssignOp\Div;

class EditGrade extends Controller
{
    public function EditGrade(Request $request)
    {
        $this->validate($request,[
            'grade_id'=>'required|exists:grades,id',
            'api_token'=>'required|exists:user_tokens,api_token'
        ]);

        $userId = UserTokens::where('api_token',$request->api_token)->value('user_id');
        $user_type_id = User::where('id',$userId)->value('type_id');
        $school_id = User::where('id',$userId)->value('school_id');//40
        $division_id = Grade::where('id',$request->grade_id)->value('division_id');//1
        $school_grade_id = Division::where('id',$division_id)->value('school_id');//40
        if ($user_type_id == 1 or ($user_type_id == 2 and $school_id == $school_grade_id)){
            $grade = Grade::where('id',$request->grade_id)->first();
            if ($grade) {
                if ($request->has('division_id')) {
                    $grade->division_id = $request->division_id;
                }
                if ($request->has('name')) {
                    $grade->name = $request->name;
                }
                $grade->update();
                return response(['data'=>$grade]);
            }
        }
        return response()->json(['error'=>'U Can\'t Complete this process']);
    }
}
