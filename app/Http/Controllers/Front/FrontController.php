<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\AboutUs;
use App\Blog;
use App\Chapter;
use App\Conceptvideo;
use App\Contactus;
use App\ContinueStudy;
use App\CouponCode;
use App\Coursefeature;
use App\Coursefeq;
use App\Courses;
use App\Enquiry;
use App\Lession;
use App\LiveClass;
use App\LiveclassNotify;
use App\Notification;
use App\Page;
use App\Popularvideo;
use App\Portfolio;
use App\QuestionAnswer;
use App\QuestionAnswerLike;
use App\QuestionAsk;
use App\Quiz;
use App\Quizoption;
use App\Quizquestions;
use App\RatingMessage;
use App\RatingType;
use App\RatingUser;
use App\State;
use App\StudentClass;
use App\StudentExam;
use App\StudentExamAnswer;
use App\Subscription;
use App\Team;
use App\Testimonial;
use App\User;
use App\UserSubscription;
use App\VideoTemp;
use Image;
use DateTime;
date_default_timezone_set('Asia/Kolkata');
use DB;
use PDF;
use Carbon\Carbon;
include public_path().'/razorpay-php/Razorpay.php';
use Razorpay\Api\Api;


class FrontController extends Controller
{
	public function index()
	{
		//$this->smsWithTemplate('9887470545', 'LiveClassStarting', 'username', 'subject', 'xyz', '10 minutes');
		//$this->sendEmail('rajendrakataria43@gmail.com', 'Testing', $data = array('userName' => 'Rajendra', 'message' => 'Thank you for signing up to.  <br> <br> <a href=\"' . url('signin') . '\" style=\'background-color: #272b34; color: #fff;padding: 10px;\'> Sign in to your account </a> <br><br> Helping you be your best '));
		$pagename = "Home";
		$user = Auth::user();
		//dd($user);
		$userId = !empty($user) ? $user->id : 0;
		$today	= date('Y-m-d');
		$subscription = UserSubscription::where("user_id", $userId)->where("end_date", ">=", $today)->orderBy('id', 'DESC')->first();
		$userSubscription = !empty($subscription) ? 1 : 0;
		$studentClasses = StudentClass::where('status',1)->where('deleted',0)->orderBy('id', 'ASC')->get();
		$conceptvideos = Conceptvideo::where("status", 1)->where('deleted', 0)->orderBy('sort_id', 'ASC')->limit(6)->get();
		$relates = DB::table('testimonial_relates')->orderBy('id', 'ASC')->get();
		$courses  = Courses::where("status", 1)->where('deleted', 0)->orderBy('sort_id', 'ASC')->get();
		$couponCode = CouponCode::where("coupon", "Joy 10")->where("status", 1)->where("deleted", 0)->first();
		$couponCodeLastDate=date('M d, Y H:i:s');
		if($couponCode){
			$couponCodeLastDate = date('M d, Y H:i:s', strtotime($couponCode->end_date));
			if(strtotime($couponCode->end_date) < strtotime($today)){
				$date = strtotime($today);
				$date = strtotime("+7 days", $date);
				$end_date = date('Y-m-d', $date);
				$update = DB::table('coupon_codes')->where('id', $couponCode->id)->update(['end_date' => $end_date]);
			}
			//echo $couponCodeLastDate;
		}
		return view('front.home', compact('pagename','userSubscription','studentClasses','conceptvideos','relates','courses','couponCodeLastDate'));
	}
	public function saveLead(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required|regex:/^[\pL\s\-]+$/u',
			'phone' => 'required|numeric|min:10',
			'email' => 'required|email',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		} else {
			//dd($request->all());
			$name 		= $request->name;
			$phone 		= $request->phone;
			$email 		= $request->email;
			$st_class 	= $request->st_class;
			$city 		= $request->city;
			if (!empty($name) && !empty($phone) && !empty($email)) {
				$data = array(
					'name'  		=> $name,
					'phone'  		=> $phone,
					'email'  		=> $email,
					'st_class'  	=> $st_class,
					'city'  		=> $city,
					'created_at'    => date('Y-m-d H:i:s'),
				);
				$insertId = Enquiry::insertGetId($data);
				
				//$message = 'Done';
				\Session::flash('success', 'Your Information Submitted Successfully.');
				return back();
			} else {
				//$message = 'Wrong Paramenter Passed!';
				\Session::flash('error', 'Wrong Paramenter Passed!');
				return back();
			}
			//return $message;
		}
	}

	public function aboutUs()
	{
		$pagename = "About Us";
		$aboutus = AboutUs::where("id", 1)->first();
		$relates = DB::table('testimonial_relates')->orderBy('id', 'ASC')->get();
		$firstPortfolios = Portfolio::where("select_row", 1)->where("status", 1)->where("deleted", 0)->orderBy("id","DESC")->get();
		$secondPortfolios = Portfolio::where("select_row", 2)->where("status", 1)->where("deleted", 0)->orderBy("id","DESC")->get();

		return view('front.about_us', compact('pagename','aboutus','relates','firstPortfolios','secondPortfolios'));
	}

	public function ourTeam()
	{
		$pagename = "Our Team";
		$departments = DB::table('team_departments')->orderBy('id', 'ASC')->get();

		return view('front.our_team', compact('pagename','departments'));
	}

	public function services()
	{
		$pagename = "Services";
		$testimonials = Testimonial::where("status", 1)->where('deleted', 0)->orderBy('id', 'DESC')->limit(4)->get();

		return view('front.services', compact('pagename','testimonials'));
	}

	public function franchiseplans()
	{
		$pagename = "Franchise Plans";
		$relates = DB::table('testimonial_relates')->orderBy('id', 'ASC')->get();
		$testimonials = Testimonial::where("status", 1)->where('deleted', 0)->orderBy('id', 'DESC')->limit(15)->get();

		return view('front.franchiseplans', compact('pagename','relates','testimonials'));
	}

	public function pricing()
	{
		//$this->smsWithTemplate('9887470545', 'AfterVerificationAccount', '+919950368500', 'vedicbrainsolutions@gmail.com');
		$pagename = "Pricing";
		$subscriptions = Subscription::where("status", 1)->where("deleted", 0)->orderBy("month", "ASC")->get();
		/*$time = '01:00:00';
		echo date('s',strtotime($time));*/
		return view('front.pricing', compact('pagename','subscriptions'));
	}
	public function planDetails($id)
	{
		$pagename = "Subscription Plan Details";
		$user = Auth::user();
		//dd($user);
		$userId = !empty($user) ? $user->id : 0;
		$subscription = Subscription::where("id", $id)->where("status", 1)->where("deleted", 0)->first();
		if(empty($subscription)){
			\Session::flash('error', 'Subscription plan not available.');
			return redirect()->route('pricing');
		}
		/*if($request->session()->has('planId') && $request->session()->get('planId')==$id){
			if($request->session()->has('payableAmt')){
				$request->session()->forget('payableAmt');
			}
		}*/
		$today	  = date('Y-m-d');
		$subscriptionTaken = UserSubscription::where("user_id", $userId)->where("end_date", ">=", $today)->orderBy('id', 'DESC')->first();
		$userSubscription = !empty($subscriptionTaken) ? 1 : 0;

		return view('front.plan_details', compact('pagename','subscription','userSubscription'));
	}

	public function contactUs()
	{
		$pagename = "Contact Us";

		return view('front.contact_us', compact('pagename'));
	}
	public function postContact(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required|regex:/^[\pL\s\-]+$/u',
			'phone' => 'required|numeric|min:10',
			'email' => 'required|email',
			'message' => 'required',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		} else {
			$user = Auth::user();
			$userId 	= !empty($user) ? $user->id : 0;
			$name 		= !empty($request->name) ? $request->name : $user->name;
			$phone 		= !empty($request->phone) ? $request->phone : $user->phone;
			$email 		= !empty($request->email) ? $request->email : $user->email;
			$message 	= $request->message;
			if (!empty($email) && !empty($message)) {
				$data = array(
					'user_id'  		=> $userId,
					'name'  		=> $name,
					'phone'  		=> $phone,
					'email'  		=> $email,
					'message'  		=> $message,
					'created_at'    => date('Y-m-d H:i:s'),
				);
				$inserId = Contactus::insertGetId($data);
				
				\Session::flash('success', 'Your Message Added Successfully.');
				return back();
			} else {
				\Session::flash('error', 'Wrong Paramenter Passed!');
				return back();
			}
		}
	}
	
	public function login(Request $request)
	{
		//dd($request->all());
		$email		= !empty($_REQUEST['email']) ? trim($_REQUEST['email']) : '';
		$password	= !empty($_REQUEST['password']) ? trim($_REQUEST['password']) : '';
		if (!empty($email) && !empty($password)) {
			if (is_numeric($email)) {
				$checkUser = User::where('phone', $email)->first();
				if(!empty($checkUser) && $checkUser->status != 1){
					$otpnumber = rand(1111, 9999);
					$update = DB::table('users')->where('id', $checkUser->id)->update(['otp_match' => $otpnumber]);
					$request->session()->put('phone', $checkUser->phone);
					$this->sms($checkUser->phone, $otpnumber);
					$this->sendEmail($checkUser->email, 'BrainyWood: Verify OTP', $data = array('userName' => $checkUser->name, 'message' => '<p>Thank you for connecting at BrainyWood,</p><p>You have got successfully your OTP: ' . $otpnumber . '</p>'));

					\Session::flash('error', 'Please verify your account first!');
					return back();
				}
				if (Auth::attempt(['phone' => $email, 'password' => $password])) {
					$user = Auth::user();
					if($user->role_id != 3){
						\Session::flash('error', 'You are not allow to login here!');
						return back();
					}
					/*if($user->status != 1){
						$request->session()->put('phone', $user->phone);
						
						\Session::flash('error', 'Please verify your account first!');
						return back();
					}*/
					if ($request->session()->has('phone')){
						$request->session()->forget('phone');
					}
					if ($request->session()->has('forgotPassPhone')){
						$request->session()->forget('forgotPassPhone');
					}
					$user->generateToken();
					$api_token = Str::random(60);
					$userss = User::find($user->id);
					$userss->api_token = $api_token;
					$userss->save();
					
					$request->session()->put('loginToken', $api_token);

					\Session::flash('success', 'Login successfully.');
					return redirect()->route('ourCourses');
					//return redirect()->back();
				}else{
					\Session::flash('error', 'Mobile number and Password not matched!');
					return back();
				}
			} else {
				$checkUser = User::where('email', $email)->first();
				if(!empty($checkUser) && $checkUser->status != 1){
					$otpnumber = rand(1111, 9999);
					$update = DB::table('users')->where('id', $checkUser->id)->update(['otp_match' => $otpnumber]);
					$request->session()->put('phone', $checkUser->phone);
					$this->sms($checkUser->phone, $otpnumber);
					$this->sendEmail($checkUser->email, 'BrainyWood: Verify OTP', $data = array('userName' => $checkUser->name, 'message' => '<p>Thank you for connecting at BrainyWood,</p><p>You have got successfully your OTP: ' . $otpnumber . '</p>'));

					\Session::flash('error', 'Please verify your account first!');
					return back();
				}
				if(Auth::attempt(['email' => $email, 'password' => $password])){
					$user = Auth::user();
					if($user->role_id != 3){
						\Session::flash('error', 'You are not allow to login here!');
						return back();
					}
					/*if($user->status != 1){
						$request->session()->put('phone', $user->phone);
						
						\Session::flash('error', 'Please verify your account first!');
						return back();
					}*/
					if ($request->session()->has('phone')){
						$request->session()->forget('phone');
					}
					if ($request->session()->has('forgotPassPhone')){
						$request->session()->forget('forgotPassPhone');
					}
					$user->generateToken();
					$api_token = Str::random(60);
					$userss = User::find($user->id);
					$userss->api_token = $api_token;
					//$userss->deviceToken = $deviceToken;
					$userss->save();
					
					$request->session()->put('loginToken', $api_token);
					
					\Session::flash('success', 'Login successfully.');
					return redirect()->route('ourCourses');
					//return redirect()->back();
				}else{
					\Session::flash('error', 'Email id and Password not matched!');
					return back();
				}
			}
		}else{
			\Session::flash('error', 'Email id and Mobile number not found!');
			return back();
		}
	}
	public function logout(Request $request)
	{
		Auth::logout();
		\Session::flush();
		return redirect()->route('home');
	}

	public function register(Request $request)
	{
		$phone = $request->phone;
		$phonecheck = User::where('phone', $phone)->first();
		if (!empty($phonecheck)) {
			if ($phonecheck->status!=1) {
				$validator = Validator::make($request->all(), [
					'name' => 'required|regex:/^[\pL\s\-]+$/u',
					'city' => 'required',
					//'city' => 'required|regex:/^[\pL\s\-]+$/u',
					//'email' => 'required|email|unique:users,email',
					//'phone' => 'required|numeric|min:10|unique:users,phone',
					'password' => 'required|min:6',
					'confirm_password' => 'required|same:password|min:6',
				]);

				if ($validator->fails()) {
					return back()
						->withErrors($validator)
						->withInput();
				} else {
					$name 		      = $request->input('name');
					$password 		  = $request->input('password');
					$confirm_password = $request->input('confirm_password');
					$gender 		  = $request->input('gender');
					$class_name 	  = $request->input('class_name');
					$city 		 	  = $request->input('city');
					$cities = DB::table('cities')->where('city', $city)->first();
					$state_id = $cities->state_id;
					$states = DB::table('states')->where('id', $state_id)->first();
					$state_name = $states->state;
					$otpnumber = rand(1111, 9999);
					$data = array(
						'name' 		=> $name,
						'password'	=> bcrypt($password),
						'userpass'	=> $password,
						'gender' 	=> $gender,
						'class_name' => $class_name,
						'city' 		=> $city,
						'state' 	=> $state_name,
						'otp_match' => $otpnumber,
						'api_token' => Str::random(60),
						'status'    => 0,
						'role_id'   => 3,
						'created_at' => date('Y-m-d H:i:s'),
					);
					$update = DB::table('users')->where('id', $phonecheck->id)->update($data);
					if($update){
						$request->session()->put('phone', $phone);
					}
					$this->sms($phone, $otpnumber);
					$this->sendEmail($phonecheck->email, 'BrainyWood: Verify OTP', $data = array('userName' => $phonecheck->name, 'message' => '<p>Thank you for connecting at BrainyWood,</p><p>You have got successfully your OTP: ' . $otpnumber . '</p>'));
				}
			}
			\Session::flash('success', 'User Registration Completed Successfully.');
			//\Session::flash('error', 'Phone number already exists. Please login directly.');
			return redirect()->back();
		} else {
			$validator = Validator::make($request->all(), [
				'name' => 'required|regex:/^[\pL\s\-]+$/u',
				'city' => 'required',
				'email' => 'required|email|unique:users,email',
				'phone' => 'required|numeric|min:10|unique:users,phone',
				'password' => 'required|min:6',
				'confirm_password' => 'required|same:password|min:6',
			]);

			if ($validator->fails()) {
				return back()
					->withErrors($validator)
					->withInput();
			} else {
				//dd($request->all());
				$name 		      = $request->input('name');
				$email 			  = $request->input('email');
				$phone 			  = $request->input('phone');
				$password 		  = $request->input('password');
				$confirm_password = $request->input('confirm_password');
				$gender 		  = $request->input('gender');
				$class_name 	  = $request->input('class_name');
				$city 		 	  = $request->input('city');
				$cities = DB::table('cities')->where('city', $city)->first();
				$state_id = $cities->state_id;
				$states = DB::table('states')->where('id', $state_id)->first();
				$state_name = $states->state;
				$msg = '';
				if (!empty($name)  && !empty($email) && !empty($phone) && !empty($password)) {
					if ($password != $confirm_password) {
						\Session::flash('error', 'Password and Confirm password not matched!');
						return redirect()->back();
					}
					$usercheck = User::where('email', $email)->first();
					if (!empty($usercheck)) {
						\Session::flash('error', 'Email id already exists. Please login directly.');
						return redirect()->back();
					} else {
						$phonecheck = User::where('phone', $phone)->first();
						if (!empty($phonecheck)) {
							\Session::flash('error', 'Phone number already exists. Please login directly.');
							return redirect()->back();
						} else {
							$imagess = '';
							if (isset($_FILES['image']['name'])) {
								$profileimagename = $_FILES['image']['name'];
								$tmpimage1 = $_FILES['image']['tmp_name'];
								$newprofileImage = rand(00000, 99999) . date('d') . $profileimagename;
								$location = "upload/profile/";
								move_uploaded_file($tmpimage1, $location . $newprofileImage);
								$url = 'upload/profile/' . $newprofileImage;
								$img = Image::make($url)->resize(200, 200);
								$imagess =  $img->basename;
							}
							$otp = rand(1111, 9999);
							$remember_token = Str::random(80);
							$data = array(
								'name' 		=> $name,
								'phone' 	=> $phone,
								'email' 	=> $email,
								'password'	=> bcrypt($password),
								'userpass'	=> $password,
								'gender' 	=> $gender,
								'class_name' => $class_name,
								'city' 		=> $city,
								'state' 	=> $state_name,
								//'image'   => $imagess,
								'otp_match' => $otp,
								'remember_token' => $remember_token,
								'api_token' => Str::random(60),
								'status'    => 0,
								'role_id'   => 3,
								'created_at' => date('Y-m-d H:i:s'),
							);
							$userId = User::insertGetId($data);
							if($userId){
								$request->session()->put('phone', $phone);
							}
							$msg = 'User Registration Completed Successfully.';
							$this->sms($phone, $otp);
							$this->addNotification($userId,$msg);
							// $data = array('username' => $name, 'remember_token' => $remember_token, 'msg' =>  $msg);
							// Mail::send('emails.register', $data, function ($message) {
							/*$data = array('username' => $name, 'OTP' => $otp, 'msg' => $msg);
							Mail::send('emails.otpmail', $data, function ($message) {
								$email = $_POST['email'];
								$message->to($email, 'From BrainyWood')->subject('BrainyWood: Verify your account');
								$message->from('vedicbrainsoulutions@gmail.com', 'BrainyWood');
							});*/
							$this->sendEmail($email, 'BrainyWood: Verify your account', $data = array('userName' => $name, 'message' => '<p>Thank you for connecting at BrainyWood,</p><p>You have got successfully your OTP: ' . $otp . '</p>'));


							\Session::flash('success', 'User Registration Completed Successfully.');
							return redirect()->back();
						}
					}
				} else {
					\Session::flash('error', 'Wrong Paramenter Passed!');
					return redirect()->back();
				}
			}
		}
	}

	public function verifyAccount($token)
	{
		$user = User::where('remember_token', $token)->first();
		if (empty($user)) {
			\Session::flash('error', 'This token has been expired, please try again!');
			return redirect()->route('home');
		} else {
			$user = User::find($user->id);
			$user->status = 1;
			$user->save();
			\Session::flash('success', 'You are Welcome at BrainyWood, your account successfully verified, You can access your account, Please login now.');
			return redirect()->route('home');
		}
	}

	public function verifyAccountByOtp(Request $request)
	{
		$phone = $request->phone;
		$otp = $request->otp;
		$user = User::where('phone', $phone)->where('otp_match', $otp)->first();
		if (empty($user)) {
			\Session::flash('error', 'This otp has been expired, please try again!');
			return redirect()->route('home');
		} else {
			$user = User::find($user->id);
			$user->status = 1;
			$user->save();

			$request->session()->forget('phone');

			$this->smsWithTemplate($user->phone, 'AfterVerificationAccount', '+919950368500', 'vedicbrainsolutions@gmail.com');
			
			\Session::flash('success', 'You are Welcome at BrainyWood, your account successfully verified, You can access your account, Please login now.');
			return redirect()->route('home');
		}
	}
	public function resendOtp(Request $request)
	{
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id != 3 || empty($user)){
			$userId = 0;
			/*\Session::flash('error', 'You are not allow to access here!');
			return redirect()->route('home');*/
		}else{
			$userId = $user->id;
		}
		//echo '<pre />'; print_r($request->all()); die;
		$phone = $request->phone;
		if (!empty($phone)) {
			if($userId==0){
				$user = User::where('phone', $phone)->first();
				$userId = $user->id;
			}
			//$checkUser = User::where('phone', $phone)->first();
			//if ($checkUser) {
				$otpnumber = rand(1111, 9999);
				//$phone = $checkUser->phone;
				$update = DB::table('users')->where('id', $userId)->update(['otp_match' => $otpnumber]);
				if ($update) {
					if ($request->session()->has('new_email')){
						$request->session()->forget('phone');
					} elseif ($request->session()->has('new_phone')){
						$request->session()->forget('phone');
					} else {
						$request->session()->put('phone', $phone);
					}

					$msg = 'Verification Otp Send, Please Check.';
					$this->sms($phone, $otpnumber);
					/*$data = array('username' => $checkUser->name, 'OTP' => $otpnumber, 'msg' => $msg);
					Mail::send('emails.otpmail', $data, function ($message) {
						$checkUser = User::where('phone', $_POST['phone'])->first();
						$email = $checkUser->email;
						$message->to($email, 'From BrainyWood')->subject('BrainyWood: Verify OTP');
						$message->from('vedicbrainsoulutions@gmail.com', 'BrainyWood');
					});*/
					$this->sendEmail($user->email, 'BrainyWood: Verify OTP', $data = array('userName' => $user->name, 'message' => '<p>Thank you for connecting at BrainyWood,</p><p>You have got successfully your OTP: ' . $otpnumber . '</p>'));

					\Session::flash('success', 'Verification Otp Send, Please Check your Mobile or Email id.');
					return redirect()->back();
				} else {
					\Session::flash('error', 'Somthing Went Wrong!');
					return redirect()->back();
				}
			//}
		}
	}
	public function closeVerification(Request $request)
	{
		if ($request->session()->has('phone')){
			$request->session()->forget('phone');
		}
		if ($request->session()->has('forgotPassPhone')){
			$request->session()->forget('forgotPassPhone');
		}
		//return "Done";
		return redirect()->back();
	}

	public function forgotPassword(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'email' => 'required',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		} else {
			//dd($request->all());
			$email = $request->input('email');
			if (is_numeric($email)) {
				$usercheck = User::where('phone', $email)->first();
			} else {
				$usercheck = User::where('email', $email)->first();
			}
			if (!empty($usercheck)) {
				$userId = $usercheck->id;
				$name = $usercheck->name;
				$email = $usercheck->email;
				$phone = $usercheck->phone;
				$remember_token = Str::random(60);
				$otpnumber = rand(1111, 9999);
				$user = User::find($userId);
				$user->remember_token = $remember_token;
				$user->otp_match = $otpnumber;
				$user->save();
				
				$request->session()->put('forgotPassPhone', $phone);

				/*$msg = 'You have forgot your password, don\'t worry. Please reset your password <a href="'.route('home').'">click here</a>';
				$data = array('username' => $name, 'remember_token' =>  $remember_token, 'msg' =>  $msg);
				Mail::send('emails.forgot_password', $data, function ($message) {
					$email = $_POST['email'];
					$message->to($email, 'From BrainyWood')->subject('BrainyWood: Forgot Password');
					$message->from('vedicbrainsoulutions@gmail.com', 'BrainyWood');
				});*/
				$this->sms($phone, $otpnumber);
				$this->sendEmail($email, 'BrainyWood: Forgot Password', $data = array('userName' => $name, 'message' => '<p>You have been forgotton your password, don\'t worry, Please reset your password <a href=\"' . route('passwordToken', $remember_token) . '\">click here</a></p><br>OR<br><p>You have got successfully your OTP: ' . $otpnumber . ' to reset your password</p>'));
				
				\Session::flash('success', 'Please check your mobile or email id to reset your password.');
			} else {
				\Session::flash('error', 'Mobile or Email id not found!');
			}
		}
		return redirect()->back();

	}
	public function forgotPasswordByOtp(Request $request)
	{
		$phone = $request->phone;
		$otp = $request->otp;
		$user = User::where('phone', $phone)->where('otp_match', $otp)->first();
		if (empty($user)) {
			\Session::flash('error', 'This otp has been expired, please try again!');
			return redirect()->route('home');
		} else {
			if ($user->remember_token!='') {
				$remember_token = $user->remember_token;
			} else {
				$remember_token = Str::random(60);
				$user = User::find($user->id);
				$user->remember_token = $remember_token;
				$user->save();
			}

			$request->session()->forget('forgotPassPhone');
			
			\Session::flash('success', 'You can reset your password now.');
			return redirect()->route('passwordToken', $remember_token);
		}
	}
	public function forgotResendOtp(Request $request)
	{
		//echo '<pre />'; print_r($request->all()); die;
		$phone = $request->phone;
		if (!empty($phone)) {
			$checkUser = User::where('phone', $phone)->first();
			if ($checkUser) {
				$userId = $checkUser->id;
				$otpnumber = rand(1111, 9999);
				$phone = $checkUser->phone;
				$update = DB::table('users')->where('id', $userId)->update(['otp_match' => $otpnumber]);
				if ($update) {
					$request->session()->put('forgotPassPhone', $phone);

					$this->sms($phone, $otpnumber);
					/*$msg = 'Verification Otp Send, Please Check.';
					$data = array('username' => $checkUser->name, 'OTP' => $otpnumber, 'msg' => $msg);
					Mail::send('emails.otpmail', $data, function ($message) {
						$checkUser = User::where('phone', $_POST['phone'])->first();
						$email = $checkUser->email;
						$message->to($email, 'From BrainyWood')->subject('BrainyWood: Verify OTP');
						$message->from('vedicbrainsoulutions@gmail.com', 'BrainyWood');
					});*/
					$this->sendEmail($checkUser->email, 'BrainyWood: Forgot Password Verify OTP', $data = array('userName' => $checkUser->name, 'message' => '<p>Thank you for connecting at BrainyWood,</p><p>You have got successfully your OTP: ' . $otpnumber . '</p>'));

					\Session::flash('success', 'Verification Otp Send, Please Check your Mobile or Email id.');
					return redirect()->back();
				} else {
					\Session::flash('error', 'Somthing Went Wrong!');
					return redirect()->back();
				}
			}
		}
	}

	public function passwordToken($token)
	{
		$pagename = 'Reset Password';
		$user = User::where('remember_token', $token)->first();
		if (empty($user)) {
			\Session::flash('error', 'This token has been expired, please try again!');
			return redirect()->route('home');
		}
		return view('front.reset_password', compact('pagename','user'));
	}
	public function resetPassword(Request $request)
	{
		$userId = $request->userId;
		$newPassword = $request->get('new_pass');
		$confirmPassword = $request->get('con_pass');
		if ($newPassword != $confirmPassword) {
			\Session::flash('error', 'Password and Confirm password not matched!');
			return back();
		}
		$users = User::findOrFail($userId);
		$users->password = bcrypt($newPassword);
		$users->userpass = $newPassword;
		$users->save();
		
		\Session::flash('success', 'Password reset successfully.');
		return redirect()->route('home');
	}

	public function myProfile(Request $request)
	{
		$pagename = "My Profile";
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id != 3 || empty($user)){
			\Session::flash('error', 'You are not allow to access here!');
			return redirect()->route('home');
		}
		if ($request->session()->has('loginToken')){
			if($user->api_token != $request->session()->get('loginToken')){
				\Session::flash('error', 'You have already logged-in another device!');
				Auth::logout();
				//\Session::flush();
				return redirect()->route('home');
			}
		}

		return view('front.my_profile', compact('pagename','user'));
	}

	public function myAccount(Request $request)
	{
		$pagename = "My Account";
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id != 3 || empty($user)){
			\Session::flash('error', 'You are not allow to access here!');
			return redirect()->route('home');
		}
		if ($request->session()->has('loginToken')){
			if($user->api_token != $request->session()->get('loginToken')){
				\Session::flash('error', 'You have already logged-in another device!');
				Auth::logout();
				//\Session::flush();
				return redirect()->route('home');
			}
		}
		$userId = $user->id;
		$subscriptions = UserSubscription::where("user_id", $userId)->orderBy('id', 'DESC')->get();
		$studentClasses = StudentClass::where('status',1)->where('deleted',0)->orderBy('id', 'ASC')->get();
		$states = State::orderBy('state', 'ASC')->get();
		$userState = $user->state;
		$state = State::where('state', $userState)->first();
		$stateId = $state->id;
		$cities = DB::table('cities')->where('state_id', $stateId)->orderBy('city', 'ASC')->get();

		return view('front.my_account', compact('pagename','user','subscriptions','studentClasses','states','cities'));
	}

	public function uploadProfile(Request $request)
	{
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id != 3 || empty($user)){
			\Session::flash('error', 'You are not allow to access here!');
			return redirect()->route('home');
		}
		if ($request->session()->has('loginToken')){
			if($user->api_token != $request->session()->get('loginToken')){
				\Session::flash('error', 'You have already logged-in another device!');
				Auth::logout();
				//\Session::flush();
				return redirect()->route('home');
			}
		}

		$validator = Validator::make($request->all(), [
			'image' => 'required',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		} else {
			//dd($request->all());
			$imagess = '';
			if (isset($_FILES['image']['name'])) {
				$profileimagename = $_FILES['image']['name'];
				$tmpimage1 = $_FILES['image']['tmp_name'];
				$newprofileImage = rand(00000, 99999) . date('d') . $profileimagename;
				$location = "upload/profile/";
				move_uploaded_file($tmpimage1, $location . $newprofileImage);
				$url = 'upload/profile/' . $newprofileImage;
				$img = Image::make($url)->resize(200, 200);
				$imagess =  $img->basename;
			}
			//echo $imagess; die;
			$userId = $user->id;
			$users = User::findOrFail($userId);
			$users->image = $imagess;
			$users->save();
			
			\Session::flash('success', 'Profile Image Uploaded Successfully.');
			return back();
		}
	}
	public function updateAccount(Request $request)
	{
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id != 3 || empty($user)){
			\Session::flash('error', 'You are not allow to access here!');
			return redirect()->route('home');
		}
		if ($request->session()->has('loginToken')){
			if($user->api_token != $request->session()->get('loginToken')){
				\Session::flash('error', 'You have already logged-in another device!');
				Auth::logout();
				//\Session::flush();
				return redirect()->route('home');
			}
		}
		$userId = $user->id;
		$users = User::findOrFail($userId);
		$users->name = $request->get('name');
		$users->phone = $request->get('phone');
		$users->email = $request->get('email');
		$users->save();
		
		\Session::flash('success', 'Account updated successfully.');
		return back();
	}
	public function mobileUpdate(Request $request)
	{
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id != 3 || empty($user)){
			$message = 'You are not allow to access here!';
			return $message;
		}
		if ($request->session()->has('loginToken')){
			if($user->api_token != $request->session()->get('loginToken')){
				$message = 'You have already logged-in another device!';
				Auth::logout();
				//\Session::flush();
				return $message;
			}
		}
		$userId = $user->id;

		$validator = Validator::make($request->all(), [
			'phone' => 'required|numeric|min:10',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		} else {
			$phone 	= $request->phone;
			if (!empty($phone)) {
				$checkPhone = User::where('id', '!=', $userId)->where('phone', $phone)->first();
				if (empty($checkPhone)) {
					$request->session()->put('new_phone', $phone);
					$otp = rand(1111, 9999);
					$updateData = User::where('id', $userId)->update([
						'otp_match' 	=> $otp,
						'updated_at' 	=> date('Y-m-d H:i:s')
					]);
					$this->sms($phone, $otp);
					$this->sendEmail($user->email, 'BrainyWood: Verify OTP', $data = array('userName' => $user->name, 'message' => '<p>Thank you for connecting at BrainyWood,</p><p>You have got successfully your OTP: ' . $otp . '</p>'));
					$message = 'Done';
					return $message;
				}
			}
		}
	}
	public function mobileOtpSend(Request $request)
	{
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id != 3 || empty($user)){
			$message = 'You are not allow to access here!';
			return $message;
		}
		if ($request->session()->has('loginToken')){
			if($user->api_token != $request->session()->get('loginToken')){
				$message = 'You have already logged-in another device!';
				Auth::logout();
				//\Session::flush();
				return $message;
			}
		}
		$userId = $user->id;

		$validator = Validator::make($request->all(), [
			'new_phone' => 'required|numeric|min:10',
			'otp' => 'required|numeric',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		} else {
			$phone 	= $request->new_phone;
			$otp 	= $request->otp;
			$checkUser = User::where('id', $userId)->where('otp_match', $otp)->first();
			if (!empty($checkUser)) {
				if (!empty($phone)) {
					$checkPhone = User::where('id', '!=', $userId)->where('phone', $phone)->first();
					if (empty($checkPhone)) {
						$updateData = User::where('id', $userId)->update([
							'phone' 		=> $phone,
							'updated_at' 	=> date('Y-m-d H:i:s')
						]);
						$request->session()->forget('new_phone');
						$message = 'Done';
						return $message;
					} else {
						$message = 'This Mobile number already exists, can not update for now.';
						return $message;
					}
				}
			} else {
				$message = 'OTP not matched, please resend a OTP to update your mobile number';
				return $message;
			}
		}
	}
	public function emailUpdate(Request $request)
	{
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id != 3 || empty($user)){
			$message = 'You are not allow to access here!';
			return $message;
		}
		if ($request->session()->has('loginToken')){
			if($user->api_token != $request->session()->get('loginToken')){
				$message = 'You have already logged-in another device!';
				Auth::logout();
				//\Session::flush();
				return $message;
			}
		}
		$userId = $user->id;

		$validator = Validator::make($request->all(), [
			'email' => 'required|email',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		} else {
			$email 	= $request->email;
			if (!empty($email)) {
				$checkEmail = User::where('id', '!=', $userId)->where('email', $email)->first();
				if (empty($checkEmail)) {
					$request->session()->put('new_email', $email);
					$request->session()->put('new_email_phone', $user->phone);
					$otp = rand(1111, 9999);
					$updateData = User::where('id', $userId)->update([
						'otp_match' 	=> $otp,
						'updated_at' 	=> date('Y-m-d H:i:s')
					]);
					$this->sms($user->phone, $otp);
					//sendEmail
					$this->sendEmail($user->email, 'BrainyWood: Verify OTP', $data = array('userName' => $user->name, 'message' => '<p>Thank you for connecting at BrainyWood,</p><p>You have got successfully your OTP: ' . $otp . '</p>'));
					$message = 'Done';
					return $message;
				}
			}
		}
	}
	public function emailOtpSend(Request $request)
	{
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id != 3 || empty($user)){
			$message = 'You are not allow to access here!';
			return $message;
		}
		if ($request->session()->has('loginToken')){
			if($user->api_token != $request->session()->get('loginToken')){
				$message = 'You have already logged-in another device!';
				Auth::logout();
				//\Session::flush();
				return $message;
			}
		}
		$userId = $user->id;

		$validator = Validator::make($request->all(), [
			'new_email' => 'required|email',
			'otp' => 'required|numeric',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		} else {
			$email 	= $request->new_email;
			$otp 	= $request->otp;
			$checkUser = User::where('id', $userId)->where('otp_match', $otp)->first();
			if (!empty($checkUser)) {
				if (!empty($email)) {
					$checkEmail = User::where('id', '!=', $userId)->where('email', $email)->first();
					if (empty($checkEmail)) {
						$updateData = User::where('id', $userId)->update([
							'email' 		=> $email,
							'updated_at' 	=> date('Y-m-d H:i:s')
						]);
						$request->session()->forget('new_email');
						$request->session()->forget('new_email_phone');
						$message = 'Done';
						return $message;
					} else {
						$message = 'This email id already exists, can not update for now.';
						return $message;
					}
				}
			} else {
				$message = 'OTP not matched, please resend a OTP to update your email id';
				return $message;
			}
		}
	}
	public function changePassword(Request $request)
	{
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id != 3 || empty($user)){
			\Session::flash('error', 'You are not allow to access here!');
			return redirect()->route('home');
		}
		if ($request->session()->has('loginToken')){
			if($user->api_token != $request->session()->get('loginToken')){
				\Session::flash('error', 'You have already logged-in another device!');
				Auth::logout();
				//\Session::flush();
				return redirect()->route('home');
			}
		}
		$userId = $user->id;

		$validator = Validator::make($request->all(), [
			'current_password' => 'required',
			'new_password' => 'required|min:6',
			'confirm_password' => 'required|same:new_password|min:6',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		} else {
			$currentPassword = $request->get('current_password');
			$newPassword = $request->get('new_password');
			$confirmPassword = $request->get('confirm_password');
			if (Hash::check($currentPassword, $user->password)) {
				if ($newPassword != $confirmPassword) {
					\Session::flash('error', 'Password and Confirm password not matched!');
					return back();
				}
				$users = User::findOrFail($userId);
				$users->password = bcrypt($newPassword);
				$users->userpass = $newPassword;
				$users->save();
			} else {
				\Session::flash('error', 'Current Password not matched!');
				return back();
			}
			
			\Session::flash('success', 'Password updated successfully.');
			return back();
		}
	}
	public function updateInfo(Request $request)
	{
		//echo '<pre />'; print_r($request->all()); die;
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id != 3 || empty($user)){
			\Session::flash('error', 'You are not allow to access here!');
			return redirect()->route('home');
		}
		if ($request->session()->has('loginToken')){
			if($user->api_token != $request->session()->get('loginToken')){
				\Session::flash('error', 'You have already logged-in another device!');
				Auth::logout();
				//\Session::flush();
				return redirect()->route('home');
			}
		}

		$validator = Validator::make($request->all(), [
			'name' => 'required|regex:/^[\pL\s\-]+$/u',
			'city' => 'required|regex:/^[\pL\s\-]+$/u',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		} else {
			$userId = $user->id;
			$users = User::findOrFail($userId);
			$users->name = $request->get('name');
			$users->dob = date('Y-m-d H:i:s',strtotime($request->get('dob')));
			$users->gender = $request->get('gender');
			$users->class_name = $request->get('class_name');
			$users->school_college = $request->get('school_college');
			$users->state = $request->get('state');
			$users->city = $request->get('city');
			$users->postal_code = $request->get('postal_code');
			$users->save();
		}
		
		\Session::flash('success', 'Profile info updated successfully.');
		return back();
	}

	public function getCitiesByState(Request $request)
	{
		$state = $request->state;
		$stateData = State::where('state', $state)->first();
		$stateId = $stateData->id;
		$cities = DB::table('cities')->where('state_id', $stateId)->orderBy('city', 'ASC')->get();
		$output = '<option>Select City</option>';
		foreach ($cities as $key => $value) {
			$output .= '<option value="'.$value->city.'">'.$value->city.'</option>';
		}
		echo $output;
	}

	public function ourCourses(Request $request)
	{
		$pagename = "Our Courses";
		$search   = $request->search;
		$courses  = Courses::where("status", 1)->where('deleted', 0);
		if (!empty($courses)) {
			$courses = $courses->where("name", 'like', "%" . $search . "%");
		}
		$courses = $courses->orderBy('sort_id', 'ASC')->get();

		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id != 3 || empty($user)){
			$userId = 0;
		}else{
			$userId = $user->id;
		}
		$today	= date('Y-m-d');
		$subscription = UserSubscription::where("user_id", $userId)->where("end_date", ">=", $today)->orderBy('id', 'DESC')->first();
		$userSubscription = !empty($subscription) ? 1 : 0;

		if($request->session()->has('quizTime')){
			$request->session()->forget('quizTime');
			$request->session()->forget('quizId');
		}

		return view('front.our_courses', compact('pagename','search','courses','userSubscription'));
	}

	public function courseDetails(Request $request, $id)
	{
		$pagename = "Course Details";
		$course = Courses::where('id', $id)->where("status", 1)->where('deleted', 0)->first();
		if (empty($course)) {
			\Session::flash('error', 'Course not available.');
			return redirect()->route('ourCourses');
		}
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id != 3 || empty($user)){
			$userId = 0;
			\Session::flash('error', 'Please login first to proceed.');
			return redirect()->route('ourCourses');
		}else{
			$userId = $user->id;
		}
		if ($request->session()->has('loginToken')){
			if($user->api_token != $request->session()->get('loginToken')){
				\Session::flash('error', 'You have already logged-in another device!');
				Auth::logout();
				//\Session::flush();
				return redirect()->route('home');
			}
		}
		$today	= date('Y-m-d');
		$subscription = UserSubscription::where("user_id", $userId)->where("end_date", ">=", $today)->orderBy('id', 'DESC')->first();
		$userSubscription = !empty($subscription) ? 1 : 0;
		if($course->isFree==1){
			if($userSubscription==0){
				\Session::flash('error', 'Please subscribe a plan first to proceed.');
				return redirect()->route('ourCourses');
			}
		}
		$getQuiz = Quiz::where("courseId", $id)->where('islession', 1)->where('status', 1)->where('deleted', 0)->orderBy("id", "DESC")->first();
		$courseFeatures = Coursefeature::where("courseId", $id)->orderBy('id', 'ASC')->get();
		$courseFaqs = Coursefeq::where("courseId", $id)->orderBy('id', 'ASC')->get();
		$lessions = Lession::where("courseId", $id)->where("status", 1)->where('deleted', 0)->orderBy('sort_id', 'ASC')->get();
		//$ratingMessages = RatingMessage::groupBy("message")->get();
		$ratingMessages = RatingMessage::get();
		if($request->session()->has('quizTime')){
			$request->session()->forget('quizTime');
			$request->session()->forget('quizId');
		}

		return view('front.course_details', compact('pagename','course','userSubscription','getQuiz','courseFeatures','courseFaqs','lessions','ratingMessages'));
	}

	public function lessionDetails(Request $request, $id)
	{
		$pagename = "Lession Details";
		$lession = Lession::where('id', $id)->where("status", 1)->where('deleted', 0)->first();
		if (empty($lession)) {
			return redirect()->route('ourCourses');
		}
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id != 3 || empty($user)){
			$userId = 0;
			\Session::flash('error', 'Please login first to proceed.');
			return redirect()->route('ourCourses');
		}else{
			$userId = $user->id;
		}
		if ($request->session()->has('loginToken')){
			if($user->api_token != $request->session()->get('loginToken')){
				\Session::flash('error', 'You have already logged-in another device!');
				Auth::logout();
				//\Session::flush();
				return redirect()->route('home');
			}
		}
		$today	= date('Y-m-d');
		$subscription = UserSubscription::where("user_id", $userId)->where("end_date", ">=", $today)->orderBy('id', 'DESC')->first();
		$userSubscription = !empty($subscription) ? 1 : 0;
		if($lession->isFree==1){
			if($userSubscription==0){
				\Session::flash('error', 'Please subscribe a plan first to proceed.');
				return redirect()->route('ourCourses');
			}
		}
		$getQuiz = Quiz::where("courseId", $lession->courseId)->where("lessionId", $id)->where('islession', 0)->where('status', 1)->where('deleted', 0)->orderBy("id", "DESC")->first();
		$lessions = Lession::where("courseId", $lession->courseId)->where("status", 1)->where('deleted', 0)->orderBy('sort_id', 'ASC')->get();
		$topics = Chapter::where("courseId", $lession->courseId)->where("lessionId", $id)->where("status", 1)->where('deleted', 0)->orderBy('sort_id', 'ASC')->get();
		//$ratingMessages = RatingMessage::groupBy("message")->get();
		$ratingMessages = RatingMessage::get();
		if($request->session()->has('quizTime')){
			$request->session()->forget('quizTime');
			$request->session()->forget('quizId');
		}

		return view('front.lession_details', compact('id','pagename','lession','userSubscription','getQuiz','lessions','topics','ratingMessages'));
	}

	public function topicDetails(Request $request, $id)
	{
		$pagename = "Topic Details";
		$topic = Chapter::where('id', $id)->where("status", 1)->where('deleted', 0)->first();
		if (empty($topic)) {
			return redirect()->route('ourCourses');
		}
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id != 3 || empty($user)){
			$userId = 0;
			\Session::flash('error', 'Please login first to proceed.');
			return redirect()->route('ourCourses');
		}else{
			$userId = $user->id;
		}
		if ($request->session()->has('loginToken')){
			if($user->api_token != $request->session()->get('loginToken')){
				\Session::flash('error', 'You have already logged-in another device!');
				Auth::logout();
				//\Session::flush();
				return redirect()->route('home');
			}
		}
		$today	= date('Y-m-d');
		$subscription = UserSubscription::where("user_id", $userId)->where("end_date", ">=", $today)->orderBy('id', 'DESC')->first();
		$userSubscription = !empty($subscription) ? 1 : 0;
		if($topic->isFree==1){
			if($userSubscription==0){
				\Session::flash('error', 'Please subscribe a plan first to proceed.');
				return redirect()->route('ourCourses');
			}
		}
		$getQuiz = Quiz::where("courseId", $topic->courseId)->where("lessionId", $topic->lessionId)->where('islession', 0)->where('status', 1)->where('deleted', 0)->orderBy("id", "DESC")->first();
		$topics = Chapter::where("courseId", $topic->courseId)->where("lessionId", $topic->lessionId)->where("status", 1)->where('deleted', 0)->orderBy('sort_id', 'ASC')->get();
		//$ratingMessages = RatingMessage::groupBy("message")->get();
		$ratingMessages = RatingMessage::get();
		if($request->session()->has('quizTime')){
			$request->session()->forget('quizTime');
			$request->session()->forget('quizId');
		}

		return view('front.topic_details', compact('id','pagename','topic','userSubscription','getQuiz','topics','ratingMessages'));
	}

	public function rateByUser(Request $request)
	{
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id != 3 || empty($user)){
			\Session::flash('error', 'You are not allow to access here!');
			return redirect()->route('home');
		}
		if ($request->session()->has('loginToken')){
			if($user->api_token != $request->session()->get('loginToken')){
				\Session::flash('error', 'You have already logged-in another device!');
				Auth::logout();
				//\Session::flush();
				return redirect()->route('home');
			}
		}
		$userId = $user->id;

		$validator = Validator::make($request->all(), [
			'message' => 'required',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		} else {
			//dd($request->all());
			$courseId 	= $request->courseId;
			$lessionId  = $request->lessionId;
			$topicId 	= $request->topicId;
			$ratingType = $request->ratingType;
			$ratingMessage = implode(',', $request->ratingMessage);
			$message 	= $request->message;
			$msg = '';
			$data = array(
				'userId' 		=> $userId,
				'courseId' 		=> $courseId,
				'lessionId' 	=> $lessionId,
				'topicId' 		=> $topicId,
				'ratingType' 	=> $ratingType,
				'ratingMessage' => $ratingMessage,
				'message' 		=> $message,
				'status' 		=> 0,
				'created_at' 	=> date('Y-m-d H:i:s'),
			);
			$insertId = RatingUser::insertGetId($data);
			\Session::flash('success', 'Rating Submitted Successfully.');
			return redirect()->back();
		}
	}

	public function liveClasses(Request $request)
	{
		$pagename = "Live Classes";
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id != 3 || empty($user)){
			\Session::flash('error', 'You are not allow to access here!');
			return redirect()->route('home');
		}
		if ($request->session()->has('loginToken')){
			if($user->api_token != $request->session()->get('loginToken')){
				\Session::flash('error', 'You have already logged-in another device!');
				Auth::logout();
				//\Session::flush();
				return redirect()->route('home');
			}
		}
		$userId = $user->id;
		$today	= date('Y-m-d');
		$subscription = UserSubscription::where("user_id", $userId)->where("end_date", ">=", $today)->orderBy('id', 'DESC')->first();
		$userSubscription = !empty($subscription) ? 1 : 0;
		$from = date('Y-m-d').' 00:00:00';
		$to = date('Y-m-d').' 23:59:59';
		$now = date('Y-m-d H:i:s');
		$pastClasses = LiveClass::where("status", 1)->where("deleted", 0)->where('class_time', '<', $now)->orderBy('class_time', 'ASC')->get();
		$liveClasses = LiveClass::where("status", 1)->where("deleted", 0)->whereBetween('class_time', [$from, $to])->orderBy('class_time', 'ASC')->get();
		$upcomingClasses = LiveClass::where("status", 1)->where("deleted", 0)->where('class_time', '>=', $now)->orderBy('class_time', 'ASC')->get();

		return view('front.live_classes', compact('pagename','userSubscription','pastClasses','liveClasses','upcomingClasses'));
	}

	public function notify_me(Request $request)
	{
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id != 3 || empty($user)){
			$message = 'You are not allow to access here!';
			return $message;
		}
		if ($request->session()->has('loginToken')){
			if($user->api_token != $request->session()->get('loginToken')){
				$message = 'You have already logged-in another device!';
				Auth::logout();
				//\Session::flush();
				return $message;
			}
		}
		$userId   = $user->id;
		$classId = $request->classId;
		if (!empty($userId) && !empty($classId)) {
			$check_interest = LiveclassNotify::where("user_id", $userId)->where("class_id", $classId)->first();
			if (empty($check_interest)) {
				$data = array(
					'user_id'  		=> $userId,
					'class_id'  	=> $classId,
					'status'  		=> 0,
					'created_at'    => date('Y-m-d H:i:s'),
				);
				$insertId = LiveclassNotify::insertGetId($data);
			} else {
				$data = array(
					'status'  		=> 0,
					'updated_at'    => date('Y-m-d H:i:s'),
				);
				$insertId = LiveclassNotify::where("id", $check_interest->id)->update($data);
			}
			$liveClass = LiveClass::where("id", $classId)->where("status", 1)->where("deleted", 0)->first();
			if ($liveClass) {
				$this->smsWithTemplate($user->phone, 'LiveClassSMS', $user->name, $liveClass->subject, $liveClass->class_time);
				$this->sendEmail($user->email, 'BrainyWood: Live Class', $data = array('userName' => $user->name, 'message' => '<p>Your live class of '.$liveClass->subject.' will start at '.$liveClass->class_time.', Please join timely.</p><p>Team Brainywood</p>'));
			}
			//$message = "Your Class Added Successfully.";
			$message = "Done";
			return $message;
		} else {
			$message = "Wrong Paramenter Passed!";
			return $message;
		}
	}

	public function getQuiz(Request $request, $id)
	{
		$pagename = "Quiz";
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id != 3 || empty($user)){
			\Session::flash('error', 'You are not allow to access here!');
			return redirect()->route('home');
		}
		if ($request->session()->has('loginToken')){
			if($user->api_token != $request->session()->get('loginToken')){
				\Session::flash('error', 'You have already logged-in another device!');
				Auth::logout();
				//\Session::flush();
				return redirect()->route('home');
			}
		}
		$userId = $user->id;
		$examId = 0;
		$quiz = Quiz::where("id", $id)->where('status', 1)->where('deleted', 0)->first();
		if (!empty($quiz)) {
			$examQuestions = Quizquestions::where("quizId", $quiz->id)->get();
			$courseId = $quiz->courseId;
			$lessionId = $quiz->lessionId;
			$checkStudentExam = StudentExam::where("user_id", $userId)->where("course_id", $courseId)->where("lession_id", $lessionId)->where('is_complete', 0)->first();
			if (!empty($checkStudentExam)) {
				$examId = $checkStudentExam->id;
				$data = array(
					'start_time' => date('H:i:s'),
					'end_time'   => date('H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);
				$update = StudentExam::where("id", $examId)->update($data);
				//$duration = $quiz->duration;
				$time = explode(':', $quiz->duration);
				$durationInMinutes = ($time[0]*60) + ($time[1]) + ($time[2]/60);
				$takenMinutes = 0;
				if ($checkStudentExam->total_time != ''){
					$takenTime = explode(':', $checkStudentExam->total_time);
					$takenMinutes = ($takenTime[0]*60) + ($takenTime[1]) + ($takenTime[2]/60);
					$durationInMinutes = $durationInMinutes - $takenMinutes;
				}
				$date = date("Y-m-d H:i:s"); //"2021-06-19 16:40:00";
				$date = strtotime($date);
				$date = strtotime("+".$durationInMinutes." minute", $date);
				$duration = date('M d, Y H:i:s', $date); //"June 19, 2021 16:40:00";
				if($request->session()->has('quizId') && $request->session()->get('quizId')==$id){
					if($request->session()->has('quizTime')){
						$quizTime = $request->session()->get('quizTime');
					}else{
						$quizTime = $request->session()->put('quizTime', $duration);
					}
				}else{
					$quizId = $request->session()->put('quizId', $id);
					$quizTime = $request->session()->put('quizTime', $duration);
					return redirect()->route('getQuiz',$id);
				}
			} else {
				$data = array(
					'user_id'     => $userId,
					'course_id'   => $courseId,
					'lession_id'  => $lessionId,
					'start_time'  => date('H:i:s'),
					'is_complete' => 0,
					'created_at'  => date('Y-m-d H:i:s'),
				);
				$examId = StudentExam::insertGetId($data);
				//$duration = $quiz->duration;
				$time = explode(':', $quiz->duration);
				$durationInMinutes = ($time[0]*60) + ($time[1]) + ($time[2]/60);
				$date = date("Y-m-d H:i:s"); //"2021-06-19 16:40:00";
				$date = strtotime($date);
				$date = strtotime("+".$durationInMinutes." minute", $date);
				$duration = date('M d, Y H:i:s', $date); //"June 19, 2021 16:40:00";
				if($request->session()->has('quizId') && $request->session()->get('quizId')==$id){
					if($request->session()->has('quizTime')){
						$quizTime = $request->session()->get('quizTime');
					}else{
						$quizTime = $request->session()->put('quizTime', $duration);
					}
				}else{
					$quizId = $request->session()->put('quizId', $id);
					$quizTime = $request->session()->put('quizTime', $duration);
					return redirect()->route('getQuiz',$id);
				}
			}
		} else {
			\Session::flash('error', 'Quiz not available for now!');
			return redirect()->back();
		}

		return view('front.quiz', compact('pagename','quiz','quizTime','examQuestions','examId'));
	}
	public function pauseQuiz(Request $request)
	{
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id != 3 || empty($user)){
			\Session::flash('error', 'You are not allow to access here!');
			return redirect()->route('home');
		}
		if ($request->session()->has('loginToken')){
			if($user->api_token != $request->session()->get('loginToken')){
				\Session::flash('error', 'You have already logged-in another device!');
				Auth::logout();
				//\Session::flush();
				return redirect()->route('home');
			}
		}
		$userId = $user->id;
		$examId = $request->examId;
		$studentExam = StudentExam::where("id", $examId)->where("user_id", $userId)->where('is_complete', 0)->first();
		if (!empty($studentExam)) {
			$start_time = $studentExam->start_time;
			$end_time = date('H:i:s');
			$start = Carbon::parse($start_time);
			$end = Carbon::parse($end_time);
			/*$hours = $end->diffInHours($start);
			$minutes = $end->diffInMinutes($start);*/
			$seconds = $end->diffInSeconds($start);
			$total_time = sprintf('%02d:%02d:%02d', ($seconds/3600),($seconds/60%60), $seconds%60);
			$before_total_time = $studentExam->total_time;
			if (!empty($before_total_time)) {
				$newDateTime = Carbon::parse($before_total_time)->addSeconds($seconds);
				$total_time = date('H:i:s', strtotime($newDateTime));
			}
			//echo $total_time; die;
			$data = array(
				'end_time'   => $end_time,
				'total_time' => $total_time,
				'updated_at' => date('Y-m-d H:i:s'),
			);
			$update = StudentExam::where("id", $examId)->update($data);
			$message = "Exam paused successfully.";
			echo $message;
		}
	}
	public function nextQuiz(Request $request)
	{
		$examId = $request->examId;
		$quesId = $request->quesId;
		$answer = $request->answer;
		if (!empty($answer)) {
			$attemp = 1;
		} else {
			$attemp = 0;
		}
		//echo 'EXID '.$examId.' QID '.$quesId.' ANSID '.$answer; die;
		$studentAns = StudentExamAnswer::where("exam_id", $examId)->where("ques_id", $quesId)->first();
		if (!empty($studentAns)) {
			$studentAnsId = $studentAns->id;
			$data = array(
				'answer'     => $answer,
				'attemp'     => $attemp,
				'updated_at' => date('Y-m-d H:i:s'),
			);
			$update = StudentExamAnswer::where("id", $studentAnsId)->update($data);
			$message = "Answer updated successfully.";
		} else {
			$data = array(
				'exam_id'    => $examId,
				'ques_id'    => $quesId,
				'answer'     => $answer,
				'attemp'     => $attemp,
				'created_at' => date('Y-m-d H:i:s'),
			);
			$studentAnsId = StudentExamAnswer::insertGetId($data);
			$message = "Answer inserted successfully.";
		}
		echo $message;
	}
	public function endQuiz(Request $request)
	{
		//dd($request->all());
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id == 3 || !empty($user)){
			$userId = $user->id;
			$examId = $request->examId;
			$quesId = $request->quesId;
			$answer = $request->answer;
			if (!empty($answer)) {
				$attemp = 1;
			} else {
				$attemp = 0;
			}
			//echo 'EXID '.$examId.' QID '.$quesId.' ANSID '.$answer; die;
			$studentAns = StudentExamAnswer::where("exam_id", $examId)->where("ques_id", $quesId)->first();
			if (!empty($studentAns)) {
				$studentAnsId = $studentAns->id;
				$data = array(
					'answer'     => $answer,
					'attemp'     => $attemp,
					'updated_at' => date('Y-m-d H:i:s'),
				);
				$update = StudentExamAnswer::where("id", $studentAnsId)->update($data);
				$message = "Answer updated successfully.";
			} else {
				$data = array(
					'exam_id'    => $examId,
					'ques_id'    => $quesId,
					'answer'     => $answer,
					'attemp'     => $attemp,
					'created_at' => date('Y-m-d H:i:s'),
				);
				$studentAnsId = StudentExamAnswer::insertGetId($data);
				$message = "Answer inserted successfully.";
			}
			$studentExam = StudentExam::where("id", $examId)->where("user_id", $userId)->where('is_complete', 0)->first();
			if (!empty($studentExam)) {
				$start_time = $studentExam->start_time;
				$end_time = date('H:i:s');
				$start = Carbon::parse($start_time);
				$end = Carbon::parse($end_time);
				/*$hours = $end->diffInHours($start);
				$minutes = $end->diffInMinutes($start);*/
				$seconds = $end->diffInSeconds($start);
				$total_time = sprintf('%02d:%02d:%02d', ($seconds/3600),($seconds/60%60), $seconds%60);
				$before_total_time = $studentExam->total_time;
				if (!empty($before_total_time)) {
					$newDateTime = Carbon::parse($before_total_time)->addSeconds($seconds);
					$total_time = date('H:i:s', strtotime($newDateTime));
				}
				//echo $total_time; die;
				$data1 = array(
					'end_time'   => $end_time,
					'total_time' => $total_time,
					'is_complete' => 1,
					'updated_at' => date('Y-m-d H:i:s'),
				);
				$update = StudentExam::where("id", $examId)->update($data1);
				$message = "Exam ended successfully.";
			}
		}
		echo $message;
	}
	public function autoEndQuiz(Request $request)
	{
		//dd($request->all());
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id == 3 || !empty($user)){
			$userId = $user->id;
			$examId = $request->examId;
			//echo 'EXID '.$examId; die;
			$studentExam = StudentExam::where("id", $examId)->where("user_id", $userId)->where('is_complete', 0)->first();
			if (!empty($studentExam)) {
				$start_time = $studentExam->start_time;
				$end_time = date('H:i:s');
				$start = Carbon::parse($start_time);
				$end = Carbon::parse($end_time);
				/*$hours = $end->diffInHours($start);
				$minutes = $end->diffInMinutes($start);*/
				$seconds = $end->diffInSeconds($start);
				$total_time = sprintf('%02d:%02d:%02d', ($seconds/3600),($seconds/60%60), $seconds%60);
				$before_total_time = $studentExam->total_time;
				if (!empty($before_total_time)) {
					$newDateTime = Carbon::parse($before_total_time)->addSeconds($seconds);
					$total_time = date('H:i:s', strtotime($newDateTime));
				}
				//echo $total_time; die;
				$data1 = array(
					'end_time'   => $end_time,
					'total_time' => $total_time,
					'is_complete' => 1,
					'updated_at' => date('Y-m-d H:i:s'),
				);
				$update = StudentExam::where("id", $examId)->update($data1);
				$message = "Exam ended successfully.";
			}
		}
		echo $message;
	}

	public function quizList(Request $request, $quizId,$examId)
	{
		$pagename = "Quiz List";
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id != 3 || empty($user)){
			\Session::flash('error', 'You are not allow to access here!');
			return redirect()->route('home');
		}
		if ($request->session()->has('loginToken')){
			if($user->api_token != $request->session()->get('loginToken')){
				\Session::flash('error', 'You have already logged-in another device!');
				Auth::logout();
				//\Session::flush();
				return redirect()->route('home');
			}
		}
		$examQuestions = Quizquestions::where("quizId", $quizId)->get();
		$total_questions = count($examQuestions);
		$total_attemped = $total_unattemped = 0;
		if (!empty($examQuestions)) {
			$total_attemped = StudentExamAnswer::where("exam_id", $examId)->count();
			$total_unattemped = $total_questions - $total_attemped;
		} else {
			\Session::flash('error', 'Quiz Not Found!');
			return redirect()->route('home');
		}

		return view('front.quiz_list', compact('pagename','quizId','examId','examQuestions','total_questions','total_attemped','total_unattemped'));
	}

	public function quizResult(Request $request, $quizId, $examId)
	{
		$pagename = "Quiz Result";
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id != 3 || empty($user)){
			\Session::flash('error', 'You are not allow to access here!');
			return redirect()->route('home');
		}
		if ($request->session()->has('loginToken')){
			if($user->api_token != $request->session()->get('loginToken')){
				\Session::flash('error', 'You have already logged-in another device!');
				Auth::logout();
				//\Session::flush();
				return redirect()->route('home');
			}
		}
		$userId = $user->id;
		$quiz = Quiz::where("id", $quizId)->where('status', 1)->where('deleted', 0)->first();
		if (!empty($quiz)) {
			$islession = $quiz->islession;
			$passing_percent = $quiz->passing_percent;
			$quiz['examId'] = $examId;
			$examQuestions = Quizquestions::where("quizId", $quiz->id)->get();
			$total_questions = count($examQuestions);
			$quiz['total_questions'] = $total_questions;
			$studentExam = StudentExam::where("id", $examId)->where("user_id", $userId)->first();
			$quiz['time_efficiency'] = $studentExam->total_time;
			$certificate = $studentExam->certificate;
			$attemped_date = date('d M, Y', strtotime($studentExam->created_at));
			$quiz['attemped_date'] = $attemped_date;
			$total_marking = $score = $right = $wrong = $total_solved = $not_solved = 0;
			foreach ($examQuestions as $key => $val) {
				$quizdata[$key]['id'] = $val->id;
				$quizdata[$key]['questions'] = $val->questions;
				$quizdata[$key]['image'] = !empty($val->image) ? asset('upload/quizquestions') . "/" . $val->image : '';
				$quizdata[$key]['marking'] = $val->marking;
				$total_marking += $val->marking;

				$studentAns = StudentExamAnswer::where("exam_id", $examId)->where("ques_id", $val->id)->first();
				if (!empty($studentAns)) {
					$quizAnswers = Quizoption::where("questionId", $val->id)->orderBy("id", "ASC")->get();
					$answer = '';
					foreach ($quizAnswers as $key1 => $value) {
						if ($key1 == ($val->currect_option - 1)){
							$answer = $value->id;
						}
					}
					//if ($val->currect_option == $studentAns->answer) {
					if ($answer == $studentAns->answer) {
						$right++;
						$score += $val->marking;
					} else {
						$wrong++;
					}
				}
			}
			$total_solved = $right + $wrong;
			$not_solved = $total_questions - $total_solved;
			$quiz['total_attemped'] = $total_solved;
			$quiz['right_answer'] = $right;
			$quiz['wrong_answer'] = $wrong + $not_solved;
			$quiz['total_score'] = $score.' out of '.$total_marking;
			//$percentage = number_format((($right * 100) / $total_questions), 2);
			$percentage = number_format((($score * 100) / $total_marking), 2);
			$quiz['percentage'] = $percentage;
			if ($percentage >= $passing_percent) {
				$download_status = 1;
			} else {
				$download_status = 0;
			}
			if ($islession==1){
				$download_status = $download_status;
			} else {
				$download_status = 0;
			}
			$quiz['download_status'] = $download_status;
			if ($download_status==1) {
				if ($certificate !='') {
					//$quiz['certificate_url'] = asset('lessions/978material.pdf');
					$quiz['certificate_url'] = asset('upload/generatedPDF') . "/" . $certificate;
				} else {
					$user = User::where("id", $userId)->first();
					$username = $user->name;
					$newCertificate = $this->generatePDF($examId, $username, $attemped_date);
					$quiz['certificate_url'] = asset('upload/generatedPDF') . "/" . $newCertificate;
				}
			} else {
				$quiz['certificate_url'] = '';
			}
			
			if ($download_status == 1) {
				$msg = 'Hi, '.$user->name.' Wonderful score on the recent quiz. Keep learning';
			} else {
				$msg = 'Hi, '.$user->name.' Less score on the recent quiz. Keep learning';
			}
			$this->addNotification($userId,$msg);

			if($request->session()->has('quizTime')){
				$request->session()->forget('quizId');
				$request->session()->forget('quizTime');
			}

		} else {
			\Session::flash('error', 'Quiz Not Found!');
			return redirect()->route('home');
		}

		return view('front.quiz_result', compact('pagename','quiz'));
	}

	public function quizResultViewQuestion(Request $request, $quizId,$examId)
	{
		$pagename = "Quiz Result View Question";
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id != 3 || empty($user)){
			\Session::flash('error', 'You are not allow to access here!');
			return redirect()->route('home');
		}
		if ($request->session()->has('loginToken')){
			if($user->api_token != $request->session()->get('loginToken')){
				\Session::flash('error', 'You have already logged-in another device!');
				Auth::logout();
				//\Session::flush();
				return redirect()->route('home');
			}
		}
		$userId = $user->id;
		$quiz = Quiz::where("id", $quizId)->where('status', 1)->where('deleted', 0)->first();
		$quizdata = array();
		if (!empty($quiz)) {
			$passing_percent = $quiz->passing_percent;
			$quiz['examId'] = $examId;
			$examQuestions = Quizquestions::where("quizId", $quiz->id)->get();
			$total_questions = count($examQuestions);
			$quiz['total_questions'] = $total_questions;
			$studentExam = StudentExam::where("id", $examId)->where("user_id", $userId)->first();
			$quiz['time_efficiency'] = !empty($studentExam) ? $studentExam->total_time : '';
			$total_marking = $score = $right = $wrong = $total_solved = $not_solved = 0;
			foreach ($examQuestions as $key => $val) {
				$quizdata[$key]['id'] = $val->id;
				$quizdata[$key]['questions'] = $val->questions;
				$quizdata[$key]['image'] = !empty($val->image) ? asset('upload/quizquestions') . "/" . $val->image : '';
				$quizdata[$key]['marking'] = $val->marking;
				$quizdata[$key]['solution'] = $val->solution;
				$total_marking += $val->marking;
				$queoptions = Quizoption::where("questionId", $val->id)->get();
				$optiondata = array();
				foreach ($queoptions as $key1 => $value) {
					$optiondata[$key1]['id'] = $value->id;
					$optiondata[$key1]['option'] = $value->quizoption;
				}
				$quizdata[$key]['answers'] = $optiondata;
				$studentAns = StudentExamAnswer::where("exam_id", $examId)->where("ques_id", $val->id)->first();
				if (!empty($studentAns)) {
					$quizStAnswer = Quizoption::where("id", $studentAns->answer)->first();
				}
				//$quizdata[$key]['given_answer'] = isset($quizStAnswer->quizoption) ? $quizStAnswer->quizoption : 'NA';
				$given_answer = isset($studentAns->answer) ? $studentAns->answer : 'NA';
				$quizdata[$key]['given_answer'] = $given_answer;
				$quizAnswers = Quizoption::where("questionId", $val->id)->orderBy("id", "ASC")->get();
				$answer = '';
				foreach ($quizAnswers as $key1 => $value) {
					if ($key1 == ($val->currect_option - 1)){
						$answer = $value->id;
					}
				}
				if ($answer == $given_answer) {
					$right++;
					$score += $val->marking;
				} else {
					$wrong++;
				}
				$quizAnswer = Quizoption::where("id", $answer)->first();
				//$quizdata[$key]['correct_answer'] = isset($quizAnswer->quizoption) ? $quizAnswer->quizoption : 'NA';
				$quizdata[$key]['correct_answer'] = isset($answer) ? $answer : 'NA';
			}
			$total_solved = $right + $wrong;
			$not_solved = $total_questions - $total_solved;
			$quiz['total_attemped'] = $total_solved;
			$quiz['right_answer'] = $right;
			$quiz['wrong_answer'] = $wrong + $not_solved;
			//$percentage = number_format((($right * 100) / $total_questions), 2);
			$percentage = number_format((($score * 100) / $total_marking), 2);
			$quiz['percentage'] = $percentage;
			if ($percentage >= $passing_percent) {
				$download_status = 1;
			} else {
				$download_status = 0;
			}
			$quiz['download_status'] = $download_status;
			$quiz['certificate_url'] = asset('lessions/978material.pdf');
		} else {
			\Session::flash('error', 'Quiz Not Found!');
			return redirect()->route('home');
		}
		//dd($quizdata);

		return view('front.quiz_result_view_question', compact('pagename','quiz','quizdata'));
	}

	public function questionAnswer(Request $request)
	{
		$pagename = "Q&A";
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id != 3 || empty($user)){
			\Session::flash('error', 'You are not allow to access here!');
			return redirect()->route('home');
		}
		if ($request->session()->has('loginToken')){
			if($user->api_token != $request->session()->get('loginToken')){
				\Session::flash('error', 'You have already logged-in another device!');
				Auth::logout();
				//\Session::flush();
				return redirect()->route('home');
			}
		}
		$userId = $user->id;
		$today	= date('Y-m-d');
		$subscription = UserSubscription::where("user_id", $userId)->where("end_date", ">=", $today)->orderBy('id', 'DESC')->first();
		$userSubscription = !empty($subscription) ? 1 : 0;
		$questioncount = QuestionAsk::where('user_id', $userId)->count();
		$courses = Courses::where("status", 1)->where('deleted', 0)->orderBy('sort_id', 'ASC')->get();
		$dt = Carbon::now();
		$from = $dt->subMonth();
		$to = date('Y-m-d H:i:s');
		$latestQuesAsks = QuestionAsk::where("status", 1)->whereBetween('created_at', [$from, $to])->orderBy("id", "DESC")->get();
		$myQuestions = QuestionAsk::where("user_id", $userId)->where("status", 1)->where("deleted", 0)->orderBy("id", "DESC")->get();
		$suggestedQues = QuestionAsk::where("status", 1)->where("deleted", 0)->orderByRaw("RAND()")->limit(3)->get();

		return view('front.question_answer', compact('pagename','userSubscription','questioncount','courses','latestQuesAsks','myQuestions','suggestedQues'));
	}

	public function getLessionsBycourse(Request $request)
	{
		$courseId = $request->courseId;
		$lessions = Lession::where("courseId", $courseId)->where("status", 1)->where('deleted', 0)->orderBy('sort_id', 'ASC')->get();
		$output = '<option>Select Lession</option>';
		foreach ($lessions as $key => $value) {
			$output .= '<option value="'.$value->id.'">'.$value->name.'</option>';
		}
		echo $output;
	}

	public function getTopicsByLession(Request $request)
	{
		$courseId = $request->courseId;
		$lessionId = $request->lessionId;
		$chapters = Chapter::where("courseId", $courseId)->where("lessionId", $lessionId)->where("status", 1)->where('deleted', 0)->orderBy('sort_id', 'ASC')->get();
		$output = '<option>Select Topic</option>';
		foreach ($chapters as $key => $value) {
			$output .= '<option value="'.$value->id.'">'.$value->name.'</option>';
		}
		echo $output;
	}

	public function getQuestionsBylession(Request $request)
	{
		$courseId = $request->courseId;
		$lessionId = !empty($request->lessionId) ? $request->lessionId : 0;
		$topicId = !empty($request->topicId) ? $request->topicId : 0;
		$search = $request->search;
		$questions = QuestionAsk::where("course_id", $courseId)->where("lession_id", $lessionId)->where("topic_id", $topicId)->where("status", 1)->where("deleted", 0);
		if (!empty($questions)) {
			$questions = $questions->where("question", 'like', "%" . $search . "%");
		}
		$questions = $questions->limit(3)->get();
		$output = '';
		foreach ($questions as $key => $value) {
			$quesUrl = route('questionAnswerView',$value->id);
			$output .= '<li><a href="'.$quesUrl.'" target="_blank">'.$value->question.'</a></li>';
		}
		echo $output;
	}

	public function saveQuestion(Request $request)
	{
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id != 3 || empty($user)){
			\Session::flash('error', 'You are not allow to access here!');
			return redirect()->route('home');
		}
		if ($request->session()->has('loginToken')){
			if($user->api_token != $request->session()->get('loginToken')){
				\Session::flash('error', 'You have already logged-in another device!');
				Auth::logout();
				//\Session::flush();
				return redirect()->route('home');
			}
		}
		$userId = $user->id;
		$today	= date('Y-m-d');
		$subscription = UserSubscription::where("user_id", $userId)->where("end_date", ">=", $today)->orderBy('id', 'DESC')->first();
		$userSubscription = !empty($subscription) ? 1 : 0;
		$questioncount = QuestionAsk::where('user_id', $userId)->count();
		if ($userSubscription==0) {
			if ($questioncount > 3) {
				\Session::flash('error', 'You are not allow to ask more question, Please buy a subscription plan first!');
				return back();
			}
		}

		$validator = Validator::make($request->all(), [
			'courseId' => 'required',
			'lessionId' => 'required',
			'question' => 'required',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		} else {
			//dd($request->all());
			$imagesData = [];
			$files = $request->file('image');
			if ($request->hasFile('image')) {
				foreach ($files as $file) {
					if($file){
						$destinationPath = public_path().'/upload/questionask/';
						$originalFile = $file->getClientOriginalName();
						$imagess = rand(111,999).strtotime(date('Y-m-d-H:isa')).$originalFile;
						$file->move($destinationPath, $imagess);
						//$imagesData[] = $imagess;
						$url = 'upload/questionask/' . $newImage;
						$thumb_img = Image::make($url)->resize(200, 200);
						$thumb_img->save('upload/questionask/thumb/'.$newImage,80);
						$imagesData[] =  $thumb_img->basename;
					}
				}
			}
			$courseId 	= $request->input('courseId');
			$lessionId 	= $request->input('lessionId');
			$topicId 	= $request->input('topicId');
			$question 	= $request->input('question');

			$questionAsk = new QuestionAsk;
			$questionAsk->user_id 	= $userId;
			$questionAsk->course_id = $courseId;
			$questionAsk->lession_id = $lessionId;
			$questionAsk->topic_id 	= $topicId;
			$questionAsk->question 	= $question;
			$questionAsk->image 	= implode(",", $imagesData);
			$questionAsk->save();

			/*$msg = $user->name.' Asked a question '.$question.' in Q&A, check it now.';
			$users = User::where("id", "!=", $userId)->where("role_id", "!=", 1)->get();
			foreach ($users as $userval) {
				$this->addNotification($userval->id,$msg);
			}*/

			\Session::flash('success', 'Thank you, Your Question added successfully, After approval by Team it will be appear here.');
			return back();
		}
	}
	public function answerAQuestion(Request $request)
	{
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id != 3 || empty($user)){
			\Session::flash('error', 'You are not allow to access here!');
			return redirect()->route('home');
		}
		if ($request->session()->has('loginToken')){
			if($user->api_token != $request->session()->get('loginToken')){
				\Session::flash('error', 'You have already logged-in another device!');
				Auth::logout();
				//\Session::flush();
				return redirect()->route('home');
			}
		}

		$validator = Validator::make($request->all(), [
			'quesId' => 'required',
			//'answer' => 'required',
		]);

		if ($validator->fails()) {
			return back()
				->withErrors($validator)
				->withInput();
		} else {
			$userId = $user->id;
			$quesId = $request->quesId;
			$answer = $request->answer;
			$msg = '';
			if (!empty($userId)  && !empty($quesId)) {
				$questioncheck = QuestionAsk::where('id', $quesId)->first();
				if (!empty($questioncheck)) {
					/*$imagess = '';
					if (isset($_FILES['image']['name']) && $_FILES['image']['name']!='') {
						$ansimagename = $_FILES['image']['name'];
						$tmpimage1 = $_FILES['image']['tmp_name'];
						$newImage = rand(00000, 99999) . date('d') . $ansimagename;
						$location = "upload/questionask/";
						move_uploaded_file($tmpimage1, $location . $newImage);
						$url = 'upload/questionask/' . $newImage;
						$thumb_img = Image::make($url)->resize(200, 200);
						$thumb_img->save('upload/questionask/thumb/'.$newImage,80);
						$imagess =  $thumb_img->basename;
					}*/
					$imagesData = [];
					$files = $request->file('image');
					if ($request->hasFile('image')) {
						foreach ($files as $file) {
							if($file){
								$destinationPath = public_path().'/upload/questionask/';
								$originalFile = $file->getClientOriginalName();
								$newImage = rand(111,999).strtotime(date('Y-m-d-H:isa')).$originalFile;
								$file->move($destinationPath, $newImage);
								//$imagesData[] = $newImage;
								$url = 'upload/questionask/' . $newImage;
								$thumb_img = Image::make($url)->resize(200, 200);
								$thumb_img->save('upload/questionask/thumb/'.$newImage,80);
								$imagesData[] =  $thumb_img->basename;
							}
						}
					}
					$data = array(
						'user_id' 	 => $userId,
						'ques_id'    => $quesId,
						'answer'     => $answer,
						//'image'      => $imagess,
						'image'      => implode(",", $imagesData),
						'status'     => 1,
						'created_at' => date('Y-m-d H:i:s'),
					);
					$insertId = QuestionAnswer::insertGetId($data);

					$ques = QuestionAsk::where("id", $quesId)->first();
					$msg = $user->name.', Answered a question '.$ques->question.' in Q&A, check it now.';
					$this->addNotification($ques->user_id,$msg);
					/*$users = User::where("id", "!=", $userId)->where("role_id", "!=", 1)->get();
					foreach ($users as $userval) {
						$this->addNotification($userval->id,$msg);
					}*/
					\Session::flash('success', 'Your Answer Submitted Successfully.');
					return redirect()->back();
				} else {
					\Session::flash('error', 'Question not Found!');
					return redirect()->back();
				}
			} else {
				\Session::flash('error', 'Wrong Paramenter Passed!');
				return redirect()->back();
			}
		}
	}

	public function questionAnswerView(Request $request, $id)
	{
		$pagename = "Q&A";
		$userId = 0;
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id == 3 || !empty($user)){
			$userId = $user->id;
		}
		if ($request->session()->has('loginToken')){
			if($user->api_token != $request->session()->get('loginToken')){
				\Session::flash('error', 'You have already logged-in another device!');
				Auth::logout();
				//\Session::flush();
				return redirect()->route('home');
			}
		}
		$today	= date('Y-m-d');
		$subscription = UserSubscription::where("user_id", $userId)->where("end_date", ">=", $today)->orderBy('id', 'DESC')->first();
		$userSubscription = !empty($subscription) ? 1 : 0;
		$questioncount = QuestionAsk::where('user_id', $userId)->count();
		$askedQuestion = QuestionAsk::where("id", $id)->where("status", 1)->where("deleted", 0)->first();
		if(empty($askedQuestion)){
			\Session::flash('error', 'Question not found!');
			return redirect()->route('questionAnswer');
		}
		$courseLessionTopicName = '';
		if($askedQuestion->topic_id > 0){
			$courseLessionTopicName = $askedQuestion->course->name.' / '.$askedQuestion->lession->name.' / '.$askedQuestion->topic->name;
		}elseif($askedQuestion->lession_id > 0){
			$courseLessionTopicName = $askedQuestion->course->name.' / '.$askedQuestion->lession->name;
		}else{
			if($askedQuestion->course_id > 0){
				$courseLessionTopicName = $askedQuestion->course->name;
			}
		}
		$answers = QuestionAnswer::where("ques_id", $id)->where("status", 1)->get();

		return view('front.question_answer_view', compact('pagename','userSubscription','questioncount','askedQuestion','courseLessionTopicName','answers'));
	}

	public function answerLike(Request $request)
	{
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id != 3 || empty($user)){
			\Session::flash('error', 'Please login first to like it!');
			return redirect()->back();
		}
		if ($request->session()->has('loginToken')){
			if($user->api_token != $request->session()->get('loginToken')){
				\Session::flash('error', 'You have already logged-in another device!');
				Auth::logout();
				//\Session::flush();
				return redirect()->route('home');
			}
		}
		$userId = $user->id;
		$answerId = $request->answerId;
		if (!empty($userId) && !empty($answerId)) {
			$getAnswer = QuestionAnswer::where('id', $answerId)->first();
			if (!empty($getAnswer)) {
				$getAnswerLike = QuestionAnswerLike::where('user_id', $userId)->where('answer_id', $answerId)->first();
				$userLiked = !empty($getAnswerLike) ? $getAnswerLike->ans_like : 0;
				$userDisliked = !empty($getAnswerLike) ? $getAnswerLike->ans_unlike : 0;
				if ($userLiked==0) {
					$preLike = $getAnswer->ans_like;
					$preDislike = $getAnswer->ans_unlike;
					if ($userDisliked==1) {
						$preDislike = $preDislike - 1;
					}
					$like = $preLike + 1;
					$data = array(
						'ans_like' 	 => $like,
						'ans_unlike' => $preDislike,
						'updated_at' => date('Y-m-d H:i:s'),
					);
					$update = QuestionAnswer::where("id", $answerId)->update($data);
					if (!empty($getAnswerLike)) {
						$data1 = array(
							'ans_like' 	 => 1,
							'ans_unlike' => 0,
							'updated_at' => date('Y-m-d H:i:s'),
						);
						$update = QuestionAnswerLike::where("id", $getAnswerLike->id)->update($data1);
					} else {
						$data1 = array(
							'user_id' 	 => $userId,
							'answer_id'  => $answerId,
							'ans_like' 	 => 1,
							'ans_unlike' => 0,
							'created_at' => date('Y-m-d H:i:s'),
						);
						$insert = QuestionAnswerLike::insertGetId($data1);
					}
					\Session::flash('success', 'Your Like Submitted Successfully.');
				} else {
					\Session::flash('success', 'You have already liked this answer.');
				}
			}
		}
		return back();
	}

	public function answerUnLike(Request $request)
	{
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id != 3 || empty($user)){
			\Session::flash('error', 'Please login first to dislike it!');
			return redirect()->back();
		}
		if ($request->session()->has('loginToken')){
			if($user->api_token != $request->session()->get('loginToken')){
				\Session::flash('error', 'You have already logged-in another device!');
				Auth::logout();
				//\Session::flush();
				return redirect()->route('home');
			}
		}
		$userId = $user->id;
		$answerId = $request->answerId;
		if (!empty($userId) && !empty($answerId)) {
			$getAnswer = QuestionAnswer::where('id', $answerId)->first();
			if (!empty($getAnswer)) {
				$getAnswerLike = QuestionAnswerLike::where('user_id', $userId)->where('answer_id', $answerId)->first();
				$userLiked = !empty($getAnswerLike) ? $getAnswerLike->ans_like : 0;
				$userDisliked = !empty($getAnswerLike) ? $getAnswerLike->ans_unlike : 0;
				if ($userDisliked==0) {
					$preLike = $getAnswer->ans_like;
					if ($userLiked==1) {
						$preLike = $preLike - 1;
					}
					$preUnLike = $getAnswer->ans_unlike;
					$unlike = $preUnLike + 1;
					$data = array(
						'ans_like' 	 => $preLike,
						'ans_unlike' => $unlike,
						'updated_at' => date('Y-m-d H:i:s'),
					);
					$update = QuestionAnswer::where("id", $answerId)->update($data);
					if (!empty($getAnswerLike)) {
						$data1 = array(
							'ans_like' 	 => 0,
							'ans_unlike' => 1,
							'updated_at' => date('Y-m-d H:i:s'),
						);
						$update = QuestionAnswerLike::where("id", $getAnswerLike->id)->update($data1);
					} else {
						$data1 = array(
							'user_id' 	 => $userId,
							'answer_id'  => $answerId,
							'ans_like' 	 => 0,
							'ans_unlike' => 1,
							'created_at' => date('Y-m-d H:i:s'),
						);
						$insert = QuestionAnswerLike::insertGetId($data1);
					}
					\Session::flash('success', 'Your Dislike Submitted Successfully.');
				} else {
					\Session::flash('success', 'You have already disliked this answer.');
				}
			}
		}
		return back();
	}

	public function apply_coupon_code(Request $request)
	{
		//echo '<pre />'; print_r($request->all()); die;
		if($request->session()->has('payableAmt')){
			$request->session()->forget('payableAmt');
		}
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id != 3 || empty($user)){
			\Session::flash('error', 'Please login first to apply coupon code!');
			return redirect()->back();
		}
		if ($request->session()->has('loginToken')){
			if($user->api_token != $request->session()->get('loginToken')){
				$message = '<span style="color:red;">You have already logged-in another device!</span>';
				return $message;
			}
		}
		$userId   = $request->userId;
		$subscriptionId = $request->subscriptionId;
		$couponCode		= $request->couponCode;
		$discount = $discountAmt = $payableAmt = $coupon_no_of_users = $coupon_user_id = $coupon_subscription_id = 0;
		if (!empty($userId) && !empty($subscriptionId) && !empty($couponCode)) {
			$today	  = date('Y-m-d');
			$subscription = UserSubscription::where("user_id", $userId)->where("end_date", ">=", $today)->orderBy('id', 'DESC')->first();
			$userSubscription = !empty($subscription) ? 1 : 0;
			if ($userSubscription==1) {
				$message = '<span style="color:red;">You have already subscribed a plan, after expired you can take new subscription!</span>';
				return $message;
			}
			$getCoupon = CouponCode::where("coupon", $couponCode)->where("end_date", ">=", $today)->where("status", 1)->where("deleted", 0)->first();
			if (!empty($getCoupon) && $getCoupon->discount > 0) {
				$discount = $getCoupon->discount;
			} else {
				$message = '<span style="color:red;">This Coupon Code not found!</span>';
				return $message;
			}
			$checkSubscription = UserSubscription::where("user_id", $userId)->where("coupon_code", $couponCode)->first();
			if (!empty($checkSubscription)) {
				$message = '<span style="color:red;">This Coupon Code already in used!</span>';
				return $message;
			} else {
				if ($getCoupon->condition_1 == 1){
					if ($getCoupon->user_id > 0){
						$coupon_user_id = $getCoupon->user_id;
						if ($userId != $coupon_user_id) {
							$message = '<span style="color:red;">This Coupon Code not made for you!</span>';
							return $message;
						}
					}
				} elseif ($getCoupon->condition_1 == 2){
					if ($getCoupon->no_of_users > 0){
						$coupon_no_of_users = $getCoupon->no_of_users;
					}
				} else {
					if ($getCoupon->no_of_users > 0){
						$coupon_no_of_users = $getCoupon->no_of_users;
					}
				}
				if ($getCoupon->subscription_id > 0){
					$coupon_subscription_id = $getCoupon->subscription_id;
					if ($subscriptionId != $coupon_subscription_id) {
						$message = '<span style="color:red;">This Coupon Code not made for this subscription plan!</span>';
						return $message;
					}
				}
				if ($coupon_no_of_users > 0) {
					$totalUsedCouponCode = UserSubscription::where("coupon_code", $couponCode)->count();
					if ($totalUsedCouponCode >= $coupon_no_of_users) {
						$message = '<span style="color:red;">This Coupon Code is expired!</span>';
						return $message;
					}
				}
			}
			$getSubscription = Subscription::where("id", $subscriptionId)->where("status", 1)->where("deleted", 0)->first();
			if (!empty($getSubscription) && $getSubscription->price > 1) {
				$amount = $getSubscription->price;
				if ($discount > 0) {
					$discountAmt = ($amount * $discount) / 100;
				}
				if ($discountAmt > 0) {
					if ($amount > $discountAmt) {
						$payableAmt = $amount - $discountAmt;
					} else {
						$payableAmt = 0;
					}
				}
				if ($payableAmt > 0) {
					$request->session()->put('planId', $subscriptionId);
					$request->session()->put('payableAmt', $payableAmt);

					
					$payment_gateway = 1;
					$message = "Done";
				} else {
					$month = !empty($getSubscription->month) ? $getSubscription->month : 0;
					$today = date('Y-m-d');
					$end_date = date('Y-m-d', strtotime('+'.$month.' months'));
					$data1 = array(
						'user_id'			=> $userId,
						'subscription_id'	=> $subscriptionId,
						'start_date'		=> $today,
						'end_date'			=> $end_date,
						'coupon_code'		=> $couponCode,
						'mode'				=> 'Coupon',
						'created_at'		=> date('Y-m-d H:i:s'),
					);
					$orderId = UserSubscription::insertGetId($data1);
					$user = User::where("id", $userId)->first();
					$msg = 'Subscription plan activated';
					$this->smsWithTemplate($user->phone, 'Mambership', $user->name, $getSubscription->name);
					$this->addNotification($userId,$msg);
					/*$data = array('username' => $user->name, 'payment_id' => $couponCode, 'msg' => $msg);
					Mail::send('emails.payment', $data, function ($message) {
						$user = User::where("id", $_POST['userId'])->first();
						$email = $user->email;
						$message->to($email, 'From BrainyWood')->subject('BrainyWood: Subscription plan activated');
						$message->from('vedicbrainsoulutions@gmail.com', 'BrainyWood');
					});*/
					$this->sendEmail($user->email, 'BrainyWood: Subscription payment initiated', $data = array('userName' => $user->name, 'message' => '<p>Thank you for payment initiated at BrainyWood,</p><p>You have subscribed a plan successfully with Coupon Code: ' . $couponCode . '</p>'));

					$payment_gateway = 0;
					$message = "Activated";
				}
				return $message;
			} else {
				$message = '<span style="color:red;">Subscription not found!</span>';
				return $message;
			}
		} else {
			$message = '<span style="color:red;">Wrong Paramenter Passed!</span>';
			return $message;
		}
	}

	public function razorpay()
	{        
		return view('front.razorpay');
	}

	public function payment(Request $request, $id)
	{
		$planID = $id;
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id != 3 || empty($user)){
			$userId = 0;
			\Session::flash('error', 'You are not allow to access here!');
			return redirect()->route('home');
		}else{
			$userId = $user->id;
		}

		$input = $request->all();
		//echo '<pre />'; print_r($input);
		$api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
		$payment = $api->payment->fetch($input['razorpay_payment_id']);

		if(count($input)  && !empty($input['razorpay_payment_id'])) 
		{
			try 
			{
				$response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount']));
				//echo '<pre />'; print_r($response); //die; //success@razorpay
				$paymentStatus = isset($response['status']) ? $response['status'] : 'failed';
				if ($paymentStatus!='failed') {
					//$txn_id = isset($response['id']) ? $response['id'] : $input['razorpay_payment_id'];
					echo $txn_id = $input['razorpay_payment_id'];// die;
					$amount = isset($response['amount']) ? $response['amount'] : '';
					if ($txn_id != '' && $amount != '') {
						$subPrice = $amount / 100;
						$paymentMode = 'Online';
						if($request->session()->has('payableAmt')){
							if($request->session()->get('payableAmt')==$subPrice){
								$paymentMode = 'Coupon & Online';
							}
						}
						$getSubscription = Subscription::where("id", $planID)->where("status", 1)->where("deleted", 0)->first();
						//echo '<pre />'; print_r($getSubscription); die;
						$subscriptionId = $getSubscription->id;
						$month = !empty($getSubscription->month) ? $getSubscription->month : 0;
						$today = date('Y-m-d');
						$end_date = date('Y-m-d', strtotime('+'.$month.' months'));
						$data1 = array(
							'user_id'			=> $userId,
							'subscription_id'	=> $subscriptionId,
							'start_date'		=> $today,
							'end_date'			=> $end_date,
							'txn_id'			=> $txn_id,
							'mode'				=> $paymentMode,
							'created_at'		=> date('Y-m-d H:i:s'),
						);
						$inserId = UserSubscription::insertGetId($data1);
						$user = User::where("id", $userId)->first();
						$msg = 'Subscription payment initiated';
						$this->smsWithTemplate($user->phone, 'Mambership', $user->name, $getSubscription->name);
						$this->addNotification($userId,$msg);
						/*$data = array('username' => $user->name, 'payment_id' =>  $txn_id, 'msg' =>  $msg);
						Mail::send('emails.payment', $data, function ($message) {
							$email = $user->email;
							$message->to($email, 'From BrainyWood')->subject('BrainyWood: Subscription payment initiated');
							$message->from('vedicbrainsoulutions@gmail.com', 'BrainyWood');
						});*/
						$this->sendEmail($user->email, 'BrainyWood: Subscription payment initiated', $data = array('userName' => $user->name, 'message' => '<p>Thank you for payment initiated at BrainyWood,</p><p>You have subscribed a plan successfully with Payment id: ' . $txn_id . '</p>'));

					}
				} else {
					\Session::flash('error', 'Payment not initiated!');
					return redirect()->back();
				}
			} 
			catch (\Exception $e) 
			{
				return  $e->getMessage();
				\Session::flash('error',$e->getMessage());
				return redirect()->back();
			}            
		}
		
		\Session::flash('success', 'Payment successful, your subscription available now.');
		return redirect()->back();
	}

	public function blogs(Request $request)
	{
		$pagename = "Blog";
		$search   = $request->search;
		$blogs  = Blog::where("status", 1)->where('deleted', 0);
		if (!empty($blogs)) {
			$blogs = $blogs->where("title", 'like', "%" . $search . "%");
		}
		$blogs = $blogs->orderBy('id', 'DESC')->get();

		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id != 3 || empty($user)){
			$userId = 0;
		}else{
			$userId = $user->id;
		}
		$today	= date('Y-m-d');
		$subscription = UserSubscription::where("user_id", $userId)->where("end_date", ">=", $today)->orderBy('id', 'DESC')->first();
		$userSubscription = !empty($subscription) ? 1 : 0;

		return view('front.blogs', compact('pagename','search','blogs','userSubscription'));
	}

	public function blogDetails($slug_url)
	{
		$pagename = "Blog Details";
		$blog = Blog::where('slug_url', $slug_url)->where("status", 1)->where('deleted', 0)->first();
		if (empty($blog)) {
			\Session::flash('error', 'Blog not available.');
			return redirect()->route('blogs');
		}
		$user = Auth::user();
		if(isset($user->role_id) && $user->role_id != 3 || empty($user)){
			$userId = 0;
		}else{
			$userId = $user->id;
		}
		$today	= date('Y-m-d');
		$subscription = UserSubscription::where("user_id", $userId)->where("end_date", ">=", $today)->orderBy('id', 'DESC')->first();
		$userSubscription = !empty($subscription) ? 1 : 0;

		return view('front.blog_details', compact('pagename','blog','userSubscription'));
	}

	public function staticPage($slug_url)
	{
		$pagename = "Page";
		$page = Page::where("slug_url", $slug_url)->where("status", 1)->where("deleted", 0)->first();
		if (empty($page)) {
			return redirect()->route('home');
		}
		
		return view('front.staticpage', compact('pagename','page'));
	}

	public static function get_excerpt($content, $length = 30, $more = '...' ) {
		$excerpt = strip_tags( trim( $content ) );
		$words = str_word_count( $excerpt, 2 );
		if ( count( $words ) > $length ) {
			$words = array_slice( $words, 0, $length, true );
			end( $words );
			$position = key( $words ) + strlen( current( $words ) );
			$excerpt = substr( $excerpt, 0, $position ) . $more;
		}
		return $excerpt;
	}

	public function addNotification($userId,$message)
	{
		$data = array(
			'user_id'		=> $userId,
			'message'		=> $message,
			'created_at'	=> date('Y-m-d H:i:s'),
		);
		$inserId = Notification::insertGetId($data);
		$user = User::where("id", $userId)->first();
		$token = isset($user->deviceToken) ? $user->deviceToken : '';
		if ($token!='') {
			$title = 'BrainyWood';
			$this->notificationsend($token, $title, $message);
		}
	}
	public function notificationsend($token, $title, $body)
	{
		$url = "https://fcm.googleapis.com/fcm/send";
		$token = $token;
		$serverKey = 'AAAAqt_CbVU:APA91bH1KAkCHGHbgQEtQYxUldBupx4_7y42dNa1hOPGz8IFePdzSXWu4uC1CudCTuowek2O01KScKbHgoROAscE8mCiy-53rcxcQOABsLvrp1JB14kbGNVT7sGqT53Qh1sjeAflTqC2';
		$title = $title;
		$body = $body;
		$notification = array('title' => $title, 'body' => $body, 'sound' => 'default', 'badge' => '1');
		$arrayToSend = array('to' => $token, 'notification' => $notification, 'priority' => 'high');
		$json = json_encode($arrayToSend);
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Authorization: key=' . $serverKey;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		//Send the request
		curl_exec($ch);
		curl_close($ch);
	}

	/*public function generatePDF()
	{
		$username = 'Rajendra Kataria';
		$content = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, remaining essentially unchanged.';
		$date = '31/05/2021';
		$data = ['username' => $username, 'content' => $content, 'date' => $date];
		$pdf = PDF::loadView('front.myPDF', $data);

		//return $pdf->stream();
  
		//return $pdf->download('certificate.pdf');
		$destinationPath = public_path().'/upload/generatedPDF/';
		return $pdf->save($destinationPath.'my_stored_file.pdf')->stream('download.pdf');
	}*/

	public function generatePDF($examId, $username, $date)
	{
		//$username = 'Rajendra Kataria';
		$content = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, remaining essentially unchanged.';
		$date = date('d/m/Y',strtotime($date));
		$data = ['username' => $username, 'content' => $content, 'date' => $date];
		$pdf = PDF::loadView('front.myPDF', $data);

		//return $pdf->stream();
  
		//return $pdf->download('certificate.pdf');
		$destinationPath = public_path().'/upload/generatedPDF/';
		$filename = $examId.'_'.time().'.pdf';
		if($pdf->save($destinationPath.$filename)->stream('download.pdf')){
			$update = StudentExam::where("id", $examId)->update(array("certificate" => $filename));
			return $filename;
		} else {
			return 0;
		}
	}

    public function sms($phone, $otp)
	{
		/*$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://2factor.in/API/V1/e0268e22-d023-11eb-8089-0200cd936042/SMS/' . $phone . '/' . $otp . '/Template',

			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_POSTFIELDS => "{}",
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);*/

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'http://2factor.in/API/V1/e0268e22-d023-11eb-8089-0200cd936042/ADDON_SERVICES/SEND/TSMS',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => array('From' => 'BRNYWD','To' => $phone,'TemplateName' => 'customtemplate','VAR1' => $otp),
			CURLOPT_HTTPHEADER => array(
				'token: gfLOYYpyKqGfyZ@vGMbeUhTcP%Erta#JnoDKWZffIVM@IVR'
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		//echo $response;
	}

    public function smsWithTemplate($phone, $templateName, $var1='', $var2='', $var3='', $var4='')
	{
		/*$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'http://2factor.in/API/V1/e0268e22-d023-11eb-8089-0200cd936042/ADDON_SERVICES/SEND/TSMS',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => array('From'=>'BRNYWD', 'To'=>$phone, 'TemplateName'=>$templateName, 'VAR1'=>$var1, 'VAR2'=>$var2, 'VAR3'=>$var3, 'VAR4'=>$var4),
			CURLOPT_HTTPHEADER => array(
				'token: gfLOYYpyKqGfyZ@vGMbeUhTcP%Erta#JnoDKWZffIVM@IVR'
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);*/

		$senderId = 'BRNYWD';

		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, "http://2factor.in/API/V1/e0268e22-d023-11eb-8089-0200cd936042/ADDON_SERVICES/SEND/TSMS");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "From=$senderId&To=$phone&TemplateName=$templateName&VAR1=$var1&VAR2=$var2&VAR3=$var3&VAR4=$var4");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		//print_r($response); exit;
		curl_close($ch);
		//echo $response;
	}

	public function sendEmail($to, $subject, $data)
	{
		$curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.sendgrid.com/v3/mail/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{"personalizations":[{"to":[{"email":"' . $to . '","name":"ByWood"}],"subject":"' . $subject . '"}],"content": [{"type": "text/html", "value": "<div style=\'background-color:#272b34 !important; text-align:center;display:block ;height: 43px;padding-top: 29px;\'>  <img src=\'http://brainscienceindia.in/public/front/assets/img/web-logo.png\' hight=\'50px\' width=\'100px\'> </div> <br>Hi  ' . $data['userName'] . ', <br><br> ' . $data['message'] . ' <br> <br>The Team <br> <br><span style=\'font-size:9px\'>You are receiving this email because  <br> <br><center style=\'font-size:9px\'>  Copyright © 2021 | BrainyWood | All rights reserved </center></span>"}],"from":{"email":"jangirgopal06@gmail.com","name":"BrainyWood"}}',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer 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',
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);


        curl_close($curl);
	}

	public function pi()
	{
		echo phpinfo();
	}
	//cron job
	public function sendLiveClassSecondNotification()
	{
		error_reporting(E_ALL);
		ini_set('max_execution_time', 0);

		/*Notification Send 45 minutes Before Start Live Class*/
		$from = date("Y-m-d H:i:s");
		//$to = date("Y-m-d H:i:s", strtotime("+1 hours"));
		$to = date("Y-m-d H:i:s", strtotime("+45 minutes"));
		$liveClasses = LiveClass::whereBetween("class_time",[$from, $to])->where("status", 1)->where("deleted", 0)->orderBy("id", "DESC")->get();
		foreach($liveClasses as $liveClass){
			$liveClassNotify = LiveclassNotify::where("class_id",$liveClass->id)->where("status",0)->get();
			foreach($liveClassNotify as $classNotify){
				$userId = $classNotify->user_id;
				$user = User::where("id", $userId)->first();
				$token = isset($user->deviceToken) ? $user->deviceToken : '';
				$liveCls = LiveClass::where("id",$classNotify->class_id)->where("status", 1)->where("deleted", 0)->first();
				$subject = $liveCls->subject;
				$class_time = $liveCls->class_time;
				$to_time = strtotime($class_time);
				$from_time = strtotime($from);
				echo $minutes = round(abs($to_time - $from_time) / 60). " minute"; //die;
				if(strtotime($liveCls->class_time) > strtotime($from)){
					if ($token!='') {
						$title = 'BrainyWood';
						$message = 'Please check your Live class.';
						$this->notificationsend($token, $title, $message);
					}
					$this->smsWithTemplate($user->phone, 'live_class_starting', $user->name, $subject, $class_time, $minutes);
					$this->sendEmail($user->email, 'BrainyWood: Live Class Notification', $data = array('userName' => $user->name, 'message' => '<p>Your live class of '.$subject.' at '.$class_time.' will start in '.$minutes.'. Please join timely.</p><p>Team Brainywood</p>'));
				}
			}
		}
	}
	public function sendLiveClassThirdNotification()
	{
		error_reporting(E_ALL);
		ini_set('max_execution_time', 0);

		/*Notification Send 15 minutes Before Start Live Class*/
		$from = date("Y-m-d H:i:s");
		//$to = date("Y-m-d H:i:s", strtotime("+1 hours"));
		$to = date("Y-m-d H:i:s", strtotime("+15 minutes"));
		$liveClasses = LiveClass::whereBetween("class_time",[$from, $to])->where("status", 1)->where("deleted", 0)->orderBy("id", "DESC")->get();
		foreach($liveClasses as $liveClass){
			$liveClassNotify = LiveclassNotify::where("class_id",$liveClass->id)->where("status",0)->get();
			foreach($liveClassNotify as $classNotify){
				$userId = $classNotify->user_id;
				$user = User::where("id", $userId)->first();
				$token = isset($user->deviceToken) ? $user->deviceToken : '';
				$liveCls = LiveClass::where("id",$classNotify->class_id)->where("status", 1)->where("deleted", 0)->first();
				$subject = $liveCls->subject;
				$class_time = $liveCls->class_time;
				$to_time = strtotime($class_time);
				$from_time = strtotime($from);
				echo $minutes = round(abs($to_time - $from_time) / 60). " minute"; //die;
				if(strtotime($liveCls->class_time) > strtotime($from)){
					if ($token!='') {
						$title = 'BrainyWood';
						$message = 'Please check your Live class.';
						$this->notificationsend($token, $title, $message);
					}
					$this->smsWithTemplate($user->phone, 'live_class_starting', $user->name, $subject, $class_time, $minutes);
					$this->sendEmail($user->email, 'BrainyWood: Live Class Notification', $data = array('userName' => $user->name, 'message' => '<p>Your live class of '.$subject.' at '.$class_time.' will start in '.$minutes.'. Please join timely.</p><p>Team Brainywood</p>'));
				}
			}
		}
	}
	public function sendLiveClassFourthNotification()
	{
		error_reporting(E_ALL);
		ini_set('max_execution_time', 0);

		/*Notification Send Same Time Start Live Class*/
		$from = date("Y-m-d H:i:s");
		//echo $to = date("Y-m-d H:i:s", strtotime("+15 minutes")); die;
		$liveClasses = LiveClass::where("class_time", $from)->where("status", 1)->where("deleted", 0)->orderBy("id", "DESC")->get();
		foreach($liveClasses as $liveClass){
			$liveClassNotify = LiveclassNotify::where("class_id",$liveClass->id)->where("status",0)->get();
			foreach($liveClassNotify as $classNotify){
				$userId = $classNotify->user_id;
				$user = User::where("id", $userId)->first();
				$token = isset($user->deviceToken) ? $user->deviceToken : '';
				$liveCls = LiveClass::where("id",$classNotify->class_id)->where("status", 1)->where("deleted", 0)->first();
				$subject = $liveCls->subject;
				$class_time = $liveCls->class_time;
				$to_time = strtotime($class_time);
				$from_time = strtotime($from);
				echo $minutes = round(abs($to_time - $from_time) / 60). " minute"; //die;
				//if(strtotime($liveCls->class_time) > strtotime($from)){
					if ($token!='') {
						$title = 'BrainyWood';
						$message = 'Please check your Live class.';
						$this->notificationsend($token, $title, $message);
					}
					$this->smsWithTemplate($user->phone, 'LiveClassStarted', $user->name, $subject);
					$this->sendEmail($user->email, 'BrainyWood: Live Class Started Notification', $data = array('userName' => $user->name, 'message' => '<p>Your live class of '.$subject.' has been started. Please join the class.</p><p>Team Brainywood</p>'));
				//}
			}
		}
	}
	public function convertVideoOneByOne()
	{
		error_reporting(E_ALL);
		ini_set('max_execution_time', 0);

		/*Live Class Last Notification Send*/
		$from = date("Y-m-d H:i:s", strtotime("-10 minutes"));
		$to = date("Y-m-d H:i:s");
		$liveClasses = LiveClass::whereBetween("class_time",[$from, $to])->where("status", 1)->where("deleted", 0)->orderBy("id", "DESC")->get();
		foreach($liveClasses as $liveClass){
			$liveClassNotify = LiveclassNotify::where("class_id",$liveClass->id)->where("status",0)->get();
			foreach($liveClassNotify as $classNotify){
				$userId = $classNotify->user_id;
				$user = User::where("id", $userId)->first();
				$token = isset($user->deviceToken) ? $user->deviceToken : '';
				$liveCls = LiveClass::where("id",$classNotify->class_id)->where("status", 1)->where("deleted", 0)->first();
				$subject = $liveCls->subject;
				if(strtotime($liveCls->class_time) < strtotime($from)){
					if ($token!='') {
						$title = 'BrainyWood';
						$message = 'Please check your Live class.';
						$this->notificationsend($token, $title, $message);
					}
					$this->smsWithTemplate($user->phone, 'LiveClassStarted', $user->name, $subject);
					$this->sendEmail($user->email, 'BrainyWood: Live Class Started Notification', $data = array('userName' => $user->name, 'message' => '<p>Your live class of '.$subject.' has been started. Please join the class.</p><p>Team Brainywood</p>'));
					$liveClsNotify = LiveclassNotify::findOrFail($classNotify->id);
					$liveClsNotify->status=1;
					$liveClsNotify->update();
				}
			}
		}


		/*Video Convert Start*/

		// $localurl = "D:/xampp/htdocs/fmpag/ffmpeg/bin/ffmpeg.exe";
		$localurl = "/usr/bin/ffmpeg";

		//Topic Videos
		//$topic = Chapter::where("fullvideo","!=","")->where("status", 1)->where("deleted", 0)->orWhere("video_1","")->orWhere("video_2","")->orWhere("video_3","")->orderBy("id", "DESC")->first();
		$topics = DB::select("SELECT * FROM `lession_chapters` WHERE (video_1 is null or video_2 is null or video_3 is null) and fullvideo !='' and `status` = 1 and `deleted` = 0 ORDER BY `id` desc limit 1");
		//echo '<pre />'; print_r($topic); die;
		if (!empty($topics)) {
			foreach ($topics as $topic) {
				$topic1 = Chapter::where("processtatus",1)->orderBy("id", "DESC")->first();
				$starttime = @$topic1->starttime;
				if (!empty($starttime)) {
					//echo $videolist1[0]['starttime']."=".date("Y-m-d H:i:s");
					$hourdiff = round((strtotime(date("Y-m-d H:i:s")) - strtotime($starttime)) / 3600, 1);
					echo $hourdiff;
					if ($hourdiff > 2) {
						//@mail("rajendra.kataria@jploft.in", "BrainyWood Topic Video Stuck", "video Id" . $topic1->id);
						$update = Chapter::where("id",$topic1->id)->update(array('endtime' => date("Y-m-d H:i:s"), 'processtatus' => 3));
					}

					echo "underprocess";
					exit;
				}

				$foldername = public_path().'/lessions/';
				
				$orgurl = $foldername . $topic->fullvideo;
				
				if (empty($topic->video_1)) {
					//echo "vbmxbglxdjb"; die;
					$name1 = $topic->id . "_240.mp4";
					$name2 = $topic->id . '_topic_' . time() . "_240.mp4";

					//$name1="1585034850720.mp4"; 
					//$videoname = "topic/" . $foldername . "/" . "video/" . $name1;
					$videourl = "temp/" .  $name1;
					$videoname = $foldername . $name2;
					$update = Chapter::where("id",$topic->id)->update(array('video_1' => 'NA', 'starttime' => date("Y-m-d H:i:s"), 'processtatus' => 1));

					$command1 = $localurl . " -i " . $orgurl . "  -aspect 4:3 -s 320x240 " . $videoname;

					$process = exec($command1, $result);
					echo $command1;
					
					// $upload = $this->s3->digitalocean($videoname, $videourl);
					//$upload = $this->s3->s3upload($videoname, $videourl);

					$videoTemp = new VideoTemp();
					$videoTemp->courseId = $topic->courseId;
					$videoTemp->lessionId = $topic->lessionId;
					$videoTemp->topicId = $topic->id;
					$videoTemp->low_video = $name2;
					$videoTemp->low_status = 1;
					$videoTemp->save();
					//$videoTempId=$videoTemp->id;
					$update = Chapter::where("id",$topic->id)->update(array('endtime' => date("Y-m-d H:i:s"), 'processtatus' => 2));
				} elseif (empty($topic->video_2)) {
					//echo 'here '.$topic->video_1; die;
					$name1 = $topic->id . "_480.mp4";
					$name2 = $topic->id . '_topic_' . time() . "_480.mp4";

					$videourl = "temp/" .  $name1;
					$videoname = $foldername . $name2;
					$update = Chapter::where("id",$topic->id)->update(array('video_2' => 'NA', 'starttime' => date("Y-m-d H:i:s"), 'processtatus' => 1));

					$command2 = $localurl . " -i " . $orgurl . "  -aspect 4:3 -s 480x360 " . $videoname;

					$process = exec($command2, $result);
					echo $command2;
					
					// $upload = $this->s3->digitalocean($videoname, $videourl);
					//$upload = $this->s3->s3upload($videoname, $videourl);

					$videoTemp = new VideoTemp();
					$videoTemp->courseId = $topic->courseId;
					$videoTemp->lessionId = $topic->lessionId;
					$videoTemp->topicId = $topic->id;
					$videoTemp->med_video = $name2;
					$videoTemp->med_status = 1;
					$videoTemp->save();
					//$videoTempId=$videoTemp->id;
					$update = Chapter::where("id",$topic->id)->update(array('endtime' => date("Y-m-d H:i:s"), 'processtatus' => 2));
				} else {
					if (empty($topic->video_3)) {
						$name1 = $topic->id . "_720.mp4";
						$name2 = $topic->id . '_topic_' . time() . "_720.mp4";

						$videourl = "temp/" .  $name1;
						$videoname = $foldername . $name2;
						$update = Chapter::where("id",$topic->id)->update(array('video_3' => 'NA', 'starttime' => date("Y-m-d H:i:s"), 'processtatus' => 1));

						$command3 = $localurl . " -i " . $orgurl . "  -aspect 16:9 -s 960x540 " . $videoname;

						$process = exec($command3, $result);
						echo $command3;
						
						// $upload = $this->s3->digitalocean($videoname, $videourl);
						//$upload = $this->s3->s3upload($videoname, $videourl);

						$videoTemp = new VideoTemp();
						$videoTemp->courseId = $topic->courseId;
						$videoTemp->lessionId = $topic->lessionId;
						$videoTemp->topicId = $topic->id;
						$videoTemp->high_video = $name2;
						$videoTemp->high_status = 1;
						$videoTemp->save();
						//$videoTempId=$videoTemp->id;
						$update = Chapter::where("id",$topic->id)->update(array('endtime' => date("Y-m-d H:i:s"), 'processtatus' => 2));

						//unlink($videourl);
						//print_r($result);
					}
				}
			}
		} else {
			//Lession Videos
			//$lession = Lession::where("fullvideo","!=","")->where("status", 1)->where("deleted", 0)->orderBy("id", "DESC")->orWhere("video_1","")->orWhere("video_2","")->orWhere("video_3","")->first();
			$lessions = DB::select("SELECT * FROM `lessions` WHERE (video_1 is null or video_2 is null or video_3 is null) and fullvideo !='' and `status` = 1 and `deleted` = 0 ORDER BY `id` desc limit 1");
			if (!empty($lessions)) {
				foreach ($lessions as $lession) {
					$lession1 = Lession::where("processtatus",1)->orderBy("id", "DESC")->first();
					$starttime = @$lession1->starttime;
					if (!empty($starttime)) {
						//echo $videolist1[0]['starttime']."=".date("Y-m-d H:i:s");
						$hourdiff = round((strtotime(date("Y-m-d H:i:s")) - strtotime($starttime)) / 3600, 1);
						echo $hourdiff;
						if ($hourdiff > 2) {
							//@mail("rajendra.kataria@jploft.in", "BrainyWood Lession Video Stuck", "video Id" . $lession1->id);
							$update = Lession::where("id",$lession1->id)->update(array('endtime' => date("Y-m-d H:i:s"), 'processtatus' => 3));
						}

						echo "underprocess";
						exit;
					}

					$foldername = public_path().'/lessions/';
					
					$orgurl = $foldername . $lession->fullvideo;
					
					if (empty($lession->video_1)) {
						//echo "vbmxbglxdjb"; die;
						$name1 = $lession->id . "_240.mp4";
						$name2 = $lession->id . '_lession_' . time() . "_240.mp4";

						$videourl = "temp/" .  $name1;
						$videoname = $foldername . $name2;
						$update = Lession::where("id",$lession->id)->update(array('video_1' => 'NA', 'starttime' => date("Y-m-d H:i:s"), 'processtatus' => 1));

						$command1 = $localurl . " -i " . $orgurl . "  -aspect 4:3 -s 320x240 " . $videoname;

						$process = exec($command1, $result);
						echo $command1;
						
						// $upload = $this->s3->digitalocean($videoname, $videourl);
						//$upload = $this->s3->s3upload($videoname, $videourl);

						$videoTemp = new VideoTemp();
						$videoTemp->courseId = $lession->courseId;
						$videoTemp->lessionId = $lession->id;
						$videoTemp->topicId = 0;
						$videoTemp->low_video = $name2;
						$videoTemp->low_status = 1;
						$videoTemp->save();
						//$videoTempId=$videoTemp->id;
						$update = Lession::where("id",$lession->id)->update(array('endtime' => date("Y-m-d H:i:s"), 'processtatus' => 2));
					} elseif (empty($lession->video_2)) {
						//echo 'here '.$lession->video_1; die;
						$name1 = $lession->id . "_480.mp4";
						$name2 = $lession->id . '_lession_' . time() . "_480.mp4";

						$videourl = "temp/" .  $name1;
						$videoname = $foldername . $name2;
						$update = Lession::where("id",$lession->id)->update(array('video_2' => 'NA', 'starttime' => date("Y-m-d H:i:s"), 'processtatus' => 1));

						$command2 = $localurl . " -i " . $orgurl . "  -aspect 4:3 -s 480x360 " . $videoname;

						$process = exec($command2, $result);
						echo $command2;
						
						// $upload = $this->s3->digitalocean($videoname, $videourl);
						//$upload = $this->s3->s3upload($videoname, $videourl);

						$videoTemp = new VideoTemp();
						$videoTemp->courseId = $lession->courseId;
						$videoTemp->lessionId = $lession->id;
						$videoTemp->topicId = 0;
						$videoTemp->med_video = $name2;
						$videoTemp->med_status = 1;
						$videoTemp->save();
						//$videoTempId=$videoTemp->id;
						$update = Lession::where("id",$lession->id)->update(array('endtime' => date("Y-m-d H:i:s"), 'processtatus' => 2));
					} else {
						$name1 = $lession->id . "_720.mp4";
						$name2 = $lession->id . '_lession_' . time() . "_720.mp4";

						$videourl = "temp/" .  $name1;
						$videoname = $foldername . $name2;
						$update = Lession::where("id",$lession->id)->update(array('video_3' => 'NA', 'starttime' => date("Y-m-d H:i:s"), 'processtatus' => 1));

						$command3 = $localurl . " -i " . $orgurl . "  -aspect 16:9 -s 960x540 " . $videoname;

						$process = exec($command3, $result);
						echo $command3;
						
						// $upload = $this->s3->digitalocean($videoname, $videourl);
						//$upload = $this->s3->s3upload($videoname, $videourl);

						$videoTemp = new VideoTemp();
						$videoTemp->courseId = $lession->courseId;
						$videoTemp->lessionId = $lession->id;
						$videoTemp->topicId = 0;
						$videoTemp->high_video = $name2;
						$videoTemp->high_status = 1;
						$videoTemp->save();
						//$videoTempId=$videoTemp->id;
						$update = Lession::where("id",$lession->id)->update(array('endtime' => date("Y-m-d H:i:s"), 'processtatus' => 2));

						//unlink($videourl);
						//print_r($result);
					}
				}
			} else {
				//Course Videos
				//$course = Courses::where("video","!=","")->where("status", 1)->where("deleted", 0)->orderBy("id", "DESC")->orWhere("video_1","")->orWhere("video_2","")->orWhere("video_3","")->first();
				$courses = DB::select("SELECT * FROM `courses` WHERE (video_1 is null or video_2 is null or video_3 is null) and video !='' and `status` = 1 and `deleted` = 0 ORDER BY `id` desc limit 1");
				if (!empty($courses)) {
					foreach ($courses as $course) {
						$course1 = Courses::where("processtatus",1)->orderBy("id", "DESC")->first();
						$starttime = @$course1->starttime;
						if (!empty($starttime)) {
							//echo $videolist1[0]['starttime']."=".date("Y-m-d H:i:s");
							$hourdiff = round((strtotime(date("Y-m-d H:i:s")) - strtotime($starttime)) / 3600, 1);
							echo $hourdiff;
							if ($hourdiff > 2) {
								//@mail("rajendra.kataria@jploft.in", "BrainyWood Course Video Stuck", "video Id" . $course1->id);
								$update = Courses::where("id",$course1->id)->update(array('endtime' => date("Y-m-d H:i:s"), 'processtatus' => 3));
							}

							echo "underprocess";
							exit;
						}

						$foldername = public_path().'/course/';
						
						$orgurl = $foldername . $course->video;
						
						if (empty($course->video_1)) {
							//echo "vbmxbglxdjb"; die;
							$name1 = $course->id . "_240.mp4";
							$name2 = $course->id . '_course_' . time() . "_240.mp4";

							$videourl = "temp/" .  $name1;
							$videoname = $foldername . $name2;
							$update = Courses::where("id",$course->id)->update(array('video_1' => 'NA', 'starttime' => date("Y-m-d H:i:s"), 'processtatus' => 1));

							$command1 = $localurl . " -i " . $orgurl . "  -aspect 4:3 -s 320x240 " . $videoname;

							$process = exec($command1, $result);
							echo $command1;
							
							// $upload = $this->s3->digitalocean($videoname, $videourl);
							//$upload = $this->s3->s3upload($videoname, $videourl);

							$videoTemp = new VideoTemp();
							$videoTemp->courseId = $course->id;
							$videoTemp->lessionId = 0;
							$videoTemp->topicId = 0;
							$videoTemp->low_video = $name2;
							$videoTemp->low_status = 1;
							$videoTemp->save();
							//$videoTempId=$videoTemp->id;
							$update = Courses::where("id",$course->id)->update(array('endtime' => date("Y-m-d H:i:s"), 'processtatus' => 2));
						} elseif (empty($course->video_2)) {
							//echo 'here '.$course->video_1; die;
							$name1 = $course->id . "_480.mp4";
							$name2 = $course->id . '_course_' . time() . "_480.mp4";

							$videourl = "temp/" .  $name1;
							$videoname = $foldername . $name2;
							$update = Courses::where("id",$course->id)->update(array('video_2' => 'NA', 'starttime' => date("Y-m-d H:i:s"), 'processtatus' => 1));

							$command2 = $localurl . " -i " . $orgurl . "  -aspect 4:3 -s 480x360 " . $videoname;

							$process = exec($command2, $result);
							echo $command2;
							
							// $upload = $this->s3->digitalocean($videoname, $videourl);
							//$upload = $this->s3->s3upload($videoname, $videourl);

							$videoTemp = new VideoTemp();
							$videoTemp->courseId = $course->id;
							$videoTemp->lessionId = 0;
							$videoTemp->topicId = 0;
							$videoTemp->med_video = $name2;
							$videoTemp->med_status = 1;
							$videoTemp->save();
							//$videoTempId=$videoTemp->id;
							$update = Courses::where("id",$course->id)->update(array('endtime' => date("Y-m-d H:i:s"), 'processtatus' => 2));
						} else {
							$name1 = $course->id . "_720.mp4";
							$name2 = $course->id . '_course_' . time() . "_720.mp4";

							$videourl = "temp/" .  $name1;
							$videoname = $foldername . $name2;
							$update = Courses::where("id",$course->id)->update(array('video_3' => 'NA', 'starttime' => date("Y-m-d H:i:s"), 'processtatus' => 1));

							$command3 = $localurl . " -i " . $orgurl . "  -aspect 16:9 -s 960x540 " . $videoname;

							$process = exec($command3, $result);
							echo $command3;
							
							// $upload = $this->s3->digitalocean($videoname, $videourl);
							//$upload = $this->s3->s3upload($videoname, $videourl);

							$videoTemp = new VideoTemp();
							$videoTemp->courseId = $course->id;
							$videoTemp->lessionId = 0;
							$videoTemp->topicId = 0;
							$videoTemp->high_video = $name2;
							$videoTemp->high_status = 1;
							$videoTemp->save();
							//$videoTempId=$videoTemp->id;
							$update = Courses::where("id",$course->id)->update(array('endtime' => date("Y-m-d H:i:s"), 'processtatus' => 2));

							//unlink($videourl);
							//print_r($result);
						}
					}
				} else {
					//Popular Videos
					//$popularVideo = Popularvideo::where("video","!=","")->where("status", 1)->where("deleted", 0)->orderBy("id", "DESC")->orWhere("video_1","")->orWhere("video_2","")->orWhere("video_3","")->first();
					$popularVideos = DB::select("SELECT * FROM `popular_videos` WHERE (video_1 is null or video_2 is null or video_3 is null) and video !='' and `status` = 1 and `deleted` = 0 ORDER BY `id` desc limit 1");
					if (!empty($popularVideos)) {
						foreach ($popularVideos as $popularVideo) {
							$popularVideo1 = Popularvideo::where("processtatus",1)->orderBy("id", "DESC")->first();
							$starttime = @$popularVideo1->starttime;
							if (!empty($starttime)) {
								//echo $videolist1[0]['starttime']."=".date("Y-m-d H:i:s");
								$hourdiff = round((strtotime(date("Y-m-d H:i:s")) - strtotime($starttime)) / 3600, 1);
								echo $hourdiff;
								if ($hourdiff > 2) {
									//@mail("rajendra.kataria@jploft.in", "BrainyWood Popular Video Stuck", "video Id" . $popularVideo1->id);
									$update = Popularvideo::where("id",$popularVideo1->id)->update(array('endtime' => date("Y-m-d H:i:s"), 'processtatus' => 3));
								}

								echo "underprocess";
								exit;
							}

							$foldername = public_path().'/upload/popularvideos/';
							
							$orgurl = $foldername . $popularVideo->video;
							
							if (empty($popularVideo->video_1)) {
								//echo "vbmxbglxdjb"; die;
								$name1 = $popularVideo->id . "_240.mp4";
								$name2 = $popularVideo->id . '_popular_' . time() . "_240.mp4";

								$videourl = "temp/" .  $name1;
								$videoname = $foldername . $name2;
								$update = Popularvideo::where("id",$popularVideo->id)->update(array('video_1' => 'NA', 'starttime' => date("Y-m-d H:i:s"), 'processtatus' => 1));

								$command1 = $localurl . " -i " . $orgurl . "  -aspect 4:3 -s 320x240 " . $videoname;

								$process = exec($command1, $result);
								echo $command1;
								
								// $upload = $this->s3->digitalocean($videoname, $videourl);
								//$upload = $this->s3->s3upload($videoname, $videourl);

								$videoTemp = new VideoTemp();
								$videoTemp->popularvideoId = $popularVideo->id;
								$videoTemp->low_video = $name2;
								$videoTemp->low_status = 1;
								$videoTemp->save();
								//$videoTempId=$videoTemp->id;
								$update = Popularvideo::where("id",$popularVideo->id)->update(array('endtime' => date("Y-m-d H:i:s"), 'processtatus' => 2));
							} elseif (empty($popularVideo->video_2)) {
								//echo 'here '.$popularVideo->video_1; die;
								$name1 = $popularVideo->id . "_480.mp4";
								$name2 = $popularVideo->id . '_popular_' . time() . "_480.mp4";

								$videourl = "temp/" .  $name1;
								$videoname = $foldername . $name2;
								$update = Popularvideo::where("id",$popularVideo->id)->update(array('video_2' => 'NA', 'starttime' => date("Y-m-d H:i:s"), 'processtatus' => 1));

								$command2 = $localurl . " -i " . $orgurl . "  -aspect 4:3 -s 480x360 " . $videoname;

								$process = exec($command2, $result);
								echo $command2;
								
								// $upload = $this->s3->digitalocean($videoname, $videourl);
								//$upload = $this->s3->s3upload($videoname, $videourl);

								$videoTemp = new VideoTemp();
								$videoTemp->popularvideoId = $popularVideo->id;
								$videoTemp->med_video = $name2;
								$videoTemp->med_status = 1;
								$videoTemp->save();
								//$videoTempId=$videoTemp->id;
								$update = Popularvideo::where("id",$popularVideo->id)->update(array('endtime' => date("Y-m-d H:i:s"), 'processtatus' => 2));
							} else {
								$name1 = $popularVideo->id . "_720.mp4";
								$name2 = $popularVideo->id . '_popular_' . time() . "_720.mp4";

								$videourl = "temp/" .  $name1;
								$videoname = $foldername . $name2;
								$update = Popularvideo::where("id",$popularVideo->id)->update(array('video_3' => 'NA', 'starttime' => date("Y-m-d H:i:s"), 'processtatus' => 1));

								$command3 = $localurl . " -i " . $orgurl . "  -aspect 16:9 -s 960x540 " . $videoname;

								$process = exec($command3, $result);
								echo $command3;
								
								// $upload = $this->s3->digitalocean($videoname, $videourl);
								//$upload = $this->s3->s3upload($videoname, $videourl);

								$videoTemp = new VideoTemp();
								$videoTemp->popularvideoId = $popularVideo->id;
								$videoTemp->high_video = $name2;
								$videoTemp->high_status = 1;
								$videoTemp->save();
								//$videoTempId=$videoTemp->id;
								$update = Popularvideo::where("id",$popularVideo->id)->update(array('endtime' => date("Y-m-d H:i:s"), 'processtatus' => 2));

								//unlink($videourl);
								//print_r($result);
							}
						}
					} else {
						//LiveClass Videos
						//$liveClass = LiveClass::where("video","!=","")->where("status", 1)->where("deleted", 0)->orderBy("id", "DESC")->orWhere("video_1","")->orWhere("video_2","")->orWhere("video_3","")->first();
						$liveClasses = DB::select("SELECT * FROM `live_classes` WHERE (video_1 is null or video_2 is null or video_3 is null) and video !='' and `status` = 1 and `deleted` = 0 ORDER BY `id` desc limit 1");
						if (!empty($liveClasses)) {
							foreach ($liveClasses as $liveClass) {
								$liveClass1 = LiveClass::where("processtatus",1)->orderBy("id", "DESC")->first();
								$starttime = @$liveClass1->starttime;
								if (!empty($starttime)) {
									//echo $videolist1[0]['starttime']."=".date("Y-m-d H:i:s");
									$hourdiff = round((strtotime(date("Y-m-d H:i:s")) - strtotime($starttime)) / 3600, 1);
									echo $hourdiff;
									if ($hourdiff > 2) {
										//@mail("rajendra.kataria@jploft.in", "BrainyWood Popular Video Stuck", "video Id" . $liveClass1->id);
										$update = LiveClass::where("id",$liveClass1->id)->update(array('endtime' => date("Y-m-d H:i:s"), 'processtatus' => 3));
									}

									echo "underprocess";
									exit;
								}

								$foldername = public_path().'/upload/liveclasses/';
								
								$orgurl = $foldername . $liveClass->video;
								
								if (empty($liveClass->video_1)) {
									//echo "vbmxbglxdjb"; die;
									$name1 = $liveClass->id . "_240.mp4";
									$name2 = $liveClass->id . '_live_' . time() . "_240.mp4";

									$videourl = "temp/" .  $name1;
									$videoname = $foldername . $name2;
									$update = LiveClass::where("id",$liveClass->id)->update(array('video_1' => 'NA', 'starttime' => date("Y-m-d H:i:s"), 'processtatus' => 1));

									$command1 = $localurl . " -i " . $orgurl . "  -aspect 4:3 -s 320x240 " . $videoname;

									$process = exec($command1, $result);
									echo $command1;
									
									// $upload = $this->s3->digitalocean($videoname, $videourl);
									//$upload = $this->s3->s3upload($videoname, $videourl);

									$videoTemp = new VideoTemp();
									$videoTemp->liveclassId = $liveClass->id;
									$videoTemp->low_video = $name2;
									$videoTemp->low_status = 1;
									$videoTemp->save();
									//$videoTempId=$videoTemp->id;
									$update = LiveClass::where("id",$liveClass->id)->update(array('endtime' => date("Y-m-d H:i:s"), 'processtatus' => 2));
								} elseif (empty($liveClass->video_2)) {
									//echo 'here '.$liveClass->video_1; die;
									$name1 = $liveClass->id . "_480.mp4";
									$name2 = $liveClass->id . '_live_' . time() . "_480.mp4";

									$videourl = "temp/" .  $name1;
									$videoname = $foldername . $name2;
									$update = LiveClass::where("id",$liveClass->id)->update(array('video_2' => 'NA', 'starttime' => date("Y-m-d H:i:s"), 'processtatus' => 1));

									$command2 = $localurl . " -i " . $orgurl . "  -aspect 4:3 -s 480x360 " . $videoname;

									$process = exec($command2, $result);
									echo $command2;
									
									// $upload = $this->s3->digitalocean($videoname, $videourl);
									//$upload = $this->s3->s3upload($videoname, $videourl);

									$videoTemp = new VideoTemp();
									$videoTemp->liveclassId = $liveClass->id;
									$videoTemp->med_video = $name2;
									$videoTemp->med_status = 1;
									$videoTemp->save();
									//$videoTempId=$videoTemp->id;
									$update = LiveClass::where("id",$liveClass->id)->update(array('endtime' => date("Y-m-d H:i:s"), 'processtatus' => 2));
								} else {
									$name1 = $liveClass->id . "_720.mp4";
									$name2 = $liveClass->id . '_live_' . time() . "_720.mp4";

									$videourl = "temp/" .  $name1;
									$videoname = $foldername . $name2;
									$update = LiveClass::where("id",$liveClass->id)->update(array('video_3' => 'NA', 'starttime' => date("Y-m-d H:i:s"), 'processtatus' => 1));

									$command3 = $localurl . " -i " . $orgurl . "  -aspect 16:9 -s 960x540 " . $videoname;

									$process = exec($command3, $result);
									echo $command3;
									
									// $upload = $this->s3->digitalocean($videoname, $videourl);
									//$upload = $this->s3->s3upload($videoname, $videourl);

									$videoTemp = new VideoTemp();
									$videoTemp->liveclassId = $liveClass->id;
									$videoTemp->high_video = $name2;
									$videoTemp->high_status = 1;
									$videoTemp->save();
									//$videoTempId=$videoTemp->id;
									$update = LiveClass::where("id",$liveClass->id)->update(array('endtime' => date("Y-m-d H:i:s"), 'processtatus' => 2));

									//unlink($videourl);
									//print_r($result);
								}
							}
						}
					}
				}
			}
		}
	}
	public function membershipExpiry()
	{
		error_reporting(E_ALL);
		ini_set('max_execution_time', 0);

		/*Notification Send Before 2 days Membership Expired*/
		echo $from = date("Y-m-d");
		echo $to = date("Y-m-d", strtotime("+2 days")); //die;
		$userSubscriptions = UserSubscription::whereBetween("end_date",[$from, $to])->orderBy('id', 'DESC')->get();
		foreach($userSubscriptions as $userPlan){
			$userId = $userPlan->user_id;
			$user = User::where("id", $userId)->first();
			$token = isset($user->deviceToken) ? $user->deviceToken : '';
			$subscription = Subscription::where("id", $userPlan->subscription_id)->first();
			if(strtotime($userPlan->end_date) > strtotime($from)){
				if ($token!='') {
					$title = 'BrainyWood';
					$message = 'Please purchase our new subscription plans to avoid interruption into the services.';
					$this->notificationsend($token, $title, $message);
				}
				$this->smsWithTemplate($user->phone, 'MembershipExpiry', $user->name, $subscription->name, $userPlan->end_date);
				$this->sendEmail($user->email, 'BrainyWood: Live Class Started Notification', $data = array('userName' => $user->name, 'message' => '<p>Your brainywood subscription plan of '.$subscription->name.' will be expired on '.$userPlan->end_date.', Please purchase our new subscription plans to avoid interruption into the services.</p>'));
			}
		}
	}


}
