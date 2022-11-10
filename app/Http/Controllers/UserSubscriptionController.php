<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\CouponCode;
use App\Subscription;
use App\UserSubscription;
use App\User;


class UserSubscriptionController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		//echo '<pre />'; print_r($request->all()); die;
		if(!empty($request->user) && !empty($request->subscription) && !empty($request->coupon) && !empty($request->from) && !empty($request->to) ){
			$data = UserSubscription::where("user_id",$request->user)->where("subscription_id",$request->subscription)->where("coupon_code",$request->coupon)->where("start_date",">=",$request->from)->where("start_date","<=",$request->to)->orderBy('id', 'DESC')->get();
		}elseif(!empty($request->user) && !empty($request->subscription) && !empty($request->coupon) && !empty($request->from) ){
			$data = UserSubscription::where("user_id",$request->user)->where("subscription_id",$request->subscription)->where("coupon_code",$request->coupon)->where("start_date",">=",$request->from)->orderBy('id', 'DESC')->get();
		}elseif(!empty($request->user) && !empty($request->subscription) && !empty($request->coupon) ){
			$data = UserSubscription::where("user_id",$request->user)->where("subscription_id",$request->subscription)->where("coupon_code",$request->coupon)->orderBy('id', 'DESC')->get();
		}elseif(!empty($request->user) && !empty($request->subscription) ){
			$data = UserSubscription::where("user_id",$request->user)->where("subscription_id",$request->subscription)->orderBy('id', 'DESC')->get();
		}elseif(!empty($request->user) && !empty($request->coupon) ){
			$data = UserSubscription::where("user_id",$request->user)->where("coupon_code",$request->coupon)->orderBy('id', 'DESC')->get();
		}elseif(!empty($request->user) && !empty($request->from) && !empty($request->to) ){
			$data = UserSubscription::where("user_id",$request->user)->where("start_date",">=",$request->from)->where("start_date","<=",$request->to)->orderBy('id', 'DESC')->get();
		}elseif(!empty($request->user) && !empty($request->from) ){
			$data = UserSubscription::where("user_id",$request->user)->where("start_date",">=",$request->from)->orderBy('id', 'DESC')->get();
		}elseif(!empty($request->subscription) && !empty($request->coupon) ){
			$data = UserSubscription::where("subscription_id",$request->subscription)->where("coupon_code",$request->coupon)->orderBy('id', 'DESC')->get();
		}elseif(!empty($request->user) && !empty($request->subscription) && !empty($request->from) ){
			$data = UserSubscription::where("user_id",$request->user)->where("subscription_id",$request->subscription)->where("start_date",">=",$request->from)->orderBy('id', 'DESC')->get();
		}elseif(!empty($request->subscription) && !empty($request->from) ){
			$data = UserSubscription::where("subscription_id",$request->subscription)->where("start_date",">=",$request->from)->orderBy('id', 'DESC')->get();
		}elseif(!empty($request->user) ){
			$data = UserSubscription::where("user_id",$request->user)->orderBy('id', 'DESC')->get();
		}elseif(!empty($request->subscription) ){
			$data = UserSubscription::where("subscription_id",$request->subscription)->orderBy('id', 'DESC')->get();
		}elseif(!empty($request->coupon) ){
			$data = UserSubscription::where("coupon_code",$request->coupon)->orderBy('id', 'DESC')->get();
		}elseif(!empty($request->from) && !empty($request->to) ){
			//$data = UserSubscription::where("start_date",">=",$request->from)->where("end_date","<=",$request->to)->orderBy('id', 'DESC')->get();
			$data = UserSubscription::where("start_date",">=",$request->from)->where("start_date","<=",$request->to)->orderBy('id', 'DESC')->get();
		}elseif(!empty($request->from) ){
			$data = UserSubscription::where("start_date",">=",$request->from)->orderBy('id', 'DESC')->get();
		}else{
			$data = UserSubscription::orderBy('id', 'DESC')->get();
		}
		$users = User::where("role_id", 3)->where("deleted", 0)->orderBy('name', 'ASC')->get();
		$coupons = CouponCode::where("deleted", 0)->get();
		$subscriptions = Subscription::where("deleted", 0)->get();

		return view('admin.usersubscriptions.index', compact('data','users','coupons','subscriptions'));
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$users = User::where("role_id", 3)->where("status", 1)->where("deleted", 0)->get();
		$subscriptions = Subscription::where("status", 1)->where('deleted',0)->get();

		return view('admin.usersubscriptions.create', compact('users','subscriptions'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//echo '<pre />'; print_r($request->all()); die;
		$validator = Validator::make($request->all(), [
			'user_id' => 'required',
			'subscription_id' => 'required',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		}else { 
			//echo '<pre />'; print_r($request->all()); die;
			$subscriptionId = $request->get('subscription_id');
			$getSubscription = Subscription::where("id", $subscriptionId)->first();
			$month = !empty($getSubscription->month) ? $getSubscription->month : 0;
			$today = date('Y-m-d');
			$end_date = date('Y-m-d', strtotime('+'.$month.' months'));
			$userSubscription = new UserSubscription();
			$userSubscription->user_id = $request->get('user_id');
			$userSubscription->subscription_id = $request->get('subscription_id');
			$userSubscription->start_date = $today;
			$userSubscription->end_date = $end_date;
			$userSubscription->mode = 'Admin';
			$userSubscription->save();
			$userSubscriptionId = $userSubscription->id;

			\Session::flash('msg', 'User Subscription Added Successfully.');
			return back();
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\UserSubscription $usersubscriptions
	 * @return \Illuminate\Http\Response
	 */
	public function show(UserSubscription $usersubscriptions)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\UserSubscription $usersubscriptions
	 * @return \Illuminate\Http\Response
	 */
	public function edit(UserSubscription $usersubscriptions, $id)
	{
		$data = UserSubscription::findOrFail($id);
		$users = User::where("role_id", 3)->where("status", 1)->where("deleted", 0)->get();
		$subscriptions = Subscription::where("status", 1)->where('deleted',0)->get();

		return view('admin.usersubscriptions.edit',compact('data','users','subscriptions'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\UserSubscription $usersubscriptions
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, UserSubscription $usersubscriptions, $id)
	{
		$validator = Validator::make($request->all(), [
			'user_id' => 'required',
			'subscription_id' => 'required',
			'start_date' => 'required',
			'end_date' => 'required',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		} else {
			$userSubscription = UserSubscription::findOrFail($id);
			$userSubscription->user_id = $request->get('user_id');
			$userSubscription->subscription_id = $request->get('subscription_id');
			$userSubscription->start_date = date('Y-m-d',strtotime($request->get('start_date')));
			$userSubscription->end_date = date('Y-m-d',strtotime($request->get('end_date')));
			$userSubscription->save();
			$userSubscriptionId = $userSubscription->id;

			\Session::flash('msg', 'User Subscription Updated Successfully.');
			return redirect('/admin/usersubscriptions');
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\UserSubscription
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id)
	{
		$userSubscription = UserSubscription::findOrFail($id);
		$userSubscription->deleted=1;
		$userSubscription->update();

		return redirect('/admin/usersubscriptions');
	}

	public function updateStatus($id,$status)
	{
		$userSubscription = UserSubscription::findOrFail($id);
		$userSubscription->status=$status;
		$userSubscription->update();

		return redirect('/admin/usersubscriptions');
	}

}
