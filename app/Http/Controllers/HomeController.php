<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Null_;
use App\Contactus;
use App\CourseRequest;
use App\Courses;
use App\Lession;
use App\LiveClass;
use App\Popularvideo;
use App\QuestionAsk;
use App\Quiz;
use App\User;
use App\UserSubscription;


class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$courses_pending = CourseRequest::whereNull('builderId')->latest()->get();
		$courses_active = CourseRequest::whereNotNull('builderId')->latest()->get();

		$totalTeachers = User::where("role_id",2)->where("status",1)->where("deleted",0)->count();
		$totalStudents = User::where("role_id",3)->where("status",1)->where("deleted",0)->count();
		$totalCourses = Courses::where("status",1)->where("deleted",0)->count();
		$totalLessions = Lession::where("status",1)->where("deleted",0)->count();
		$totalQuizes = Quiz::where("status",1)->where("deleted",0)->count();
		$totalLiveClasses = LiveClass::where("status",1)->where("deleted",0)->count();
		$totalPopularvideos = Popularvideo::where("status",1)->where("deleted",0)->count();
		$totalQuestionAsks = QuestionAsk::where("status",1)->where("deleted",0)->count();
		$totalContactus = Contactus::count();
		$totalUserSubscriptions = UserSubscription::count();


		return view('home',compact('courses_pending','courses_active','totalTeachers','totalStudents','totalCourses','totalLessions','totalQuizes','totalLiveClasses','totalPopularvideos','totalQuestionAsks','totalContactus','totalUserSubscriptions'));
	}
}
