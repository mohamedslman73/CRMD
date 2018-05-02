<?php

namespace App\Http\Controllers\Api\Teacher;

use App\HomeWorks;
use App\Http\Controllers\Api\ApiController;
use App\TeacherSubjects;
use App\UserTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeacherHomwork extends ApiController
{
    public function TeacherHomwork(Request $request)
    {
        $this->validate($request, [
            'class_id'           => 'required',
            'subject_id'         => 'required',
            'api_token'          => 'required',
            'school_id'          => 'required',
        ]);
        $user = UserTokens::where('api_token', $request->api_token)->value('user_id');//12
        $teacher_subject = TeacherSubjects::where('user_id', $user)->value('subject_id');//11
        $teacher_class = TeacherSubjects::where('user_id', $user)->value('class_id');//4
        if (($teacher_subject == $request->subject_id) and ($teacher_class == $request->class_id)) {
            $homework = HomeWorks::where('subject_id',$request->subject_id)
                                   ->where('class_id',$request->class_id)
                                   ->with('files')
                                    ->get()->toArray();

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
        return response(['error'=>'There Are No Data','scode'=>404]);
    }
}
