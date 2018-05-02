<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialFile extends Model
{
    protected $visible=['file'];
    protected $fillable=['file','material_id','created_at','updated_at'];
    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
