<?php

namespace App\Http\Controllers\Api\Schedule;

use App\Classes;
use App\Day;
use App\Division;
use App\DivisionBreaks;
use App\Grade;
use App\User;
use App\UserTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class getDivisionInfoOnCreateSchedule extends Controller
{
    //
    public function getDivisionInfoOnCreateSchedule(Request $request)
    {
        $this->validate($request,[
            'api_token'=>'required',
            'class_id' =>'required|exists:classes,id',
        ]);
        $userID = UserTokens::where('api_token', $request->api_token)
            ->first()
            ->user_id;
        $school_id = User::where('id', $userID)
            ->first()
            ->school_id;
        $grade = Classes::where('id', $request->class_id)->first()->grade_id;
        $division_id = Grade::where('id', $grade)->first()->division_id;
        $division = Division::where('id', $division_id)->with('divisionBreaks')->get();

        $days = Day::all();

        return response()->json(['Division'=>$division,'Days'=>$days]);
    }
}
