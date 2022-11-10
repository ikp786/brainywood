<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Chapter;
use App\Courses;
use App\Lession;
use App\RatingUser;
use App\User;


class UserRatingController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		if(!empty($request->user) && !empty($request->course) && !empty($request->lession) && ($request->lession!='--Select--') && !empty($request->topic) && ($request->topic!='--Select--') && !empty($request->type) && !empty($request->from) && !empty($request->to) ){
			$data = RatingUser::where('userId',$request->user)->where('courseId',$request->course)->where('lessionId',$request->lession)->where('topicId',$request->topic)->where('ratingType',$request->type)->whereBetween("created_at",[$request->from, $request->to.' 23:59:59'])->orderBy('id', 'DESC')->get();
		}elseif(!empty($request->user) && !empty($request->course) && !empty($request->lession) && ($request->lession!='--Select--') && !empty($request->topic) && ($request->topic!='--Select--') && !empty($request->type) && !empty($request->from) ){
			$to = date('Y-m-d H:i:s');
			$data = RatingUser::where('userId',$request->user)->where('courseId',$request->course)->where('lessionId',$request->lession)->where('topicId',$request->topic)->where('ratingType',$request->type)->whereBetween("created_at",[$request->from, $to])->orderBy('id', 'DESC')->get();
		}elseif(!empty($request->user) && !empty($request->course) && !empty($request->lession) && ($request->lession!='--Select--') && !empty($request->topic) && ($request->topic!='--Select--') ){
			$data = RatingUser::where('userId',$request->user)->where('courseId',$request->course)->where('lessionId',$request->lession)->where('topicId',$request->topic)->orderBy('id', 'DESC')->get();
		}elseif(!empty($request->user) && !empty($request->course) && !empty($request->lession) && ($request->lession!='--Select--') ){
			$data = RatingUser::where('userId',$request->user)->where('courseId',$request->course)->where('lessionId',$request->lession)->orderBy('id', 'DESC')->get();
		}elseif(!empty($request->user) && !empty($request->course) || ($request->lession=='--Select--') || ($request->topic=='--Select--') ){
			$data = RatingUser::where('userId',$request->user)->where('courseId',$request->course)->orderBy('id', 'DESC')->get();
		}elseif(!empty($request->user) || ($request->lession=='--Select--') || ($request->topic=='--Select--') ){
			$data = RatingUser::where('userId',$request->user)->orderBy('id', 'DESC')->get();
		}elseif(!empty($request->course) || ($request->lession=='--Select--') ){
			$data = RatingUser::where('courseId',$request->course)->orderBy('id', 'DESC')->get();
		}elseif(!empty($request->lession) && ($request->lession!='--Select--') || ($request->topic=='--Select--') ){
			$data = RatingUser::where('lessionId',$request->lession)->orderBy('id', 'DESC')->get();
		}elseif(!empty($request->topic) && ($request->topic!='--Select--') || ($request->lession=='--Select--') ){
			$data = RatingUser::where('topicId',$request->topic)->orderBy('id', 'DESC')->get();
		}elseif(!empty($request->type) || ($request->lession=='--Select--') || ($request->topic=='--Select--') ){
			$data = RatingUser::where('ratingType',$request->type)->orderBy('id', 'DESC')->get();
		}elseif(!empty($request->from) ){
			$to = date('Y-m-d H:i:s');
			$data = RatingUser::whereBetween("created_at",[$request->from, $to])->orderBy('id', 'DESC')->get();
		}elseif(!empty($request->from) && !empty($request->to) ){
			$data = RatingUser::whereBetween("created_at",[$request->from, $request->to.' 23:59:59'])->orderBy('id', 'DESC')->get();
		}else{
			$data = RatingUser::orderBy('id', 'DESC')->get();
		}
		$users = User::where("role_id", 3)->where("status", 1)->where("deleted", 0)->orderBy('name', 'ASC')->get();
		$courses = Courses::where('deleted',0)->orderBy('sort_id', 'ASC')->get();
		$lessions = Lession::where('deleted', 0)->orderBy('sort_id', 'ASC')->get();
		$topics = Chapter::where('deleted',0)->orderBy('sort_id', 'ASC')->get();

		return view('admin.usersrating.index', compact('data','users','courses','lessions','topics'));
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$users = User::where("status", 1)->get();

		return view('admin.usersrating.create', compact('users'));
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
			'userId' => 'required|numeric',
			'courseId' => 'required|numeric',
			'lessionId' => 'required|numeric',
			'topicId' => 'required|numeric',
			'ratingType' => 'required',
			'ratingMessage' => 'required',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		}else { 
			//echo '<pre />'; print_r($request->all()); die;
			$ratinguser = new RatingUser();
			$ratinguser->userId = $request->get('userId');
			$ratinguser->courseId = $request->get('courseId');
			$ratinguser->lessionId = $request->get('lessionId');
			$ratinguser->topicId = $request->get('topicId');
			$ratinguser->ratingType = $request->get('ratingType');
			$ratinguser->ratingMessage = $request->get('ratingMessage');
			$ratinguser->message = $request->get('message');
			$ratinguser->save();
			$ratinguserId = $ratinguser->id;

			\Session::flash('msg', 'Rating Added Successfully.');
			return back();
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\RatingUser $ratinguser
	 * @return \Illuminate\Http\Response
	 */
	public function show(RatingUser $ratinguser, $id)
	{
		$data = RatingUser::findOrFail($id);
		if ($data->status==0) {
			$data->status=1;
			$data->update();
		}

		return view('admin.usersrating.view',compact('data'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\RatingUser $ratinguser
	 * @return \Illuminate\Http\Response
	 */
	public function edit(RatingUser $ratinguser, $id)
	{
		$data = RatingUser::findOrFail($id);
		$users = User::where("status", 1)->get();

		return view('admin.usersrating.edit',compact('data','users'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\RatingUser $ratinguser
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, RatingUser $ratinguser, $id)
	{
		$validator = Validator::make($request->all(), [
			'userId' => 'required|numeric',
			'courseId' => 'required|numeric',
			'lessionId' => 'required|numeric',
			'topicId' => 'required|numeric',
			'ratingType' => 'required',
			'ratingMessage' => 'required',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		} else {
			$ratinguser = RatingUser::findOrFail($id);
			$ratinguser->userId = $request->get('userId');
			$ratinguser->courseId = $request->get('courseId');
			$ratinguser->lessionId = $request->get('lessionId');
			$ratinguser->topicId = $request->get('topicId');
			$ratinguser->ratingType = $request->get('ratingType');
			$ratinguser->ratingMessage = $request->get('ratingMessage');
			$ratinguser->message = $request->get('message');
			$ratinguser->save();
			$ratinguserId = $ratinguser->id;

			\Session::flash('msg', 'Rating Updated Successfully.');
			return redirect('/admin/usersratings');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\RatingUser
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id)
	{
		$ratinguser = RatingUser::findOrFail($id);
		$ratinguser->deleted=1;
		$ratinguser->update();

		return redirect('/admin/usersratings');
	}

	public function updateStatus($id,$status)
	{
		$ratinguser = RatingUser::findOrFail($id);
		$ratinguser->status=$status;
		$ratinguser->update();

		return redirect('/admin/usersratings');
	}

}
