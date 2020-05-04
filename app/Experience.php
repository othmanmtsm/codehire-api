<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    public function freelancer(){
        return $this->belongsTo(Freelancer::class,'freelancer_id','user_id');
    }
}
