<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Courses;
use App\Coursefeature;
use App\Coursefeq;
use App\VideoTemp;


class CoursesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$course = Courses::where('sort_id',0)->orderBy('sort_id', 'ASC')->first();
		if($course){
			$Course = Courses::findOrFail($course->id);
			$Course->sort_id = $course->id;
			$Course->update();
		}
		$data = Courses::where('deleted',0)->orderBy('sort_id', 'ASC')->get();

		return view('admin.courses.index', compact('data'));
	}

	public function test(){

		$data = Courses::find(5)->get();

		foreach ($data as $col){
			echo $col->collage;
		}


	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('admin.courses.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{ 
		//echo '<pre />'; print_r($request->all()); die;
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'video' => 'required|mimes:mp4',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		}else {

			$file = $request->file('image');
			$video = $request->file('video');
			$thumb = $request->file('thumb');
			$pdf = $request->file('pdf');
			$filename = $filenamevideo = $filenamepdf = '';
			if($file){
				$destinationPath = public_path().'/course/';
				$originalFile = $file->getClientOriginalName();
				$filename=strtotime(date('Y-m-d-H:isa')).$originalFile;
				$file->move($destinationPath, $filename);
			}
			if($video){
				$destinationPathvideo = public_path().'/course/';
				$originalFilevideo = $video->getClientOriginalName();
				//$filenamevideo=rand(111,999).strtotime(date('Y-m-d-H:isa')).$originalFilevideo;
				$filenamevideo = time() . "_org.mp4";
				$video->move($destinationPathvideo, $filenamevideo);
			}
			if($pdf){
				$destinationPathpdf = public_path().'/course/';
				$originalFilepdf = $pdf->getClientOriginalName();
				$filenamepdf=rand(111,999).strtotime(date('Y-m-d-H:isa')).$originalFilepdf;
				$pdf->move($destinationPathpdf, $filenamepdf);
			}
				
			$Courses = new Courses();
			$Courses->name = $request->get('name');
			$Courses->overview = $request->get('overview');
			$Courses->video_duration = $request->get('video_duration');
			$Courses->image = $filename;
			$Courses->video = $filenamevideo;
			$Courses->pdf = $filenamepdf;
			$Courses->isFree = $request->get('free');
			$Courses->save();
			$courseId=$Courses->id;
			if($courseId){
				$Course = Courses::findOrFail($courseId);
				$Course->sort_id = $courseId;
				$Course->update();
			}
		    
			$feature = ($request->get('featu')) ? $request->get('featu') : [];
			for ($i=0; $i<count($feature); $i++){
				$Coursefeature=new Coursefeature();
				$Coursefeature->courseId =$courseId;    
				$Coursefeature->feature =$request->input('featu')[$i];    
				$Coursefeature->save(); 
			}
			$faqTitle = ($request->get('faqTitle')) ? $request->get('faqTitle') : [];
			for ($i=0; $i<count($faqTitle); $i++){
				$Coursefeq=new Coursefeq();
				$Coursefeq->courseId =$courseId;    
				$Coursefeq->title =$request->input('faqTitle')[$i];
				$Coursefeq->contant =$request->input('faqcontant')[$i];    
				$Coursefeq->save(); 
			}
			
			\Session::flash('msg', 'Course Added Successfully.');
			return back();
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Courses  $courses
	 * @return \Illuminate\Http\Response
	 */
	public function show(Courses $courses)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Courses  $courses
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Courses $courses, $id)
	{
		$Coursefeq = Coursefeq::where('courseId',$id)->get();
		$Coursefeature = Coursefeature::where('courseId',$id)->get();
	  
		$course = Courses::findOrFail($id);

		return view('admin.courses.edit',compact('course','Coursefeq','Coursefeature'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Courses  $courses
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Courses $courses, $id)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'video' => 'mimes:mp4',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		}else {

			$Courses = Courses::findOrFail($id);

			$file = $request->file('image');
			$video = $request->file('video');
			$thumb = $request->file('thumb');
			$pdf = $request->file('pdf');

			if($file){
				$destinationPath = public_path().'/course/';
				$originalFile = $file->getClientOriginalName();
				$filename=strtotime(date('Y-m-d-H:isa')).$originalFile;
				$file->move($destinationPath, $filename);
			}else{
			   $filename=$Courses->image;  
			}

			if($video){
				$destinationPathvideo = public_path().'/course/';
				$originalFilevideo = $video->getClientOriginalName();
				//$filenamevideo=rand(111,999).strtotime(date('Y-m-d-H:isa')).$originalFilevideo;
				$filenamevideo = time() . "_org.mp4";
				$video->move($destinationPathvideo, $filenamevideo);
			}else{
			   $filenamevideo=$Courses->video;  
			}
			if($pdf){
				$destinationPathpdf = public_path().'/course/';
				$originalFilepdf = $pdf->getClientOriginalName();
				$filenamepdf=rand(111,999).strtotime(date('Y-m-d-H:isa')).$originalFilepdf;
				$pdf->move($destinationPathpdf, $filenamepdf);
			}else {
				$filenamepdf=$Courses->pdf;
			}
			
			if($video){
				if(!empty($Courses->video) && file_exists( public_path().'/course/'.$Courses->video )) {
					unlink( public_path().'/course/'.$Courses->video );
				}
				if(!empty($Courses->video_1) && file_exists( public_path().'/course/'.$Courses->video_1 ) && $Courses->video_1!='NA') {
					unlink( public_path().'/course/'.$Courses->video_1 );
				}
				if(!empty($Courses->video_2) && file_exists( public_path().'/course/'.$Courses->video_2 ) && $Courses->video_2!='NA') {
					unlink( public_path().'/course/'.$Courses->video_2 );
				}
				if(!empty($Courses->video_3) && file_exists( public_path().'/course/'.$Courses->video_3 ) && $Courses->video_3!='NA') {
					unlink( public_path().'/course/'.$Courses->video_3 );
				}
				$deleteVideoTemp = VideoTemp::where('courseId',$id)->where('lessionId',0)->where('topicId',0)->delete();
				$Courses->video_1 = NULL;
				$Courses->video_2 = NULL;
				$Courses->video_3 = NULL;
				$Courses->processtatus = 0;
				$Courses->starttime = NULL;
				$Courses->endtime = NULL;
			}
			$Courses->name = $request->get('name');
			$Courses->overview = $request->get('overview');
			$Courses->video_duration = $request->get('video_duration');
			$Courses->image = $filename;
			$Courses->video = $filenamevideo;
			$Courses->pdf = $filenamepdf;
			$Courses->isFree = $request->get('free');
			$courseId=$Courses->save();
			$courseId=$id;
		   
			Coursefeature::where('courseId',$id)->delete();
			Coursefeq::where('courseId',$id)->delete();
			$feature = ($request->get('featu')) ? $request->get('featu') : [];
			for ($i=0; $i<count($feature); $i++){
				$Coursefeature=new Coursefeature();
				$Coursefeature->courseId =$courseId;    
				$Coursefeature->feature =$request->input('featu')[$i];    
				$Coursefeature->save(); 
			}
			$faqTitle = ($request->get('faqTitle')) ? $request->get('faqTitle') : [];
			for ($i=0; $i<count($faqTitle); $i++){
				$Coursefeq=new Coursefeq();
				$Coursefeq->courseId =$courseId;    
				$Coursefeq->title =$request->input('faqTitle')[$i];
				$Coursefeq->contant =$request->input('faqcontant')[$i];    
				$Coursefeq->save(); 
			}
			
			$Courses->update();
			\Session::flash('msg', 'Course updated Successfully.');
			return redirect('/admin/courses');
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Courses  $courses
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id)
	{
		$user = Courses::findOrFail($id);
		$user->deleted=1;
		$user->update();

	   return redirect('/admin/courses');
	}

	public function updateStatus($id,$status)
	{
		//echo "string";die;
		$user = Courses::findOrFail($id);
		$user->status=$status;
		$user->update();

	   return redirect('/admin/courses');
	}

	public function sortUp($id,$sort_id)
	{
		$sort_id = $sort_id - 1;
		$course = Courses::where("sort_id", $sort_id);
		//$course->sort_id = $sort_id + 1;
		$course->update(array("sort_id"=>$sort_id + 1));
		$course1 = Courses::findOrFail($id);
		$course1->sort_id = $sort_id;
		$course1->save();

	   return redirect('/admin/courses');
	}

	public function sortDown($id,$sort_id)
	{
		$sort_id = $sort_id + 1;
		$course = Courses::where("sort_id", $sort_id);
		//$course->sort_id = $sort_id - 1;
		$course->update(array("sort_id"=>$sort_id - 1));
		$course1 = Courses::findOrFail($id);
		$course1->sort_id = $sort_id;
		$course1->save();

	   return redirect('/admin/courses');
	}

	public function convertVideo()
	{
		$data = VideoTemp::where('courseId','!=',0)->where('lessionId',0)->where('topicId',0)->orderBy('id', 'ASC')->get();
		
		return view('admin.courses.convertVideo', compact('data'));
	}

	public function approveVideo($id)
	{
		$videoTemp = VideoTemp::where('id',$id)->first();
		$courseId = $videoTemp->courseId;
		$low_status = $videoTemp->low_status;
		$med_status = $videoTemp->med_status;
		$high_status = $videoTemp->high_status;
		$course = Courses::findOrFail($courseId);
		if ($low_status == 1) {
			$course->video_1 = $videoTemp->low_video;
		}
		if ($med_status == 1) {
			$course->video_2 = $videoTemp->med_video;
		}
		if ($high_status == 1) {
			$course->video_3 = $videoTemp->high_video;
		}
		$course->update();
		
		$delete = VideoTemp::where('id',$id)->delete();

		\Session::flash('msg', 'Converted Video Approved Successfully.');
	    return redirect('/admin/courses/convertVideo');
	}

	public function imgremove($id)
	{
		$course = Courses::findOrFail($id);
		if(file_exists( public_path().'/course/'.$course->image )) {
			unlink( public_path().'/course/'.$course->image );
		}
		$course->image = NULL;
		$course->update();

		\Session::flash('msg', 'Course Image Removed Successfully.');
	    return redirect()->back();
	}

	public function vidremove($id)
	{
		$course = Courses::findOrFail($id);
		if(!empty($course->video) && file_exists( public_path().'/course/'.$course->video )) {
			unlink( public_path().'/course/'.$course->video );
		}
		if(!empty($course->video_1) && file_exists( public_path().'/course/'.$course->video_1 ) && $course->video_1!='NA') {
			unlink( public_path().'/course/'.$course->video_1 );
		}
		if(!empty($course->video_2) && file_exists( public_path().'/course/'.$course->video_2 ) && $course->video_2!='NA') {
			unlink( public_path().'/course/'.$course->video_2 );
		}
		if(!empty($course->video_3) && file_exists( public_path().'/course/'.$course->video_3 ) && $course->video_3!='NA') {
			unlink( public_path().'/course/'.$course->video_3 );
		}
		$deleteVideoTemp = VideoTemp::where('courseId',$id)->where('lessionId',0)->where('topicId',0)->delete();
		$course->video = NULL;
		$course->video_1 = NULL;
		$course->video_2 = NULL;
		$course->video_3 = NULL;
		$course->processtatus = 0;
		$course->starttime = NULL;
		$course->endtime = NULL;
		$course->update();

		\Session::flash('msg', 'Course Video Removed Successfully.');
	    return redirect()->back();
	}

	public function pdfremove($id)
	{
		$course = Courses::findOrFail($id);
		if(file_exists( public_path().'/course/'.$course->pdf )) {
			unlink( public_path().'/course/'.$course->pdf );
		}
		$course->pdf = NULL;
		$course->update();

		\Session::flash('msg', 'Course PDF Removed Successfully.');
	    return redirect()->back();
	}

}