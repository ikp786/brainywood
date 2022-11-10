<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\LiveClass;
use App\LiveclassNotify;
use App\User;
use App\VideoTemp;


class LiveclassesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$user = Auth::user();
		//dd($user);
		$userId = $user->id;
		$role_id = $user->role_id;
		if($role_id==2){
			$data = LiveClass::where("added_by", $userId)->where("deleted", 0)->orderBy("id", "DESC")->get();
		}else{
			if(!empty($request->added_by) && !empty($request->from) && !empty($request->to) ){
				$data = LiveClass::where("added_by",$request->added_by)->where("class_time",">=",$request->from)->where("end_time","<=",$request->to.' 23:59:59')->where("deleted", 0)->orderBy("id", "DESC")->get();
			}elseif(!empty($request->added_by) && !empty($request->from) ){
				$data = LiveClass::where("added_by",$request->added_by)->where("class_time",">=",$request->from)->where("deleted", 0)->orderBy("id", "DESC")->get();
			}elseif(!empty($request->from) && !empty($request->to) ){
				$data = LiveClass::where("class_time",">=",$request->from)->where("end_time","<=",$request->to.' 23:59:59')->where("deleted", 0)->orderBy("id", "DESC")->get();
			}elseif(!empty($request->from) ){
				$data = LiveClass::where("class_time",">=",$request->from)->where("deleted", 0)->orderBy("id", "DESC")->get();
			}elseif(!empty($request->added_by) ){
				$data = LiveClass::where("added_by",$request->added_by)->where("deleted", 0)->orderBy("id", "DESC")->get();
			}else{
				$data = LiveClass::where('deleted',0)->orderBy("id", "DESC")->get();
			}
			$users = User::where("role_id", "!=", 3)->where("deleted", 0)->orderBy("name", "ASC")->get();
		}

		return view('admin.liveclasses.index', compact('role_id','data','users'));
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$user = Auth::user();
		$teachers = User::whereIn("role_id",array(1, 2))->where("status",1)->get();

		return view('admin.liveclasses.create', compact('user','teachers'));
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
			'added_by' => 'required',
			'title' => 'required',
			'subject' => 'required',
			'meeting_id' => 'required',
			'class_time' => 'required',
			'end_time' => 'required',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		}else { 
			//echo '<pre />'; print_r($request->all()); die;
			$file = $request->file('image');
			if($file){
				$destinationPath = public_path().'/upload/liveclasses/';
				$originalFile = $file->getClientOriginalName();
				$filename=strtotime(date('Y-m-d-H:isa')).$originalFile;
				$file->move($destinationPath, $filename);
			}
			
			$liveClass = new LiveClass();
			$liveClass->added_by = $request->get('added_by');
			$liveClass->title = $request->get('title');
			$liveClass->subject = $request->get('subject');
			$liveClass->image = $filename;
			$liveClass->meeting_id = $request->get('meeting_id');
			$liveClass->pass_code = $request->get('pass_code');
			$liveClass->class_time = date('Y-m-d H:i:s', strtotime($request->get('class_time')));
			$liveClass->end_time = date('Y-m-d H:i:s', strtotime($request->get('end_time')));
			$liveClass->isFree = $request->get('free');
			$liveClass->status = 1;
			$user = User::where("id", $request->get('added_by'))->first();
			if($user->role_id==1){
				$liveClass->master_class = 1;
			}
			$liveClass->save();
			$liveClassId = $liveClass->id;

			\Session::flash('msg', 'Live Class Added Successfully.');
			return back();
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\LiveClass $liveclasses
	 * @return \Illuminate\Http\Response
	 */
	public function show(LiveClass $liveclasses)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\LiveClass $liveclasses
	 * @return \Illuminate\Http\Response
	 */
	public function edit(LiveClass $liveclasses, $id)
	{
		$user = Auth::user();
		$liveClass = LiveClass::findOrFail($id);
		$teachers = User::whereIn("role_id",array(1, 2))->where("status",1)->get();

		return view('admin.liveclasses.edit',compact('user','liveClass','teachers'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\LiveClass $liveclasses
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, LiveClass $liveclasses, $id)
	{
		//print_r($request->all());die;
		$validator = Validator::make($request->all(), [
			'added_by' => 'required',
			'title' => 'required',
			'subject' => 'required',
			'meeting_id' => 'required',
			'class_time' => 'required',
			'end_time' => 'required',
			'video' => 'mimes:mp4',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		} else {
			$liveClass = LiveClass::findOrFail($id);

			$file = $request->file('image');
			$video = $request->file('video');
			
			if($file){
				$destinationPath = public_path().'/upload/liveclasses/';
				$originalFile = $file->getClientOriginalName();
				$filename=strtotime(date('Y-m-d-H:isa')).$originalFile;
				$file->move($destinationPath, $filename);
			}else{
				$filename=$liveClass->image;  
			}
			if($video){
				$destinationPathvideo = public_path().'/upload/liveclasses/';
				$originalFilevideo = $video->getClientOriginalName();
				//$filenamevideo = strtotime(date('Y-m-d-H:isa')).$originalFilevideo;
				$filenamevideo = time() . "_org.mp4";
				$video->move($destinationPathvideo, $filenamevideo);
			}else{
				$filenamevideo = $liveClass->video;  
			}

			if($video){
				if(!empty($liveClass->video) && file_exists( public_path().'/upload/liveclasses/'.$liveClass->video )) {
					unlink( public_path().'/upload/liveclasses/'.$liveClass->video );
				}
				if(!empty($liveClass->video_1) && file_exists( public_path().'/upload/liveclasses/'.$liveClass->video_1 ) && $liveClass->video_1!='NA') {
					unlink( public_path().'/upload/liveclasses/'.$liveClass->video_1 );
				}
				if(!empty($liveClass->video_2) && file_exists( public_path().'/upload/liveclasses/'.$liveClass->video_2 ) && $liveClass->video_2!='NA') {
					unlink( public_path().'/upload/liveclasses/'.$liveClass->video_2 );
				}
				if(!empty($liveClass->video_3) && file_exists( public_path().'/upload/liveclasses/'.$liveClass->video_3 ) && $liveClass->video_3!='NA') {
					unlink( public_path().'/upload/liveclasses/'.$liveClass->video_3 );
				}
				$deleteVideoTemp = VideoTemp::where('liveclassId',$id)->delete();
				$liveClass->video_1 = NULL;
				$liveClass->video_2 = NULL;
				$liveClass->video_3 = NULL;
				$liveClass->processtatus = 0;
				$liveClass->starttime = NULL;
				$liveClass->endtime = NULL;
			}
			$liveClass->added_by = $request->get('added_by');
			$liveClass->title = $request->get('title');
			$liveClass->subject = $request->get('subject');
			$liveClass->image = $filename;
			$liveClass->video = $filenamevideo;
			$liveClass->meeting_id = $request->get('meeting_id');
			$liveClass->pass_code = $request->get('pass_code');
			$liveClass->class_time = date('Y-m-d H:i:s', strtotime($request->get('class_time')));
			$liveClass->end_time = date('Y-m-d H:i:s', strtotime($request->get('end_time')));
			$liveClass->isFree = $request->get('free');
			//$liveClass->status = 1;
			$user = User::where("id", $request->get('added_by'))->first();
			if($user->role_id==1){
				$liveClass->master_class = 1;
			}
			$liveClass->save();
			$liveClassId = $liveClass->id;

			\Session::flash('msg', 'Live Class Updated Successfully.');
			return redirect('/admin/liveclasses');
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\LiveClass
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id)
	{
		$liveClass = LiveClass::findOrFail($id);
		$liveClass->deleted=1;
		$liveClass->update();

		return redirect('/admin/liveclasses');
	}

	public function updateStatus($id,$status)
	{
		$liveClass = LiveClass::findOrFail($id);
		$liveClass->status=$status;
		$liveClass->update();

		return redirect('/admin/liveclasses');
	}

	public function notify(Request $request)
	{
		if(!empty($request->live_class) && !empty($request->from) && !empty($request->to) ){
			$Classes = LiveClass::where("id",$request->live_class)->where("class_time",">=",$request->from)->where("end_time","<=",$request->to.' 23:59:59')->where("deleted", 0)->orderBy("id", "DESC")->get();
		}elseif(!empty($request->live_class) && !empty($request->from) ){
			$Classes = LiveClass::where("id",$request->live_class)->where("class_time",">=",$request->from)->where("deleted", 0)->orderBy("id", "DESC")->get();
		}elseif(!empty($request->from) && !empty($request->to) ){
			$Classes = LiveClass::where("class_time",">=",$request->from)->where("end_time","<=",$request->to.' 23:59:59')->where("deleted", 0)->orderBy("id", "DESC")->get();
		}elseif(!empty($request->from) ){
			$Classes = LiveClass::where("class_time",">=",$request->from)->where("deleted", 0)->orderBy("id", "DESC")->get();
		}elseif(!empty($request->live_class) ){
			$Classes = LiveClass::where("id",$request->live_class)->where("deleted", 0)->orderBy("id", "DESC")->get();
		}else{
			$Classes = array();
		}
		if (!empty($Classes)) {
			$liveClassId_arr = array();
			foreach($Classes as $livecls){
				$liveClassId = $livecls->id;
				array_push($liveClassId_arr, $liveClassId);
			}
			$liveClassIds = implode(', ', $liveClassId_arr);
			//print_r($liveClassId_arr); die;
			$data = LiveclassNotify::whereIn('id', array($liveClassIds))->where("status", 0)->get();
		} else {
			$data = LiveclassNotify::where("status", 0)->get();
		}
		$liveClasses = LiveClass::where("deleted", 0)->orderBy("id", "DESC")->get();

		return view('admin.liveclasses.notify', compact('data','liveClasses'));
	}

	public function sendLiveclass($id)
	{
		$liveClass = LiveclassNotify::findOrFail($id);
		
		$userId = $liveClass->user_id;
		$user = User::where("id", $userId)->first();
		$token = isset($user->deviceToken) ? $user->deviceToken : '';
		if ($token!='') {
			$title = 'BrainyWood';
			$message = 'Please check your Live class.';
			$this->notificationsend($token, $title, $message);
		}

		$liveClass->status=1;
		$liveClass->update();

		\Session::flash('msg', 'Live Class Notification Sent Successfully.');
		return redirect('/admin/liveclasses/notify');
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

	public function convertVideo()
	{
		$data = VideoTemp::where('liveclassId','!=',0)->orderBy('id', 'ASC')->get();
		
		return view('admin.liveclasses.convertVideo', compact('data'));
	}

	public function approveVideo($id)
	{
		$videoTemp = VideoTemp::where('id',$id)->first();
		$liveclassId = $videoTemp->liveclassId;
		$low_status = $videoTemp->low_status;
		$med_status = $videoTemp->med_status;
		$high_status = $videoTemp->high_status;
		$liveClass = LiveClass::findOrFail($liveclassId);
		if ($low_status == 1) {
			$liveClass->video_1 = $videoTemp->low_video;
		}
		if ($med_status == 1) {
			$liveClass->video_2 = $videoTemp->med_video;
		}
		if ($high_status == 1) {
			$liveClass->video_3 = $videoTemp->high_video;
		}
		$liveClass->update();
		
		$delete = VideoTemp::where('id',$id)->delete();

		\Session::flash('msg', 'Converted Video Approved Successfully.');
	    return redirect('/admin/liveclasses/convertVideo');
	}

	public function imgremove($id)
	{
		$liveClass = LiveClass::findOrFail($id);
		if(file_exists( public_path().'/upload/liveclasses/'.$liveClass->image )) {
			unlink( public_path().'/upload/liveclasses/'.$liveClass->image );
		}
		$liveClass->image = NULL;
		$liveClass->update();

		\Session::flash('msg', 'LiveClass Image Removed Successfully.');
	    return redirect()->back();
	}

	public function vidremove($id)
	{
		$liveClass = LiveClass::findOrFail($id);
		if(!empty($liveClass->video) && file_exists( public_path().'/upload/liveclasses/'.$liveClass->video )) {
			unlink( public_path().'/upload/liveclasses/'.$liveClass->video );
		}
		if(!empty($liveClass->video_1) && file_exists( public_path().'/upload/liveclasses/'.$liveClass->video_1 ) && $liveClass->video_1!='NA') {
			unlink( public_path().'/upload/liveclasses/'.$liveClass->video_1 );
		}
		if(!empty($liveClass->video_2) && file_exists( public_path().'/upload/liveclasses/'.$liveClass->video_2 ) && $liveClass->video_2!='NA') {
			unlink( public_path().'/upload/liveclasses/'.$liveClass->video_2 );
		}
		if(!empty($liveClass->video_3) && file_exists( public_path().'/upload/liveclasses/'.$liveClass->video_3 ) && $liveClass->video_3!='NA') {
			unlink( public_path().'/upload/liveclasses/'.$liveClass->video_3 );
		}
		$deleteVideoTemp = VideoTemp::where('liveclassId',$id)->delete();
		$liveClass->video = NULL;
		$liveClass->video_1 = NULL;
		$liveClass->video_2 = NULL;
		$liveClass->video_3 = NULL;
		$liveClass->processtatus = 0;
		$liveClass->starttime = NULL;
		$liveClass->endtime = NULL;
		$liveClass->update();

		\Session::flash('msg', 'LiveClass Video Removed Successfully.');
	    return redirect()->back();
	}

}
