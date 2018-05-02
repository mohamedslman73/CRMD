<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Addgrade;
use App\Notification;
use App\StudentGrades;
use App\Subject;
use App\TeacherSubjects;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeacherStudentEditGrade extends Controller
{
    //
    public function TeacherStudentEditGrade(Request $request)
    {
            /*        "grades" : [
            {"user_id":"7","total_score":"7","addgrade_id"},
            {"user_id":"44","total_score":"8"},
            {"user_id":"47","total_score":"9"}
            ]

              {"grades" : [
           {"user_id":"8","total_score":"17","addgrade_id":"1"},
            {"user_id":"44","total_score":"18","addgrade_id":"1"},
            {"user_id":"47","total_score":"19","addgrade_id":"1"}
            ] }

            }*/
//$rules=['grades'=>'required|array'];
        $request=json_decode($request->getContent());
       // dd($request->grades);
//        $this->validate([$request->grades=>"required|array"],  [
//                   'grades'=>'required|array'
//                ]);

              //return count($request->user_id);


              foreach ($request->grades as $key)
              {
                  $subject_id =Addgrade::find($key->addgrade_id)->subject_id;
                  $subject_name =  Subject::find($subject_id)->subject_name;
                  $teacher_id = TeacherSubjects::where('subject_id',$subject_id)->value('user_id');
                  $teacher_name =   User::find($teacher_id)->name;
                  $msg = array(
                      'title' => 'Mr. ' .$teacher_name,
                      'body' => 'There are '. $key->total_score.' Grade added to You in '.$subject_name. ' Subject',
                      'image' => '',/*Default Icon*/
                      'sound' => 'mySound'/*Default sound*/
                  );
                  $token = User::find($key->user_id)->refresh_token;
                  $student = StudentGrades::where('user_id', $key->user_id)
                      ->where('addgrade_id', $key->addgrade_id)->first();
                  if ($student !=null) {
                       StudentGrades::where('user_id', $key->user_id)->update(['total_score' => $key->total_score, 'addgrade_id' => $key->addgrade_id]);
                       /*
                        * insert in notifications table
                        */
                       $notification = new Notification;
                       $notification->title = 'Mr. ' .$teacher_name;
                       $notification->body = 'There are '. $key->total_score.' Grade added to You in '.$subject_name. ' Subject';
                       $notification->user_id = $key->user_id;
                       $notification->notification_type = 3 ;
                       $notification->save();
                       notify1([$token],$msg);
                  }
                  else{
                        StudentGrades::create(['user_id' => $key->user_id,'total_score' => $key->total_score, 'addgrade_id' => $key->addgrade_id]);

                      /*
                     * insert in notifications table
                     */
                      $notification = new Notification;
                      $notification->title = 'Mr. ' .$teacher_name;
                      $notification->body = 'There are '. $key->total_score.' Grade added to You in '.$subject_name. ' Subject';
                      $notification->user_id = $key->user_id;
                      $notification->notification_type = 3 ;
                      $notification->save();
                      notify1([$token],$msg);
                  }
              }
        return response()->json(['Graded'=>'Updates Successfully']);
    }
}
