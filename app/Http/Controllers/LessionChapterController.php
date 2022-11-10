<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Courses;
use App\Lession;
use App\Chapter;
use App\VideoTemp;


class LessionChapterController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		if(!empty($request->course) && !empty($request->lession) && ($request->lession!='--Select--') ){
			$data = Chapter::with('lession')->where('courseId',$request->course)->where('lessionId',$request->lession)->where('deleted',0)->orderBy('sort_id', 'ASC')->get();
		}elseif(!empty($request->lession) && ($request->lession!='--Select--') ){
			$data = Chapter::with('lession')->where('lessionId',$request->lession)->where('deleted',0)->orderBy('sort_id', 'ASC')->get();
		}elseif(!empty($request->course) || ($request->lession=='--Select--') ){
			$data = Chapter::with('lession')->where('courseId',$request->course)->where('deleted',0)->orderBy('sort_id', 'ASC')->get();
		}else{
			$data = Chapter::with('lession')->where('deleted',0)->orderBy('sort_id', 'ASC')->get();
		}
		$courses = Courses::where('deleted',0)->orderBy('sort_id', 'ASC')->get();
		$lessions = Lession::where('deleted', 0)->orderBy('sort_id', 'ASC')->get();
		//print_r($data);
		return view('admin.chapter.index', compact('data','courses','lessions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$courses = Courses::where('status',1)->where('deleted',0)->orderBy('sort_id', 'ASC')->get();
		return view('admin.chapter.create',compact('courses'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//echo '<pre />'; print_r($request->all());die;
		$validator = Validator::make($request->all(), [
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
				
			$chapter = new Chapter();
			$chapter->courseId = $request->get('courseId');
			$chapter->lessionId = $request->get('lessionId');
			$chapter->name = $request->get('name');
			$chapter->video_thumb = $filenamethumb;
			$chapter->fullvideo = $filenamevideo;
			$chapter->pdf = $filenamepdf;
			$chapter->content = $request->get('content');
			$chapter->isFree = $request->get('free');
			$chapter->save();
			$chapterId=$chapter->id;
			if($chapterId){
				$chapter = Chapter::findOrFail($chapterId);
				$chapter->sort_id = $chapterId;
				$chapter->save();
			}
			
			\Session::flash('msg', 'Lession Chapter Added Successfully.');
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
		$chapter = Chapter::find($id);
		$courses = Courses::where('status', 1)->where('deleted', 0)->orderBy('sort_id', 'ASC')->get();
		$lession = Lession::where('courseId', $chapter->courseId)->where('status', 1)->where('deleted', 0)->orderBy('sort_id', 'ASC')->get();
		//print_r($chapter);die;

		return view('admin.chapter.edit',compact('chapter','courses','lession'));
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
			$chapter = Chapter::findOrFail($id);
			$thumb = $request->file('thumb');
			$video = $request->file('video');
			$pdf = $request->file('pdf');

			if($thumb){
				$destinationPaththumb = public_path().'/lessions/';
				$originalFilethumb = $thumb->getClientOriginalName();
				$filenamethumb=rand(111,999).strtotime(date('Y-m-d-H:isa')).$originalFilethumb;
				$thumb->move($destinationPaththumb, $filenamethumb);
			}else {
				$filenamethumb=$chapter->video_thumb;
			}
			if($video){
				$destinationPathvideo = public_path().'/lessions/';
				$originalFilevideo = $video->getClientOriginalName();
				//$filenamevideo=rand(111,999).strtotime(date('Y-m-d-H:isa')).$originalFilevideo;
				$filenamevideo = time() . "_org.mp4";
				$video->move($destinationPathvideo, $filenamevideo);
			}else {
				$filenamevideo=$chapter->fullvideo;
			}
			if($pdf){
				$destinationPathpdf = public_path().'/lessions/';
				$originalFilepdf = $pdf->getClientOriginalName();
				$filenamepdf=rand(111,999).strtotime(date('Y-m-d-H:isa')).$originalFilepdf;
				$pdf->move($destinationPathpdf, $filenamepdf);
			}else {
				$filenamepdf=$chapter->pdf;
			}
			
			if($video){
				if(!empty($chapter->fullvideo) && file_exists( public_path().'/lessions/'.$chapter->fullvideo )) {
					unlink( public_path().'/lessions/'.$chapter->fullvideo );
				}
				if(!empty($chapter->video_1) && file_exists( public_path().'/lessions/'.$chapter->video_1 ) && $chapter->video_1!='NA') {
					unlink( public_path().'/lessions/'.$chapter->video_1 );
				}
				if(!empty($chapter->video_2) && file_exists( public_path().'/lessions/'.$chapter->video_2 ) && $chapter->video_2!='NA') {
					unlink( public_path().'/lessions/'.$chapter->video_2 );
				}
				if(!empty($chapter->video_3) && file_exists( public_path().'/lessions/'.$chapter->video_3 ) && $chapter->video_3!='NA') {
					unlink( public_path().'/lessions/'.$chapter->video_3 );
				}
				$deleteVideoTemp = VideoTemp::where('topicId',$id)->delete();
				$chapter->video_1 = NULL;
				$chapter->video_2 = NULL;
				$chapter->video_3 = NULL;
				$chapter->processtatus = 0;
				$chapter->starttime = NULL;
				$chapter->endtime = NULL;
			}
			$chapter->courseId = $request->get('courseId');
			$chapter->lessionId = $request->get('lessionId');
			$chapter->name = $request->get('name');
			$chapter->video_thumb = $filenamethumb;
			$chapter->fullvideo = $filenamevideo;
			$chapter->pdf = $filenamepdf;
			$chapter->content = $request->get('content');
			$chapter->isFree = $request->get('free');
			$chapter->save();

			\Session::flash('msg', 'Lession Chapter Updated Successfully.');
			return redirect('/admin/lession-chapter');
		}

	}

	public function updateStatus($id,$status)
	{
		$chapter = Chapter::findOrFail($id);
		$chapter->status=$status;
		$chapter->update();

	    return redirect('/admin/lession-chapter');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Courses  $courses
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id)
	{
		$chapter = Chapter::findOrFail($id);
		$chapter->deleted=1;
		$chapter->update();

	   return redirect('/admin/lession-chapter');
	}

	public function sortUp($id,$sort_id)
	{
		$sort_id = $sort_id - 1;
		$chapter = Chapter::where("sort_id", $sort_id);
		$chapter->update(array("sort_id"=>$sort_id + 1));
		$chapter1 = Chapter::findOrFail($id);
		$chapter1->sort_id = $sort_id;
		$chapter1->save();

	   return redirect('/admin/lession-chapter');
	}

	public function sortDown($id,$sort_id)
	{
		$sort_id = $sort_id + 1;
		$chapter = Chapter::where("sort_id", $sort_id);
		$chapter->update(array("sort_id"=>$sort_id - 1));
		$chapter1 = Chapter::findOrFail($id);
		$chapter1->sort_id = $sort_id;
		$chapter1->save();

	   return redirect('/admin/lession-chapter');
	}

	public function getchapterbylession(Request $request)
	{
		$lessionId = $request->get('lessionId');

		$getChapters = Chapter::where('lessionId', $lessionId)->where('status', 1)->where('deleted', 0)->orderBy('sort_id', 'ASC')->get();
		?>
		<option>--Select--</option>
		<?php
		foreach ($getChapters as $key => $value) {
			?>
			<option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
			<?php
		}
	}

	public function convertVideo()
	{
		$data = VideoTemp::where('topicId','!=',0)->orderBy('id', 'ASC')->get();
		
		return view('admin.chapter.convertVideo', compact('data'));
	}

	public function approveVideo($id)
	{
		$videoTemp = VideoTemp::where('id',$id)->first();
		$topicId = $videoTemp->topicId;
		$low_status = $videoTemp->low_status;
		$med_status = $videoTemp->med_status;
		$high_status = $videoTemp->high_status;
		$chapter = Chapter::findOrFail($topicId);
		if ($low_status == 1) {
			$chapter->video_1 = $videoTemp->low_video;
		}
		if ($med_status == 1) {
			$chapter->video_2 = $videoTemp->med_video;
		}
		if ($high_status == 1) {
			$chapter->video_3 = $videoTemp->high_video;
		}
		$chapter->update();
		
		$delete = VideoTemp::where('id',$id)->delete();

		\Session::flash('msg', 'Converted Video Approved Successfully.');
	    return redirect('/admin/lession-chapter/convertVideo');
	}

	public function imgremove($id)
	{
		$chapter = Chapter::findOrFail($id);
		if(file_exists( public_path().'/lessions/'.$chapter->video_thumb )) {
			unlink( public_path().'/lessions/'.$chapter->video_thumb );
		}
		$chapter->video_thumb = NULL;
		$chapter->update();

		\Session::flash('msg', 'Chapter Image Removed Successfully.');
	    return redirect()->back();
	}

	public function vidremove($id)
	{
		$chapter = Chapter::findOrFail($id);
		if(!empty($chapter->fullvideo) && file_exists( public_path().'/lessions/'.$chapter->fullvideo )) {
			unlink( public_path().'/lessions/'.$chapter->fullvideo );
		}
		if(!empty($chapter->video_1) && file_exists( public_path().'/lessions/'.$chapter->video_1 ) && $chapter->video_1!='NA') {
			unlink( public_path().'/lessions/'.$chapter->video_1 );
		}
		if(!empty($chapter->video_2) && file_exists( public_path().'/lessions/'.$chapter->video_2 ) && $chapter->video_2!='NA') {
			unlink( public_path().'/lessions/'.$chapter->video_2 );
		}
		if(!empty($chapter->video_3) && file_exists( public_path().'/lessions/'.$chapter->video_3 ) && $chapter->video_3!='NA') {
			unlink( public_path().'/lessions/'.$chapter->video_3 );
		}
		$deleteVideoTemp = VideoTemp::where('topicId',$id)->delete();
		$chapter->fullvideo = NULL;
		$chapter->video_1 = NULL;
		$chapter->video_2 = NULL;
		$chapter->video_3 = NULL;
		$chapter->processtatus = 0;
		$chapter->starttime = NULL;
		$chapter->endtime = NULL;
		$chapter->update();

		\Session::flash('msg', 'Chapter Video Removed Successfully.');
	    return redirect()->back();
	}

	public function pdfremove($id)
	{
		$chapter = Chapter::findOrFail($id);
		if(file_exists( public_path().'/lessions/'.$chapter->pdf )) {
			unlink( public_path().'/lessions/'.$chapter->pdf );
		}
		$chapter->pdf = NULL;
		$chapter->update();

		\Session::flash('msg', 'Chapter PDF Removed Successfully.');
	    return redirect()->back();
	}

}
