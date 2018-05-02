<?php
namespace App\Http\Controllers\Api\Material;
use App\Classes;
use App\Http\Controllers\Api\ApiController;
use App\Material;
use App\MaterialFile;
use App\Subject;
use App\TeacherSubjects;
use App\UserTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class CreateMaterialController extends ApiController
{
    public function createMaterialSubject(Request $request)
    {
        $this->validate($request,[
            'api_token'     =>'required',
            'title'         =>'required',
            'description'   =>'required',
            'week_num'      =>'required',
            'file'          =>'required',
            'subject_id'    =>'required',
        ]);

//                $userID = UserTokens::where('api_token',$request->api_token)
//                                      ->first()
//                                      ->user_id;
        $material = new Material();
        $material->title = $request->title;
        $material->description = $request->description;
        $material->week_num = $request->week_num;
        $material->subject_id = $request->subject_id;
        $material->save();
        if(count($request->file) != 0){
            foreach ($request->file as $files) {
                $material->materialFile()->create(['file'=>$files->store('files')]);
            }
        }
        return $this->fire($material);
        /*        $data=[];
                $material=Material::create($request->all());
                $data['materialInfo']=$material;
                $data['id']=$material->id;
                if($request->hasFile('file')){
                    $files=$request->file;
                    foreach ($files as $key=>$file){
                        $file=$material->materialFile()->create(['file'=>$file->store('homework/answers')]);
                        $data['files'][$key]=$file;
                    }
                }*/
        // return $this->fire($data);
    }
}