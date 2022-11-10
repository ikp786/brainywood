<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Chapter;
use App\Courses;
use App\Lession;
use App\Notification;
use App\QuestionAsk;
use App\QuestionAnswer;
use App\User;


class QuestionAnswerController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		if(!empty($request->course) && !empty($request->lession) && !empty($request->topic) && !empty($request->from) && !empty($request->to) ){
			$data = QuestionAsk::where("course_id",$request->course)->where("lession_id",$request->lession)->where("topic_id",$request->topic)->whereBetween("created_at",[$request->from, $request->to.' 23:59:59'])->where("deleted",0)->orderBy("id", "DESC")->get();
		}elseif(!empty($request->course) && !empty($request->lession) && !empty($request->topic) && !empty($request->from) ){
			$to = date('Y-m-d H:i:s');
			$data = QuestionAsk::where("course_id",$request->course)->where("lession_id",$request->lession)->where("topic_id",$request->topic)->whereBetween("created_at",[$request->from, $to])->where("deleted",0)->orderBy("id", "DESC")->get();
		}elseif(!empty($request->course) && !empty($request->lession) && !empty($request->topic) ){
			$data = QuestionAsk::where("course_id",$request->course)->where("lession_id",$request->lession)->where("topic_id",$request->topic)->where("deleted",0)->orderBy("id", "DESC")->get();
		}elseif(!empty($request->course) && !empty($request->lession) ){
			$data = QuestionAsk::where("course_id",$request->course)->where("lession_id",$request->lession)->where("deleted",0)->orderBy("id", "DESC")->get();
		}elseif(!empty($request->course) && !empty($request->from) && !empty($request->to) ){
			$data = QuestionAsk::where("course_id",$request->course)->whereBetween("created_at",[$request->from, $request->to.' 23:59:59'])->where("deleted",0)->orderBy("id", "DESC")->get();
		}elseif(!empty($request->course) && !empty($request->topic) ){
			$data = QuestionAsk::where("course_id",$request->course)->where("topic_id",$request->topic)->where("deleted",0)->orderBy("id", "DESC")->get();
		}elseif(!empty($request->course) ){
			$data = QuestionAsk::where("course_id",$request->course)->where("deleted",0)->orderBy("id", "DESC")->get();
		}elseif(!empty($request->lession) ){
			$data = QuestionAsk::where("lession_id",$request->lession)->where("deleted",0)->orderBy("id", "DESC")->get();
		}elseif(!empty($request->topic) ){
			$data = QuestionAsk::where("topic_id",$request->topic)->where("deleted",0)->orderBy("id", "DESC")->get();
		}elseif(!empty($request->from) && !empty($request->to) ){
			$data = QuestionAsk::where("deleted",0)->whereBetween("created_at",[$request->from, $request->to.' 23:59:59'])->orderBy("id", "DESC")->get();
		}else{
			$data = QuestionAsk::where("deleted",0)->orderBy("id", "DESC")->get();
		}
		$totalQuestions = count($data);
		$totalAnswers = QuestionAnswer::where("status",1)->count();
		$courses = Courses::where("status",1)->where("deleted",0)->orderBy("sort_id", "ASC")->get();
		$lessions = Lession::where("status",1)->where("deleted",0)->orderBy("sort_id", "ASC")->get();
		$topics = Chapter::where("status",1)->where("deleted",0)->orderBy("sort_id", "ASC")->get();

		return view('admin.questionanswers.index', compact('data','totalQuestions','totalAnswers','courses','lessions','topics'));
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('admin.questionanswers.create');
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
			'name' => 'required',
			'video' => 'required',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		}else { 
			$file = $request->file('video');
			if($file){
				$destinationPath = public_path().'/upload/questionask/';
				$originalFile = $file->getClientOriginalName();
				$filename=strtotime(date('Y-m-d H:isa')).$originalFile;
				$file->move($destinationPath, $filename);
			}
			
			$queAsk = new QuestionAsk();
			$queAsk->name = $request->get('name');
			$queAsk->video = $filename;
			$queAsk->status = 1;
			$queAsk->save();
			$queAskId = $queAsk->id;

			\Session::flash('msg', 'Question Answer Added Successfully.');
			return back();
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\QuestionAsk $questionanswers
	 * @return \Illuminate\Http\Response
	 */
	public function show(QuestionAsk $questionanswers, $id)
	{
		$data = QuestionAsk::findOrFail($id);
		$answers = QuestionAnswer::where("ques_id", $id)->get();

		return view('admin.questionanswers.view',compact('data','answers'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\QuestionAsk $questionanswers
	 * @return \Illuminate\Http\Response
	 */
	public function edit(QuestionAsk $questionanswers, $id)
	{
		$data = QuestionAsk::findOrFail($id);
		$answers = QuestionAnswer::where("ques_id", $id)->get();

		return view('admin.questionanswers.edit',compact('data','answers'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\QuestionAsk $questionanswers
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, QuestionAsk $questionanswers, $id)
	{
		//echo '<pre />'; print_r($request->all()); die;
		$answers = $request->ans_id;
		if(isset($answers)){
			foreach($answers as $key => $answer){
				$queAns = QuestionAnswer::findOrFail($answer);

				$file = isset($request->file('image')[$key]) ? $request->file('image')[$key] : '';
				if($file){
					$destinationPath = public_path().'/upload/questionask/';
					$originalFile = $file->getClientOriginalName();
					$filename = rand(111,999).strtotime(date('Y-m-d-H:isa')).$originalFile;
					$file->move($destinationPath, $filename);
				}else{
					$filename = $queAns->image;
				}

				$queAns->answer = $request->get('answer')[$key];
				$queAns->image = $filename;
				$queAns->status = 1;
				$queAns->save();
			}
		}

		$queAsk = QuestionAsk::findOrFail($id);

		$file = $request->file('image');
		if($file){
			$destinationPath = public_path().'/upload/questionask/';
			$originalFile = $file->getClientOriginalName();
			$filename = rand(111,999).strtotime(date('Y-m-d-H:isa')).$originalFile;
			$file->move($destinationPath, $filename);
		}else{
			$filename=$queAsk->image;
		}

		$queAsk->question = $request->get('question');
		$queAsk->image = $filename;
		//$queAsk->status = 1;
		$queAsk->save();
		$queAskId = $queAsk->id;

		if(!empty($request->adm_answer) || !empty($request->file('adm_image'))){
			if (auth()->user()->role_id==1) {
				$expert = 1;
			} elseif (auth()->user()->role_id==2) {
				$expert = 2;
			} else {
				$expert = 0;
			}
			
			$queAnswer = new QuestionAnswer();

			$file = $request->file('adm_image');
			if($file){
				$destinationPath = public_path().'/upload/questionask/';
				$originalFile = $file->getClientOriginalName();
				$filename = rand(111,999).strtotime(date('Y-m-d-H:isa')).$originalFile;
				$file->move($destinationPath, $filename);
			}else{
				$filename=$queAnswer->image;
			}

			$queAnswer->user_id = auth()->user()->id;
			$queAnswer->ques_id = $id;
			$queAnswer->answer = $request->get('adm_answer');
			$queAnswer->image = $filename;
			$queAnswer->expert = $expert;
			$queAnswer->status = 1;
			$queAnswer->save();
			$queAnswerId = $queAnswer->id;

			$userId = auth()->user()->id;
			$ques = QuestionAsk::where("id", $id)->first();
			$msg = auth()->user()->name.', Answered a question '.$ques->question.' in Q&A, check it now.';
			$users = User::where("id", "!=", $userId)->where("role_id", "!=", 1)->get();
			foreach ($users as $userval) {
				//$this->addNotification($userval->id,$msg);
				$notify = new Notification();
				$notify->user_id = $userval->id;
				$notify->message = $msg;
				$notify->save();
			
				$token = isset($userval->deviceToken) ? $userval->deviceToken : '';
				if ($token!='') {
					$title = 'BrainyWood';
					$this->notificationsend($token, $title, $msg);
				}
			}
		}

		\Session::flash('msg', 'Question Answer Updated Successfully.');
		return redirect('/admin/questionanswers');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\QuestionAsk
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id)
	{
		$queAsk = QuestionAsk::findOrFail($id);
		$queAsk->deleted=1;
		$queAsk->update();

		return redirect('/admin/questionanswers');
	}

	public function updateStatus($id,$status)
	{
		$queAsk = QuestionAsk::findOrFail($id);
		$queAsk->status=$status;
		$queAsk->update();

		/*if ($status==1) {
			$queAsked = QuestionAsk::where("id", $id)->first();
			$userId = $queAsked->user_id;
			$user = User::where("id", $userId)->first();
			$msg = $user->name.' Asked a question '.$queAsked->question.' in Q&A, check it now.';
			$users = User::where("id", "!=", $userId)->where("role_id", "!=", 1)->get();
			foreach ($users as $userval) {
				$this->addNotification($userval->id,$msg);
			}
		}*/

		return redirect('/admin/questionanswers');
	}

	public function deleteAnswer($id)
	{
		$delete = QuestionAnswer::where("id",$id)->delete();

		\Session::flash('msg', 'Answer Deleted Successfully.');
		return back();
	}

	public function getLessionsBycourse(Request $request)
	{
		$courseId = $request->courseId;
		$lessions = Lession::where("courseId", $courseId)->where("status", 1)->where('deleted', 0)->orderBy('sort_id', 'ASC')->get();
		$output = '<option>Select Lession</option>';
		foreach ($lessions as $key => $value) {
			$output .= '<option value="'.$value->id.'">'.$value->name.'</option>';
		}
		echo $output;
	}

	public function getTopicsByLession(Request $request)
	{
		$courseId = $request->courseId;
		$lessionId = $request->lessionId;
		$chapters = Chapter::where("courseId", $courseId)->where("lessionId", $lessionId)->where("status", 1)->where('deleted', 0)->orderBy('sort_id', 'ASC')->get();
		$output = '<option>Select Topic</option>';
		foreach ($chapters as $key => $value) {
			$output .= '<option value="'.$value->id.'">'.$value->name.'</option>';
		}
		echo $output;
	}

	public function addNotification($userId,$message)
	{
		$data = array(
			'user_id'		=> $userId,
			'message'		=> $message,
			'created_at'	=> date('Y-m-d H:i:s'),
		);
		$inserId = Notification::insertGetId($data);
		$user = User::where("id", $userId)->first();
		$token = isset($user->deviceToken) ? $user->deviceToken : '';
		if ($token!='') {
			$title = 'BrainyWood';
			$this->notificationsend($token, $title, $message);
		}
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
