<?php

namespace App\Http\Controllers\Api\Division;

use App\Division;
use App\User;
use App\UserTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteDivision extends Controller
{
    public function DeleteDivision(Request $request)
    {
        $this->validate($request,[
            'division_id'=>'required|exists:divisions,id',
            'api_token' => 'required|exists:user_tokens,api_token',
        ]);
        $userID = UserTokens::where('api_token',$request->api_token)->value('user_id');
        $user_type_id = User::where('id',$userID)->value('type_id');
        if ($user_type_id == 1) {
            $division = Division::where('id', $request->division_id)->first();
            $division->delete();
        }else{
            return response()->json(['error'=>'U Can\'t Complete this process']);
        }
        return response()->json(['data' => 'Division_Deleted_Successfully']);
    }
}
