<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Enquiry;


class EnquiryController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		if(!empty($request->from) && !empty($request->to) ){
			$data = Enquiry::where("created_at",">=",$request->from)->where("created_at","<=",$request->to.' 23:59:59')->orderBy("id", "DESC")->get();
		}elseif(!empty($request->from) ){
			$data = Enquiry::where("created_at",">=",$request->from)->orderBy("id", "DESC")->get();
		} else {
			$data = Enquiry::orderBy("id", "DESC")->get();
		}

		return view('admin.enquiry.index', compact('data'));
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$users = User::where("status", 1)->get();

		return view('admin.enquiry.create', compact('users'));
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
		} else {
			//echo '<pre />'; print_r($request->all()); die;
			$enquiry = new Enquiry();
			$enquiry->user_id = $request->get('user_id');
			$enquiry->message = $request->get('message');
			$enquiry->save();
			$enquiryId = $enquiry->id;

			\Session::flash('msg', 'Contact us Added Successfully.');
			return back();
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Enquiry $enquiry
	 * @return \Illuminate\Http\Response
	 */
	public function show(Enquiry $enquiry)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Enquiry $enquiry
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Enquiry $enquiry, $id)
	{
		$data = Enquiry::findOrFail($id);
		$users = User::where("status", 1)->get();

		return view('admin.enquiry.edit',compact('data','users'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Enquiry $enquiry
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Enquiry $enquiry, $id)
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
			$enquiry = Enquiry::findOrFail($id);
			$enquiry->user_id = $request->get('user_id');
			$enquiry->message = $request->get('message');
			$enquiry->save();
			$enquiryId = $enquiry->id;

			\Session::flash('msg', 'Contact us Updated Successfully.');
			return redirect('/admin/enquiries');
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Enquiry
	 * @return \Illuminate\Http\Response
	 */
	 public function delete($id)
	{
		$enquiry = Enquiry::findOrFail($id);
		$enquiry->deleted=1;
		$enquiry->update();

		return redirect('/admin/enquiries');
	}

	public function updateStatus($id,$status)
	{
		$enquiry = Enquiry::findOrFail($id);
		$enquiry->status=$status;
		$enquiry->update();

		return redirect('/admin/enquiries');
	}

}
