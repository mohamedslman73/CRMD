<?php
namespace App\Http\Controllers\Api;
use App\Exceptions\ApiValidation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Validator;
class ApiController extends Controller
{
    protected function fire($data = [],$message = 'data fetched successfully',$errorsToShow = [],$scode = 200)
    {
        if(count($errorsToShow)>0)
            return response()->json(['scode'=>400,'message'=>'Some Errors Happened','errors'=>$errorsToShow,'data'=>[]]);
        if(count($data) == 0)
            return response()->json(['scode'=>400,'message'=>'no records to show','errors'=>"No Data To Show",'data'=>[]]);
        return response()->json(['scode'=>$scode,'message'=>$message,'errors'=>[],'data'=>$data]);
    }
    protected function doUserLogin($guard,Request $request)
    {
        $this->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);
        $credentials  = ['email'=>$request->email,'password'=>$request->password];
        if (Auth::guard($guard)->attempt($credentials)) {
            $new_token = ['api_token'=>str_random(60)];
            Auth::guard('usersSession')->user()->tokens()->create($new_token);
            $this->fire([array_merge(Auth::guard('usersSession')->user()->toArray(),$new_token)],'Successfully Logged in');
        }
        $this->fire([],null,['wrong email or password']);
    }
    protected function getUserObject()
    {
        return Auth::guard('userApi')->user();
    }
}