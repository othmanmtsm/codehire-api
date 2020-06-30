<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'organisation', 'nb_employees'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function projects(){
        return $this->hasMany(Project::class,'client_id','user_id');
    }

    public function reviews(){
        return $this->belongsToMany(Freelancer::class, 'freelancer_reviews', 'client_id', 'freelancer_id')->withPivot('id','review', 'rating');
    }
}
