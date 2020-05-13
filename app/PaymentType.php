<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    public function projects(){
        return $this->hasMany(Project::class,'payment_type','id');
    }
}
