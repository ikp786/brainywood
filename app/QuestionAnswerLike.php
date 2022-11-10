<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionAnswerLike extends Model
{
	protected $table = 'question_answer_likes';

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function answer()
	{
		return $this->belongsTo(QuestionAnswer::class, 'answer_id');
	}

	
}
