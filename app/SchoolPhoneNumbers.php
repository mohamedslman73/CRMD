<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolPhoneNumbers extends Model
{
    //
    protected $table = "school_phone_numbers";
    protected $fillable = ["title","number","school_id"];
}
