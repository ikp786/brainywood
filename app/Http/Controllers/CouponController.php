<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\CouponCode;
use App\Subscription;
use App\User;


class CouponController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$today = date('Y-m-d');
		$old_data = CouponCode::where("end_date", "<", $today)->where("status", 1)->where("deleted", 0)->orderBy("id", "DESC")->get();
		foreach ($old_data as $old) {
			$id = $old->id;
			$couponcode = CouponCode::findOrFail($id);
			$couponcode->status=0;
			$couponcode->update();
		}

		if(!empty($request->user) && !empty($request->subscription) && !empty($request->coupon) && !empty($request->from) && !empty($request->to) ){
			$data = CouponCode::where("user_id",$request->user)->where("subscription_id",$request->subscription)->where("coupon",$request->coupon)->where("end_date",">=",$request->from)->where("end_date","<=",$request->to)->where("deleted", 0)->orderBy("id", "DESC")->get();
		}elseif(!empty($request->user) && !empty($request->subscription) && !empty($request->coupon) && !empty($request->from) ){
			$data = CouponCode::where("user_id",$request->user)->where("subscription_id",$request->subscription)->where("coupon",$request->coupon)->where("end_date",">=",$request->from)->where("deleted", 0)->orderBy("id", "DESC")->get();
		}elseif(!empty($request->user) && !empty($request->subscription) && !empty($request->coupon) ){
			$data = CouponCode::where("user_id",$request->user)->where("subscription_id",$request->subscription)->where("coupon",$request->coupon)->where("deleted", 0)->orderBy("id", "DESC")->get();
		}elseif(!empty($request->user) && !empty($request->subscription) ){
			$data = CouponCode::where("user_id",$request->user)->where("subscription_id",$request->subscription)->where("deleted", 0)->orderBy("id", "DESC")->get();
		}elseif(!empty($request->user) ){
			$data = CouponCode::where("user_id",$request->user)->where("deleted", 0)->orderBy("id", "DESC")->get();
		}elseif(!empty($request->subscription) ){
			$data = CouponCode::where("subscription_id",$request->subscription)->where("deleted", 0)->orderBy("id", "DESC")->get();
		}elseif(!empty($request->coupon) ){
			$data = CouponCode::where("coupon",$request->coupon)->where("deleted", 0)->orderBy("id", "DESC")->get();
		}elseif(!empty($request->from) && !empty($request->to) ){
			$data = CouponCode::where("end_date",">=",$request->from)->where("end_date","<=",$request->to)->where("deleted", 0)->orderBy("id", "DESC")->get();
		} else {
			$data = CouponCode::where("deleted", 0)->orderBy("id", "DESC")->get();
		}
		$users = User::where("role_id", 3)->where("status", 1)->where("deleted", 0)->orderBy("name", "ASC")->get();
		$subscriptions = Subscription::where("status", 1)->where("deleted", 0)->get();
		$coupons = CouponCode::where("status", 1)->where("deleted", 0)->orderBy("id", "DESC")->get();

		return view('admin.couponcode.index', compact('data','users','subscriptions','coupons'));
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$users = User::where("role_id", 3)->where("status", 1)->where("deleted", 0)->orderBy("name", "ASC")->get();
		$subscriptions = Subscription::where("status", 1)->where('deleted',0)->get();

		return view('admin.couponcode.create', compact('users','subscriptions'));
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
			//'user_id' => 'required',
			//'coupon' => 'required|unique:coupon_codes',
			'discount' => 'required|integer|min:1|max:100',
			//'validity' => 'required|numeric',
			'end_date' => 'required|after:yesterday',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		}else { 
			//echo '<pre />'; print_r($request->all()); die;
			$no_of_users = 0;
			if($request->get('condition_3')==0){
				$checkCoupon = CouponCode::where('coupon', $request->get('coupon'))->first();
				if (empty($checkCoupon)) {
					$couponcode = new CouponCode();
					$couponcode->coupon = $request->get('coupon');
					$couponcode->discount = $request->get('discount');
					//$couponcode->validity = $request->get('validity');
					$couponcode->end_date = date('Y-m-d H:i:s', strtotime($request->get('end_date')));
					$couponcode->description = $request->get('description');
					$couponcode->condition_1 = $request->get('condition_1');
					if($request->get('condition_1')==0){
						$user_id = 0;
						//$subscription_id = 0;
						if($request->get('condition_2')==1){
							$no_of_users = ($request->get('no_of_users')) ? $request->get('no_of_users') : 0;
						}
					}elseif($request->get('condition_1')==1){
						$user_id = $request->get('user_id');
						//$subscription_id = 0;
						$no_of_users = 0;
					}else{
						$user_id = 0;
						//$subscription_id = $request->get('subscription_id');
						if($request->get('condition_2')==1){
							$no_of_users = ($request->get('no_of_users')) ? $request->get('no_of_users') : 0;
						}
					}
					$couponcode->user_id = $user_id;
					$couponcode->subscription_id = ($request->get('subscription_id')) ? $request->get('subscription_id') : 0;
					$couponcode->no_of_users = $no_of_users;
					$couponcode->save();
					$couponcodeId = $couponcode->id;
				}else{
					\Session::flash('msg', 'Coupon Code Already Exists.');
					return back();
				}
			}else{
				$no_of_codes = ($request->get('no_of_codes')) ? $request->get('no_of_codes') : 0;
				//echo "Multiple".$no_of_codes; die;
				for($a=1; $a<=$no_of_codes; $a++){
					//echo "Multiple".$a;

					$length = 10;
					$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
					$charactersLength = strlen($characters);
					$randomString = '';
					for ($i = 0; $i < $length; $i++) {
						$randomString .= $characters[rand(0, $charactersLength - 1)];
					}
					$checkCoupon = CouponCode::where('coupon', $randomString)->first();
					if (empty($checkCoupon)) {
						$coupon = $randomString;
					} else {
						for ($i = 0; $i < $length; $i++) {
							$randomString .= $characters[rand(0, $charactersLength - 1)];
						}
						$coupon = $randomString;
					}

					$cpnCode = new CouponCode();
					$cpnCode->coupon = $coupon;
					$cpnCode->discount = $request->get('discount');
					//$cpnCode->validity = $request->get('validity');
					$cpnCode->end_date = date('Y-m-d H:i:s', strtotime($request->get('end_date')));
					$cpnCode->description = $request->get('description');
					$cpnCode->condition_1 = $request->get('condition_1');
					$cpnCode->user_id = 0; //($request->get('user_id')) ? $request->get('user_id') : 0;
					$cpnCode->subscription_id = ($request->get('subscription_id')) ? $request->get('subscription_id') : 0;
					$cpnCode->no_of_users = 1;
					$cpnCode->save();
					$cpnCodeId = $cpnCode->id;
				}
			}

			\Session::flash('msg', 'Coupon Code Added Successfully.');
			return back();
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\CouponCode $couponcode
	 * @return \Illuminate\Http\Response
	 */
	public function show(CouponCode $couponcode)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\CouponCode $couponcode
	 * @return \Illuminate\Http\Response
	 */
	public function edit(CouponCode $couponcode, $id)
	{
		$data = CouponCode::findOrFail($id);
		$users = User::where("role_id", 3)->where("status", 1)->where("deleted", 0)->orderBy("name", "ASC")->get();
		$subscriptions = Subscription::where("status", 1)->where('deleted',0)->get();

		return view('admin.couponcode.edit',compact('data','users','subscriptions'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\CouponCode $couponcode
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, CouponCode $couponcode, $id)
	{
		$validator = Validator::make($request->all(), [
			//'user_id' => 'required',
			'coupon' => 'required',
			'discount' => 'required|integer|min:1|max:100',
			//'validity' => 'required|numeric',
			'end_date' => 'required|after:yesterday',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		} else {
			$checkCoupon = CouponCode::where('id', '!=', $id)->where('coupon', $request->get('coupon'))->first();
			if (empty($checkCoupon)) {
				$couponcode = CouponCode::findOrFail($id);
				$couponcode->coupon = $request->get('coupon');
				$couponcode->discount = $request->get('discount');
				//$couponcode->validity = $request->get('validity');
				$couponcode->end_date = date('Y-m-d H:i:s', strtotime($request->get('end_date')));
				$couponcode->description = $request->get('description');
				$couponcode->condition_1 = $request->get('condition_1');
				$no_of_users = 0;
				if($request->get('condition_1')==0){
					$user_id = 0;
					//$subscription_id = 0;
					if($request->get('condition_2')==1){
						$no_of_users = ($request->get('no_of_users')) ? $request->get('no_of_users') : 0;
					}
				}elseif($request->get('condition_1')==1){
					$user_id = $request->get('user_id');
					//$subscription_id = 0;
					$no_of_users = 0;
				}else{
					$user_id = 0;
					//$subscription_id = $request->get('subscription_id');
					if($request->get('condition_2')==1){
						$no_of_users = ($request->get('no_of_users')) ? $request->get('no_of_users') : 0;
					}
				}
				$couponcode->user_id = $user_id;
				$couponcode->subscription_id = ($request->get('subscription_id')) ? $request->get('subscription_id') : 0;
				$couponcode->no_of_users = $no_of_users;
				$couponcode->save();
				$couponcodeId = $couponcode->id;

				\Session::flash('msg', 'Coupon Code Updated Successfully.');
				return redirect('/admin/couponcodes');
			} else {
				\Session::flash('msg', 'Coupon Code Already Exists.');
				return redirect()->back();
			}
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\CouponCode
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id)
	{
		$couponcode = CouponCode::findOrFail($id);
		$couponcode->deleted=1;
		$couponcode->update();

		return redirect('/admin/couponcodes');
	}

	public function updateStatus($id,$status)
	{
		$couponcode = CouponCode::findOrFail($id);
		$couponcode->status=$status;
		$couponcode->update();

		return redirect('/admin/couponcodes');
	}

	public function getcouponcode(Request $request)
	{
		$length = 10;
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		$checkCoupon = CouponCode::where('coupon', $randomString)->first();
		if (empty($checkCoupon)) {
			echo $randomString;
		} else {
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			echo $randomString;
		}
	}

}
