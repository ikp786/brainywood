<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\courses;

class  Quizquestions extends Model
{
	protected $table = 'quizquestions';
    /*public function collage(){
        return $this->hasMany('App\Collages','id','collageId');
    }

    public function department(){
        return $this->hasOne('App\Department','id','departmentId');
    }*/
     
}
