<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\courses;

class Quizoption extends Model
{
	protected $table = 'quiz_options';
    /*public function collage(){
        return $this->hasMany('App\Collages','id','collageId');
    }

    public function department(){
        return $this->hasOne('App\Department','id','departmentId');
    }*/
     
}
