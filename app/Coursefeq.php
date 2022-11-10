<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\user;

class Coursefeq extends Model
{
	protected $table = 'course_feqs';

  /*  protected $fillable = [
        'name',
        'instructor'
    ];

    public function instructor(){
        return $this->hasOne('App\user','id','instructorId');
    }*/


}
