<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function freelancers(){
        return $this->belongsToMany(Freelancer::class,'category_freelancer','category_id','freelancer_id');
    }
}
