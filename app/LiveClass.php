<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\courses;

class LiveClass extends Model
{

	protected $table = 'live_classes';

	public function user()
	{
		return $this->belongsTo(User::class, 'added_by');
	}

    /*public function courses(){
        return $this->hasOne('App\courses','id','courseId');
    }*/

}