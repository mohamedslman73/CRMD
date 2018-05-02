<?php

namespace App\Http\Controllers\Api\Material;

use App\Http\Controllers\Api\ApiController;
use App\Material;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetMaterialForSubject extends ApiController
{
    public function getMaterialSubject(Request $request)
    {
        $this->validate($request,[
            'subject_id'    =>'required',
            'api_token'     =>'required',
        ]);
        $material=Material::where('subject_id',$request->subject_id)
                    ->with('materialFile')
                    ->get()->toArray();
        //['id','title','description','week_num','q_link','subject_id','subject_id','grade_id','created_at']
        $data=[];

        for( $key=0;count($material)>$key;$key++){//to override the array
            $data[$key]=$material[$key];
            /*return count($data[$key]['materialFile']);*/

            for ($i = 0;$i<count($data[$key]['material_file']);$i++) {

                $data[$key]['material_file'][$i]['file'] = url('uploads/'.$data[$key]['material_file'][$i]['file']);
                $info = pathinfo($data[$key]['material_file'][$i]['file']);


                $data[$key]['material_file'][$i]['extension']= $info['extension'];
                $img = ['ai','bmp','gif','ico','jpeg','jpg','png','ps','psd','svg','tif','tiff'];
                $doc = ['wpd','wks','pps','ppt','pptx','wps','txt','tex','rtf','odt','docx','doc','docm','dotx','dotm','docb','dot','wbk','pot','pptm','potx','potm','ppam','ppsx','ppsm','sldx','sldm'];
                $video = ['wmv','vob','swf','rm','mpg','mpeg','mp4','mov','mkv','m4v','h264','flv','avi','3gp','3g2'];
                $pdf = ['pdf'];
                if(in_array($info['extension'],$img)){

                    $data[$key]['material_file'][$i]['type']='image';

                }elseif(in_array($info['extension'],$doc)){

                    $data[$key]['material_file'][$i]['type']='doc';

                }elseif(in_array($info['extension'],$video)){

                    $data[$key]['material_file'][$i]['type']='video';

                }elseif(in_array($info['extension'],$pdf)){

                    $data[$key]['material_file']    [$i]['type']='pdf';

                }
            }
        }
/*        dd($data);*/
        return $this->fire($data);
    }
}
