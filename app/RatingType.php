<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RatingType extends Model
{
	protected $table = 'rating_types';

	/*public function lession()
	{
		return $this->belongsTo(Lession::class, 'lessionId');
	}*/
}
