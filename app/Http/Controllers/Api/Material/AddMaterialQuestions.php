<?php

namespace App\Http\Controllers\Api\Material;

use App\Http\Controllers\Api\ApiController;
use App\Material;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddMaterialQuestions extends ApiController
{
    public function addMaterialQuestion(Request $request)
    {
        $this->validate($request,[
                            'material_id'=>'required',

        ]);
        $data=[];
        $material=Material::find($request->material_id);
        if(count($request->questions)!=0){
            $questions= $request->questions;
            for ($i=0;count($questions)>$i;$i++ ){
                $text=$questions[$i]['q_text'];
                $type=$questions[$i]['q_type'];

                $questionQuery=$material->questions()->create(['q_text'=>$text,
                    'q_type'=>$type]);
                $data['question'][]=$questionQuery;
                $answers=$questions[$i]['answers'];
                for ($j=0;count($answers)>$j;$j++ ){
                    $answerQuery=$questionQuery->answers()->create([ 'ans_text'=>$answers[$j]['ans_text'],
                        'is_right'=>$answers[$j]['is_right']]);
                    $data['question'][$i]['answers'][$j]=$answerQuery;
                }
            }
            return $this->fire($data);

        }
    }
}
