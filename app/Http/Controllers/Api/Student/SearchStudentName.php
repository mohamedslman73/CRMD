<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Api\ApiController;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchStudentName extends ApiController
{
    //
    /*public function Search(Request $request)
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

    }*/
    public function SearchStudentName(Request $request)
    {
        $name = $request->get('name');
        if ($name ==null){
            return response()->json('enter search information . Try to search again !');
        }else{
            $data = User::where('name','LIKE','%'.$name.'%')
                          ->where('type_id','=',5)
                          ->get();
        }
        if (count($data)){
            return $this->fire($data);
        }else{
            return $this->fire([],null,['Student Not Exists']);
        }
    }
}
