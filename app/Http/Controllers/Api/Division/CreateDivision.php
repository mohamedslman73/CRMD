<?php

namespace App\Http\Controllers\Api\Division;

use App\Division;
use App\DivisionBreaks;
use App\DivisionDaysOff;
use App\DivisionTerms;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\CreateDivisionRequest;
use App\SchoolYears;
use Illuminate\Http\Request;
use App\User;
use App\UserTokens;


class CreateDivision extends ApiController
{
    //
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function CreateDivivsion(CreateDivisionRequest $request)
    {
//        $this->validate($request,[
//            'name'=>'required',
//            'lessons_per_day'=>'required',
//            'lesson_duration'=>'required',
//            'day_start_at'=>'required',
//            'day_end_at'=>'required',
//            //'api_token' => 'required|exists:user_tokens,api_token',
//            'education_type_id'=>'required|exists:education_types,id',
//            'start_date'=>'required',
//            'end_date'=>'required',
//            'duration'=>'required',
//            'break_name'=>'required',
//            'day'=>'required',
//            'school_id'=>'required|exists:schools,id'
//        ]);

        //api_token aOfeaniPvKEtKrrIh6IkNOF4zMhSaehRJBa6PcIohCS5MfmOWpttjLyfAWuc user_id=15
      /*  $userID = UserTokens::where('api_token', $request->api_token)->first()->user_id;

            $school = User::find($userID)->school_id;
        $schoo_year = SchoolYears::where('school_id',$school)->first()->id;*/
        $schoo_year = SchoolYears::where('school_id',$request->school_id)->first()->id;
        $division = new Division;
        $division->name = $request->name;
        $division->lessons_per_day = $request->lessons_per_day;
        $division->lesson_duration = $request->lesson_duration;
        $division->day_start_at = $request->day_start_at;
        $division->day_end_at = $request->day_end_at;
        $division->education_type_id = $request->education_type_id;
        $division->school_id = $request->school_id;
        $division->save();
        $division_terms = new DivisionTerms;
        $division_terms->start_date = $request->start_date;
        $division_terms->end_date = $request->end_date;
        $division_terms->year_id = $schoo_year;
       // $division_terms->division_id = $division->id;
        $division->getDivisionsTerms()->save($division_terms);

        $division_breaks = new DivisionBreaks;
        $division_breaks->break_name = $request->break_name;
        $division_breaks->duration = $request->duration;
        $division->divisionBreaks()->save($division_breaks);

        if(count($request->day) != 0) {
            foreach ($request->day as $days) {
                $divisions_days_offs = new DivisionDaysOff;
                $divisions_days_offs->day = $days;
                $division->divisionsDaysOff()->save($divisions_days_offs);
            }
        }
        //$division->divisionsDaysOff()->save($divisions_days_offs);
         return $this->fire($division);


    }
}
