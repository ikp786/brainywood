<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\AboutUs;


class AboutUsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$data = AboutUs::get();

		return view('admin.aboutus.index', compact('data'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('admin.aboutus.create');
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
			'title' => 'required',
			'content' => 'required',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		}else { 
			//print_r($request->all());die;
			$video = $request->file('video');

			if($video){
				$destinationPathvideo = public_path().'/upload/aboutus/';
				$originalFilevideo = $video->getClientOriginalName();
				$filenamevideo=rand(111,999).strtotime(date('Y-m-d-H:isa')).$originalFilevideo;
				$video->move($destinationPathvideo, $filenamevideo);
			}
				
			$about = new AboutUs();
			$about->title = $request->get('title');
			$about->content = $request->get('content');
			$about->organization = $request->get('organization');
			$about->vision = $request->get('vision');
			$about->mission = $request->get('mission');
			$about->process = $request->get('process');
			$about->video = $filenamevideo;

			$facts = array();
			$fact_title = ($request->get('fact_title')) ? $request->get('fact_title') : [];
			for ($i=0; $i<count($fact_title); $i++){

				$file = $request->file('fact_icon');

				if($file){
					$destinationPathicon = public_path().'/upload/aboutus/';
					$originalFileicon = $file->getClientOriginalName();
					$filenameicon=rand(111,999).strtotime(date('Y-m-d-H:isa')).$originalFileicon;
					$file->move($destinationPathicon, $filenameicon);
				}
				$facts[] = array(
					'fact_icon' => $filenameicon[$i],
					'fact_title' => $request->input('fact_title')[$i],
					'fact_sub_title' => $request->input('fact_sub_title')[$i]
				);
			}
			$about->interesting_facts = json_encode($facts);
			$about->save();
			$aboutId=$about->id;
			
			\Session::flash('msg', 'About Us Added Successfully.');
			return back();
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\AboutUs $aboutus
	 * @return \Illuminate\Http\Response
	 */
	public function show(AboutUs $aboutus)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\AboutUs $aboutus
	 * @return \Illuminate\Http\Response
	 */
	public function edit(AboutUs $aboutus, $id)
	{
		$about = AboutUs::findOrFail($id);

		return view('admin.aboutus.edit',compact('about'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\AboutUs $aboutus
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, AboutUs $aboutus, $id)
	{
		$validator = Validator::make($request->all(), [
			'title' => 'required',
			//'content' => 'required',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		}else {
			//echo '<pre />'; print_r($request->all()); die;
			$about = AboutUs::findOrFail($id);

			$file = $request->file('image');
			if($file){
				$destinationPath = public_path().'/upload/aboutus/';
				$originalFile = $file->getClientOriginalName();
				$filename=strtotime(date('Y-m-d-H:isa')).$originalFile;
				$file->move($destinationPath, $filename);
			}else{
			   $filename=$about->image;  
			}

			$video = $request->file('video');
			if($video){
				$destinationPathvideo = public_path().'/upload/aboutus/';
				$originalFilevideo = $video->getClientOriginalName();
				$filenamevideo=rand(111,999).strtotime(date('Y-m-d-H:isa')).$originalFilevideo;
				$video->move($destinationPathvideo, $filenamevideo);
			}else{
			   $filenamevideo=$about->video;
			}

			$facts = array();
			$file_icon = $request->file('fact_icon');
			$fact_title = ($request->get('fact_title')) ? $request->get('fact_title') : [];
			for ($i=0; $i<count($fact_title); $i++){

				if(!empty($file_icon[$i])){
					$destinationPathicon = public_path().'/upload/aboutus/';
					$originalFileicon = $file_icon[$i]->getClientOriginalName();
					$filenameicon=rand(111,999).strtotime(date('Y-m-d-H:isa')).$originalFileicon;
					$file_icon[$i]->move($destinationPathicon, $filenameicon);
				}else{
				   $filenameicon=$request->input('old_icon')[$i];
				}
				$facts[] = array(
					'fact_icon' => $filenameicon,
					'fact_title' => $request->input('fact_title')[$i],
					'fact_sub_title' => $request->input('fact_sub_title')[$i]
				);
			}

			$about->title = $request->get('title');
			$about->content = $request->get('content');
			$about->organization = $request->get('organization');
			$about->vision = $request->get('vision');
			$about->mission = $request->get('mission');
			$about->process = $request->get('process');
			$about->image = $filename;
			$about->video = $filenamevideo;
			$about->interesting_facts = json_encode($facts);
			$about->save();
			$aboutId=$id;
			
			\Session::flash('msg', 'About Us Updated Successfully.');
			return redirect('/admin/aboutus');
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\AboutUs $aboutus
	 * @return \Illuminate\Http\Response
	 */
	 public function delete($id)
	{
		$about = AboutUs::findOrFail($id);
		$about->deleted=1;
		$about->update();

	   return redirect('/admin/aboutus');
	}

	public function updateStatus($id,$status)
	{
		//echo "string";die;
		$about = AboutUs::findOrFail($id);
		$about->status=$status;
		$about->update();

	   return redirect('/admin/aboutus');
	}

}