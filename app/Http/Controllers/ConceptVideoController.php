<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Conceptvideo;
use App\VideoTemp;


class ConceptVideoController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$data = Conceptvideo::where('deleted',0)->orderBy('sort_id', 'ASC')->get();

		return view('admin.conceptvideos.index', compact('data'));
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('admin.conceptvideos.create');
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
			'image' => 'required',
			'video' => 'required|mimes:mp4',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		}else { 
			//echo '<pre />'; print_r($request->all()); die;

			$file = $request->file('image');
			if($file){
				$destinationPath = public_path().'/upload/conceptvideos/';
				$originalFile = $file->getClientOriginalName();
				$filenamevideo_thumb = rand(111,999).strtotime(date('Y-m-d-H:isa')).$originalFile;
				$file->move($destinationPath, $filenamevideo_thumb);
			}

			$video = $request->file('video');
			if($video){
				$destinationPath = public_path().'/upload/conceptvideos/';
				$originalFile = $video->getClientOriginalName();
				//$filenamevideo=strtotime(date('Y-m-d H:isa')).$originalFile;
				$filenamevideo = time() . "_org.mp4";
				$video->move($destinationPath, $filenamevideo);
			}
			
			$conceptvideo = new Conceptvideo();
			$conceptvideo->name = $request->get('name');
			$conceptvideo->video_thumb = $filenamevideo_thumb;
			$conceptvideo->video = $filenamevideo;
			$conceptvideo->paid = ($request->get('paid')) ? $request->get('paid') : 0;
			$conceptvideo->status = 1;
			$conceptvideo->save();
			$conceptvideoId = $conceptvideo->id;
			if($conceptvideoId){
				$concept = Conceptvideo::findOrFail($conceptvideoId);
				$concept->sort_id = $conceptvideoId;
				$concept->save();
			}

			\Session::flash('msg', 'Concept Video Added Successfully.');
			return back();
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Conceptvideo $conceptvideos
	 * @return \Illuminate\Http\Response
	 */
	public function show(Conceptvideo $conceptvideos)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Conceptvideo $conceptvideos
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Conceptvideo $conceptvideos, $id)
	{
		$data = Conceptvideo::findOrFail($id);

		return view('admin.conceptvideos.edit',compact('data'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Conceptvideo $conceptvideos
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Conceptvideo $conceptvideos, $id)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			//'image' => 'required',
			'video' => 'mimes:mp4',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		} else {
			//echo '<pre />'; print_r($request->all()); die;
			$conceptvideo = Conceptvideo::findOrFail($id);

			$file = $request->file('image');
			if($file){
				$destinationPath = public_path().'/upload/conceptvideos/';
				$originalFile = $file->getClientOriginalName();
				$filenamevideo_thumb = rand(111,999).strtotime(date('Y-m-d-H:isa')).$originalFile;
				$file->move($destinationPath, $filenamevideo_thumb);
			}else{
				$filenamevideo_thumb = $conceptvideo->video_thumb;  
			}

			$video = $request->file('video');
			if($video){
				$destinationPathvideo = public_path().'/upload/conceptvideos/';
				$originalFilevideo = $video->getClientOriginalName();
				//$filenamevideo=rand(111,999).strtotime(date('Y-m-d-H:isa')).$originalFilevideo;
				$filenamevideo = time() . "_org.mp4";
				$video->move($destinationPathvideo, $filenamevideo);
			}else{
				$filenamevideo=$conceptvideo->video;  
			}

			if($video){
				if(!empty($conceptvideo->video) && file_exists( public_path().'/upload/conceptvideos/'.$conceptvideo->video )) {
					unlink( public_path().'/upload/conceptvideos/'.$conceptvideo->video );
				}
				if(!empty($conceptvideo->video_1) && file_exists( public_path().'/upload/conceptvideos/'.$conceptvideo->video_1 ) && $conceptvideo->video_1!='NA') {
					unlink( public_path().'/upload/conceptvideos/'.$conceptvideo->video_1 );
				}
				if(!empty($conceptvideo->video_2) && file_exists( public_path().'/upload/conceptvideos/'.$conceptvideo->video_2 ) && $conceptvideo->video_2!='NA') {
					unlink( public_path().'/upload/conceptvideos/'.$conceptvideo->video_2 );
				}
				if(!empty($conceptvideo->video_3) && file_exists( public_path().'/upload/conceptvideos/'.$conceptvideo->video_3 ) && $conceptvideo->video_3!='NA') {
					unlink( public_path().'/upload/conceptvideos/'.$conceptvideo->video_3 );
				}
				//$deleteVideoTemp = VideoTemp::where('conceptvideoId',$id)->delete();
				$conceptvideo->video_1 = NULL;
				$conceptvideo->video_2 = NULL;
				$conceptvideo->video_3 = NULL;
				$conceptvideo->processtatus = 0;
				$conceptvideo->starttime = NULL;
				$conceptvideo->endtime = NULL;
			}
			$conceptvideo->name = $request->get('name');
			$conceptvideo->video_thumb = $filenamevideo_thumb;
			$conceptvideo->video = $filenamevideo;
			$conceptvideo->paid = ($request->get('paid')) ? $request->get('paid') : 0;
			$conceptvideo->save();
			$conceptvideoId = $conceptvideo->id;

			\Session::flash('msg', 'Concept Video Updated Successfully.');
			return redirect('/admin/conceptvideos');
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Conceptvideo
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id)
	{
		$conceptvideo = Conceptvideo::findOrFail($id);
		$conceptvideo->deleted=1;
		$conceptvideo->update();

		return redirect('/admin/conceptvideos');
	}

	public function updateStatus($id,$status)
	{
		$conceptvideo = Conceptvideo::findOrFail($id);
		$conceptvideo->status=$status;
		$conceptvideo->update();

		return redirect('/admin/conceptvideos');
	}

	public function sortUp($id,$sort_id)
	{
		$sort_id = $sort_id - 1;
		$conceptvideo = Conceptvideo::where("sort_id", $sort_id);
		//$conceptvideo->sort_id = $sort_id + 1;
		$conceptvideo->update(array("sort_id"=>$sort_id + 1));
		$conceptvideo1 = Conceptvideo::findOrFail($id);
		$conceptvideo1->sort_id = $sort_id;
		$conceptvideo1->save();

	   return redirect('/admin/conceptvideos');
	}

	public function sortDown($id,$sort_id)
	{
		$sort_id = $sort_id + 1;
		$conceptvideo = Conceptvideo::where("sort_id", $sort_id);
		//$conceptvideo->sort_id = $sort_id - 1;
		$conceptvideo->update(array("sort_id"=>$sort_id - 1));
		$conceptvideo1 = Conceptvideo::findOrFail($id);
		$conceptvideo1->sort_id = $sort_id;
		$conceptvideo1->save();

	   return redirect('/admin/conceptvideos');
	}

	public function convertVideo()
	{
		$data = VideoTemp::where('conceptvideoId','!=',0)->orderBy('id', 'ASC')->get();
		
		return view('admin.conceptvideos.convertVideo', compact('data'));
	}

	public function approveVideo($id)
	{
		$videoTemp = VideoTemp::where('id',$id)->first();
		$conceptvideoId = $videoTemp->conceptvideoId;
		$low_status = $videoTemp->low_status;
		$med_status = $videoTemp->med_status;
		$high_status = $videoTemp->high_status;
		$conceptvideo = Conceptvideo::findOrFail($conceptvideoId);
		if ($low_status == 1) {
			$conceptvideo->video_1 = $videoTemp->low_video;
		}
		if ($med_status == 1) {
			$conceptvideo->video_2 = $videoTemp->med_video;
		}
		if ($high_status == 1) {
			$conceptvideo->video_3 = $videoTemp->high_video;
		}
		$conceptvideo->update();
		
		$delete = VideoTemp::where('id',$id)->delete();

		\Session::flash('msg', 'Converted Video Approved Successfully.');
	    return redirect('/admin/conceptvideos/convertVideo');
	}

	public function imgremove($id)
	{
		$conceptvideo = Conceptvideo::findOrFail($id);
		if(file_exists( public_path().'/upload/conceptvideos/'.$conceptvideo->video_thumb )) {
			unlink( public_path().'/upload/conceptvideos/'.$conceptvideo->video_thumb );
		}
		$conceptvideo->video_thumb = NULL;
		$conceptvideo->update();

		\Session::flash('msg', 'Conceptvideo Image Removed Successfully.');
	    return redirect()->back();
	}

	public function vidremove($id)
	{
		$conceptvideo = Conceptvideo::findOrFail($id);
		if(!empty($conceptvideo->video) && file_exists( public_path().'/upload/conceptvideos/'.$conceptvideo->video )) {
			unlink( public_path().'/upload/conceptvideos/'.$conceptvideo->video );
		}
		if(!empty($conceptvideo->video_1) && file_exists( public_path().'/upload/conceptvideos/'.$conceptvideo->video_1 ) && $conceptvideo->video_1!='NA') {
			unlink( public_path().'/upload/conceptvideos/'.$conceptvideo->video_1 );
		}
		if(!empty($conceptvideo->video_2) && file_exists( public_path().'/upload/conceptvideos/'.$conceptvideo->video_2 ) && $conceptvideo->video_2!='NA') {
			unlink( public_path().'/upload/conceptvideos/'.$conceptvideo->video_2 );
		}
		if(!empty($conceptvideo->video_3) && file_exists( public_path().'/upload/conceptvideos/'.$conceptvideo->video_3 ) && $conceptvideo->video_3!='NA') {
			unlink( public_path().'/upload/conceptvideos/'.$conceptvideo->video_3 );
		}
		//$deleteVideoTemp = VideoTemp::where('conceptvideoId',$id)->delete();
		$conceptvideo->video = NULL;
		$conceptvideo->video_1 = NULL;
		$conceptvideo->video_2 = NULL;
		$conceptvideo->video_3 = NULL;
		$conceptvideo->processtatus = 0;
		$conceptvideo->starttime = NULL;
		$conceptvideo->endtime = NULL;
		$conceptvideo->update();

		\Session::flash('msg', 'Concept Video Removed Successfully.');
	    return redirect()->back();
	}

}
