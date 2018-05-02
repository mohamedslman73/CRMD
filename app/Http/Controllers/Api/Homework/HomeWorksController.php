<?php

namespace App\Http\Controllers\Api\Homework;

use App\Classes;
use App\HomeworkFiles;
use App\HomeWorks;
use App\Notification;
use App\StudentClass;
use App\Subject;
use App\TeacherSubjects;
use App\User;
use App\UserTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
class HomeWorksController extends ApiController
{
    //

    public function createHomeWork(Request $request)
    {

        $this->validate($request, [
            'api_token'             =>'required|exists:user_tokens,api_token',
            'name'                  =>'required',
            'description'           =>'required',
            'score'                 =>'required',
            'weight'                =>'required',
           // 'type'                  =>'required',
            'deadline'              =>'required',
            'subject_id'            =>'required|numeric|exists:subjects,id',
            'class_id'              => 'required|numeric|exists:classes,id',
           // 'howeworkfile'          => 'required',
        ]);
          $userID = UserTokens::where('api_token', $request->api_token)->first()->user_id;
          $schoolID = User::find($userID)->school_id;
          $teacher_name = User::find($userID)->name;
          $subject_name = Subject::find($request->subject_id)->subject_name;
          $student = StudentClass::where('class_id',$request->class_id)->get(['user_id']);
          $array = array();
        foreach ($student as $s)
        {
          $array [] = $s->user_id;
        }

      //  return $array;
        $token =array();
        $refresh = User::whereIn('id',$array)->get(['refresh_token']);
        foreach ($refresh as $any)
        {
            $token [] = $any->refresh_token;
        }
        // re
     // return $token;
         $msg = array(
            'title' => 'Mr. '.$teacher_name,
            'body' => 'There are now Homework added in '.$subject_name.' Subject by Mr. ' .$teacher_name,
            'image' => '',/*Default Icon*/
            'sound' => 'mySound'/*Default sound*/
        );
       // $request->merge(['file' => $request->file('file')->store('schools/files')]);

      /*  $school = Subject::find($request->subject_id);
        if(!$school){
            return $this->fire([],null,['Subject Not Exist']);
        }

        $class = Classes::find($request->class_id);
        if(!$class)
        {
            return $this->fire([],null,['Class Not Exist']);
        }


        $homework =HomeWorks::create($request->all());
        return $this->fire($homework);*/
       // dd($request->all());
       $homework = new HomeWorks;
       $homework->name =$request->name;
       $homework->description = $request->description;
       $homework->score =$request->score;
       $homework->weight =$request->weight;
       $homework->q_link =$request->q_link;
       $homework->type =$request->type;
       $homework->deadline =$request->deadline;
       $homework->school_id =$schoolID;
       $homework->class_id =$request->class_id;
       $homework->subject_id =$request->subject_id;
     //  $homework->save();
        //return 'saman';
        foreach ($array as $user)
        {
            $notification = new Notification();
            $notification->user_id = $user;
            $notification->title = 'Mr. '.$teacher_name;
            $notification->notification_type = 1;
            $notification->body = 'There are now Homework added in '.$subject_name.' Subject by Mr. ' .$teacher_name;
            $notification->save();
        }
      notify1($token,$msg);
            /* $file = new HomeworkFiles();


        $file->file = $request->file('howeworkfile')->store('file');
        $file->homework_id = $homework->id;

        $file->save();*/
        if(count($request->howeworkfile) != 0){
            foreach ($request->howeworkfile as $file) {
                  $homework->files()->create(['file'=>$file->store('files')]);
            }
        }



        //return $homework;
        return response(['status' => true,'home work'=>$homework]);



    }


}
