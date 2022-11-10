<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Testimonial;
use DB;

class TestimonialController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		if(!empty($request->related) ){
			$data = Testimonial::where('related',$request->related)->where('deleted',0)->orderBy('sort_id', 'ASC')->get();
		}else{
			$data = Testimonial::where('deleted',0)->orderBy('sort_id', 'ASC')->get();
		}
		$relates = DB::table('testimonial_relates')->orderBy('title', 'ASC')->get();
		
		return view('admin.testimonials.index', compact('data','relates'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$relates = DB::table('testimonial_relates')->orderBy('title', 'ASC')->get();
		
		return view('admin.testimonials.create', compact('relates'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		// print_r($request->all());die;
		$validator = Validator::make($request->all(), [
			'related' => 'required',
			'name' => 'required',
			//'profession' => 'regex:/^[\pL\s\-]+$/u',
			'image' => 'required',
			'content' => 'required',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		}else { 
			//print_r($request->all());die;

			$file = $request->file('image');
			if($file){
				$destinationPath = public_path().'/upload/testimonials/';
				$originalFile = $file->getClientOriginalName();
				$filename=strtotime(date('Y-m-d-H:isa')).$originalFile;
				$file->move($destinationPath, $filename);
			}
				
			$testimonial = new Testimonial();
			$testimonial->related = $request->get('related');
			$testimonial->name = $request->get('name');
			$testimonial->profession = $request->get('profession');
			$testimonial->content = $request->get('content');
			$testimonial->image = $filename;
			$testimonial->status = 1;
			$testimonial->save();
			$testimonialId=$testimonial->id;
			if($testimonialId){
				$Testimonial = Testimonial::findOrFail($testimonialId);
				$Testimonial->sort_id = $testimonialId;
				$Testimonial->update();
			}
			
			\Session::flash('msg', 'Testimonial Added Successfully.');
			return back();
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Testimonial  $testimonials
	 * @return \Illuminate\Http\Response
	 */
	public function show(Testimonial $testimonials)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Testimonial  $testimonials
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Testimonial $testimonials, $id)
	{
		$testimonial = Testimonial::findOrFail($id);
		$relates = DB::table('testimonial_relates')->orderBy('title', 'ASC')->get();

		return view('admin.testimonials.edit',compact('testimonial','relates'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Testimonial  $testimonials
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Testimonial $testimonials, $id)
	{
		$validator = Validator::make($request->all(), [
			'related' => 'required',
			'name' => 'required',
			//'profession' => 'regex:/^[\pL\s\-]+$/u',
			'content' => 'required',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		}else {

			$testimonial = Testimonial::findOrFail($id);

			$file = $request->file('image');

			if($file){
				$destinationPath = public_path().'/upload/testimonials/';
				$originalFile = $file->getClientOriginalName();
				$filename=strtotime(date('Y-m-d-H:isa')).$originalFile;
				$file->move($destinationPath, $filename);
			}else{
			   $filename=$testimonial->image;  
			}
			
			$testimonial->related = $request->get('related');
			$testimonial->name = $request->get('name');
			$testimonial->profession = $request->get('profession');
			$testimonial->content = $request->get('content');
			$testimonial->image = $filename;
			$testimonial->status = 1;
			$testimonial->save();
			$testimonialId=$id;
			
			\Session::flash('msg', 'Testimonial updated Successfully.');
			return redirect('/admin/testimonials');
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Testimonial  $testimonials
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id)
	{
		$testimonial = Testimonial::findOrFail($id);
		$testimonial->deleted=1;
		$testimonial->update();

	    return redirect('/admin/testimonials');
	}

	public function updateStatus($id,$status)
	{
		$testimonial = Testimonial::findOrFail($id);
		$testimonial->status=$status;
		$testimonial->update();

	    return redirect('/admin/testimonials');
	}

	public function sortUp($id,$sort_id)
	{
		$sort_id = $sort_id - 1;
		$testimonial = Testimonial::where("sort_id", $sort_id);
		//$testimonial->sort_id = $sort_id + 1;
		$testimonial->update(array("sort_id"=>$sort_id + 1));
		$testimonial1 = Testimonial::findOrFail($id);
		$testimonial1->sort_id = $sort_id;
		$testimonial1->save();

	   return redirect('/admin/testimonials');
	}

	public function sortDown($id,$sort_id)
	{
		$sort_id = $sort_id + 1;
		$testimonial = Testimonial::where("sort_id", $sort_id);
		//$testimonial->sort_id = $sort_id - 1;
		$testimonial->update(array("sort_id"=>$sort_id - 1));
		$testimonial1 = Testimonial::findOrFail($id);
		$testimonial1->sort_id = $sort_id;
		$testimonial1->save();

	   return redirect('/admin/testimonials');
	}

}