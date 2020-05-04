<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    public function freelancer(){
        return $this->belongsTo(Freelancer::class,'freelancer_id','user_id');
    }
}
