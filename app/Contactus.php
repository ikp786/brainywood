<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contactus extends Model
{

	protected $table = 'contactus';

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

}