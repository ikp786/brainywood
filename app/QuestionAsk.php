<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionAsk extends Model
{
	protected $table = 'question_asks';

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function course()
	{
		return $this->belongsTo(Courses::class, 'course_id');
	}

	public function lession()
	{
		return $this->belongsTo(Lession::class, 'lession_id');
	}

	public function topic()
	{
		return $this->belongsTo(Chapter::class, 'topic_id');
	}

	
}
