<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\HomeWorks;

class HomeworkFiles extends Model
{


    protected $visible = ['file'];
    protected $table ="homework_files";
    protected $fillable=['id','homework_id','file','created_at','updated_at'];
    public function homework()
    {
        return $this->belongsTo(HomeWorks::class,'homework_id');
    }


}


