<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Api\ApiController;
use App\User;
use App\UserTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ChangePassword extends ApiController
{
    //
    public function ChangePassword(Request $request)
    {
        $this->validate($request,[
            'api_token'=>'required',
            'oldPassword'=>'required',
            'newPassword'=>'required'
        ]);

        $userID = UserTokens::where('api_token',$request->api_token)->first()->user_id;
        $user = User::find($userID);
        $oldpassword = $request->oldPassword;
        $newpassword = $request->newPassword;
        if(!Hash::check($oldpassword,$user->password)){

            return $this->fire([],null,['Password Not Correct']);
        }
        $request->merge(['password' => bcrypt($newpassword)]);
        $user=User::find($user->id)->update(['password'=>$request->password]);
        $updated_user = User::find($userID);
        return response()->json(['Updated user'=>$updated_user,"status"=>200]);

    }
}
