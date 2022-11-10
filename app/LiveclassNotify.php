<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiveclassNotify extends Model
{

	protected $table = 'liveclass_notify';

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function liveclass()
	{
		return $this->belongsTo(LiveClass::class, 'class_id');
	}

}