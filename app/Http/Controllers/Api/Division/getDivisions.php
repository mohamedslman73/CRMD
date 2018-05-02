<?php

namespace App\Http\Controllers\Api\Division;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserTokens;
use App\User;
use App\Division;
class getDivisions extends ApiController
{
    //

    public function getDivisions(Request $request)
    {
        /*
        $user_type = UserTypes::select('type')->get()->toArray();
        //return $this->fire($user_type);

       if($user_type ==1) {
           $grades = Grade::all();
           return $this->fire($grades);
       }
        */
        // $user_type = UserTypes::select('type')->get()->toArray();
        //if ($user_type == 1) {
        $this->validate($request,[
            //'api_token'=>'required|exists:user_tokens,api_token',
            'school_id'=>'required|exists:schools,id',
        ]);

       // $userID = UserTokens::where('api_token', $request->api_token)->first()->user_id;
      //  $school_id = User::where('id',$userID)->first()->school_id;

        /*  $divison  = Division::where('school_id',$school_id)->with(['grade'=>function($grades){
              $grades->with(['classes'=>function($classes){
                  $classes->select('id','grade_id');
              }])->select('id','division_id','name');
          }])->select('id','name')->get()->toArray();*/
           $school_id = $request->school_id;
           $divison = Division::where('school_id',$school_id)->with('grade.classes')->with('grade.subjects')->get();

         return $this->fire($divison);
    }
//    }
}
