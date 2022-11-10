<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContinueStudy extends Model
{

	protected $table = 'continue_study_history';

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

}