<?php

namespace App\Http\Controllers\Api\Subject;

use App\Division;
use App\Grade;
use App\Subject;
use App\User;
use App\UserTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpParser\Node\Expr\AssignOp\Div;

class EditSubject extends Controller
{
    public function EditSubject(Request $request)
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

        if ($user_type_id == 1 or ($user_type_id == 2 and $school_id == $school_subject_id)){
            $subject = Subject::where('id',$request->subject_id)->first();
            if ($subject) {
                if ($request->has('subject_name')) {
                    $subject->subject_name = $request->subject_name;
                }
                if ($request->has('grade_id')) {
                    $subject->grade_id = $request->grade_id;
                }
                if ($request->has('subject_description')){
                    $subject->subject_description = $request->subject_description;
                }
                if ($request->has('subject_weight')){
                    $subject->subject_weight = $request->subject_weight;
                }
                if ($request->has('success_percentage')){
                    $subject->success_percentage = $request->success_percentage;
                }
                if ($request->has('attendance_percentage')){
                    $subject->attendance_percentage = $request->attendance_percentage;
                }
                if ($request->has('term')){
                    $subject->term = $request->term;
                }
                if ($request->has('book_name')){
                    $subject->book_name = $subject->book_name;
                }
                $subject->update();
                return response(['data'=>$subject]);
            }
        }
        return response()->json(['error'=>'U Can\'t Complete this process']);

    }
}
