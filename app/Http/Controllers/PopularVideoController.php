<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Popularvideo;
use App\VideoTemp;


class PopularVideoController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$data = Popularvideo::where('deleted',0)->orderBy('sort_id', 'ASC')->get();

		return view('admin.popularvideos.index', compact('data'));
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('admin.popularvideos.create');
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
				$destinationPath = public_path().'/upload/popularvideos/';
				$originalFile = $file->getClientOriginalName();
				$filenamevideo_thumb = rand(111,999).strtotime(date('Y-m-d-H:isa')).$originalFile;
				$file->move($destinationPath, $filenamevideo_thumb);
			}else{
				$filenamevideo_thumb = $popularvideo->video_thumb;  
			}

			$video = $request->file('video');
			if($video){
				$destinationPath = public_path().'/upload/popularvideos/';
				$originalFile = $video->getClientOriginalName();
				//$filenamevideo=strtotime(date('Y-m-d H:isa')).$originalFile;
				$filenamevideo = time() . "_org.mp4";
				$video->move($destinationPath, $filenamevideo);
			}
			
			$popularvideo = new Popularvideo();
			$popularvideo->name = $request->get('name');
			$popularvideo->video_thumb = $filenamevideo_thumb;
			$popularvideo->video = $filenamevideo;
			$popularvideo->paid = ($request->get('paid')) ? $request->get('paid') : 0;
			$popularvideo->status = 1;
			$popularvideo->save();
			$popularvideoId = $popularvideo->id;
			if($popularvideoId){
				$popular = Popularvideo::findOrFail($popularvideoId);
				$popular->sort_id = $popularvideoId;
				$popular->save();
			}

			\Session::flash('msg', 'Popular Video Added Successfully.');
			return back();
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Popularvideo $popularvideos
	 * @return \Illuminate\Http\Response
	 */
	public function show(Popularvideo $popularvideos)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Popularvideo $popularvideos
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Popularvideo $popularvideos, $id)
	{
		$data = Popularvideo::findOrFail($id);

		return view('admin.popularvideos.edit',compact('data'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Popularvideo $popularvideos
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Popularvideo $popularvideos, $id)
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
			$popularvideo = Popularvideo::findOrFail($id);

			$file = $request->file('image');
			if($file){
				$destinationPath = public_path().'/upload/popularvideos/';
				$originalFile = $file->getClientOriginalName();
				$filenamevideo_thumb = rand(111,999).strtotime(date('Y-m-d-H:isa')).$originalFile;
				$file->move($destinationPath, $filenamevideo_thumb);
			}else{
				$filenamevideo_thumb = $popularvideo->video_thumb;  
			}

			$video = $request->file('video');
			if($video){
				$destinationPathvideo = public_path().'/upload/popularvideos/';
				$originalFilevideo = $video->getClientOriginalName();
				//$filenamevideo=rand(111,999).strtotime(date('Y-m-d-H:isa')).$originalFilevideo;
				$filenamevideo = time() . "_org.mp4";
				$video->move($destinationPathvideo, $filenamevideo);
			}else{
				$filenamevideo=$popularvideo->video;  
			}

			if($video){
				if(!empty($popularvideo->video) && file_exists( public_path().'/upload/popularvideos/'.$popularvideo->video )) {
					unlink( public_path().'/upload/popularvideos/'.$popularvideo->video );
				}
				if(!empty($popularvideo->video_1) && file_exists( public_path().'/upload/popularvideos/'.$popularvideo->video_1 ) && $popularvideo->video_1!='NA') {
					unlink( public_path().'/upload/popularvideos/'.$popularvideo->video_1 );
				}
				if(!empty($popularvideo->video_2) && file_exists( public_path().'/upload/popularvideos/'.$popularvideo->video_2 ) && $popularvideo->video_2!='NA') {
					unlink( public_path().'/upload/popularvideos/'.$popularvideo->video_2 );
				}
				if(!empty($popularvideo->video_3) && file_exists( public_path().'/upload/popularvideos/'.$popularvideo->video_3 ) && $popularvideo->video_3!='NA') {
					unlink( public_path().'/upload/popularvideos/'.$popularvideo->video_3 );
				}
				$deleteVideoTemp = VideoTemp::where('popularvideoId',$id)->delete();
				$popularvideo->video_1 = NULL;
				$popularvideo->video_2 = NULL;
				$popularvideo->video_3 = NULL;
				$popularvideo->processtatus = 0;
				$popularvideo->starttime = NULL;
				$popularvideo->endtime = NULL;
			}
			$popularvideo->name = $request->get('name');
			$popularvideo->video_thumb = $filenamevideo_thumb;
			$popularvideo->video = $filenamevideo;
			$popularvideo->paid = ($request->get('paid')) ? $request->get('paid') : 0;
			$popularvideo->save();
			$popularvideoId = $popularvideo->id;

			\Session::flash('msg', 'Popular Video Updated Successfully.');
			return redirect('/admin/popularvideos');
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Popularvideo
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id)
	{
		$popularvideo = Popularvideo::findOrFail($id);
		$popularvideo->deleted=1;
		$popularvideo->update();

		return redirect('/admin/popularvideos');
	}

	public function updateStatus($id,$status)
	{
		$popularvideo = Popularvideo::findOrFail($id);
		$popularvideo->status=$status;
		$popularvideo->update();

		return redirect('/admin/popularvideos');
	}

	public function sortUp($id,$sort_id)
	{
		$sort_id = $sort_id - 1;
		$popularvideo = Popularvideo::where("sort_id", $sort_id);
		//$popularvideo->sort_id = $sort_id + 1;
		$popularvideo->update(array("sort_id"=>$sort_id + 1));
		$popularvideo1 = Popularvideo::findOrFail($id);
		$popularvideo1->sort_id = $sort_id;
		$popularvideo1->save();

	   return redirect('/admin/popularvideos');
	}

	public function sortDown($id,$sort_id)
	{
		$sort_id = $sort_id + 1;
		$popularvideo = Popularvideo::where("sort_id", $sort_id);
		//$popularvideo->sort_id = $sort_id - 1;
		$popularvideo->update(array("sort_id"=>$sort_id - 1));
		$popularvideo1 = Popularvideo::findOrFail($id);
		$popularvideo1->sort_id = $sort_id;
		$popularvideo1->save();

	   return redirect('/admin/popularvideos');
	}

	public function convertVideo()
	{
		$data = VideoTemp::where('popularvideoId','!=',0)->orderBy('id', 'ASC')->get();
		
		return view('admin.popularvideos.convertVideo', compact('data'));
	}

	public function approveVideo($id)
	{
		$videoTemp = VideoTemp::where('id',$id)->first();
		$popularvideoId = $videoTemp->popularvideoId;
		$low_status = $videoTemp->low_status;
		$med_status = $videoTemp->med_status;
		$high_status = $videoTemp->high_status;
		$popularVideo = Popularvideo::findOrFail($popularvideoId);
		if ($low_status == 1) {
			$popularVideo->video_1 = $videoTemp->low_video;
		}
		if ($med_status == 1) {
			$popularVideo->video_2 = $videoTemp->med_video;
		}
		if ($high_status == 1) {
			$popularVideo->video_3 = $videoTemp->high_video;
		}
		$popularVideo->update();
		
		$delete = VideoTemp::where('id',$id)->delete();

		\Session::flash('msg', 'Converted Video Approved Successfully.');
	    return redirect('/admin/popularvideos/convertVideo');
	}

	public function imgremove($id)
	{
		$popularvideo = Popularvideo::findOrFail($id);
		if(file_exists( public_path().'/upload/popularvideos/'.$popularvideo->video_thumb )) {
			unlink( public_path().'/upload/popularvideos/'.$popularvideo->video_thumb );
		}
		$popularvideo->video_thumb = NULL;
		$popularvideo->update();

		\Session::flash('msg', 'Popularvideo Image Removed Successfully.');
	    return redirect()->back();
	}

	public function vidremove($id)
	{
		$popularvideo = Popularvideo::findOrFail($id);
		if(!empty($popularvideo->video) && file_exists( public_path().'/upload/popularvideos/'.$popularvideo->video )) {
			unlink( public_path().'/upload/popularvideos/'.$popularvideo->video );
		}
		if(!empty($popularvideo->video_1) && file_exists( public_path().'/upload/popularvideos/'.$popularvideo->video_1 ) && $popularvideo->video_1!='NA') {
			unlink( public_path().'/upload/popularvideos/'.$popularvideo->video_1 );
		}
		if(!empty($popularvideo->video_2) && file_exists( public_path().'/upload/popularvideos/'.$popularvideo->video_2 ) && $popularvideo->video_2!='NA') {
			unlink( public_path().'/upload/popularvideos/'.$popularvideo->video_2 );
		}
		if(!empty($popularvideo->video_3) && file_exists( public_path().'/upload/popularvideos/'.$popularvideo->video_3 ) && $popularvideo->video_3!='NA') {
			unlink( public_path().'/upload/popularvideos/'.$popularvideo->video_3 );
		}
		$deleteVideoTemp = VideoTemp::where('popularvideoId',$id)->delete();
		$popularvideo->video = NULL;
		$popularvideo->video_1 = NULL;
		$popularvideo->video_2 = NULL;
		$popularvideo->video_3 = NULL;
		$popularvideo->processtatus = 0;
		$popularvideo->starttime = NULL;
		$popularvideo->endtime = NULL;
		$popularvideo->update();

		\Session::flash('msg', 'Popularvideo Video Removed Successfully.');
	    return redirect()->back();
	}

}
