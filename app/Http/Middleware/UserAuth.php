<?php

namespace App\Http\Middleware;

use Closure;
use Dotenv\Validator;

class UserAuth
{
    public function __construct(Auth $auth)
    {
        $this->auth = Auth::guard('users');
    }

    public function handle($request, Closure $next)
    {
        $validator = Validator::make($request->all(),['api_token'=>'required']);
        if ($validator->fails())
        {
            return response()->json(['scode'=>400,'message'=>'Some Errors Habbened','errors'=>$validator->errors()->toArray(),'data'=>[]]);
        }
        $user = User::whereHas('tokens',function($query) use ($request){
            $query->where('api_token',$request->get('api_token'));
        });
        if($user->count() ==  0){
            return response()->json(['scode'=>400,'message'=>'Some Errors Habbened','errors'=>['User Not Found'],'data'=>[]]);
        }
        $beforeThirty   = Carbon::now()->subDays(30);
        $token          = UserTokens::where('api_token',$request->api_token)->first();
        if($token && $token->last_activity  != null)
        {
            if($token->last_activity < $beforeThirty){
                return response()->json(['scode'=>401,'message'=>'Some Errors Habbened','errors'=>['Expired Token'],'data'=>[]]);
            }
        }
        $token->update(['last_activity'=>Carbon::now()]);
        return $next($request);
    }
}
