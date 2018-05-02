<?php

namespace App\Http\Controllers\Api\School;

use App\Http\Middleware\apiLocale;
use App\School;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;

class GetSchoolsController extends ApiController
{
    //

    public function getSchools()
    {
        $schools = School::with('emails')->with('phoneNumbers')->get();

        return $this->fire($schools);
    }

    public function singleSchool(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:schools,id',
        ]);
        $school = School::where('id', $request->id)->with('emails')->with('phoneNumbers')->first();
        return $this->fire($school);
    }

        public function Search(Request $request)
        {
            $name =  $request->get('name');

            if ($name == null) {
                return response()->json('enter search information. Try to search again !');
            } else {

                $data = School::where('name','LIKE', '%'.$name.'%')->get();

            }
            if (count($data)) {
                return $this->fire($data);
            }
            else{
                return $this->fire([], null, ['School Not Exist']);
            }

        }
}
