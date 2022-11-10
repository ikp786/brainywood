<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Courses;
use App\Lession;
use App\Quiz;
use App\Quizoption;
use App\Quizquestions;


class QuizController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		if(!empty($request->course) && !empty($request->lession) && ($request->lession!='--Select--') && !empty($request->from) && !empty($request->to) ){
			$data = Quiz::With('courses','lession')->where('courseId',$request->course)->where('lessionId',$request->lession)->whereBetween("created_at",[$request->from, $request->to.' 23:59:59'])->where('deleted',0)->orderBy('id','DESC')->get();
		}elseif(!empty($request->course) && !empty($request->lession) && ($request->lession!='--Select--') && !empty($request->from) ){
			$to = date('Y-m-d H:i:s');
			$data = Quiz::With('courses','lession')->where('courseId',$request->course)->where('lessionId',$request->lession)->whereBetween("created_at",[$request->from, $to])->where('deleted',0)->orderBy('id','DESC')->get();
		}elseif(!empty($request->lession) && ($request->lession!='--Select--') && !empty($request->from) && !empty($request->to) ){
			$data = Quiz::With('courses','lession')->where('lessionId',$request->lession)->whereBetween("created_at",[$request->from, $request->to.' 23:59:59'])->where('deleted',0)->orderBy('id','DESC')->get();
		}elseif(!empty($request->course) && !empty($request->lession) && ($request->lession!='--Select--') ){
			$data = Quiz::With('courses','lession')->where('courseId',$request->course)->where('lessionId',$request->lession)->where('deleted',0)->orderBy('id','DESC')->get();
		}elseif(!empty($request->lession) && ($request->lession!='--Select--') ){
			$data = Quiz::With('courses','lession')->where('lessionId',$request->lession)->where('deleted',0)->orderBy('id','DESC')->get();
		}elseif(!empty($request->course) || ($request->lession=='--Select--') ){
			$data = Quiz::With('courses','lession')->where('courseId',$request->course)->where('deleted',0)->orderBy('id','DESC')->get();
		}elseif(!empty($request->from) && !empty($request->to) ){
			$data = Quiz::With('courses','lession')->whereBetween("created_at",[$request->from, $request->to.' 23:59:59'])->where('deleted',0)->orderBy('id','DESC')->get();
		}elseif(!empty($request->from) ){
			$to = date('Y-m-d H:i:s');
			$data = Quiz::With('courses','lession')->whereBetween("created_at",[$request->from, $to])->where('deleted',0)->orderBy('id','DESC')->get();
		}else{
			$data = Quiz::With('courses','lession')->Where('deleted',0)->orderBy('id','DESC')->get();
		}
		$courses = Courses::where('deleted',0)->orderBy('sort_id', 'ASC')->get();
		$lessions = Lession::where('deleted', 0)->orderBy('sort_id', 'ASC')->get();
		/*echo "<pre>";
		print_r($data);die;*/
		return view('admin.quiz.index', compact('data','courses','lessions'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$courses = Courses::Where('deleted',0)->orderBy('sort_id','ASC')->get();
		return view('admin.quiz.create',compact('courses'));
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
			'type' => 'required',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		}else {

			$name = $request->get('name');
			$type = $request->get('type');
			$courseId = $request->get('courseId');
			$lessionId = $request->get('lessionId');
			if($lessionId=='--Select--')
			{
				$lessionId=0;
			}
			if($type==0){
				$checkQuiz = Quiz::where('lessionId',$lessionId)->where('islession',0)->where('deleted',0)->first();
				if(!empty($checkQuiz)){
					\Session::flash('error', 'Quiz already exists for this lession!');
					return back();
				}
			}else{
				$checkQuiz = Quiz::where('courseId',$courseId)->where('islession',1)->where('deleted',0)->first();
				if(!empty($checkQuiz)){
					\Session::flash('error', 'Quiz already exists for this course!');
					return back();
				}
			}
			if($request->get('hours')==00){
				if($request->get('minutes')==00){
					\Session::flash('error', 'Quiz minimum time should be required!');
					return back();
				}
			}
			$duration = $request->get('hours').':'.$request->get('minutes').':00';
			$guideline = $request->get('guideline');
			$passing_percent = $request->get('passing_percent');
			$question = $request->get('question');
			$option1 = $request->get('option');
			$Currectoption = $request->get('Currectoption');
			$marks = $request->get('marks');
			$solution = $request->get('solution');
			$file = $request->file('image');
			$optionfile = $request->file('option');

			$QuizId=0;
			$Quiz = new Quiz();
			$Quiz->name = $name;
			$Quiz->islession = $type;
			$Quiz->courseId = $courseId;
			$Quiz->lessionId = $lessionId;
			$Quiz->duration = $duration;
			$Quiz->guideline = $guideline;
			$Quiz->passing_percent = $passing_percent;
			$Quiz->status = 0;
			$Quiz->save();
			$QuizId = $Quiz->id;
			
			
			for ($i=0; $i <count($question); $i++) {
				//image exist
				if(isset($file[$i])){
					$destinationPath = public_path().'/upload/quizquestions/';
					$originalFile = $file[$i]->getClientOriginalName();
					$filename = strtotime(date('Y-m-d-H:isa')).$originalFile;
					$file[$i]->move($destinationPath, $filename);
				}else{
					$filename = NULL;
				}

				$Quizquestions = new Quizquestions();
				$Quizquestions->quizId = $QuizId;
				$Quizquestions->questions = $question[$i];
				$Quizquestions->image = $filename;
				$Quizquestions->currect_option = $Currectoption[$i][0];
				$Quizquestions->marking = $marks[$i];
				$Quizquestions->solution = $solution[$i];
				$Quizquestions->save();
				$QuizQuestionId=$Quizquestions->id;

				if(isset($optionfile[$i])){
					for ($j=0; $j <count($optionfile[$i]); $j++) {
						//echo '<pre />'; print_r($optionfile[$i]); die;
						if(isset($optionfile[$i][$j])){
							$destinationPath = public_path().'/upload/quizquestions/';
							$optionoriginalFile = $optionfile[$i][$j]->getClientOriginalName();
							$optionfilename = strtotime(date('Y-m-d-H:isa')).$optionoriginalFile;
							$optionfile[$i][$j]->move($destinationPath, $optionfilename);
						}else{
							$optionfilename = NULL;
						}
						
						$Quizoption = new Quizoption();
						$Quizoption->questionId=$QuizQuestionId;
						$Quizoption->quizoption=$optionfilename;
						$Quizoption->val_type=0;
						$Quizoption->save();
					}
				}else{
					for ($j=0; $j <count($option1[$i]) ; $j++) { 
						// print_r($option1[$i]);
						if($option1[$i][$j]!=''){
							$Quizoption = new Quizoption();
							$Quizoption->questionId = $QuizQuestionId;
							$Quizoption->quizoption = $option1[$i][$j];
							$Quizoption->val_type = 1;
							$Quizoption->save();
						}
					}
				}
			}

			\Session::flash('msg', 'Quiz Added Successfully.');
			return back();
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Quiz  $quizes
	 * @return \Illuminate\Http\Response
	 */
	public function show(Quiz $quizes)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Quiz $quizes
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Quiz $quizes, $id)
	{
		$quiz = Quiz::findOrFail($id);
		$course = Courses::Where('deleted',0)->get();
		$lession  = Lession::where('courseId',$quiz->courseId)->where('deleted',0)->get();
		$Quizquestions = Quizquestions::where('quizId',$id)->get();
		$Response=array();
		foreach ($Quizquestions as $key => $value) {
			$Response[$key]['id']=$value->id;
			$Response[$key]['name']=$value->questions;
			$Response[$key]['image']=$value->image;
			$Response[$key]['currect_option']=$value->currect_option;
			$Response[$key]['marking']=$value->marking;
			$Response[$key]['solution']=$value->solution;
			$Quizoption = Quizoption::where('questionId',$value->id)->get();
			foreach ($Quizoption as $key1 => $value) {
				$Response[$key]['options'][$key1]['id']=$value->id;
				$Response[$key]['options'][$key1]['name']=$value->quizoption;
				$Response[$key]['options'][$key1]['val_type']=$value->val_type;
			}
		}

		return view('admin.quiz.edit',compact('course','lession','Response','quiz'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Quiz  $quizes
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Quiz $quizes, $id)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'type' => 'required',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		} else {
			//echo "<pre>"; print_r($request->all()); die;
			$Quiz = Quiz::findOrFail($id);

			$name = $request->get('name');
			$type = $request->get('type');
			$courseId = $request->get('courseId');
			$lessionId = $request->get('lessionId');
			if($lessionId=='--Select--')
			{
				$lessionId=0;
			}
			if($request->get('hours')==00){
				if($request->get('minutes')==00){
					\Session::flash('error', 'Quiz minimum time should be required!');
					return back();
				}
			}
			$duration = $request->get('hours').':'.$request->get('minutes').':00';
			$guideline = $request->get('guideline');
			$passing_percent = $request->get('passing_percent');
			$question = $request->get('question');
			$option1 = $request->get('option');
			$optionId = $request->get('optionId');
			$questionId = $request->get('questionId');
			$Currectoption = $request->get('Currectoption');
			$marks = $request->get('marks');
			$solution = $request->get('solution');
			$file = $request->file('image');
			$optionfile = $request->file('option');
			
			$QuizId = 0;
			$Quiz->name = $name;
			$Quiz->islession = $type;
			$Quiz->courseId = $courseId;
			$Quiz->lessionId = $lessionId;
			$Quiz->duration = $duration;
			$Quiz->guideline = $guideline;
			$Quiz->passing_percent = $passing_percent;
			$Quiz->save();
			$QuizId = $id;
			
			//echo "<pre>"; print_r($request->all()); die;
			
			for ($i=0; $i <count($question); $i++) {
				if(isset($questionId[$i]))
				{
					$Quizquestions=Quizquestions::find($questionId[$i]);
				}else{
					$Quizquestions=new Quizquestions();
				}

				//check question image exists
				if(isset($file[$i])){
					$destinationPath = public_path().'/upload/quizquestions/';
					$originalFile = $file[$i]->getClientOriginalName();
					$filename = strtotime(date('Y-m-d-H:isa')).$originalFile;
					$file[$i]->move($destinationPath, $filename);
				}else{
					$filename = $Quizquestions->image;
				}
			   
				$Quizquestions->quizId = $QuizId;
				$Quizquestions->questions = $question[$i];
				$Quizquestions->image = $filename;
				$Quizquestions->currect_option = isset($Currectoption[$i][0]) ? $Currectoption[$i][0] : '';
				$Quizquestions->marking = $marks[$i];
				$Quizquestions->solution = $solution[$i];
				$Quizquestions->save();
				$QuizQuestionId = $Quizquestions->id;
				
				if(isset($optionfile[$i])){
					for ($j=0; $j <count($optionfile[$i]); $j++) {
					    if (!empty($optionfile[$i][$j])) {
							$destinationPath = public_path().'/upload/quizquestions/';
							$optionoriginalFile = $optionfile[$i][$j]->getClientOriginalName();
							$optionfilename = strtotime(date('Y-m-d-H:isa')).$optionoriginalFile;
							$optionfile[$i][$j]->move($destinationPath, $optionfilename);

							if(isset($questionId[$i]) && isset($optionId[$i][$j]))
							{
								$Quizoption=Quizoption::find($optionId[$i][$j]);
							}else{
								$Quizoption=new Quizoption();
							}
							
							$Quizoption->questionId=$QuizQuestionId;
							$Quizoption->quizoption=$optionfilename;
							$Quizoption->val_type=0;
							$Quizoption->save();
						}
					}
				}else{
					if(isset($option1[$i])){
						for ($j=0; $j <count($option1[$i]); $j++) { 
						    if (!empty($option1[$i][$j])) {
								if(isset($questionId[$i]) && isset($optionId[$i][$j]))
								{
									$Quizoption=Quizoption::find($optionId[$i][$j]);
								}else{
									$Quizoption=new Quizoption();
								}

								$supported_image = array('gif', 'jpg', 'jpeg', 'png', 'webp');
								$src_file_name = $option1[$i][$j];
								$ext = strtolower(pathinfo($src_file_name, PATHINFO_EXTENSION)); // Using strtolower to overcome case sensitive
								if (in_array($ext, $supported_image)) {
									$val_type = 0;
								} else {
									$val_type = 1;
								}
						    	
						    	$Quizoption->questionId=$QuizQuestionId;
								$Quizoption->quizoption=$option1[$i][$j];
								$Quizoption->val_type=$val_type;
								$Quizoption->save();
							}
						}
					}
				}
			}
			
			\Session::flash('msg', 'Quiz updated Successfully.');
			return redirect('/admin/quizs');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Quiz  $quizes
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id)
	{
		$user = Quiz::findOrFail($id);
		$user->deleted=1;
		$user->update();

		return redirect('/admin/quizs');
	}

	public function updateStatus($id,$status)
	{
		$user = Quiz::findOrFail($id);
		$user->status=$status;
		$user->update();

		return redirect('/admin/quizs');
	}
	
	public function deleteOption(Request $request)
	{
		$id=$request->get('id');
		$user = Quizquestions::where('id',$id)->delete();
		echo 1;
	}
	
}