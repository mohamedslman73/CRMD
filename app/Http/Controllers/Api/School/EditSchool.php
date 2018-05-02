<?php

namespace App\Http\Controllers\Api\School;

use App\School;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EditSchool extends Controller
{
    //
    public function EditSchool(Request $request)
    {
        $this->validate($request,[
            'school_id'=>'required|exists:schools,id'
        ]);

          $school = School::find($request->school_id);
        if ($request->has('vision')) {
            $school->vision = $request->vision;
        }
        if($request->has('mission')) {
            $school->mission = $request->mission;
        }
        if ($request->has('address')) {
            $school->address = $request->address;
        }
        if ($request->has('name')) {
            $school->name = $request->name;
        }
        if ($request->has('latitude')) {
            $school->latitude = $request->latitude;
        }
        if ($request->has('longitude')) {
            $school->longitude = $request->longitude;
        }
        if ($request->hasFile('logo')){
            $school->logo = $request->file('logo')->store('schools/logo');
        }
           $school->update();
        if(count($request->emails) != 0) {
            foreach ($request->emails as $email) {
                $school->emails()->update(['title' => $email['title'], 'email' => $email['email']]);
            }
        }
        if(count($request->school) != 0) {
            foreach ($request->numbers as $number) {
                $school->phoneNumbers()->update(['title' => $number['title'], 'number' => $number['number']]);
            }
        }
        if(count($request->numbers) != 0) {
            foreach ($request->numbers as $number) {
                $school->phoneNumbers()->update(['title' => $number['title'], 'number' => $number['number']]);
            }
        }
         $school->emails()->get();
        return response(['school'=>$school]);
    }
}
