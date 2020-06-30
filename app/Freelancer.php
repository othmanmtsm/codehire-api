<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Freelancer extends Model
{
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'hourly_rate','username','title','bio'
    ];

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
        return $this->belongsToMany(Category::class,'category_freelancer','category_id','freelancer_id')->withPivot('category_id','freelancer_id');
    }

    public function skills(){
        return $this->belongsToMany(Skill::class,'skill_user','user_id','skill_id');
    }

    public function projects(){
        return $this->belongsToMany(Project::class, 'project_freelancer', 'freelancer_id', 'project_id')->withPivot('amount','duration','description','isHired');
    }

    public function reviews(){
        return $this->belongsToMany(Client::class, 'freelancer_reviews', 'freelancer_id', 'client_id')->withPivot('id','review', 'rating');
    }

    public function tasks()
    {
        return $this->belongsToMany(Project::class, 'tasks', 'freelancer_id', 'project_id')->withPivot('freelancer_id','project_id','task','stage');
    }
}
