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

class EditMaterial extends Controller
{
    public function EditMaterial(Request $request)
    {
        $this->validate($request, [
            'api_token' => 'required|exists:user_tokens,api_token',
            'material_id' => 'required|exists:materials,id'
        ]);


        $userID = UserTokens::where('api_token', $request->api_token)->value('user_id');
        $user_type_id = User::where('id', $userID)->value('type_id');
        $school_id = User::where('id', $userID)->value('school_id');
        $subject_id = Material::where('id', $request->material_id)->value('subject_id');
        $grade_id = Subject::where('id', $subject_id)->value('grade_id');
        $division_id = Grade::where('id', $grade_id)->value('division_id');
        $school_material_id = Division::where('id', $division_id)->value('school_id');
        if ($user_type_id == 1 or ($user_type_id == 2 and $school_id == $school_material_id)) {
            $material = Material::where('id', $request->material_id)->first();
            if ($material) {
                if ($request->has('title')) {
                    $material->title = $request->title;
                }
                if ($request->has('description')) {
                    $material->description = $request->description;
                }
                if ($request->has('week_num')) {
                    $material->week_num = $request->week_num;
                }
                if ($request->has('subject_id')) {
                    $material->subject_id = $request->subject_id;
                }
                $material->update();
                if (count($request->file) != 0) {
                    $material->materialFile()->delete();
                    foreach ($request->file as $files) {

                        $material->materialFile()->create(['file' => $files->store('files')]);
                    }
                }
            } else {
                return response(['error' => 'U can\'t Complete This Operation']);
            }
            return response(['data' => $material]);
        }
    }
}
