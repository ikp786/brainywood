<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RatingUser extends Model
{
	protected $table = 'rating_users';

	public function user()
	{
		return $this->belongsTo(User::class, 'userId');
	}

	public function course()
	{
		return $this->belongsTo(Courses::class, 'courseId');
	}

	public function lession()
	{
		return $this->belongsTo(Lession::class, 'lessionId');
	}

	public function topic()
	{
		return $this->belongsTo(Chapter::class, 'topicId');
	}
}
