<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Team;
use DB;

class TeamController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$data = Team::where('deleted',0)->orderBy('id', 'DESC')->get();

		return view('admin.teams.index', compact('data'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$departments = DB::table('team_departments')->orderBy('title', 'ASC')->get();
		
		return view('admin.teams.create', compact('departments'));
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
			'name' => 'required|regex:/^[\pL\s\-]+$/u',
			'position' => 'required|regex:/^[\pL\s\-]+$/u',
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
				$destinationPath = public_path().'/upload/teams/';
				$originalFile = $file->getClientOriginalName();
				$filename=strtotime(date('Y-m-d-H:isa')).$originalFile;
				$file->move($destinationPath, $filename);
			}
				
			$team = new Team();
			$team->dept_id = $request->get('dept_id');
			$team->name = $request->get('name');
			$team->position = $request->get('position');
			$team->image = $filename;
			$team->about = $request->get('content');
			$team->linkdin = $request->get('linkdin');
			$team->email_id = $request->get('email_id');
			$team->instagram = $request->get('instagram');
			$team->status = 1;
			$team->save();
			$teamId=$team->id;
			
			\Session::flash('msg', 'Team Member Added Successfully.');
			return back();
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Team  $teams
	 * @return \Illuminate\Http\Response
	 */
	public function show(Team $teams)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Team  $teams
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Team $teams, $id)
	{
		$team = Team::findOrFail($id);
		$departments = DB::table('team_departments')->orderBy('title', 'ASC')->get();

		return view('admin.teams.edit',compact('team','departments'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Team  $teams
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Team $teams, $id)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required|regex:/^[\pL\s\-]+$/u',
			'position' => 'required|regex:/^[\pL\s\-]+$/u',
			'content' => 'required',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		}else {

			$team = Team::findOrFail($id);

			$file = $request->file('image');

			if($file){
				$destinationPath = public_path().'/upload/teams/';
				$originalFile = $file->getClientOriginalName();
				$filename=strtotime(date('Y-m-d-H:isa')).$originalFile;
				$file->move($destinationPath, $filename);
			}else{
			   $filename=$team->image;  
			}
			
			$team->dept_id = $request->get('dept_id');
			$team->name = $request->get('name');
			$team->position = $request->get('position');
			$team->image = $filename;
			$team->about = $request->get('content');
			$team->linkdin = $request->get('linkdin');
			$team->email_id = $request->get('email_id');
			$team->instagram = $request->get('instagram');
			$teamId=$team->save();
			$teamId=$id;
			
			\Session::flash('msg', 'Team Member Updated Successfully.');
			return redirect('/admin/teams');
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Team  $teams
	 * @return \Illuminate\Http\Response
	 */
	 public function delete($id)
	{
		$team = Team::findOrFail($id);
		$team->deleted=1;
		$team->update();

	   return redirect('/admin/teams');
	}

	public function updateStatus($id,$status)
	{
		//echo "string";die;
		$team = Team::findOrFail($id);
		$team->status=$status;
		$team->update();

	   return redirect('/admin/teams');
	}

}