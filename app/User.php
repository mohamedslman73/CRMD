<?php

namespace App;


use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    //
    use Notifiable;
    protected $hidden = [
        'password', 'remember_token','created_at','updated_at','activation_code'
    ];

    protected $table = "users";
    protected $fillable = ["name","email","password","type_id","school_id","image"];

    public function userTokens()
    {
        return $this->hasMany(UserTokens::class,'user_id');
    }
    public function studentBehaviors()
    {
        return $this->hasMany(StudentBehavior::class,'student_id');
    }
    public function behaviors()
    {
        return $this->belongsToMany(Behavior::class,'student_behaviors','student_id','behavior_id')->withPivot('total');
    }
    public function userType()
    {
        return $this->belongsTo(UserTypes::class,'type_id');
    }
    public function UserGrades()
    {
        return $this->belongsTo(UserGrades::class,'user_id');
    }
    public function TeacherSubjects()
    {
        return $this->hasMany(TeacherSubjects::class,'user_id');
    }
    public function StudentClass()
    {
        return $this->belongsTo(StudentClass::class,'user_id');
    }
    public function Attendance()
    {
        return $this->belongsTo(Attendance::class,'id','user_id');
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function online()
    {
      // return Cache::has('user-is-online-'.$this->id);
        return Cache::has('user-is-online-'.$this->id);
    }

}
