<?php

namespace App\Http\Controllers\Api\Material;

use App\Division;
use App\Grade;
use App\Material;
use App\Subject;
use App\User;
use App\UserTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class DeleteMaterial extends Controller
{
    public function DeleteMaterial(Request $request)
    {

        $this->validate($request, [
            'api_token' => 'required|exists:user_tokens,api_token',
            'material_id' => 'required|exists:materials,id'
        ]);

        $material = Material::where('id', $request->material_id);
        $userID = UserTokens::where('api_token', $request->api_token)->value('user_id');
        $user_type_id = User::where('id', $userID)->value('type_id');
        $school_id = User::where('id', $userID)->value('school_id');
        $subject_id = Material::where('id', $request->material_id)->value('subject_id');
        $grade_id = Subject::where('id', $subject_id)->value('grade_id');
        $division_id = Grade::where('id', $grade_id)->value('division_id');
        $school_material_id = Division::where('id', $division_id)->value('school_id');
        if ($user_type_id == 1 or ($user_type_id == 2 and $school_id == $school_material_id)) {
            if ($material){
                $material->delete();
            }
        }else{
            return response(['error'=>'U can\'t Complete This Operation']);
        }
        return response(['data'=>'Material_Deleted_Successfully']);
    }
}
