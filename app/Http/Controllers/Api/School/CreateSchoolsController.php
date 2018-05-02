<?php
namespace App\Http\Controllers\Api\School;
use App\Division;
use App\EducationTypes;
use App\Grade;
use App\Http\Requests\CreateSchoolRequest;
use App\School;
use App\SchoolEmails;
use App\User;
use App\UserTypes;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\ApiController;

class CreateSchoolsController extends ApiController
{

    /*
     * step1 : logo,mission,vision,emails,numbers,address
     * step2 : district_id,schooltypes,years
     * step3 : location
     * step4 : grades
     * step5 : useraccount
     */

    public function create(CreateSchoolRequest $request)
    {
//        $this->validate($request, [
//            'name' => 'required',
//            'logo' => 'required|image',
//            'vision' => 'required',
//            'mission' => 'required',
//            'address' => 'required',
//           // 'longitude' => 'required',
//          //  'latitude' => 'required',
//            'district_id'=>'required|numeric|exists:districts,id',
//            'emails'=>'required',
//            'numbers'=>'required',
//            'schoolyears'=>'required',
//            'schooltypes'=>'required',
//
//
//            //'grades'=>'required',
//          //  'division_id'=>'required|exists:divisions,id',
//
//
//
//          //  'grades'=>'required',
//
//           // 'division_id'=>'required|exists:divisions,id',
//
//
//        ]);
        $school = new School;
        $school->name = $request->name;
        $school->logo = $request->file('logo')->store('schools/logo');
        $school->vision = $request->vision;
        $school->mission = $request->mission;
        $school->address = $request->address;
        $school->longitude = $request->longitude;
        $school->latitude = $request->latitude;
        $school->district_id = $request->district_id;

        $school->save();

/*      if(count($request->grades) !=0)
        { //return $request->grades;
            foreach ($request->grades as $grade)
            {// return var_dump($grade);
                $g = new Grade();
                $g->name = $grade['name'];
                $g->division_id = $grade['division_id'];
                $g->save();
            }
        }*/

         //$emails = new SchoolEmails;
              //return $request->emails;
        if(count($request->emails) != 0) {
            foreach ($request->emails as $email) {
                $school->emails()->create(['title' => $email['title'], 'email' => $email['email']]);
            }
        }
        if(count($request->numbers) != 0) {
            foreach ($request->numbers as $number) {
                $school->phoneNumbers()->create(['title' => $number['title'], 'number' => $number['number']]);
            }
        }

        if(count($request->schoolyears) != 0) {
            foreach ($request->schoolyears as $schoolyear) {
                $school->schoolYears()->create(['start_date' => $schoolyear['start_date'], 'end_date' => $schoolyear['end_date']]);
            }
        }

        if(count($request->schooltypes) != 0) {
            foreach ($request->schooltypes as $schooltype) {
                $school->schoolTypes()->create(['type_id' => $schooltype['type_id']]);
            }
        }

    return $this->fire($school);

    }

    public function getEducationTypes()
    {
        $educationTypes = EducationTypes::all();
        return $this->fire($educationTypes);
    }

    public function getGrades(Request $request)
    {
      $this->validate($request,[
          'education_type_id'=>'required|exists:education_types,id',
      ]);
     $division = Division::where('education_type_id',$request->education_type_id)->get();
   /* foreach ($div as $d)
    {
        //return $d->id;
         $grades = Grade::where('division_id',$d->id)->get(['name']);
        return $this->fire($grades);
    }*/
   return $this->fire($division);

    }


/*        // $request->merge(['logo' => $request->file('logo')->store('schools/logos')]);
        $school = School::create($request->all());
        $email = $request->emails;

        if ($request->has('emails')) {

            $school->emails()->create(['email' => $email]);
        }

        $phone = $request->phonenumbers;
        if ($request->has('phoneNumbers')) {

            $school->phoneNumbers()->create(['number' => $phone]);


            foreach ($request->emails as $email) {
                $school->emails()->create(['title' => $email['title'], 'email' => $email['email']]);

            }


            foreach ($request->phoneNumbers as $phone) {
                $school->phoneNumbers()->create(['title' => $phone['title'], 'number' => $phone['number']]);

            }

            return $this->fire($school);
        }
    }

        public
        function step2(Request $request)
        {
            $this->validate($request, [
                'school_id' => 'required',
                'schoolTypes' => 'array',
                'years' => 'array',
            ]);

            $school = School::find($request->school_id);
            if (!$school) {
                return $this->fire([], null, ['School Not Exist']);
            }
            $school->update(['district_id' => $request->district_id]);
            if ($request->has('schoolYears')) {
                foreach ($request->schoolYears as $year) {
                    $yearData = [
                        'year_name' => 'name',
                        'start_date' => 'start',
                        'start_end' => 'end',
                    ];
                    $school->schoolYears()->create($yearData);
                }

            }
            if ($request->has('schoolTypes')) {
                foreach ($request->schoolTypes as $type) {
                    $school->schoolTypes()->create(['type_id' => $type]);
                }
            }
            return $this->fire($school);
        }

        public
        function step3(Request $request)
        {
            $this->validate($request, [
                'school_id' => 'required',
                'longitude' => 'required',
                'latitude' => 'required',
            ]);
            $school = School::find($request->school_id);
            if (!$school) {
                return $this->fire([], null, ['School Not Exist']);
            }
            $school->update($request->all());
            return $this->fire($school);
        }*/



        public function step5(Request $request)
        {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'type_id' => 'required',
                'school_id' => 'required',
            ]);
            // $request->merge(['logo' => $request->file('logo')
            if($request->has('password')){
                $request->merge(['password'=>bcrypt($request->password)]);
            }
            $school = School::find($request->school_id);
            if (!$school) {
                return $this->fire([], null, ['School Not Exist']);
            }

            $type = UserTypes::find($request->type_id);
            if (!$type) {
                return $this->fire([], null, ['Type Not Exist']);
            }

            $user = $school->userSchool()->create($request->all());
            $token = ['api_token' => str_random(60)];
            $user->userTokens()->create($token);
            return $this->fire(array_merge($user->toArray(), $token));
        }


    }

