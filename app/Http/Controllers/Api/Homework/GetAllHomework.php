<?php

namespace App\Http\Controllers\Api\Homework;

use App\Assignment;
use App\StudentClass;
use App\UserTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;
use App\HomeWorks;
use App\HomeworkFiles;

class GetAllHomework extends ApiController
{
    //////////////////////////// Display all info about Homework for subject////////////////////////////
    public function getAllHomeworkForSubject(Request $request)
    {
        $this->validate($request,[
                                    'school_id'     =>"required",
                                    'subject_id'    =>"required",
                                    'api_token'     =>"required",
        ]);
        $user= UserTokens::where('api_token',$request->api_token)->value('user_id');
        $class_id=StudentClass::where('user_id',$user)->first()->class_id;
        $homework=HomeWorks::where('school_id',$request->school_id)
                            ->where('subject_id',$request->subject_id)
                            ->where('class_id',$class_id)
                            ->with('files')
                            ->get(['id','name','description','score','weight','deadline','type','q_link'])->toArray();

        $data=[];

            for( $key=0;count($homework)>$key;$key++){//to override the array
                $data[$key]=$homework[$key];
                for ($i = 0;$i<count($data[$key]['files']);$i++) {
                    $data[$key]['files'][$i]['file'] = url('uploads/'.$data[$key]['files'][$i]['file']);
                    $info = pathinfo($data[$key]['files'][$i]['file']);
                    $data[$key]['files'][$i]['extension'] = $info['extension'];
                    $img = ['ai','bmp','gif','ico','jpeg','jpg','png','ps','psd','svg','tif','tiff'];
                    $doc = ['wpd','wks','pps','ppt','pptx','wps','txt','tex','rtf','odt','docx','doc','docm','dotx','dotm','docb','dot','wbk','pot','pptm','potx','potm','ppam','ppsx','ppsm','sldx','sldm'];
                    $video = ['wmv','vob','swf','rm','mpg','mpeg','mp4','mov','mkv','m4v','h264','flv','avi','3gp','3g2'];
                    $pdf = ['pdf'];
                    if(in_array($info['extension'],$img)){

                        $data[$key]['files'][$i]['type']='image';

                    }elseif(in_array($info['extension'],$doc)){

                        $data[$key]['files'][$i]['type']='doc';

                    }elseif(in_array($info['extension'],$video)){

                        $data[$key]['files'][$i]['type']='video';

                    }elseif(in_array($info['extension'],$pdf)){

                        $data[$key]['files'][$i]['type']='pdf';

                    }else{
                        $data[$key]['files'][$i]['type']='notDefine';

                    }
                }
            }
        return $this->fire($data);
    }

    //////////////////////////// Uploads Answers file for homework  ////////////////////////////

    public function UploadHomeworkFile(Request $request)
    {
        $this->validate($request,[

            'homework_id'     =>"required",
            'homework_files'  =>"required",
            'api_token'       =>"required"
        ]);

        if(count($request->homework_files)!=0){
            $files=$request->homework_files;
/*         dd($files);*/
            $i=0;
            $student=$this->getUserObject()->id;
            foreach ($files as $file){
                $i++;
                Assignment::create([
                                          'student_id'=> $student,
                                          'homework_id'=> $request->homework_id,
                                          'file'=>$file->store('homework/answers')
             ]);

            }
        return $this->fire('you insert '.$i." file");
        }
        return $this->fire("don't have files");

    }
}
