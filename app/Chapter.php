<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Lession;

class Chapter extends Model
{
	protected $table = 'lession_chapters';

	/*public function lession()
	{
		return $this->belongsTo(Lession::class, 'lessionId');
	}*/
    
    public function lession(){
        return $this->hasOne('App\Lession','id','lessionId');
    }
}
