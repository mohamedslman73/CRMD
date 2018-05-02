<?php

namespace App\Http\Controllers\Api\Calendar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiController;
use App\Calendar;
use App\User;
use App\UserTokens;

class getAllEvents extends ApiController
{
    public function getAllEvents(Request $request)
    {
        $this->validate($request, [
          'api_token' => 'required|exists:user_tokens,api_token',
        ]);

        $userID = UserTokens::where('api_token', $request->api_token)->first()->user_id;

        $schoolID = User::find($userID)->school_id;

        $events = Calendar::where('school_id', $schoolID)->get();

        return $this->fire($events);
    }
}
