<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = ['skill_name'];

    public function users(){
        return $this->hasMany(User::class);
    }
}
