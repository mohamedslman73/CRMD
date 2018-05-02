<?php

namespace App\Http\Controllers\Api\Grades;
use App\Grade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CreateGrades extends Controller
{
    //
    public function CreateGrades(Request $request)
    {
        $this->validate($request,[
            'grades'=>'required',
        ]);
             if(count($request->grades) !=0)
        { //return $request->grades;
            foreach ($request->grades as $grade)
            {// return var_dump($grade);
                $g = new Grade();
                $g->name = $grade['name'];
                $g->division_id = $grade['division_id'];
                $g->save();

            }
            return response()->json(['data'=>'Grades created Successfully']);
        }
    }
}
