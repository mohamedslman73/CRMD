<?php

namespace App\Http\Controllers\Api;

use App\EducationTypes;
use App\SchoolTypes;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;


class SchoolEducationType extends ApiController
{
    //

    public function  SchoolEducationType(Request $request)
    {
        $this->validate($request,[
            'api_token'=>'required|exists:user_tokens,api_token',
        ]);

        $userID = UserTokens::where('api_token', $request->api_token)->first()->user_id;

        $school = User::find($userID)->school_id;

     $any = SchoolTypes::where('school_id',$school)->get(['type_id']);
     $ids = array();

    foreach ($any as $a)
    {
        $ids[] = $a->type_id;
    }


$education = EducationTypes::whereIn('id',$ids)->get(['name_'.app()->getLocale()]);
    return $this->fire($education);
    }

}
