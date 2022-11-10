<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CouponCode extends Model
{

	protected $table = 'coupon_codes';

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function subscription()
	{
		return $this->belongsTo(Subscription::class, 'subscription_id');
	}

}