<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Contactus;


class ContactusController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		/*$from = '2021-01-01 00:00:00';
		$to = date('Y-m-d').' 23:59:59';
		$data = array();
		if(!empty($request->created)){
			if($request->created=='today'){
				$from = date('Y-m-d').' 00:00:00';
				$to = date('Y-m-d').' 23:59:59';
			}elseif($request->created=='week'){
				$from = date('Y-m-d', strtotime("this week")).' 00:00:00';
				$to = date('Y-m-d').' 23:59:59';
			}elseif($request->created=='month'){
				$from = date('Y-m-01').' 00:00:00';
				$to = date('Y-m-d').' 23:59:59';
			}elseif($request->created=='year'){
				$from = date('Y-m-d', strtotime("first day of january this year")).' 00:00:00';
				$to = date('Y-m-d').' 23:59:59';
			}elseif($request->created=='before'){
				$from = '2021-01-01 00:00:00';
				$date = strtotime(date('Y').'-12-31 -1 year');
				$to = date('Y-m-d', $date).' 23:59:59';
			}else{
				$data = Contactus::orderBy('id', 'DESC')->get();
			}
			if(!empty($request->created)){
				$data = Contactus::whereBetween('created_at',[$from, $to])->orderBy('id', 'DESC')->get();
			}*/
		if(!empty($request->from) && !empty($request->to) ){
			$data = Contactus::where("created_at",">=",$request->from)->where("created_at","<=",$request->to.' 23:59:59')->orderBy("id", "DESC")->get();
		}elseif(!empty($request->from) ){
			$data = Contactus::where("created_at",">=",$request->from)->orderBy("id", "DESC")->get();
		} else {
			$data = Contactus::orderBy("id", "DESC")->get();
		}

		return view('admin.contactus.index', compact('data'));
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$users = User::where("status", 1)->get();

		return view('admin.contactus.create', compact('users'));
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
			'message' => 'required',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		}else { 
			//echo '<pre />'; print_r($request->all()); die;
			$notification = new Contactus();
			$notification->user_id = $request->get('user_id');
			$notification->message = $request->get('message');
			$notification->save();
			$notificationId = $notification->id;

			\Session::flash('msg', 'Contact us Added Successfully.');
			return back();
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Contactus $contactus
	 * @return \Illuminate\Http\Response
	 */
	public function show(Contactus $contactus)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Contactus $contactus
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Contactus $contactus, $id)
	{
		$data = Contactus::findOrFail($id);
		$users = User::where("status", 1)->get();

		return view('admin.contactus.edit',compact('data','users'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Contactus $contactus
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Contactus $contactus, $id)
	{
		$validator = Validator::make($request->all(), [
			'user_id' => 'required',
			'message' => 'required',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		} else {
			$notification = Contactus::findOrFail($id);
			$notification->user_id = $request->get('user_id');
			$notification->message = $request->get('message');
			$notification->save();
			$notificationId = $notification->id;

			\Session::flash('msg', 'Contact us Updated Successfully.');
			return redirect('/admin/contactus');
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Contactus
	 * @return \Illuminate\Http\Response
	 */
	 public function delete($id)
	{
		$notification = Contactus::findOrFail($id);
		$notification->deleted=1;
		$notification->update();

		return redirect('/admin/contactus');
	}

	public function updateStatus($id,$status)
	{
		$notification = Contactus::findOrFail($id);
		$notification->status=$status;
		$notification->update();

		return redirect('/admin/contactus');
	}

}
