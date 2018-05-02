<?php

namespace App\Http\Controllers\Api\Grades;

use App\Division;
use App\Grade;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;

class GradesController extends ApiController
{
    //
    public function createGrades(Request $request)
    {
        $this->validate($request,[
           'name'         =>'required',
           'total_score'  => 'required',
            'weight'      =>'required',
            'type'        =>'required',
            'division_id' =>'required',
        ]);

        $division = Division::find($request->division_id);
        if(!$division){
            return $this->fire([],null,['Division Not Exist']);
        }
        $gardes =Grade::create($request->all());
        return $this->fire($gardes);
    }

    /**
     * edit grades
     * @param Request $request
     * @param Grade $grade
     * @return \Illuminate\Http\JsonResponse
     */
    public function editGrades(Request $request, Grade $grade)
    {

        $this->validate($request,[
            'name'         =>'required',
            'total_score'  =>'required',
            'weihgt'       =>'required',
            'type'         =>'required'
        ]);
      $gradeupdate = Grade::where('id',$grade->id)->update($request->all());

      return $this->fire($gradeupdate);
    }

    public function deleteGrade(Request $request)
    {
        $deletgrade = Grade::find($request->id);
        if(!$deletgrade){
           return $this->fire([],null,['This Grade Not Exist']);
        }
        $deleted = $deletgrade->delete();
        return $this->fire($deleted);
    }
    public function getGradeClassesSubjects(Request $request)
    {
        $this->validate($request,[
            'id'=>'required|exists:grades,id'
        ]);
       $asd =Grade::where('id',$request->id);
       $grade= $asd->with('classes')->with('subjects')->first();
        return $this->fire($grade);
    }
}
