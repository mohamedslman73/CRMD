<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolEmails extends Model
{
    //
    protected $table= "school_emails";
    protected $fillable = ["title","email","school_id"];

    public function school()
    {
        return $this->belongsTo(School::class,'school_id');
    }
}
