<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Subscription;


class SubscriptionController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$data = Subscription::where('deleted',0)->get();

		return view('admin.subscriptions.index', compact('data'));
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('admin.subscriptions.create');
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
			'month' => 'required|integer|min:1',
			'price' => 'required|regex:/^[1-9][0-9]+/|not_in:0',
			'video' => 'mimes:mp4',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		}else { 
			//echo '<pre />'; print_r($request->all()); die;
			$filename = $filenamevideo = NULL;

			$file = $request->file('image');
			$video = $request->file('video');

			if($file){
				$destinationPath = public_path().'/upload/subscriptions/';
				$originalFile = $file->getClientOriginalName();
				$filename = strtotime(date('Y-m-d-H:isa')).$originalFile;
				$file->move($destinationPath, $filename);
			}
			if($video){
				$destinationPath = public_path().'/upload/subscriptions/';
				$originalFile = $video->getClientOriginalName();
				//$filenamevideo = strtotime(date('Y-m-d-H:isa')).$originalFile;
				$filenamevideo = time() . "_org.mp4";
				$video->move($destinationPath, $filenamevideo);
			}
			
			$subscription = new Subscription();
			$subscription->name = $request->get('name');
			$subscription->month = $request->get('month');
			$subscription->price = $request->get('price');
			$subscription->image = $filename;
			$subscription->video = $filenamevideo;
			$subscription->description = $request->get('description');
			$subscription->status = 1;

			$faqs = array();
			$question = !empty($request->get('question')) ? $request->get('question') : [];
			for ($i=0; $i<count($question); $i++){
				$faqs[] = array(
					'question' => $request->input('question')[$i],
					'answer' => $request->input('answer')[$i]
				);
			}
			$subscription->faqs = json_encode($faqs);

			$subscription->save();
			$subscriptionId = $subscription->id;

			\Session::flash('msg', 'Subscription Plan Added Successfully.');
			return back();
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Subscription $subscriptions
	 * @return \Illuminate\Http\Response
	 */
	public function show(Subscription $subscriptions)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Subscription $subscriptions
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Subscription $subscriptions, $id)
	{
		$data = Subscription::findOrFail($id);

		return view('admin.subscriptions.edit',compact('data'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Subscription $subscriptions
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Subscription $subscriptions, $id)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'month' => 'required|integer|min:1',
			'price' => 'required|regex:/^[1-9][0-9]+/|not_in:0',
			'video' => 'mimes:mp4',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		} else {
			$subscription = Subscription::findOrFail($id);

			$file = $request->file('image');
			$video = $request->file('video');

			if($file){
				$destinationPath = public_path().'/upload/subscriptions/';
				$originalFile = $file->getClientOriginalName();
				$filename = strtotime(date('Y-m-d-H:isa')).$originalFile;
				$file->move($destinationPath, $filename);
			}else{
			   $filename = $subscription->image;
			}
			if($video){
				$destinationPath = public_path().'/upload/subscriptions/';
				$originalFile = $video->getClientOriginalName();
				//$filenamevideo = strtotime(date('Y-m-d-H:isa')).$originalFile;
				$filenamevideo = $id.'_'.time() . "_org.mp4";
				$video->move($destinationPath, $filenamevideo);
			}else{
			   $filenamevideo = $subscription->video;
			}

			$subscription->name = $request->get('name');
			$subscription->month = $request->get('month');
			$subscription->price = $request->get('price');
			$subscription->image = $filename;
			$subscription->video = $filenamevideo;
			$subscription->description = $request->get('description');

			$faqs = array();
			$question = !empty($request->get('question')) ? $request->get('question') : [];
			for ($i=0; $i<count($question); $i++){
				$faqs[] = array(
					'question' => $request->input('question')[$i],
					'answer' => $request->input('answer')[$i]
				);
			}
			$subscription->faqs = json_encode($faqs);
			
			$subscription->save();
			$subscriptionId = $subscription->id;

			\Session::flash('msg', 'Subscription Plan Updated Successfully.');
			return redirect('/admin/subscriptions');
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Subscription
	 * @return \Illuminate\Http\Response
	 */
	 public function delete($id)
	{
		$subscription = Subscription::findOrFail($id);
		$subscription->deleted=1;
		$subscription->update();

		return redirect('/admin/subscriptions');
	}

	public function updateStatus($id,$status)
	{
		$subscription = Subscription::findOrFail($id);
		$subscription->status=$status;
		$subscription->update();

		return redirect('/admin/subscriptions');
	}

}
