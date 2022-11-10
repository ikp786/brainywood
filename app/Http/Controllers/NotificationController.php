<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Notification;
use App\User;


class NotificationController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$data = Notification::orderBy("id", "DESC")->limit(200)->get();

		return view('admin.notifications.index', compact('data'));
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//$users = User::whereIn("role_id",array(2, 3))->where("status", 1)->get();
		$users = User::whereIn("role_id",array(3))->where("status", 1)->get();
		//$users = User::where("status", 1)->get()->pluck('id', 'name');

		return view('admin.notifications.create', compact('users'));
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
			$user_id = ($request->get('user_id')) ? $request->get('user_id') : [];
			for ($i=0; $i<count($user_id); $i++){
				$notification = new Notification();
				$notification->user_id = $request->get('user_id')[$i];
				$notification->message = $request->get('message');
				$notification->save();
				$notificationId = $notification->id;

				$user = User::where("id", $notification->user_id)->first();
				$token = isset($user->deviceToken) ? $user->deviceToken : '';
				if ($token!='') {
					$title = 'BrainyWood';
					$this->notificationsend($token, $title, $notification->message);
				}
			}

			\Session::flash('msg', 'Notification Added Successfully.');
			return back();
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Notification $notifications
	 * @return \Illuminate\Http\Response
	 */
	public function show(Notification $notifications)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Notification $notifications
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Notification $notifications, $id)
	{
		$data = Notification::findOrFail($id);
		$users = User::where("status", 1)->get();

		return view('admin.notifications.edit',compact('data','users'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Notification $notifications
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Notification $notifications, $id)
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
			$notification = Notification::findOrFail($id);
			$notification->user_id = $request->get('user_id');
			$notification->message = $request->get('message');
			$notification->save();
			$notificationId = $notification->id;
			
			$user = User::where("id", $notification->user_id)->first();
			$token = isset($user->deviceToken) ? $user->deviceToken : '';
			if ($token!='') {
				$title = 'BrainyWood';
				$this->notificationsend($token, $title, $notification->message);
			}

			\Session::flash('msg', 'Notification Updated Successfully.');
			return redirect('/admin/notifications');
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Notification
	 * @return \Illuminate\Http\Response
	 */
	 public function delete($id)
	{
		$notification = Notification::findOrFail($id);
		$notification->deleted=1;
		$notification->update();

		return redirect('/admin/notifications');
	}

	public function updateStatus($id,$status)
	{
		$notification = Notification::findOrFail($id);
		$notification->status=$status;
		$notification->update();

		return redirect('/admin/notifications');
	}
	
	public function notificationsend($token, $title, $body)
	{
		$url = "https://fcm.googleapis.com/fcm/send";
		$token = $token;
		$serverKey = 'AAAAqt_CbVU:APA91bH1KAkCHGHbgQEtQYxUldBupx4_7y42dNa1hOPGz8IFePdzSXWu4uC1CudCTuowek2O01KScKbHgoROAscE8mCiy-53rcxcQOABsLvrp1JB14kbGNVT7sGqT53Qh1sjeAflTqC2';
		$title = $title;
		$body = $body;
		$notification = array('title' => $title, 'body' => $body, 'sound' => 'default', 'badge' => '1');
		$arrayToSend = array('to' => $token, 'notification' => $notification, 'priority' => 'high');
		$json = json_encode($arrayToSend);
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Authorization: key=' . $serverKey;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		//Send the request
		curl_exec($ch);
		curl_close($ch);
	}

}
