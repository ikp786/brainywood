<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Courses;
use App\Lession;

class Quiz extends Model
{
	protected $table = 'quizs';

	public function courses(){
        return $this->hasOne('App\Courses','id','courseId');
    }
    public function lession(){
        return $this->hasOne('App\Lession','id','lessionId');
    }

    /*public function collage(){
        return $this->hasMany('App\Collages','id','collageId');
    }

    public function department(){
        return $this->hasOne('App\Department','id','departmentId');
    }*/
     
}
