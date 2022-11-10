<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\StudentClass;


class StudentClassController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$data = StudentClass::where('deleted',0)->orderBy('id', 'ASC')->get();

		return view('admin.student_classes.index', compact('data'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('admin.student_classes.create');
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
			'class_name' => 'required',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		}else { 
			//print_r($request->all());die;
			
			$stClass = new StudentClass();
			$stClass->class_name = $request->get('class_name');
			$stClass->status = 1;
			$stClass->save();
			$stClassId=$stClass->id;
			
			\Session::flash('msg', 'Student Class Added Successfully.');
			return back();
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\StudentClass $student_classes
	 * @return \Illuminate\Http\Response
	 */
	public function show(StudentClass $student_classes)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\StudentClass $student_classes
	 * @return \Illuminate\Http\Response
	 */
	public function edit(StudentClass $student_classes, $id)
	{
		$stClass = StudentClass::findOrFail($id);

		return view('admin.student_classes.edit',compact('stClass'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\StudentClass $student_classes
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, StudentClass $student_classes, $id)
	{
		$validator = Validator::make($request->all(), [
			'class_name' => 'required',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		}else {
			$stClass = StudentClass::findOrFail($id);
			$stClass->class_name = $request->get('class_name');
			$stClass->status = 1;
			$stClass->save();
			$stClassId=$id;
			
			\Session::flash('msg', 'Student Class Updated Successfully.');
			return redirect('/admin/classes');
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\StudentClass $student_classes
	 * @return \Illuminate\Http\Response
	 */
	 public function delete($id)
	{
		$stClass = StudentClass::findOrFail($id);
		$stClass->deleted=1;
		$stClass->update();

	   return redirect('/admin/classes');
	}

	public function updateStatus($id,$status)
	{
		//echo "string";die;
		$stClass = StudentClass::findOrFail($id);
		$stClass->status=$status;
		$stClass->update();

	   return redirect('/admin/classes');
	}

}