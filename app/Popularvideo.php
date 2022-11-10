<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\courses;

class Popularvideo extends Model
{
	protected $table = 'popular_videos';
    
    /*public function courses(){
        return $this->hasOne('App\courses','id','courseId');
    }*/
}
