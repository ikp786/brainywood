<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Lession;

class VideoTemp extends Model
{
	protected $table = 'video_temp';

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

	public function popularvideo()
	{
		return $this->belongsTo(Popularvideo::class, 'popularvideoId');
	}

	public function liveclass()
	{
		return $this->belongsTo(LiveClass::class, 'liveclassId');
	}
    
    /*public function lession(){
        return $this->hasOne('App\Lession','id','lessionId');
    }*/
}
