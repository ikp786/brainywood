<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Courses;

class Lession extends Model
{
    public function courses(){
        return $this->hasOne('App\Courses','id','courseId');
    }
}
