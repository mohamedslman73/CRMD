<?php

namespace App\Http\Controllers\Api;

use App\Country;
use Illuminate\Http\Request;

class RegionsController extends ApiController
{
    public function getRegions($lang = "en")
    {
        $regions = Country::select('id', "name_" . app()->getLocale())->with(['cities' => function ($cities) {
            $cities->with(['districts' => function ($district) {
                $district->select('id', "name_" . app()->getLocale(), 'city_id');
            }])->select('id', "name_" . app()->getLocale(), 'country_id');
        }])->get()->toArray();

        return $this->fire($regions);
    }


    public function testUpload(Request $request)
    {
        $files = $request->pics;
        //dd($files );
        if(count($files)>0)
        {
            foreach($files as $file)
            {
                $fileName[] = $file->store('android/list');
            }
            return $fileName;
        }
        return "You aren't sening list";
    }


}
