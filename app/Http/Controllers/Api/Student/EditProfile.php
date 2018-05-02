<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Api\ApiController;
use App\User;
use App\UserTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EditProfile extends ApiController
{
    //
    public function EditProfile(Request $request)
    {

        $this->validate($request,[
            'api_token'=>'required',
            'email'=>'email|unique:users,email',
            'image'=>'image',
        ]);
    /*    if ($request->hasFile('image')) {
            //$request->merge(['image' => $request->file('image')->store('users')]);
            $user->image = $request->file('image')->store('users/images');
        }*/
        $userID = UserTokens::where('api_token',$request->api_token)
            ->first()
            ->user_id;

        $user = User::find($userID);

      $user->name = $request->name;
      $user->phone = $request->phone;
      $user->parent_phone = $request->parent_phone;
      $user->address = $request->address;
        if ($request->hasFile('image')) {
            $user->image = $request->file('image')->store('users/images');
        }

        $user->update();

        return $this->fire($user);

    }
}
