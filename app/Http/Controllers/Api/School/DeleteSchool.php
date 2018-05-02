<?php

namespace App\Http\Controllers\Api\School;

use App\School;
use App\User;
use App\UserTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteSchool extends Controller
{
    public function DeleteSchool(Request $request)
    {
        /*
         * this function for only the superAdmin EasySchools company ..
         */
        $this->validate($request, [
            'school_id' => 'required|exists:schools,id',
            'api_token' => 'required|exists:user_tokens,api_token',
        ]);
        $userID = UserTokens::where('api_token', $request->api_token)->value('user_id');
        $user_type_id = User::where('id', $userID)->value('type_id');
        if ($user_type_id == 1){
            $school = School::where('id', $request->school_id)->first();
        $school->delete();
    }else{
            return response()->json(['error'=>'U Can\'t Complete this process']);
        }
        return response()->json(['data'=>'School_Deleted_Successfully']);
    }
}
