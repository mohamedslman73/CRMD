<?php

namespace App\Http\Controllers\Api\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ForgetPassword extends Controller
{
    //
    public function ForgetPassword(Request $request){
        $this->validate($request,[
            'email'=>'required|email|exists:users,email'
        ]);
        $email=$request->email;
        $check=DB::table('users')->where('email',$email)->first();
        if(empty($check)){
            return $this->fire([],null,['This Email Does Not Exit']);
        }else{
            //updating activation code
            $code=uniqid();
            DB::table('users')->where('email',$email)->update(['activation_code'=>$code]);
            Mail::to($email)->send(new \App\Mail\Forgetpassword($code));
            return response()->json(['success'=>1]);
        }
    }
}
