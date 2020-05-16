<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = ['skill_name'];

    public function users(){
        return $this->belongsToMany(Freelancer::class,'skill_user','skill_id','user_id');
    }

    public function projects(){
        return $this->belongsToMany(Project::class, 'project_skill', 'skill_id', 'project_id');
    }
}
