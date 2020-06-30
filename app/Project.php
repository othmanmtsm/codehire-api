<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'date_limit', 'description', 'payment_min', 'payment_max', 'unavailable_at', 'payment_type', 'category_id', 'client_id','titre'
    ];

    public function client(){
        return $this->belongsTo(Client::class,'client_id','user_id');
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function paymentType(){
        return $this->belongsTo(PaymentType::class,'payment_type','id');
    }

    public function skills(){
        return $this->belongsToMany(Skill::class, 'project_skill', 'project_id', 'skill_id');
    }

    public function freelancers(){
        return $this->belongsToMany(Freelancer::class, 'project_freelancer', 'project_id', 'freelancer_id')->withPivot('amount','duration','description','isHired','hours_worked');
    }

    public function tasks()
    {
        return $this->belongsToMany(Freelancer::class, 'tasks', 'project_id', 'freelancer_id')->withPivot('freelancer_id','project_id','task','stage');
    }
}
