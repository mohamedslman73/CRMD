<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateUserRequest;
use App\School;
use App\StudentClass;
use App\TeacherSubjects;
use App\User;
use App\UserTypes;
use App\UserGrades;
use App\UserTokens;
use App\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends ApiController
{
public function createUser(CreateUserRequest $request)
    {
       /* $this->validate($request,[
            'name'     =>'required',
            'email'    =>'required|unique:users',
            'password' =>'required',
            'type_id'  =>'required|exists:user_types,id',
            'school_id'=>'required|exists:schools,id',
            'class_id'=>'required|exists:classes,id',
            'grade_id'=>'required|exists:grades,id',
            'type_name'=>'required',
           // 'image'=>'required|image',
            'phone'=>'required',
            'address'=>'required',
        ]);*/
        // create user
      /*  if($request->has('password')){
            $request->merge(['password'=>bcrypt($request->password)]);
        }

        if ($request->hasFile('image')) {
            $request->file('image')->store('users/images');
        }
        $user = User::create($request->all());
        $token  = ['api_token'=>str_random(60)];
        $user->userTokens()->create($token);
        return  $this->fire(array_merge($user->toArray(),$token),'usrRegSccs');
        $external = ['userType','userTokens','UserGrades','TeacherSubjects','StudentClass'];
        foreach ($external as $atter){
            if($request->has($atter)){
                foreach($request[$atter] as $value){
                    $user->$value()->create($value);
                }
            }
        }
        return $this->fire($user,$token);*/

      // find school_id from the api_token
/*      $userID = UserTokens::where('api_token',$request->api_token)
                           ->first()
                           ->user_id;
      $school_id = User::where('id',$userID)
                         ->first()
                         ->school_id;*/

        $user = new User();
        $user->name= $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->type_id = $request->type_id;
        $user->phone=$request->phone;
        $user->address=$request->address;
        $user->school_id = $request->school_id; // we will use $school_id in this line and not $request->school_id
                                               // because the front end developers can't send api_token in this time .
        if ($request->hasFile('image')) {
            $user->image = $request->file('image')->store('users/images');
        }

        $user->save();

         $usertype = new UserTypes();
         $usertype->type = $request->type_id;
         $usertype->name_en = $request->type_name;
         $usertype->save();


                  /*
                   * this is not true  , how can the same student in more than one class !!!
                   *
                   */
                  if (count($request->class_id)) {
                      foreach ($request->class_id as $class) {
                          $student_class = new StudentClass;
                          $student_class->user_id = $user->id;
                          $student_class->class_id = $class;
                          $student_class->save();
                      }
                  }
            /*
             * this condition right because teacher can teach the same subject in more than class
             *
             */
          if($request->has('subject_id')) {
            if (count($request->class_id) != 0) {
                foreach ($request->class_id as $class) {
                    $teacher_subject = new TeacherSubjects();
                    $teacher_subject->user_id = $user->id;
                    $teacher_subject->class_id = $class;
                    $teacher_subject->subject_id = $request->subject_id;
                    $teacher_subject->save();
               }
            }
        }
        /*
         * question ?? how can the same user be in more than one grade (user can be teacher or student or parent)
         */
         if(count($request->grade_id) !=0) {
             foreach ($request->grade_id as $grade) {
                 $user_grade = new UserGrades();
                 $user_grade->user_id = $user->id;
                 $user_grade->grade_id = $grade;
                 $user_grade->save();
             }
         }

        return response(['status' => true,'user'=>$user,'user Grades'=>$user_grade,'Student Class'=>$student_class/*,'token'=>$token->api_token*/]);
    }

    public function login(Request $request)
    {
        $rule=[
            'email'    => 'required|email',
            'password' => 'required',
          //  'refresh_token' => 'required',
        ];
        $validate = validator($request->all(),$rule);
        if ($validate->fails()) {
            return response(['status' => false, 'messages' => $validate->messages()]);
        } else {
            if (auth()->attempt(['email' => request('email'), 'password' => request('password')])) {
                $user = auth()->user();
                $user=User::find($user->id);
                $school_id=User::find($user->id)->school_id;
                $school_image=School::find($school_id)->logo;
                $user->refresh_token = $request->refresh_token;
                $user->save();
                $token = User::find($user->id)->refresh_token;
                $image = User::find($user->id)->image;
                $name = User::find($user->id)->name;
//                dd($token);
                $msg = array(
                    'title' => $name,
                    'body' => 'اي حاجه :)',
                    'image' => $image,/*Default Icon*/
                    'sound' => 'mySound'/*Default sound*/
                );
               notify1([$token], $msg);
                $token = new UserTokens;
                $token->api_token = str_random(60);
                $token->user_id = $user->id;
                $token->save();

                if(StudentClass::where('user_id',$user->id)->value('class_id') != null) {
                    $class_id = StudentClass::where('user_id', $user->id)->first()->class_id;
                    $user->class_id = $class_id;

                        if (Classes::where('id', $class_id)->first()->grade_id != null) {
                            $grade_id = Classes::where('id', $class_id)->first()->grade_id;
                            $user->grade_id = $grade_id;
                        }
                    }
                     $user->schoo_iamge = $school_image;
               // dd($user->online());
//                           if ($user->online())
//                           {
//                               $status = '<li class="text-success">Online</li>';
//                           }else{
//                               $status = '<li class="text-muted">Offline</li>';
//                           }
                return response(['status' => true,'user'=>$user,'token'=>$token->api_token]);
            } else {
                return response(['status' => false, 'message' => 'the email or password Incorrect']);
            }
        }
    }


            public function logout(Request $request)
            {
                $this->validate($request,[
                    'api_token'=>'required',
                ]);

                $token =UserTokens::where('api_token',$request->api_token)->first();
                //return $token;
                if ($token) {
                     $token->delete();
                    return response()->json(['status' => true, 'message' => 'Token Deleted Successfully']);
                }
                else
                {
                    return response()->json(['status'=>false,'message'=>'Some Errors Happened']);
                }
            }
}
