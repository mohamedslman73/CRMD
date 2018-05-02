<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\User;
use App\UserTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class editstudent extends ApiController
{
    public function editstudent(Request $request)
    {
        $this->validate($request,[
            'school_id' =>'required|exists:schools,id',
            'api_token' =>'required|exists:user_tokens,api_token',
            'user_id' =>'required|exists:users,id',
        ]);
        $userID = UserTokens::where('api_token',$request->api_token)->value('user_id');
        $type_id = User::where('id',$userID)->value('type_id');
        $user_school_id = User::where('id',$userID)->value('school_id');
        if (($user_school_id == $request->school_id)and $type_id == 2 ){
            $user = User::where('id',$request->user_id)->first();
            if ($request->has('name')){
                $user->name = $request->name;
            }
            if ($request->has('email')){
                $user->email = $request->email;
            }
            if ($request->has('password')){
                $user->password = $request->password;
            }
            if ($request->hasFile('image')){
                $user->image = $request->file('image')->store('users/images');
            }
            if ($request->has('address')){
                $user->address = $request->address;
            }
            if ($request->has('phone')){
                $user->phone = $request->phone;
            }
            if ($request->has('parent_phone')){
                $user->parent_phone = $request->parent_phone;
            }
            if ($request->has('parent_username')){
                $user->parent_username = $request->parent_username;
            }
            $user->update();
            return $this->fire($user);
        }else{
            return response(['error'=>'U can\'t Complete This Operation']);
        }
    }
}
