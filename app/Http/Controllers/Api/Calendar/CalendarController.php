<?php

namespace App\Http\Controllers\Api\Calendar;

use App\Classes;
use App\Division;
use App\School;
use App\Grade;
use App\User;
use App\UserTokens;
use App\UserTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;

class CalendarController extends ApiController
{
    //


    public function createCalender(Request $request)
    {
        $this->validate($request, [
            'api_token'        => 'required|exists:user_tokens,api_token',
            'name'             =>'required',
            'description'      =>'required',
            'start_at'         =>'required',
            'end_at'           =>'required',
            'start_time'       =>'required',
        ]);

        $userID = UserTokens::where('api_token', $request->api_token)->first()->user_id;

        $school = User::find($userID)->school_id;

      /*  $school = School::find($request->school_id);
        if(!$school)
        {
            return $this->fire([],null,['School Not Exist']);
        }*/

       $calendar= $school->calendar()->create($request->all());
        return $this->fire($calendar);
    }


}
