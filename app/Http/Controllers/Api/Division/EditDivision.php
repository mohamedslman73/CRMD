<?php

namespace App\Http\Controllers\Api\Division;

use App\Division;
use App\DivisionBreaks;
use App\DivisionDaysOff;
use App\DivisionTerms;
use App\Http\Controllers\Api\ApiController;
use App\User;
use App\UserTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EditDivision extends ApiController
{
    //

    public function EditDivision(Request $request)
    {
        $this->validate($request,[
            'division_id'=>'required|exists:divisions,id',
            'api_token' => 'required|exists:user_tokens,api_token',
        ]);
         //return $asd = Division::find($id);
     /*   $division = Division::where('id',$request->id)->update($request->all());

        $division_breaks = DivisionBreaks::where('division_id',$request->id)->update($request->all());

         $division_days_off = DivisionDaysOff::where('division_id',$request->id)->update($request->all());

        $division_terms = DivisionTerms::where('division_id',$request->id)->update($request->all());*/

        $userID = UserTokens::where('api_token',$request->api_token)->value('user_id');
        $user_type_id = User::where('id',$userID)->value('type_id');
        $school_id = User::where('id',$userID)->value('school_id');
        if ($user_type_id ==1) {
            $division = Division::where('id', $request->division_id)->first();
            if ($request->has('name')) {
                $division->name = $request->name;
            }
            if ($request->has('lessons_per_day')) {
                $division->lessons_per_day = $request->lessons_per_day;
            }
            if ($request->has('lesson_duration')) {
                $division->lesson_duration = $request->lesson_duration;
            }
            if ($request->has('day_start_at')) {
                $division->day_start_at = $request->day_start_at;
            }
            if ($request->has('day_end_at')) {
                $division->day_end_at = $request->day_end_at;
            }
            if ($request->has('education_type_id')) {
                $division->education_type_id = $request->education_type_id;
            }
            $division->school_id = $school_id;
            $division->update();

            $division_breaks = DivisionBreaks::where('division_id', $request->division_id)->first();
            if ($division_breaks) {
                if ($request->has('book_name')) {
                    $division_breaks->break_name = $request->break_name;
                }
                if ($request->has('duration')) {
                    $division_breaks->duration = $request->duration;
                }
                $division_breaks->update();
            }

            $division_terms = DivisionTerms::where('division_id', $request->division_id)->first();
            if ($division_terms) {
                if ($request->has('start_date')) {
                     $division_terms->start_date = $request->start_date;
                }
                if ($request->has('end_date')) {
                    $division_terms->end_date = $request->end_date;
                }
                if ($request->has('year_id')) {
                    $division_terms->year_id = $request->year_id;
                }
                $division_terms->update();
            }
                $divisions_days_offs = DivisionDaysOff::where('division_id', $request->division_id)->first();
            if ($divisions_days_offs) {
                $divisions_days_offs->day = $request->day;
                $divisions_days_offs->update();
            }


            $newDivision = Division::where('id', $request->division_id)
                ->with('divisionBreaks')
                ->with('getDivisionsTerms')
                ->with('divisionsDaysOff')
                ->get();
        }
        return $this->fire($newDivision);

    }
}
