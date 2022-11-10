<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Chapter;
use App\Courses;
use App\Lession;
use App\VideoTemp;


class LessionController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		if(!empty($request->course) ){
			$data = lession::with('courses')->where('courseId',$request->course)->where('deleted',0)->orderBy('sort_id', 'ASC')->get();
		}else{
			$data = lession::with('courses')->where('deleted',0)->orderBy('sort_id', 'ASC')->get();
		}
		$courses = Courses::Where('deleted',0)->get();
		//print_r($data);
		return view('admin.lession.index', compact('data','courses'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$course = Courses::Where('deleted',0)->get();
		return view('admin.lession.create',compact('course'));
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
			'courseId' => 'required',
			'name' => 'required',
			'video' => 'required|mimes:mp4',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		} else {
			//print_r($request->all());die;
			$filenamethumb = $filenamevideo = $filenamepdf = '';
			$thumb = $request->file('thumb');
			$video = $request->file('video');
			$pdf = $request->file('pdf');
			
			if($thumb){
				$destinationPaththumb = public_path().'/lessions/';
				$originalFilethumb = $thumb->getClientOriginalName();
				$filenamethumb=rand(111,999).strtotime(date('Y-m-d-H:isa')).$originalFilethumb;
				$thumb->move($destinationPaththumb, $filenamethumb);
			}
			if($video){
				$destinationPathvideo = public_path().'/lessions/';
				$originalFilevideo = $video->getClientOriginalName();
				//$filenamevideo=rand(111,999).strtotime(date('Y-m-d-H:isa')).$originalFilevideo;
				$filenamevideo = time() . "_org.mp4";
				$video->move($destinationPathvideo, $filenamevideo);
			}
			if($pdf){
				$destinationPathpdf = public_path().'/lessions/';
				$originalFilepdf = $pdf->getClientOriginalName();
				$filenamepdf=rand(111,999).strtotime(date('Y-m-d-H:isa')).$originalFilepdf;
				$pdf->move($destinationPathpdf, $filenamepdf);
			}
				
			$lession = new Lession();
			$lession->courseId = $request->get('courseId');
			$lession->name = $request->get('name');
			$lession->video_thumb = $filenamethumb;
			$lession->fullvideo = $filenamevideo;
			$lession->pdf = $filenamepdf;
			$lession->content = $request->get('content');
			$lession->isFree = $request->get('free');
			$lession->save();
			$lessionId=$lession->id;
			if($lessionId){
				$lession = Lession::findOrFail($lessionId);
				$lession->sort_id = $lessionId;
				$lession->save();
			}
			
			\Session::flash('msg', 'Lession Added Successfully.');
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
	public function edit($id)
	{
		$lession = Lession::find($id);
		//$course = Courses::Where('deleted',0)->get();
		$course = Courses::get();
		//print_r($Lession);die;

		return view('admin.lession.edit',compact('lession','course'));
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
		//print_r($request->all());die;
		$validator = Validator::make($request->all(), [
			'courseId' => 'required',
			'name' => 'required',
			'video' => 'mimes:mp4',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		}else {
			$lession = lession::findOrFail($id);
			$thumb = $request->file('thumb');
			$video = $request->file('video');
			$pdf = $request->file('pdf');

			if($thumb){
				$destinationPaththumb = public_path().'/lessions/';
				$originalFilethumb = $thumb->getClientOriginalName();
				$filenamethumb=rand(111,999).strtotime(date('Y-m-d-H:isa')).$originalFilethumb;
				$thumb->move($destinationPaththumb, $filenamethumb);
			}else {
				$filenamethumb=$lession->video_thumb;
			}
			if($video){
				$destinationPathvideo = public_path().'/lessions/';
				$originalFilevideo = $video->getClientOriginalName();
				//$filenamevideo=rand(111,999).strtotime(date('Y-m-d-H:isa')).$originalFilevideo;
				$filenamevideo = time() . "_org.mp4";
				$video->move($destinationPathvideo, $filenamevideo);
			}else {
				$filenamevideo=$lession->fullvideo;
			}
			if($pdf){
				$destinationPathpdf = public_path().'/lessions/';
				$originalFilepdf = $pdf->getClientOriginalName();
				$filenamepdf=rand(111,999).strtotime(date('Y-m-d-H:isa')).$originalFilepdf;
				$pdf->move($destinationPathpdf, $filenamepdf);
			}else {
				$filenamepdf=$lession->pdf;
			}
			
			if($video){
				if(!empty($lession->fullvideo) && file_exists( public_path().'/lessions/'.$lession->fullvideo )) {
					unlink( public_path().'/lessions/'.$lession->fullvideo );
				}
				if(!empty($lession->video_1) && file_exists( public_path().'/lessions/'.$lession->video_1 ) && $lession->video_1!='NA') {
					unlink( public_path().'/lessions/'.$lession->video_1 );
				}
				if(!empty($lession->video_2) && file_exists( public_path().'/lessions/'.$lession->video_2 ) && $lession->video_2!='NA') {
					unlink( public_path().'/lessions/'.$lession->video_2 );
				}
				if(!empty($lession->video_3) && file_exists( public_path().'/lessions/'.$lession->video_3 ) && $lession->video_3!='NA') {
					unlink( public_path().'/lessions/'.$lession->video_3 );
				}
				$deleteVideoTemp = VideoTemp::where('lessionId',$id)->where('topicId',0)->delete();
				$lession->video_1 = NULL;
				$lession->video_2 = NULL;
				$lession->video_3 = NULL;
				$lession->processtatus = 0;
				$lession->starttime = NULL;
				$lession->endtime = NULL;
			}
			$lession->courseId = $request->get('courseId');
			$lession->name = $request->get('name');
			$lession->video_thumb = $filenamethumb;
			$lession->fullvideo = $filenamevideo;
			$lession->pdf = $filenamepdf;
			$lession->content = $request->get('content');
			$lession->isFree = $request->get('free');
			$lession->save();

			\Session::flash('msg', 'Lession updated Successfully.');
			return redirect('/admin/lession');
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
		$user = Lession::findOrFail($id);
		$user->deleted=1;
		$user->update();

	   return redirect('/admin/lession');
	}

	public function updateStatus($id,$status)
	{
		$user = Lession::findOrFail($id);
		$user->status=$status;
		$user->update();

	    return redirect('/admin/lession');
	}

	public function sortUp($id,$sort_id)
	{
		$sort_id = $sort_id - 1;
		$lession = Lession::where("sort_id", $sort_id);
		$lession->update(array("sort_id"=>$sort_id + 1));
		$lession1 = Lession::findOrFail($id);
		$lession1->sort_id = $sort_id;
		$lession1->save();

	   return redirect('/admin/lession');
	}

	public function sortDown($id,$sort_id)
	{
		$sort_id = $sort_id + 1;
		$lession = Lession::where("sort_id", $sort_id);
		$lession->update(array("sort_id"=>$sort_id - 1));
		$lession1 = Lession::findOrFail($id);
		$lession1->sort_id = $sort_id;
		$lession1->save();

	   return redirect('/admin/lession');
	}

	public function convertVideo()
	{
		$data = VideoTemp::where('lessionId','!=',0)->where('topicId',0)->orderBy('id', 'ASC')->get();
		
		return view('admin.lession.convertVideo', compact('data'));
	}

	public function approveVideo($id)
	{
		$videoTemp = VideoTemp::where('id',$id)->first();
		$lessionId = $videoTemp->lessionId;
		$low_status = $videoTemp->low_status;
		$med_status = $videoTemp->med_status;
		$high_status = $videoTemp->high_status;
		$lession = Lession::findOrFail($lessionId);
		if ($low_status == 1) {
			$lession->video_1 = $videoTemp->low_video;
		}
		if ($med_status == 1) {
			$lession->video_2 = $videoTemp->med_video;
		}
		if ($high_status == 1) {
			$lession->video_3 = $videoTemp->high_video;
		}
		$lession->update();
		
		$delete = VideoTemp::where('id',$id)->delete();

		\Session::flash('msg', 'Converted Video Approved Successfully.');
	    return redirect('/admin/lession/convertVideo');
	}

	public function imgremove($id)
	{
		$lession = Lession::findOrFail($id);
		if(file_exists( public_path().'/lessions/'.$lession->video_thumb )) {
			unlink( public_path().'/lessions/'.$lession->video_thumb );
		}
		$lession->video_thumb = NULL;
		$lession->update();

		\Session::flash('msg', 'Lession Image Removed Successfully.');
	    return redirect()->back();
	}

	public function vidremove($id)
	{
		$lession = Lession::findOrFail($id);
		if(!empty($lession->fullvideo) && file_exists( public_path().'/lessions/'.$lession->fullvideo )) {
			unlink( public_path().'/lessions/'.$lession->fullvideo );
		}
		if(!empty($lession->video_1) && file_exists( public_path().'/lessions/'.$lession->video_1 ) && $lession->video_1!='NA') {
			unlink( public_path().'/lessions/'.$lession->video_1 );
		}
		if(!empty($lession->video_2) && file_exists( public_path().'/lessions/'.$lession->video_2 ) && $lession->video_2!='NA') {
			unlink( public_path().'/lessions/'.$lession->video_2 );
		}
		if(!empty($lession->video_3) && file_exists( public_path().'/lessions/'.$lession->video_3 ) && $lession->video_3!='NA') {
			unlink( public_path().'/lessions/'.$lession->video_3 );
		}
		$deleteVideoTemp = VideoTemp::where('lessionId',$id)->where('topicId',0)->delete();
		$lession->fullvideo = NULL;
		$lession->video_1 = NULL;
		$lession->video_2 = NULL;
		$lession->video_3 = NULL;
		$lession->processtatus = 0;
		$lession->starttime = NULL;
		$lession->endtime = NULL;
		$lession->update();

		\Session::flash('msg', 'Lession Video Removed Successfully.');
	    return redirect()->back();
	}

	public function pdfremove($id)
	{
		$lession = Lession::findOrFail($id);
		if(file_exists( public_path().'/lessions/'.$lession->pdf )) {
			unlink( public_path().'/lessions/'.$lession->pdf );
		}
		$lession->pdf = NULL;
		$lession->update();

		\Session::flash('msg', 'Lession PDF Removed Successfully.');
	    return redirect()->back();
	}

	public function getcourselession(Request $request)
	{
		$courseId=$request->get('courseId');

		//$getLession=Lession::where('courseId',$courseId)->where('status',1)->where('deleted',0)->get();
		$getLession = Lession::where('courseId',$courseId)->get();
		?>
		<option value="">--Select--</option>
		<?php
		foreach ($getLession as $key => $value) {
			?>
			<option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
			<?php
		}
	}

	public function getlessiontopic(Request $request)
	{
		$lessionId=$request->get('lessionId');

		//$getTopics=Chapter::where('lessionId',$lessionId)->where('status',1)->where('deleted',0)->get();
		$getTopics = Chapter::where('lessionId',$lessionId)->get();
		?>
		<option value="">--Select--</option>
		<?php
		foreach ($getTopics as $key => $value) {
			?>
			<option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
			<?php
		}
	}

}
