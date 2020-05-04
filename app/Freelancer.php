<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Freelancer extends Model
{
    protected $primaryKey = 'user_id';

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function certifications(){
        return $this->hasMany(Certification::class,'freelancer_id','user_id');
    }

    public function experience(){
        return $this->hasMany(Experience::class,'freelancer_id','user_id');
    }

    public function categories(){
        return $this->belongsToMany(Category::class,'category_freelancer','category_id','freelancer_id');
    }
}
