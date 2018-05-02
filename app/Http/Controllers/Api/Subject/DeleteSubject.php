<?php

namespace App\Http\Controllers\Api\Subject;

use App\Division;
use App\Grade;
use App\Subject;
use App\User;
use App\UserTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteSubject extends Controller
{
    public function DeleteSubject(Request $request)
    {
        $this->validate($request,[
            'subject_id'=>'required|exists:subjects,id',
            'api_token'=>'required|exists:user_tokens,api_token',
        ]);

        $userID = UserTokens::where('api_token',$request->api_token)->value('user_id');
        $user_type_id = User::where('id',$userID)->value('type_id');
        $school_id = User::where('id',$userID)->value('school_id');
        $grade_id = Subject::where('id',$request->subject_id)->value('grade_id');
        $division_id = Grade::where('id',$grade_id)->value('division_id');
        $school_subject_id = Division::where('id',$division_id)->value('school_id');

        if ($user_type_id == 1 or ($user_type_id == 2 and $school_id == $school_subject_id))
        {
            $subject = Subject::where('id',$request->subject_id)->first();
            if ($subject){
                $deleted = $subject->delete();
                if ($deleted) {
                    return response(['data' => 'Subject_Deleted_Successfully']);
                }
            }
        }else{
            return response()->json(['error'=>'U Can\'t Complete this process']);
        }
    }
}
