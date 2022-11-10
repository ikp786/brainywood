<?php
namespace App\Http\Controllers\Api;

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
use App\Chapter;
use App\Contactus;
use App\ContinueStudy;
use App\CouponCode;
use App\Coursefeature;
use App\Coursefeq;
use App\Courses;
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
use App\User;
use App\UserSubscription;
use Image;
use DateTime;
date_default_timezone_set('Asia/Kolkata');
use DB;
use Carbon\Carbon;
use PDF;
include public_path().'/razorpay-php/Razorpay.php';
use Razorpay\Api\Api;


class ApiController extends Controller
{
	/*protected function respondWithToken($token)
	{
	  return response()->json([
		'access_token' => $token,
		'token_type' => '123456',
		'expires_in' => auth()->factory()->getTTL() * 60
	  ]);
	}*/

	public function generateRandomString($length = 50)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	public function convertTimeinMiliseconds($hour,$minute,$seconds)
	{
	    $sec_to_milli = $seconds * 1000;            //seconds to milliseconds
	    $min_to_milli = $minute * 60 * 1000;        //minutes to milliseconds
	    $hrs_to_milli = $hour * 60 * 60 * 1000;     //hours to milliseconds

	    $milliseconds = $hrs_to_milli + $min_to_milli + $sec_to_milli;

	    return $milliseconds;
	}

	public function getStudentClass()
	{
		$studentClasses = StudentClass::where('status',1)->where('deleted',0)->orderBy('id', 'ASC')->get();
		$classdata = array();
		foreach ($studentClasses as $key => $val) {
			$classdata[$key]['id'] = $val['id'];
			$classdata[$key]['class_name'] = $val['class_name'];
		}
		$message = "Get All Student Classes List.";
		return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("student_classes" => $classdata)]);
	}

	public function getStates()
	{
		$states = State::orderBy('state', 'ASC')->get();
		$statedata = array();
		foreach ($states as $key => $val) {
			$statedata[$key]['id'] = $val['id'];
			$statedata[$key]['state_name'] = $val['state'];
		}
		$message = "Get All States List.";
		return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("states" => $statedata)]);
	}

	public function getuserDetail($userid)
	{
		$user = User::where('id', '=', $userid)->first();
		if ($user->role_id == 1) {
			$role = "Administrator";
		}else if ($user->role_id == 2) {
			$role = "Teacher";
		}else{
			$role = "User";
		}
		//$features = UserFeature::where("user_id", $userid)->get();
		$featureArray = array();
		if (!empty($features)) {
			foreach ($features as $val) {
				$featureArray[] = array("name" => $val->name);
			}
		}
		$data = array(
			'userId' => ($user->id) ? $user->id : '',
			//'role_id' => ($role) ? $role : '',
			'name' => ($user->name) ? $user->name : '',
			'email' => ($user->email) ? $user->email : '',
			'phone' => ($user->phone) ? $user->phone : '',
			'gender' => ($user->gender) ? $user->gender : '',
			'dob' => ($user->dob) ? date('m/d/Y', strtotime($user->dob)) : '',
			'class_name' => ($user->class_name) ? $user->class_name : '',
			'school_college' => ($user->school_college) ? $user->school_college : '',
			'state' => ($user->state) ? $user->state : '',
			'city' => ($user->city) ? $user->city : '',
			'image' => ($user->image) ? asset('upload/profile') . '/' . $user->image : '',
			'api_token' => ($user->api_token) ? $user->api_token : '',
			'otp_match' => ($user->otp_match) ? $user->otp_match : '',
			//'firebase_user_id' => ($user->firebase_user_id) ? $user->firebase_user_id : '',
			//'features' => $featureArray,
		);
		return $data;
	}
	
	public function login(Request $request)
	{
	    //$this->sms("8448323559",1234);die;
		$validator = Validator::make($request->all(), [
			'email' => 'required',
			'password' => 'required',
			'deviceToken' => 'required',
		]);

		if($validator->fails()){
        	$msg = $validator->messages()->first();
			return response()->json(['statusCode' => 400, 'message' => $msg, 'data' => array("id" => "")]);
		}
		//dd($request->all());
		$email		        = !empty($_REQUEST['email']) ? trim($_REQUEST['email']) : '';
		//$mobile		    = !empty($_REQUEST['mobile']) ? trim($_REQUEST['mobile']) : '';
		$password           = !empty($_REQUEST['password']) ? trim($_REQUEST['password']) : '';
		$deviceToken        = !empty($_REQUEST['deviceToken']) ? trim($_REQUEST['deviceToken']) : '';
		//$firebase_user_id = !empty($_REQUEST['firebase_user_id']) ? trim($_REQUEST['firebase_user_id']) : '';
		//firebase_user_id
		if (!empty($email) && !empty($password)) {
			if (is_numeric($email)) {
				$checkUser = User::where("phone", $email)->first();
				if (!empty($checkUser)) {
					if (Hash::check($password, $checkUser->password)) {
						if (Auth::attempt(['phone' => $email, 'password' => $password])) {
							$user = Auth::user();
							if($user->role_id != 3){
								$msg = "You are not allowed to login here!";
								return response()->json(['statusCode' => 400, 'message' => $msg, 'data' => array("id" => "")]);
							}
							if($user->status != 1){
								$msg = "Your account not activated, Please contact to Team!";
								return response()->json(['statusCode' => 400, 'message' => $msg, 'data' => array("id" => "")]);
							}
							$otp = rand(1111, 9999);
							$user->generateToken();
							$userss = User::find($user->id);
							$userss->deviceToken = $deviceToken;
							$userss->otp_match = $otp;
							$userss->save();
							$this->sms($user->phone, $otp);
							$this->sendEmail($user->email, 'BrainyWood: Verify OTP', $data = array('userName' => $user->name, 'message' => '<p>Thank you for connecting at BrainyWood,</p><p>You have got successfully your OTP: ' . $otp . '</p>'));

							$code = 200;
							$msg = 'Login successfully.';
							$returndata = $user;
							$returndata['image'] = !empty($user->image) ? asset('upload/profile') . "/" . $user->image : '';
						}else{
							$code = 400;
							$msg = 'Mobile number and Password not matched!';
							$returndata = array("id" => "");
						}
					}else{
						$code = 400;
						$msg = 'Password not matched!';
						$returndata = array("id" => "");
					}
				}else{
					$code = 400;
					$msg = 'Mobile number not matched!';
					$returndata = array("id" => "");
				}
			} else {
				$checkUser = User::where("email", $email)->first();
				if (!empty($checkUser)) {
					if (Hash::check($password, $checkUser->password)) {
						if(Auth::attempt(['email' => $email, 'password' => $password])){
							$user = Auth::user();
							if($user->role_id != 3){
								$msg = "You are not allowed to login here!";
								return response()->json(['statusCode' => 400, 'message' => $msg, 'data' => array("id" => "")]);
							}
							if($user->status != 1){
								$msg = "Your account not activated, Please contact to Team!";
								return response()->json(['statusCode' => 400, 'message' => $msg, 'data' => array("id" => "")]);
							}
							$otp = rand(1111, 9999);
							//$user['token'] =  $user->createToken('MyApp')->accessToken;
							$user->generateToken();
							$userss = User::find($user->id);
							$userss->deviceToken = $deviceToken;
							$userss->otp_match = $otp;
							$userss->save();
							$this->sms($user->phone, $otp);
							$this->sendEmail($user->email, 'BrainyWood: Verify OTP', $data = array('userName' => $user->name, 'message' => '<p>Thank you for connecting at BrainyWood,</p><p>You have got successfully your OTP: ' . $otp . '</p>'));

							$code = 200;
							$msg = 'Login successfully.';
							$returndata = $user;
							$returndata['image'] = !empty($user->image) ? asset('upload/profile') . "/" . $user->image : '';
							//return response()->json(['success' => $success], 200);
						}else{
							$code = 400;
							$msg = 'Email id and Password not matched!';
							$returndata = array("id" => "");
						}
					}else{
						$code = 400;
						$msg = 'Password not matched!';
						$returndata = array("id" => "");
					}
				}else{
					$code = 400;
					$msg = 'Email id not matched!';
					$returndata = array("id" => "");
				}
			}
		}else{
			$code = 400;
			$msg = 'Email id or Mobile number not found!';
			$returndata = array("id" => "");
		}
		return response()->json(['statusCode' => $code, 'message' => $msg, 'data' => $returndata]);
	}

	public function register(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required|regex:/^[\pL\s\-]+$/u',
			'email' => 'required|email|unique:users,email',
			'phone' => 'required|numeric|min:10|unique:users,phone',
			'password' => 'required|min:6',
			'confirm_password' => 'required|min:6|max:20|same:password',
		]);

		if($validator->fails()){
        	$msg = $validator->messages()->first();
			//return $this->sendError($validator->messages()->first());
			return response()->json(['statusCode' => 400, 'message' => $msg, 'data' => array("id" => "")]);
		}

	    //echo '<pre />'; print_r($request->all()); die;
		$name 				= ucwords($request->input('name'));
		$email 				= $request->input('email');
		$phone 				= $request->input('phone');
		$password 			= $request->input('password');
		$confirm_password 	= $request->input('confirm_password');
		$gender 			= $request->input('gender');
		$class_name 		= $request->input('class_name');
		$state 				= $request->input('state');
		$city 				= $request->input('city');
		$deviceToken 		= $request->input('deviceToken');
		//$firebase_user_id = $request->input('firebase_user_id');
		$msg = '';
		if (!empty($name)  && !empty($email) && !empty($phone) && !empty($password)) {
			if ($password != $confirm_password) {
				$msg = "Password and Confirm password not matched!";
				return response()->json(['statusCode' => 400, 'message' => $msg, 'data' => array("id" => "")]);
			}
			$usercheck = User::where('email', $email)->first();
			if (!empty($usercheck)) {
				$msg = "Email id already exists. Please login directly.";
				return response()->json(['statusCode' => 400, 'message' => $msg, 'data' => array("id" => "")]);
			} else {
				$phonecheck = User::where('phone', $phone)->first();
				if (!empty($phonecheck)) {
					$msg = "Phone number already exists. Please login directly.";
					return response()->json(['statusCode' => 400, 'message' => $msg, 'data' => array("id" => "")]);
				} else {
					$imagess = '';
					if (isset($_FILES['image']['name']) && $_FILES['image']['name']!='') {
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
					$data = array(
						'role_id' 	=> 3,
						'name' 		=> $name,
						'email' 	=> $email,
						'phone' 	=> $phone,
						'password' 	=> bcrypt($password),
						'userpass' 	=> $password,
						//'image'   => $imagess,
						'gender' 	=> $gender,
						//'dob'     => $dob,
						'class_name' => $class_name,
						//'school_college' => $school_college,
						'state' 	=> $state,
						'city' 		=> $city,
						'remember_token' => Str::random(60),
						'api_token' => Str::random(60),
						'devicetoken' => $deviceToken,
						'otp_match' => $otp,
						'status'    => 1,
						//'firebase_user_id' => $firebase_user_id,
						//'isDevice'=>'App',
						'created_at' => date('Y-m-d H:i:s'),
					);
					$userId = User::insertGetId($data);
					/* $user=User::find($userId);
					$refercode = strtoupper(substr($name, 0, 3));
					$refercode = $refercode . $user->id;
					$user->refercode = $refercode;
					$user->save(); */
					$msg = 'User Registration Completed Successfully.';
					$this->sms($phone, $otp);
					$this->addNotification($userId,$msg);
					/*$data = array('username' => $name, 'OTP' =>  $otp, 'msg' =>  $msg);
					Mail::send('emails.register', $data, function ($message) {
						$email = $_POST['email'];
						$message->to($email, 'From BrainyWood')->subject('BrainyWood: Verify your account');
						$message->from('vedicbrainsoulutions@gmail.com', 'BrainyWood');
					});*/
					$this->sendEmail($email, 'BrainyWood: Verify your account', $data = array('userName' => $name, 'message' => '<p>Thank you for connecting at BrainyWood,</p><p>You have got successfully your OTP: ' . $otp . '</p>'));
					$returndata = array();
					$returndata = $this->getuserDetail($userId);
					$returndata['otp'] = $otp;
					return response()->json(['statusCode' => 200, 'message' => $msg, 'data' => $returndata]);
				}
			}
		} else {
			$msg = "Wrong Paramenter Passed!";
			return response()->json(['statusCode' => 400, 'message' => $msg, 'data' => array("id" => "")]);
		}
		//$token = auth()->login($user);
		//return $this->respondWithToken($token);
	}
	public function otpMatch(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'userId' => 'required|numeric',
			'otp' => 'required|numeric',
		]);

		if($validator->fails()){
        	$msg = $validator->messages()->first();
			return response()->json(['statusCode' => 400, 'message' => $msg, 'data' => array("id" => "")]);
		}
		$userId = $request->input('userId');
		$otp = $request->input('otp');
		if (empty($otp) || empty($userId)) {
			return response()->json(['statusCode' => 400, 'message' => 'Wrong parameter Passed!', 'data' => array("id" => "")]);
		}
		$user = User::where('otp_match', $otp)->where("id", $userId)->first();
		if ($user) {
			DB::table('users')->where('id', $userId)->update(array('status' => 1));
			$returndata = array();
			$returndata = $this->getuserDetail($user->id);
			$this->smsWithTemplate($user->phone, 'AfterVerificationAccount', '+919950368500', 'vedicbrainsolutions@gmail.com');
			return response()->json(['statusCode' => 200, 'message' => 'Account Verified Successfully.', 'data' => $returndata]);
		} else {
			return response()->json(['statusCode' => 400, 'message' => 'otp does not match!', 'data' =>  array("id" => "")]);
		}
	}
	public function resendOtp(Request $request)
	{
		$userId = $request->input('userId');
		if (!empty($userId)) {
			$checkUser = User::where('id', $userId)->first();
			if ($checkUser) {
				$otpnumber = rand(1111, 9999);
				$phone = $checkUser->phone;
				$update = DB::table('users')->where('id', $userId)->update(['otp_match' => $otpnumber]);
				if ($update) {
					$returndata['otp'] = $otpnumber;
					$msg = 'Verification Otp Send, Please Check.';
					$this->sms($phone, $otpnumber);
					/*$data = array('username' => $checkUser->name, 'OTP' => $otpnumber, 'msg' => $msg);
					Mail::send('emails.otpmail', $data, function ($message) {
						$checkUser = User::where('id', $_POST['userId'])->first();
						$email = $checkUser->email;
						$message->to($email, 'From BrainyWood')->subject('BrainyWood: Verify OTP');
						$message->from('vedicbrainsoulutions@gmail.com', 'BrainyWood');
					});*/
					$this->sendEmail($checkUser->email, 'BrainyWood: Verify OTP', $data = array('userName' => $checkUser->name, 'message' => '<p>Thank you for connecting at BrainyWood,</p><p>You have got successfully your OTP: ' . $otpnumber . '</p>'));
					
					return response()->json(['statusCode' => 200, 'message' => $msg, "data" => $returndata]);
				} else {
					return response()->json(['statusCode' => 400, 'message' => 'Somthing Went Wrong!', 'data' => array("otp" => "")]);
				}
			} else {
				return response()->json(['statusCode' => 400, 'message' => 'Invaild User Id!', 'data' => array("otp" => "")]);
			}
		} else {
			return response()->json(['statusCode' => 400, 'message' => 'Wrong Paramenter Passed!', 'data' => array("otp" => "")]);
		}
	}

	public function forgetpassword(Request $request)
	{
		$returndata = array();
		$email = $request->email;
		if ($email != '') {
			if (is_numeric($email)) {
				//$user = User::where('phone', '=', $phone)->where('status', '=', 1)->where("role_id", $role_id)->first();
				$user = User::where('phone', $email)->first();
			} else {
				$user = User::where('email', $email)->first();
			}
		} else {
			$msg = "Wrong Paramenter Passed!";
			return response()->json(['statusCode' => 400, 'message' => $msg, 'data' => array("type" => "forgetpassword")]);
		}
		if (!empty($user)) {
			$otp = rand(1111, 9999);
			$user->otp_match = $otp;
			$user->save();
			$msg = 'Verification OTP send on your mobile and email address, Please Check.';
			$this->sms($user->phone, $otp);
			/*$data = array('username' => $user->name, 'OTP' =>  $otp, 'msg' =>  $msg);
			Mail::send('emails.app_forgot_password', $data, function ($message) {
				$email = $_POST['email'];
				if ($email != '') {
					if (is_numeric($email)) {
						$user = User::where('phone', $email)->first();
					} else {
						$user = User::where('email', $email)->first();
					}
				}
				$email = $user->email;
				$message->to($email, 'From BrainyWood')->subject('BrainyWood: Forgot Password');
				$message->from('vedicbrainsoulutions@gmail.com', 'BrainyWood');
			});*/
			$this->sendEmail($user->email, 'BrainyWood: Forgot Password', $data = array('userName' => $user->name, 'message' => '<p>You have been forgotton your password, don\'t worry, Please reset your password </p><p>You have got successfully your OTP: '. $otp . '</p>'));
			
			$returndata['type'] = 'forgetpassword';
			$returndata['userId'] = $user->id;
			$returndata['otp'] = $otp;
			return response()->json(['statusCode' => 200, 'message' => $msg, "data" => $returndata]);
		} else {
			$msg = "Phone Number Not Exist!";
			return response()->json(['statusCode' => 400, 'message' => $msg, 'data' => array("type" => "forgetpassword")]);
		}
	}
	public function resetPassword(Request $request)
	{
		$userId 			= $request->userId;
		$newPassword 		= $request->newPassword;
		$confirmPassword 	= $request->confirmPassword;
		$checkUser = User::where('id', $userId)->first();
		if (!empty($checkUser)) {
			if (!empty($newPassword)) {
				if ($newPassword != $confirmPassword) {
					$msg = "Password and Confirm password not matched!";
					return response()->json(['statusCode' => 400, 'message' => $msg, 'data' => array("userId" => $userId)]);
				}
				$updateData = User::where('id', $userId)->update([
					'password'		=> bcrypt($newPassword),
					'userpass'		=> $newPassword,
					'updated_at' 	=> date('Y-m-d H:i:s')
				]);
				$message = 'Password Reset Successfully';
				return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("userId" => $userId)]);
			} else {
				$message = 'Please enter new password!';
				return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("userId" => $userId)]);
			}
		} else {
			$msg = "Invalid User Id ";
			return response()->json(['statusCode' => 400, 'message' => $msg, 'data' => array("userId" => $userId)]);
		}
	}

	public function checkUserToken(Request $request)
	{
		$userId 	= $request->userId;
		$bearerToken = $request->bearerToken();
		if ($userId > 0) {
			$user = User::where("id", $userId)->where("deleted", 0)->first();
			$userStatus = !empty($user) ? $user->status : 0;
			if ($userStatus == 1) {
				if ($bearerToken != $user->api_token) {
					$userStatus = 0;
				}
			}
		} else {
			$userStatus = 0;
		}
		//return $userStatus;
		if ($userStatus == 0) {
			$message = "User not Available.";
        	return response()->json(['statusCode' => 203, 'message' => $message]);
        } else {
        	$message = "User Available.";
        	return response()->json(['statusCode' => 200, 'message' => $message]);
        }
	}

	public function isUserActive($userId,$bearerToken=NULL)
	{
		if ($userId > 0) {
			$user = User::where("id", $userId)->where("deleted", 0)->first();
			$userStatus = !empty($user) ? $user->status : 0;
			if ($userStatus == 1) {
				if ($bearerToken != $user->api_token) {
					$userStatus = 0;
				}
			}
		} else {
			$userStatus = 0;
		}
		return $userStatus;
	}


	public function getAboutUsDetails(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId 	= $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("userSubscription" => "", "aboutus" => array("id" => ""), "portfolios" => [])]);
		}
		$today	  = date('Y-m-d');
		$subscription = UserSubscription::where("user_id", $userId)->where("end_date", ">=", $today)->orderBy('id', 'DESC')->first();
		$userSubscription = !empty($subscription) ? 1 : 0;
		$aboutUs = AboutUs::where("id", 1)->first();
		$aboutdata = array();
		if (!empty($aboutUs)) {
			$aboutdata['id']  			= $aboutUs->id;
			$aboutdata['title'] 		= $aboutUs->title;
			$aboutdata['content']		= $aboutUs->content;
			$aboutdata['organization']	= $aboutUs->organization;
			$aboutdata['vision']		= $aboutUs->vision;
			$aboutdata['mission']		= $aboutUs->mission;
			$aboutdata['process']		= $aboutUs->process;
			$aboutdata['video']			= asset('upload/aboutus') . "/" . $aboutUs->video; //'https://multiplatform-f.akamaihd.net/i/multi/april11/sintel/sintel-hd_,512x288_450_b,640x360_700_b,768x432_1000_b,1024x576_1400_m,.mp4.csmil/master.m3u8';
			$interesting_facts_arr = array();
			$interesting_facts = json_decode($aboutUs->interesting_facts, true);
			if (!empty($interesting_facts)) {
				foreach ($interesting_facts as $key => $value) {
					$fact['fact_icon'] = asset('upload/aboutus') . "/" . $value['fact_icon'];
					$fact['fact_title'] = $value['fact_title'];
					$fact['fact_sub_title'] = $value['fact_sub_title'];
					array_push($interesting_facts_arr, $fact);
				}
			}
			$aboutdata['interesting_facts']	= $interesting_facts_arr;

			$portfolios = Portfolio::where("status", 1)->where('deleted', 0)->get();
			$portfoliodata = array();
			if (!empty($portfolios)) {
				foreach ($portfolios as $key => $value) {
					$portfoliodata[$key]['id'] 			= $value['id'];
					$portfoliodata[$key]['title'] 		= $value['title'];
					$portfoliodata[$key]['sub_title'] 	= $value['sub_title'];
					$portfoliodata[$key]['image'] 		= asset('upload/portfolios') . "/" . $value['image'];
				}
			}
			$message = "About Us Details.";
			return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("userSubscription" => $userSubscription, "aboutus" => $aboutdata, "portfolios" => $portfoliodata)
			]);
		} else {
			$message = "About Us Details Not Found!";
			return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("userSubscription" => $userSubscription, "aboutus" => "", "portfolios" => "")]);
		}
	}

	public function userHomepage(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("userSubscription" => "", "popular_videos" => [], "continue_studying" => [], "courses" => [])]);
		}
		$search   = $request->search;
		$today	  = date('Y-m-d');
		$subscription = UserSubscription::where("user_id", $userId)->where("end_date", ">=", $today)->orderBy('id', 'DESC')->first();
		$userSubscription = !empty($subscription) ? 1 : 0;
		$lessions = Lession::where("status", 1)->where('deleted', 0);
		$popularvideos = Popularvideo::where("status", 1)->where('deleted', 0);
		$continueStudy = ContinueStudy::where("user_id", $userId)->where('is_complete', 0);
		$courses  = Courses::where("status", 1)->where('deleted', 0);
		if (!empty($lessions)) {
			$lessions = $lessions->where("name", 'like', "%" . $search . "%");
		}
		$lessions = $lessions->orderBy('sort_id', 'ASC')->get();
		if (!empty($popularvideos)) {
			$popularvideos = $popularvideos->where("name", 'like', "%" . $search . "%");
		}
		$popularvideos = $popularvideos->orderBy('sort_id', 'ASC')->limit(10)->get();
		$continueStudy = $continueStudy->orderBy('updated_at', 'DESC')->limit(10)->get();
		if (!empty($courses)) {
			$courses = $courses->where("name", 'like', "%" . $search . "%");
		}
		$courses = $courses->orderBy('sort_id', 'ASC')->get();
		$videodata = array();
		$studydata = array();
		$coursedata = array();

		foreach ($popularvideos as $key => $val) {
			$videodata[$key]['id'] 				= $val['id'];
			$videodata[$key]['name'] 			= $val['name'];
			$videodata[$key]['video_thumb'] 	= asset('upload/popularvideos') . "/" . $val['video_thumb'];
			$videodata[$key]['original_video'] 	= isset($val['video']) ? asset('upload/popularvideos') . "/" . $val['video'] : 'NA'; //'https://multiplatform-f.akamaihd.net/i/multi/april11/sintel/sintel-hd_,512x288_450_b,640x360_700_b,768x432_1000_b,1024x576_1400_m,.mp4.csmil/master.m3u8';
			if (!empty($val['video_1']) && $val['video_1']!='NA') {
				if(file_exists( public_path().'/upload/popularvideos/'.$val['video_1'] )) {
					$video_1 = asset('upload/popularvideos') . "/" . $val['video_1'];
				} else {
					$video_1 = $videodata[$key]['original_video'];
				}
			} else {
				$video_1 = $videodata[$key]['original_video'];
			}
			if (!empty($val['video_2']) && $val['video_2']!='NA') {
				if(file_exists( public_path().'/upload/popularvideos/'.$val['video_2'] )) {
					$video_2 = asset('upload/popularvideos') . "/" . $val['video_2'];
				} else {
					$video_2 = $videodata[$key]['original_video'];
				}
			} else {
				$video_2 = $videodata[$key]['original_video'];
			}
			if (!empty($val['video_3']) && $val['video_3']!='NA') {
				if(file_exists( public_path().'/upload/popularvideos/'.$val['video_3'] )) {
					$video_3 = asset('upload/popularvideos') . "/" . $val['video_3'];
				} else {
					$video_3 = $videodata[$key]['original_video'];
				}
			} else {
				$video_3 = $videodata[$key]['original_video'];
			}
			$videodata[$key]['low_video'] 		= $video_1;
			$videodata[$key]['medium_video'] 	= $video_2;
			$videodata[$key]['high_video'] 		= $video_3;
			$videodata[$key]['paid'] 			= $val['paid'];
		}
		foreach ($continueStudy as $key => $study) {
			if ($study['lession_id']==0) {
				$course  = Courses::where("id", $study['course_id'])->where("status", 1)->where('deleted', 0)->first();
				$studydata[$key]['id']  = $study['id'];
				$studydata[$key]['courseId']  		= $study['course_id'];
				$studydata[$key]['lessionId'] 		= 0;
				$studydata[$key]['topicId'] 		= 0;
				$studydata[$key]['name'] 			= isset($course->name) ? $course->name : '';
				$studydata[$key]['image'] 			= isset($course->image) ? asset('course') . "/" . $course->image : '';
				$studydata[$key]['original_video'] 	= isset($course->video) ? asset('course') . "/" . $course->video : 'NA'; //'https://multiplatform-f.akamaihd.net/i/multi/april11/sintel/sintel-hd_,512x288_450_b,640x360_700_b,768x432_1000_b,1024x576_1400_m,.mp4.csmil/master.m3u8';
				if (!empty($course->video_1) && $course->video_1!='NA') {
					if(file_exists( public_path().'/course/'.$course->video_1 )) {
						$video_1 = asset('course') . "/" . $course->video_1;
					} else {
						$video_1 = $studydata[$key]['original_video'];
					}
				} else {
					$video_1 = $studydata[$key]['original_video'];
				}
				if (!empty($course->video_2) && $course->video_2!='NA') {
					if(file_exists( public_path().'/course/'.$course->video_2 )) {
						$video_2 = asset('course') . "/" . $course->video_2;
					} else {
						$video_2 = $studydata[$key]['original_video'];
					}
				} else {
					$video_2 = $studydata[$key]['original_video'];
				}
				if (!empty($course->video_3) && $course->video_3!='NA') {
					if(file_exists( public_path().'/course/'.$course->video_3 )) {
						$video_3 = asset('course') . "/" . $course->video_3;
					} else {
						$video_3 = $studydata[$key]['original_video'];
					}
				} else {
					$video_3 = $studydata[$key]['original_video'];
				}
				$studydata[$key]['low_video'] 		= $video_1;
				$studydata[$key]['medium_video'] 	= $video_2;
				$studydata[$key]['high_video'] 		= $video_3;
				$total_lessions = Lession::where("courseId", $study['course_id'])->where("status", 1)->where('deleted', 0)->count();
				$studydata[$key]['total_lessions'] 	= $total_lessions;
				$studydata[$key]['isFree'] 			= isset($course->isFree) ? $course->isFree : '';
			} else {
				if ($study['lession_id']>0) {
					if ($study['topic_id']==0) {
						$lession  = Lession::where("id", $study['lession_id'])->where("status", 1)->where('deleted', 0)->first();
						$studydata[$key]['id'] 				= $study['id'];
						$studydata[$key]['courseId']  		= $study['course_id'];
						$studydata[$key]['lessionId'] 		= $study['lession_id'];
						$studydata[$key]['topicId'] 		= 0;
						$studydata[$key]['name'] 			= isset($lession->name) ? $lession->name : '';
						$studydata[$key]['image'] 			= isset($lession->video_thumb) ? asset('lessions') . "/" . $lession->video_thumb : '';
						$studydata[$key]['original_video'] 	= isset($lession->fullvideo) ? asset('lessions') . "/" . $lession->fullvideo : 'NA'; //'https://multiplatform-f.akamaihd.net/i/multi/april11/sintel/sintel-hd_,512x288_450_b,640x360_700_b,768x432_1000_b,1024x576_1400_m,.mp4.csmil/master.m3u8';
						if (!empty($lession->video_1) && $lession->video_1!='NA') {
							if(file_exists( public_path().'/lessions/'.$lession->video_1 )) {
								$video_1 = asset('lessions') . "/" . $lession->video_1;
							} else {
								$video_1 = $studydata[$key]['original_video'];
							}
						} else {
							$video_1 = $studydata[$key]['original_video'];
						}
						if (!empty($lession->video_2) && $lession->video_2!='NA') {
							if(file_exists( public_path().'/lessions/'.$lession->video_2 )) {
								$video_2 = asset('lessions') . "/" . $lession->video_2;
							} else {
								$video_2 = $studydata[$key]['original_video'];
							}
						} else {
							$video_2 = $studydata[$key]['original_video'];
						}
						if (!empty($lession->video_3) && $lession->video_3!='NA') {
							if(file_exists( public_path().'/lessions/'.$lession->video_3 )) {
								$video_3 = asset('lessions') . "/" . $lession->video_3;
							} else {
								$video_3 = $studydata[$key]['original_video'];
							}
						} else {
							$video_3 = $studydata[$key]['original_video'];
						}
						$studydata[$key]['low_video'] 		= $video_1;
						$studydata[$key]['medium_video'] 	= $video_2;
						$studydata[$key]['high_video'] 		= $video_3;
						$total_lessions = Lession::where("courseId", $study['course_id'])->where("status", 1)->where('deleted', 0)->count();
						$studydata[$key]['total_lessions'] 	= $total_lessions;
						$studydata[$key]['isFree']			= isset($lession->isFree) ? $lession->isFree : '';
					} else {
						$topic = Chapter::where("id", $study['topic_id'])->where("status", 1)->where('deleted', 0)->first();
						$studydata[$key]['id'] 				= $study['id'];
						$studydata[$key]['courseId']  		= $study['course_id'];
						$studydata[$key]['lessionId'] 		= $study['lession_id'];
						$studydata[$key]['topicId'] 		= $study['topic_id'];
						$studydata[$key]['name'] 			= isset($topic->name) ? $topic->name : '';
						$studydata[$key]['image'] 			= isset($topic->video_thumb) ? asset('lessions') . "/" . $topic->video_thumb : '';
						$studydata[$key]['original_video'] 	= isset($topic->fullvideo) ? asset('lessions') . "/" . $topic->fullvideo : 'NA'; //'https://multiplatform-f.akamaihd.net/i/multi/april11/sintel/sintel-hd_,512x288_450_b,640x360_700_b,768x432_1000_b,1024x576_1400_m,.mp4.csmil/master.m3u8';
						if (!empty($topic->video_1) && $topic->video_1!='NA') {
							if(file_exists( public_path().'/lessions/'.$topic->video_1 )) {
								$video_1 = asset('lessions') . "/" . $topic->video_1;
							} else {
								$video_1 = $studydata[$key]['original_video'];
							}
						} else {
							$video_1 = $studydata[$key]['original_video'];
						}
						if (!empty($topic->video_2) && $topic->video_2!='NA') {
							if(file_exists( public_path().'/lessions/'.$topic->video_2 )) {
								$video_2 = asset('lessions') . "/" . $topic->video_2;
							} else {
								$video_2 = $studydata[$key]['original_video'];
							}
						} else {
							$video_2 = $studydata[$key]['original_video'];
						}
						if (!empty($topic->video_3) && $topic->video_3!='NA') {
							if(file_exists( public_path().'/lessions/'.$topic->video_3 )) {
								$video_3 = asset('lessions') . "/" . $topic->video_3;
							} else {
								$video_3 = $studydata[$key]['original_video'];
							}
						} else {
							$video_3 = $studydata[$key]['original_video'];
						}
						$studydata[$key]['low_video'] 		= $video_1;
						$studydata[$key]['medium_video'] 	= $video_2;
						$studydata[$key]['high_video'] 		= $video_3;
						$total_lessions = Chapter::where("courseId", $study['course_id'])->where("lessionId", $study['lession_id'])->where("status", 1)->where('deleted', 0)->count();
						$studydata[$key]['total_lessions'] 	= $total_lessions;
						$studydata[$key]['isFree']			= isset($topic->isFree) ? $topic->isFree : '';
					}
				}
			}
			$checkStudentExam = StudentExam::where("user_id", $userId)->where("course_id", $study['course_id'])->where("lession_id", $study['lession_id'])->orderBy("id","DESC")->first();
			if (!empty($checkStudentExam)) {
				$is_complete = $checkStudentExam->is_complete + 1;
			} else {
				$is_complete = 0;
			}
			$studydata[$key]['quizStatus']	= $is_complete;
			/*$total_time = strtotime($study['video_total_time']) - strtotime('00:00:00');
			$viewed_time = strtotime($study['video_viewed_time']) - strtotime('00:00:00');*/
			$total_time = !empty($study['video_total_time']) ? $study['video_total_time'] : 0;
			$viewed_time = !empty($study['video_viewed_time']) ? $study['video_viewed_time'] : 0;
			$view_percent = $percentLeft = 0;
			if ($total_time > 0) {
				$view_percent = ($viewed_time / $total_time) * 100;
				if ($view_percent > 99) {
					$data = array(
						'is_complete' => 1,
						'updated_at'  => date('Y-m-d H:i:s'),
					);
					$update = ContinueStudy::where("id", $study['id'])->update($data);
					$view_percent = 100;
				}
				if ($view_percent < 0) {
					$view_percent = 0;
				}
				$percentLeft = (($total_time - $viewed_time) / $total_time) * 100;
			}
			//echo 'TT '.$total_time.' VT '.$viewed_time.' VP '.$view_percent.' LP '.$percentLeft; die;
			$studydata[$key]['video_total_time']  = !empty($study['video_total_time']) ? $study['video_total_time'] : 0;
			$studydata[$key]['video_viewed_time'] = !empty($study['video_viewed_time']) ? $study['video_viewed_time'] : 0;
			$studydata[$key]['view_percent']      = round($view_percent);
		}
		foreach ($courses as $key => $value) {
			$coursedata[$key]['id'] 			= $value['id'];
			$coursedata[$key]['name'] 			= $value['name'];
			$coursedata[$key]['image'] 			= asset('course') . "/" . $value['image'];
			$coursedata[$key]['original_video'] = isset($value['video']) ? asset('course') . "/" . $value['video'] : 'NA'; //'https://multiplatform-f.akamaihd.net/i/multi/april11/sintel/sintel-hd_,512x288_450_b,640x360_700_b,768x432_1000_b,1024x576_1400_m,.mp4.csmil/master.m3u8';
			if (!empty($value['video_1']) && $value['video_1']!='NA') {
				if(file_exists( public_path().'/course/'.$value['video_1'] )) {
					$video_1 = asset('course') . "/" . $value['video_1'];
				} else {
					$video_1 = $coursedata[$key]['original_video'];
				}
			} else {
				$video_1 = $coursedata[$key]['original_video'];
			}
			if (!empty($value['video_2']) && $value['video_2']!='NA') {
				if(file_exists( public_path().'/course/'.$value['video_2'] )) {
					$video_2 = asset('course') . "/" . $value['video_2'];
				} else {
					$video_2 = $coursedata[$key]['original_video'];
				}
			} else {
				$video_2 = $coursedata[$key]['original_video'];
			}
			if (!empty($value['video_3']) && $value['video_3']!='NA') {
				if(file_exists( public_path().'/course/'.$value['video_3'] )) {
					$video_3 = asset('course') . "/" . $value['video_3'];
				} else {
					$video_3 = $coursedata[$key]['original_video'];
				}
			} else {
				$video_3 = $coursedata[$key]['original_video'];
			}
			$coursedata[$key]['low_video'] 		= $video_1;
			$coursedata[$key]['medium_video'] 	= $video_2;
			$coursedata[$key]['high_video'] 	= $video_3;
			$coursedata[$key]['pdf'] 			= asset('course') . "/" . $value['pdf'];
			$total_lessions = Lession::where("courseId", $value['id'])->where("status", 1)->where('deleted', 0)->count();
			$coursedata[$key]['total_lessions'] = $total_lessions;
			$coursedata[$key]['isFree'] 		= $value['isFree'];
		}
		$message = "User Home Page Data.";
		return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("userSubscription" => $userSubscription, "popular_videos" => $videodata, "continue_studying" => $studydata, "courses" => $coursedata)]);
	}
	public function allPopularVideos(Request $request)
	{
		$search   = $request->search;
		$popularvideos = Popularvideo::where("status", 1)->where('deleted', 0);
		if (!empty($popularvideos)) {
			$popularvideos = $popularvideos->where("name", 'like', "%" . $search . "%");
		}
		$popularvideos = $popularvideos->orderBy('sort_id', 'ASC')->get();
		$videodata = array();
		foreach ($popularvideos as $key => $val) {
			$videodata[$key]['id'] 				= $val['id'];
			$videodata[$key]['name'] 			= $val['name'];
			$videodata[$key]['video_thumb'] 	= asset('upload/popularvideos') . "/" . $val['video_thumb'];
			$videodata[$key]['original_video'] 	= isset($val['video']) ? asset('upload/popularvideos') . "/" . $val['video'] : 'NA'; //'https://multiplatform-f.akamaihd.net/i/multi/april11/sintel/sintel-hd_,512x288_450_b,640x360_700_b,768x432_1000_b,1024x576_1400_m,.mp4.csmil/master.m3u8';
			if (!empty($val['video_1']) && $val['video_1']!='NA') {
				if(file_exists( public_path().'/upload/popularvideos/'.$val['video_1'] )) {
					$video_1 = asset('upload/popularvideos') . "/" . $val['video_1'];
				} else {
					$video_1 = $videodata[$key]['original_video'];
				}
			} else {
				$video_1 = $videodata[$key]['original_video'];
			}
			if (!empty($val['video_2']) && $val['video_2']!='NA') {
				if(file_exists( public_path().'/upload/popularvideos/'.$val['video_2'] )) {
					$video_2 = asset('upload/popularvideos') . "/" . $val['video_2'];
				} else {
					$video_2 = $videodata[$key]['original_video'];
				}
			} else {
				$video_2 = $videodata[$key]['original_video'];
			}
			if (!empty($val['video_3']) && $val['video_3']!='NA') {
				if(file_exists( public_path().'/upload/popularvideos/'.$val['video_3'] )) {
					$video_3 = asset('upload/popularvideos') . "/" . $val['video_3'];
				} else {
					$video_3 = $videodata[$key]['original_video'];
				}
			} else {
				$video_3 = $videodata[$key]['original_video'];
			}
			$videodata[$key]['low_video'] 		= $video_1;
			$videodata[$key]['medium_video']	= $video_2;
			$videodata[$key]['high_video'] 		= $video_3;
			$videodata[$key]['paid'] 			= $val['paid'];
		}
		$message = "Get All Popular Videos List.";
		return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("popular_videos" => $videodata)]);
	}
	public function ourCourses(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("userSubscription" => "", "courses" => [])]);
		}
		$search   = $request->search;
		$today	  = date('Y-m-d');
		$subscription = UserSubscription::where("user_id", $userId)->where("end_date", ">=", $today)->orderBy('id', 'DESC')->first();
		$userSubscription = !empty($subscription) ? 1 : 0;
		$courses  = Courses::where("status", 1)->where('deleted', 0);
		if (!empty($courses)) {
			$courses = $courses->where("name", 'like', "%" . $search . "%");
		}
		$courses = $courses->orderBy('sort_id', 'ASC')->get();
		$coursedata = array();
		foreach ($courses as $key => $value) {
			$coursedata[$key]['id'] 			= $value['id'];
			$coursedata[$key]['name']			= $value['name'];
			$coursedata[$key]['image'] 			= asset('course') . "/" . $value['image'];
			$coursedata[$key]['original_video'] = isset($value['video']) ? asset('course') . "/" . $value['video'] : 'NA'; //'https://multiplatform-f.akamaihd.net/i/multi/april11/sintel/sintel-hd_,512x288_450_b,640x360_700_b,768x432_1000_b,1024x576_1400_m,.mp4.csmil/master.m3u8';
			if (!empty($value['video_1']) && $value['video_1']!='NA') {
				if(file_exists( public_path().'/course/'.$value['video_1'] )) {
					$video_1 = asset('course') . "/" . $value['video_1'];
				} else {
					$video_1 = $coursedata[$key]['original_video'];
				}
			} else {
				$video_1 = $coursedata[$key]['original_video'];
			}
			if (!empty($value['video_2']) && $value['video_2']!='NA') {
				if(file_exists( public_path().'/course/'.$value['video_2'] )) {
					$video_2 = asset('course') . "/" . $value['video_2'];
				} else {
					$video_2 = $coursedata[$key]['original_video'];
				}
			} else {
				$video_2 = $coursedata[$key]['original_video'];
			}
			if (!empty($value['video_3']) && $value['video_3']!='NA') {
				if(file_exists( public_path().'/course/'.$value['video_3'] )) {
					$video_3 = asset('course') . "/" . $value['video_3'];
				} else {
					$video_3 = $coursedata[$key]['original_video'];
				}
			} else {
				$video_3 = $coursedata[$key]['original_video'];
			}
			$coursedata[$key]['low_video']		= $video_1;
			$coursedata[$key]['medium_video']	= $video_2;
			$coursedata[$key]['high_video']		= $video_3;
			$coursedata[$key]['pdf']			= asset('course') . "/" . $value['pdf'];
			$total_lessions = Lession::where("courseId", $value['id'])->where("status", 1)->where('deleted', 0)->count();
			$coursedata[$key]['total_lessions'] = $total_lessions;
			$coursedata[$key]['isFree']			= $value['isFree'];
		}
		$message = "Our Courses List.";
		return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("userSubscription" => $userSubscription, "courses" => $coursedata)]);
	}
	public function getCourseDetails(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("userSubscription" => "", "course" => array("id" => ""), "course_features" => [], "course_faqs" => [], "course_videos" => [], "course_pdfs" => [])]);
		}
		$courseId = $request->courseId;
		$today	  = date('Y-m-d');
		$subscription = UserSubscription::where("user_id", $userId)->where("end_date", ">=", $today)->orderBy('id', 'DESC')->first();
		$userSubscription = !empty($subscription) ? 1 : 0;
		$course   = Courses::where("id", $courseId)->where("status", 1)->where('deleted', 0)->first();
		$coursedata = array();
		if (!empty($course)) {
			$coursedata['id'] 				= $course->id;
			$coursedata['name'] 			= $course->name;
			$coursedata['image']			= asset('course') . "/" . $course->image;
			$coursedata['original_video']	= isset($course->video) ? asset('course') . "/" . $course->video : 'NA'; //'https://multiplatform-f.akamaihd.net/i/multi/april11/sintel/sintel-hd_,512x288_450_b,640x360_700_b,768x432_1000_b,1024x576_1400_m,.mp4.csmil/master.m3u8';
			if (!empty($course->video_1) && $course->video_1!='NA') {
				if(file_exists( public_path().'/course/'.$course->video_1 )) {
					$video_1 = asset('course') . "/" . $course->video_1;
				} else {
					$video_1 = $coursedata['original_video'];
				}
			} else {
				$video_1 = $coursedata['original_video'];
			}
			if (!empty($course->video_2) && $course->video_2!='NA') {
				if(file_exists( public_path().'/course/'.$course->video_2 )) {
					$video_2 = asset('course') . "/" . $course->video_2;
				} else {
					$video_2 = $coursedata['original_video'];
				}
			} else {
				$video_2 = $coursedata['original_video'];
			}
			if (!empty($course->video_3) && $course->video_3!='NA') {
				if(file_exists( public_path().'/course/'.$course->video_3 )) {
					$video_3 = asset('course') . "/" . $course->video_3;
				} else {
					$video_3 = $coursedata['original_video'];
				}
			} else {
				$video_3 = $coursedata['original_video'];
			}
			$coursedata['low_video'] 		= $video_1;
			$coursedata['medium_video'] 	= $video_2;
			$coursedata['high_video'] 		= $video_3;
			$course_videos = Lession::where("courseId", $courseId)->where("fullvideo", "!=", "")->where("status", 1)->where('deleted', 0)->orderBy('sort_id', 'ASC')->get();
			$coursedata['total_videos'] 	= count($course_videos);
			$coursedata['video_duration']	= $course->video_duration;
			//$coursedata['total_duration'] = 0;
			foreach ($course_videos as $key => $val) {
				//$coursedata['total_duration'] += $val['id'];
			}
			$courseComplete = ContinueStudy::where("user_id", $userId)->where("course_id", $courseId)->get();
			$study_total_time = $study_viewed_time = 0;
			foreach ($courseComplete as $key => $val) {
				$study_total_time += $val['video_total_time'];
				$study_viewed_time += $val['video_viewed_time'];
			}
			if ($study_total_time > 0) {
				$course_complete = ($study_viewed_time / $study_total_time) * 100;
				if ($course_complete > 99) {
					$course_complete = 100;
				}
			} else {
				$course_complete = 0;
			}
			$coursedata['course_complete'] = round($course_complete);
			$coursedata['overview'] = $course->overview;
			$coursedata['course_certificate'] = '';
			$coursedata['isFree']  = $course->isFree;
			$checkStudentExam = StudentExam::where("user_id", $userId)->where("course_id", $courseId)->where("lession_id", 0)->orderBy("id", "DESC")->first();
			if (!empty($checkStudentExam)) {
				if ($checkStudentExam->start_time != '00:00:00') {
					$certificate_status = $checkStudentExam->is_complete + 1;
				} else {
					$certificate_status = 0;
				}
			} else {
				$certificate_status = 0;
			}
			$coursedata['certificateStatus']	= $certificate_status;
			$continueStudy = ContinueStudy::where("user_id", $userId)->where("course_id", $courseId)->where("lession_id", 0)->where('is_complete', 0)->first();
			$study['video_total_time'] = !empty($continueStudy->video_total_time) ? $continueStudy->video_total_time : 0;
			$study['video_viewed_time'] = !empty($continueStudy->video_viewed_time) ? $continueStudy->video_viewed_time : 0;
			$total_time = $study['video_total_time'];
			$viewed_time = $study['video_viewed_time'];
			if ($total_time > 0) {
				$view_percent = ($viewed_time / $total_time) * 100;
				if ($view_percent > 99) {
					$view_percent = 100;
				}
				if ($view_percent < 0) {
					$view_percent = 0;
				}
			} else {
				$view_percent = 0;
			}
			$coursedata['video_total_time']  = $study['video_total_time'];
			$coursedata['video_viewed_time'] = $study['video_viewed_time'];
			$coursedata['view_percent']      = round($view_percent);
			$course_features = Coursefeature::where("courseId", $courseId)->get();
			$featuredata = array();
			foreach ($course_features as $key => $val) {
				$featuredata[$key]['feature'] = $val['feature'];
			}
			$course_faqs = Coursefeq::where("courseId", $courseId)->get();
			$coursefaqdata = array();
			foreach ($course_faqs as $key => $val) {
				$coursefaqdata[$key]['id']       = $val['id'];
				$coursefaqdata[$key]['question'] = $val['title'];
				$coursefaqdata[$key]['answer']   = $val['contant'];
			}
			$lessions = Lession::where("courseId", $courseId)->where("status", 1)->where('deleted', 0)->orderBy('sort_id', 'ASC')->get();
			$videodata = array();
			foreach ($lessions as $key => $value) {
				if($value['fullvideo'] != ''){
					$videodata[$key]['lession_id']		= $value['id'];
					$videodata[$key]['name']			= $value['name'];
					$videodata[$key]['image']			= asset('lessions') . "/" . $value['video_thumb'];
					$videodata[$key]['original_video']	= isset($value['fullvideo']) ? asset('lessions') . "/" . $value['fullvideo'] : 'NA'; //'https://multiplatform-f.akamaihd.net/i/multi/april11/sintel/sintel-hd_,512x288_450_b,640x360_700_b,768x432_1000_b,1024x576_1400_m,.mp4.csmil/master.m3u8';
					if (!empty($value['video_1']) && $value['video_1']!='NA') {
						if(file_exists( public_path().'/lessions/'.$value['video_1'] )) {
							$video_1 = asset('lessions') . "/" . $value['video_1'];
						} else {
							$video_1 = $videodata[$key]['original_video'];
						}
					} else {
						$video_1 = $videodata[$key]['original_video'];
					}
					if (!empty($value['video_2']) && $value['video_2']!='NA') {
						if(file_exists( public_path().'/lessions/'.$value['video_2'] )) {
							$video_2 = asset('lessions') . "/" . $value['video_2'];
						} else {
							$video_2 = $videodata[$key]['original_video'];
						}
					} else {
						$video_2 = $videodata[$key]['original_video'];
					}
					if (!empty($value['video_3']) && $value['video_3']!='NA') {
						if(file_exists( public_path().'/lessions/'.$value['video_3'] )) {
							$video_3 = asset('lessions') . "/" . $value['video_3'];
						} else {
							$video_3 = $videodata[$key]['original_video'];
						}
					} else {
						$video_3 = $videodata[$key]['original_video'];
					}
					$videodata[$key]['low_video']		= $video_1;
					$videodata[$key]['medium_video']	= $video_2;
					$videodata[$key]['high_video']		= $video_3;
					$videodata[$key]['content']			= $value['content'];
					$videodata[$key]['isFree']			= $value['isFree'];
					$checkStudentExam = StudentExam::where("user_id", $userId)->where("course_id", $courseId)->where("lession_id", $value['id'])->orderBy("id","DESC")->first();
					if (!empty($checkStudentExam)) {
						$is_complete = $checkStudentExam->is_complete + 1;
					} else {
						$is_complete = 0;
					}
					$videodata[$key]['quizStatus']		= $is_complete;
					$continueStudy = ContinueStudy::where("user_id", $userId)->where("course_id", $courseId)->where("lession_id", $value['id'])->where('is_complete', 0)->first();
					$study['video_total_time'] = !empty($continueStudy->video_total_time) ? $continueStudy->video_total_time : 0;
					$study['video_viewed_time'] = !empty($continueStudy->video_viewed_time) ? $continueStudy->video_viewed_time : 0;
					$total_time = $study['video_total_time'];
					$viewed_time = $study['video_viewed_time'];
					if ($total_time > 0) {
						$view_percent = ($viewed_time / $total_time) * 100;
						if ($view_percent > 99) {
							$view_percent = 100;
						}
						if ($view_percent < 0) {
							$view_percent = 0;
						}
					} else {
						$view_percent = 0;
					}
					$videodata[$key]['video_total_time']  = $study['video_total_time'];
					$videodata[$key]['video_viewed_time'] = $study['video_viewed_time'];
					$videodata[$key]['view_percent']      = round($view_percent);
				}
			}
			$pdfdata = array();
			foreach ($lessions as $key => $value) {
				if($value['pdf'] != ''){
					$pdfs['lession_id']	= $value['id'];
					$pdfs['name']			= $value['name'];
					$pdfs['image']			= asset('lessions') . "/" . $value['video_thumb'];
					$pdfs['pdf']			= asset('lessions') . "/" . $value['pdf'];
					$pdfs['content']		= $value['content'];
					$pdfs['isFree']		= $value['isFree'];
					$checkStudentExam = StudentExam::where("user_id", $userId)->where("course_id", $courseId)->where("lession_id", $value['id'])->orderBy("id","DESC")->first();
					if (!empty($checkStudentExam)) {
						$is_complete = $checkStudentExam->is_complete + 1;
					} else {
						$is_complete = 0;
					}
					$pdfs['quizStatus']	= $is_complete;
					array_push($pdfdata, $pdfs);
				}
			}
			$message = "Course Details.";
			return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("userSubscription" => $userSubscription, "course" => $coursedata, "course_features" => $featuredata, "course_faqs" => $coursefaqdata, "course_videos" => $videodata, "course_pdfs" => $pdfdata)]);
		} else {
			$message = "Course Details Not Found!";
			return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("userSubscription" => $userSubscription, "course" => "", "course_features" => "", "course_faqs" => "", "course_videos" => "", "course_pdfs" => "")]);
		}
	}
	public function getLessionDetails(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("userSubscription" => "", "lession" => array("id" => ""), "topics" => [])]);
		}
		$lessionId  = $request->lessionId;
		$today	  = date('Y-m-d');
		$subscription = UserSubscription::where("user_id", $userId)->where("end_date", ">=", $today)->orderBy('id', 'DESC')->first();
		$userSubscription = !empty($subscription) ? 1 : 0;
		$lession = Lession::where("id", $lessionId)->where("status", 1)->where('deleted', 0)->first();
		$lessiondata = array();
		if (!empty($lession)) {
			$lessiondata['course_id']		= $lession->courseId;
			$lessiondata['lession_id']		= $lession->id;
			$lessiondata['name']			= $lession->name;
			$lessiondata['image']			= asset('lessions') . "/" . $lession->video_thumb;
			$lessiondata['original_video']	= isset($lession->fullvideo) ? asset('lessions') . "/" . $lession->fullvideo : 'NA'; //'https://multiplatform-f.akamaihd.net/i/multi/april11/sintel/sintel-hd_,512x288_450_b,640x360_700_b,768x432_1000_b,1024x576_1400_m,.mp4.csmil/master.m3u8';
			if (!empty($lession->video_1) && $lession->video_1!='NA') {
				if(file_exists( public_path().'/lessions/'.$lession->video_1 )) {
					$video_1 = asset('lessions') . "/" . $lession->video_1;
				} else {
					$video_1 = $lessiondata['original_video'];
				}
			} else {
				$video_1 = $lessiondata['original_video'];
			}
			if (!empty($lession->video_2) && $lession->video_2!='NA') {
				if(file_exists( public_path().'/lessions/'.$lession->video_2 )) {
					$video_2 = asset('lessions') . "/" . $lession->video_2;
				} else {
					$video_2 = $lessiondata['original_video'];
				}
			} else {
				$video_2 = $lessiondata['original_video'];
			}
			if (!empty($lession->video_3) && $lession->video_3!='NA') {
				if(file_exists( public_path().'/lessions/'.$lession->video_3 )) {
					$video_3 = asset('lessions') . "/" . $lession->video_3;
				} else {
					$video_3 = $lessiondata['original_video'];
				}
			} else {
				$video_3 = $lessiondata['original_video'];
			}
			$lessiondata['low_video']		= $video_1;
			$lessiondata['medium_video']	= $video_2;
			$lessiondata['high_video']		= $video_3;
			$lessiondata['pdf']				= asset('lessions') . "/" . $lession->pdf;
			$lessiondata['content']			= $lession->content;
			$lessiondata['isFree']			= $lession->isFree;

			$checkStudentExam = StudentExam::where("user_id", $userId)->where("course_id", $lession->courseId)->where("lession_id", $lession->id)->orderBy("id","DESC")->first();
			if (!empty($checkStudentExam)) {
				$is_complete = $checkStudentExam->is_complete + 1;
			} else {
				$is_complete = 0;
			}
			$lessiondata['quizStatus']	= $is_complete;

			$continueStudy = ContinueStudy::where("user_id", $userId)->where("course_id", $lession->courseId)->where("lession_id", $lession->id)->where('is_complete', 0)->first();
			$study['video_total_time'] = !empty($continueStudy->video_total_time) ? $continueStudy->video_total_time : 0;
			$study['video_viewed_time'] = !empty($continueStudy->video_viewed_time) ? $continueStudy->video_viewed_time : 0;
			$total_time = $study['video_total_time'];
			$viewed_time = $study['video_viewed_time'];
			if ($total_time > 0) {
				$view_percent = ($viewed_time / $total_time) * 100;
				if ($view_percent > 99) {
					$view_percent = 100;
				}
				if ($view_percent < 0) {
					$view_percent = 0;
				}
			} else {
				$view_percent = 0;
			}
			$lessiondata['video_total_time']  = $study['video_total_time'];
			$lessiondata['video_viewed_time'] = $study['video_viewed_time'];
			$lessiondata['view_percent']      = round($view_percent);

			$topics = Chapter::where("lessionId", $lession->id)->where("status", 1)->where('deleted', 0)->orderBy('sort_id', 'ASC')->get();
			$topicdata = array();
			if (!empty($topics)) {
				foreach ($topics as $key => $value) {
					$chapterNum = $key + 1;
					$topicdata[$key]['chapter_id']		= $value['lessionId'].'.'.$chapterNum;
					$topicdata[$key]['course_id']		= $value['courseId'];
					$topicdata[$key]['lession_id']		= $value['lessionId'];
					$topicdata[$key]['topic_id']		= $value['id'];
					$topicdata[$key]['name']			= $value['name'];
					$topicdata[$key]['image']			= asset('lessions') . "/" . $value['video_thumb'];
					$topicdata[$key]['original_video']	= isset($value['fullvideo']) ? asset('lessions') . "/" . $value['fullvideo'] : 'NA'; //'https://multiplatform-f.akamaihd.net/i/multi/april11/sintel/sintel-hd_,512x288_450_b,640x360_700_b,768x432_1000_b,1024x576_1400_m,.mp4.csmil/master.m3u8';
					if (!empty($value['video_1']) && $value['video_1']!='NA') {
						if(file_exists( public_path().'/lessions/'.$value['video_1'] )) {
							$video_1 = asset('lessions') . "/" . $value['video_1'];
						} else {
							$video_1 = $topicdata[$key]['original_video'];
						}
					} else {
						$video_1 = $topicdata[$key]['original_video'];
					}
					if (!empty($value['video_2']) && $value['video_2']!='NA') {
						if(file_exists( public_path().'/lessions/'.$value['video_2'] )) {
							$video_2 = asset('lessions') . "/" . $value['video_2'];
						} else {
							$video_2 = $topicdata[$key]['original_video'];
						}
					} else {
						$video_2 = $topicdata[$key]['original_video'];
					}
					if (!empty($value['video_3']) && $value['video_3']!='NA') {
						if(file_exists( public_path().'/lessions/'.$value['video_3'] )) {
							$video_3 = asset('lessions') . "/" . $value['video_3'];
						} else {
							$video_3 = $topicdata[$key]['original_video'];
						}
					} else {
						$video_3 = $topicdata[$key]['original_video'];
					}
					$topicdata[$key]['low_video']		= $video_1;
					$topicdata[$key]['medium_video']	= $video_2;
					$topicdata[$key]['high_video']		= $video_3;
					$topicdata[$key]['pdf']				= asset('lessions') . "/" . $value['pdf'];
					$topicdata[$key]['content']			= $value['content'];
					$topicdata[$key]['isFree']			= $value['isFree'];
					$continueStudy = ContinueStudy::where("user_id", $userId)->where("course_id", $value['courseId'])->where("lession_id", $value['lessionId'])->where("topic_id", $value['id'])->where('is_complete', 0)->first();
					$study['video_total_time'] = !empty($continueStudy->video_total_time) ? $continueStudy->video_total_time : 0;
					$study['video_viewed_time'] = !empty($continueStudy->video_viewed_time) ? $continueStudy->video_viewed_time : 0;
					$total_time = $study['video_total_time'];
					$viewed_time = $study['video_viewed_time'];
					if ($total_time > 0) {
						$view_percent = ($viewed_time / $total_time) * 100;
						if ($view_percent > 99) {
							$view_percent = 100;
						}
						if ($view_percent < 0) {
							$view_percent = 0;
						}
					} else {
						$view_percent = 0;
					}
					$topicdata[$key]['video_total_time']  = $study['video_total_time'];
					$topicdata[$key]['video_viewed_time'] = $study['video_viewed_time'];
					$topicdata[$key]['view_percent']      = round($view_percent);
				}
			}
			$message = "Lession Details.";
			return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("userSubscription" => $userSubscription, "lession" => $lessiondata, "topics" => $topicdata)
			]);
		} else {
			$message = "Lession Details Not Found!";
			return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("userSubscription" => $userSubscription, "lession" => "", "topics" => "")]);
		}
	}
	public function getRatingTypes(Request $request)
	{
		//$ratingType 	= $request->ratingType;
		$ratingTypes = RatingType::get();
		$ratingTypedata = array();
		if (!empty($ratingTypes)) {
			foreach ($ratingTypes as $key => $value) {
				$ratingTypedata[$key]['id']	= $value['id'];
				$ratingTypedata[$key]['ratingType']	= $value['ratingType'];
			}
			$message = "Get Rating Types Successfully.";
			return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("ratingTypes" => $ratingTypedata)
			]);
		} else {
			$message = "Rating Types Not Found!";
			return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("ratingTypes" => "")]);
		}
	}
	public function getRatingMessages(Request $request)
	{
		/*$ratingType 	= $request->ratingType;
		$ratingMessages = RatingMessage::where('ratingType', $ratingType)->get();*/
		/*echo '<pre />'; print_r($ratingMessages); die;*/
		//$ratingMessages = RatingMessage::groupBy("message")->get();
		$ratingMessages = RatingMessage::get();
		$sadMsgdata = array();
		$scepticMsgdata = array();
		$happyMsgdata = array();
		if (!empty($ratingMessages)) {
			foreach ($ratingMessages as $key => $value) {
				//$ratingMsgdata[$key]['message']	= $value['message'];
				if ($value['ratingType']==1) {
					$sadMsg['message']	= $value['message'];
					array_push($sadMsgdata, $sadMsg);
				} else if ($value['ratingType']==2) {
					$scepticMsg['message']	= $value['message'];
					array_push($scepticMsgdata, $scepticMsg);
				} else if ($value['ratingType']==3) {
					$happyMsg['message']	= $value['message'];
					array_push($happyMsgdata, $happyMsg);
				} else {
				}
			}
			$message = "Get Rating Messages Successfully.";
			return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("sadMessages" => $sadMsgdata, "scepticMessages" => $scepticMsgdata, "happyMessages" => $happyMsgdata)
			]);
		} else {
			$message = "Rating Messages Not Found!";
			return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("sadMessages" => "", "scepticMessages" => "", "happyMessages" => "")]);
		}
	}
	public function saveRatingsbyUser(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("rating_id" => "")]);
		}
		$courseId 	= $request->courseId;
		$lessionId  = $request->lessionId;
		$topicId 	= $request->topicId;
		$ratingType 	= $request->ratingType;
		$ratingMessage  = $request->ratingMessage;
		$message 		= !empty($request->message) ? $request->message : '';
		$msg = '';
		if (!empty($userId)  && !empty($courseId) && !empty($ratingMessage)) {
			$data = array(
				'userId' 	=> $userId,
				'courseId'  => $courseId,
				'lessionId' => $lessionId,
				'topicId' 	=> $topicId,
				'ratingType' => $ratingType,
				'ratingMessage' => $ratingMessage,
				'message'    => $message,
				'status'     => 0,
				'created_at' => date('Y-m-d H:i:s'),
			);
			$insertId = RatingUser::insertGetId($data);
			$message = 'Rating Submitted Successfully.';
			return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array('rating_id' => $insertId)]);
		} else {
			$message = "Wrong Paramenter Passed!";
			return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("rating_id" => "")]);
		}
	}
	public function userContinueStudyHistory(Request $request)
	{
		$search   = $request->search;
		$userId   = $request->userId;
		$today	  = date('Y-m-d');
		$subscription = UserSubscription::where("user_id", $userId)->where("end_date", ">=", $today)->orderBy('id', 'DESC')->first();
		$userSubscription = !empty($subscription) ? 1 : 0;
		$continueStudy = ContinueStudy::where("user_id", $userId)->where('is_complete', 0);
		$continueStudy = $continueStudy->orderBy('updated_at', 'DESC')->get();
		$studydata = array();
		foreach ($continueStudy as $key => $study) {
			if ($study['lession_id']==0) {
				$course = Courses::where("id", $study['course_id'])->where("status", 1)->where('deleted', 0)->first();
				$studydata[$key]['id']				= $study['id'];
				$studydata[$key]['name']			= $course->name;
				$studydata[$key]['image']			= asset('course') . "/" . $course->image;
				$studydata[$key]['original_video']	= isset($course->video) ? asset('course') . "/" . $course->video : 'NA'; //'https://multiplatform-f.akamaihd.net/i/multi/april11/sintel/sintel-hd_,512x288_450_b,640x360_700_b,768x432_1000_b,1024x576_1400_m,.mp4.csmil/master.m3u8';
				if (!empty($course->video_1) && $course->video_1!='NA') {
					if(file_exists( public_path().'/course/'.$course->video_1 )) {
						$video_1 = asset('course') . "/" . $course->video_1;
					} else {
						$video_1 = $studydata[$key]['original_video'];
					}
				} else {
					$video_1 = $studydata[$key]['original_video'];
				}
				if (!empty($course->video_2) && $course->video_2!='NA') {
					if(file_exists( public_path().'/course/'.$course->video_2 )) {
						$video_2 = asset('course') . "/" . $course->video_2;
					} else {
						$video_2 = $studydata[$key]['original_video'];
					}
				} else {
					$video_2 = $studydata[$key]['original_video'];
				}
				if (!empty($course->video_3) && $course->video_3!='NA') {
					if(file_exists( public_path().'/course/'.$course->video_3 )) {
						$video_3 = asset('course') . "/" . $course->video_3;
					} else {
						$video_3 = $studydata[$key]['original_video'];
					}
				} else {
					$video_3 = $studydata[$key]['original_video'];
				}
				$studydata[$key]['low_video']		= $video_1;
				$studydata[$key]['medium_video']	= $video_2;
				$studydata[$key]['high_video']		= $video_3;
				$total_lessions = Lession::where("courseId", $study['course_id'])->where("status", 1)->where('deleted', 0)->count();
				$studydata[$key]['total_lessions']  = $total_lessions;
			} else {
				if ($study['topic_id']==0) {
					$lession = Lession::where("id", $study['lession_id'])->where("status", 1)->where('deleted', 0)->first();
					$studydata[$key]['id']				= $study['id'];
					$studydata[$key]['name']			= $lession->name;
					$studydata[$key]['image']			= asset('lessions') . "/" . $lession->video_thumb;
					$studydata[$key]['original_video']	= isset($lession->fullvideo) ? asset('lessions') . "/" . $lession->fullvideo : 'NA'; //'https://multiplatform-f.akamaihd.net/i/multi/april11/sintel/sintel-hd_,512x288_450_b,640x360_700_b,768x432_1000_b,1024x576_1400_m,.mp4.csmil/master.m3u8';
					if (!empty($lession->video_1) && $lession->video_1!='NA') {
						if(file_exists( public_path().'/lessions/'.$lession->video_1 )) {
							$video_1 = asset('lessions') . "/" . $lession->video_1;
						} else {
							$video_1 = $studydata[$key]['original_video'];
						}
					} else {
						$video_1 = $studydata[$key]['original_video'];
					}
					if (!empty($lession->video_2) && $lession->video_2!='NA') {
						if(file_exists( public_path().'/lessions/'.$lession->video_2 )) {
							$video_2 = asset('lessions') . "/" . $lession->video_2;
						} else {
							$video_2 = $studydata[$key]['original_video'];
						}
					} else {
						$video_2 = $studydata[$key]['original_video'];
					}
					if (!empty($lession->video_3) && $lession->video_3!='NA') {
						if(file_exists( public_path().'/lessions/'.$lession->video_3 )) {
							$video_3 = asset('lessions') . "/" . $lession->video_3;
						} else {
							$video_3 = $studydata[$key]['original_video'];
						}
					} else {
						$video_3 = $studydata[$key]['original_video'];
					}
					$studydata[$key]['low_video']		= $video_1;
					$studydata[$key]['medium_video']	= $video_2;
					$studydata[$key]['high_video']		= $video_3;
					$total_lessions = Lession::where("courseId", $study['course_id'])->where("status", 1)->where('deleted', 0)->count();
					$studydata[$key]['total_lessions']	= $total_lessions;
				} else {
					$topic = Chapter::where("id", $study['topic_id'])->where("status", 1)->where('deleted', 0)->first();
					$studydata[$key]['id']				= $study['id'];
					$studydata[$key]['name']			= $topic->name;
					$studydata[$key]['image']			= asset('lessions') . "/" . $topic->video_thumb;
					$studydata[$key]['original_video']	= isset($topic->fullvideo) ? asset('lessions') . "/" . $topic->fullvideo : 'NA'; //'https://multiplatform-f.akamaihd.net/i/multi/april11/sintel/sintel-hd_,512x288_450_b,640x360_700_b,768x432_1000_b,1024x576_1400_m,.mp4.csmil/master.m3u8';
					if (!empty($topic->video_1) && $topic->video_1!='NA') {
						if(file_exists( public_path().'/lessions/'.$topic->video_1 )) {
							$video_1 = asset('lessions') . "/" . $topic->video_1;
						} else {
							$video_1 = $studydata[$key]['original_video'];
						}
					} else {
						$video_1 = $studydata[$key]['original_video'];
					}
					if (!empty($topic->video_2) && $topic->video_2!='NA') {
						if(file_exists( public_path().'/lessions/'.$topic->video_2 )) {
							$video_2 = asset('lessions') . "/" . $topic->video_2;
						} else {
							$video_2 = $studydata[$key]['original_video'];
						}
					} else {
						$video_2 = $studydata[$key]['original_video'];
					}
					if (!empty($topic->video_3) && $topic->video_3!='NA') {
						if(file_exists( public_path().'/lessions/'.$topic->video_3 )) {
							$video_3 = asset('lessions') . "/" . $topic->video_3;
						} else {
							$video_3 = $studydata[$key]['original_video'];
						}
					} else {
						$video_3 = $studydata[$key]['original_video'];
					}
					$studydata[$key]['low_video']		= $video_1;
					$studydata[$key]['medium_video']	= $video_2;
					$studydata[$key]['high_video']		= $video_3;
					$total_chapters = Chapter::where("courseId", $study['course_id'])->where("lessionId", $study['lession_id'])->where("status", 1)->where('deleted', 0)->count();
					$studydata[$key]['total_lessions']	= $total_chapters;
				}
			}
			/*$total_time = strtotime($study['video_total_time']) - strtotime('00:00:00');
			$viewed_time = strtotime($study['video_viewed_time']) - strtotime('00:00:00');*/
			$total_time = !empty($study['video_total_time']) ? $study['video_total_time'] : 0;
			$viewed_time = !empty($study['video_viewed_time']) ? $study['video_viewed_time'] : 0;
			$view_percent = $percentLeft = 0;
			if ($total_time > 0) {
				$view_percent = ($viewed_time / $total_time) * 100;
				if ($view_percent > 99) {
					$view_percent = 100;
				}
				if ($view_percent < 0) {
					$view_percent = 0;
				}
				$percentLeft = (($total_time - $viewed_time) / $total_time) * 100;
			}
			//echo 'TT '.$total_time.' VT '.$viewed_time.' VP '.$view_percent.' LP '.$percentLeft; die;
			$studydata[$key]['video_total_time']  = $study['video_total_time'];
			$studydata[$key]['video_viewed_time'] = $study['video_viewed_time'];
			$studydata[$key]['view_percent']      = round($view_percent);
		}
		$message = "User Continue Study History Data.";
		return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("userSubscription" => $userSubscription, "continue_studying" => $studydata)]);
	}
	public function postContinueStudy(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("continueStudyId" => "")]);
		}
		$courseId 			= $request->courseId;
		$lessionId 			= $request->lessionId;
		$topicId 			= $request->topicId;
		$videoTotalTime 	= $request->videoTotalTime;
		$videoViewedTime 	= $request->videoViewedTime;
		if ($videoTotalTime == $videoViewedTime) {
			$is_complete = 1;
		} else {
			$is_complete = 0;
		}
		$checkContStudy = ContinueStudy::where("user_id", $userId)->where("course_id", $courseId)->where("lession_id", $lessionId)->where("topic_id", $topicId)->where('is_complete', 0)->first();
		if (!empty($checkContStudy)) {
			$cshId = $checkContStudy->id;
			$data = array(
				/*'video_total_time'  => date('H:i:s',strtotime($videoTotalTime)),
				'video_viewed_time' => date('H:i:s',strtotime($videoViewedTime)),*/
				'video_total_time'  => $videoTotalTime,
				'video_viewed_time' => $videoViewedTime,
				'is_complete'  		=> $is_complete,
				'updated_at'        => date('Y-m-d H:i:s'),
			);
			$update = ContinueStudy::where("id", $cshId)->update($data);
			if ($is_complete==1) {
				if ($lessionId > 0) {
					$lession = Lession::where("id", $lessionId)->first();
					$msg = 'You have successfully completed your '.$lession->name.' lession.';
				} else {
					$course = Courses::where("id", $courseId)->first();
					$msg = 'You have successfully completed your '.$course->name.' course.';
				}
				$this->addNotification($userId,$msg);
			}
			$delete = ContinueStudy::where("is_complete", 1)->delete();
			$message = "Continue Study Updated Successfully.";
			return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("continueStudyId" => $cshId)]);
		} else {
			$data = array(
				'user_id'  			=> $userId,
				'course_id'  		=> $courseId,
				'lession_id'  		=> $lessionId,
				'topic_id'  		=> $topicId,
				/*'video_total_time'  => date('H:i:s',strtotime($videoTotalTime)),
				'video_viewed_time' => date('H:i:s',strtotime($videoViewedTime)),*/
				'video_total_time'  => $videoTotalTime,
				'video_viewed_time' => $videoViewedTime,
				'is_complete'  		=> $is_complete,
				'created_at'        => date('Y-m-d H:i:s'),
			);
			$cshId = ContinueStudy::insertGetId($data);
			$message = "Continue Study Added Successfully.";
			return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("continueStudyId" => $cshId)]);
		}
	}

	public function quizGuideline(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("quiz" => array("id" => ""))]);
		}
		$courseId = $request->courseId;
		$lessionId = $request->lessionId;
		if ($lessionId > 0) {
			$getQuiz = Quiz::where("courseId", $courseId)->where("lessionId", $lessionId)->where('islession', 0)->where('status', 1)->where('deleted', 0)->orderBy("id", "DESC")->first();
		} else {
			$getQuiz = Quiz::where("courseId", $courseId)->where("lessionId", $lessionId)->where('islession', 1)->where('status', 1)->where('deleted', 0)->orderBy("id", "DESC")->first();
		}
		if (!empty($getQuiz)) {
			$course   = Courses::where("id", $courseId)->where("status", 1)->where('deleted', 0)->first();
			$lession   = Lession::where("id", $lessionId)->where("status", 1)->where('deleted', 0)->first();
			$quiz['id'] = $getQuiz->id;
			$quiz['name'] = $getQuiz->name;
			$quiz['courseId'] = $courseId;
			$quiz['lessionId'] = $lessionId;
			$quiz['courseName'] = $course->name;
			$quiz['lessionName'] = !empty($lession->name) ? $lession->name : '';

			//$quiz['total_time'] = strtotime($getQuiz->duration);
			$hour         = date('H',strtotime($getQuiz->duration));
		    $minute       = date('i',strtotime($getQuiz->duration));
		    $seconds      = date('s',strtotime($getQuiz->duration));

		    $milliseconds = $this->convertTimeinMiliseconds($hour,$minute,$seconds);
			$quiz['total_time'] = $milliseconds;

			$examQuestions = Quizquestions::where("quizId", $getQuiz->id)->get();
			$total_marks = 0;
			foreach ($examQuestions as $ques) {
				$total_marks += $ques['marking'];
			}
			$quiz['total_questions'] = count($examQuestions);
			$quiz['total_marks'] = $total_marks;
			$quiz['guideline'] = $getQuiz->guideline;
			$checkStudentExam = StudentExam::where("user_id", $userId)->where("course_id", $courseId)->where("lession_id", $lessionId)->where('is_complete', 0)->orderBy("id","DESC")->first();
			$remaining_time = "";
			if (!empty($checkStudentExam)) {
				$examId = $checkStudentExam->id;
				$examTotalTime = $checkStudentExam->total_time;
				/*if (!empty($examTotalTime) && $examTotalTime!='00:00:00') {
					$remain_time = strtotime($getQuiz->duration) - strtotime($examTotalTime);
					$remain_time = date('H:i:s', $remain_time);
					$hour        = date('H',strtotime($remain_time));
				    $minute      = date('i',strtotime($remain_time));
				    $seconds     = date('s',strtotime($remain_time));

				    $remaining_time = $this->convertTimeinMiliseconds($hour,$minute,$seconds);
				} else {
					$remaining_time = "";
				}*/
				$remaining_time = $checkStudentExam->remaining_time;
				$quiz['exam_id'] = $examId;
			} else {
				$quiz['exam_id'] = 0;
			}
			$quiz['remaining_time'] = !empty($remaining_time) ? $remaining_time : '';
			$message = "Get quiz details successfully.";
			return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("quiz" => $quiz)]);
		} else {
			$message = "Quiz Not Found!";
			return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("quiz" => array("id" => ""))]);
		}
	}
	public function letStartQuiz(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("quiz" => array("quiz_id" => ""), "quizdata" => [])]);
		}
		$courseId = $request->courseId;
		$lessionId = $request->lessionId;
		if ($lessionId > 0) {
			$getQuiz = Quiz::where("courseId", $courseId)->where("lessionId", $lessionId)->where('islession', 0)->where('status', 1)->where('deleted', 0)->orderBy("id", "DESC")->first();
		} else {
			$getQuiz = Quiz::where("courseId", $courseId)->where("lessionId", $lessionId)->where('islession', 1)->where('status', 1)->where('deleted', 0)->orderBy("id", "DESC")->first();
		}
		if (!empty($getQuiz)) {
			$quiz['quiz_id'] = $getQuiz->id;
			$quiz['name'] = $getQuiz->name;
			$checkStudentExam = StudentExam::where("user_id", $userId)->where("course_id", $courseId)->where("lession_id", $lessionId)->where('is_complete', 0)->orderBy("id","DESC")->first();
			if (!empty($checkStudentExam)) {
				$examId = $checkStudentExam->id;
				$data = array(
					'start_time' => date('H:i:s'),
					'end_time'   => date('H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				);
				$update = StudentExam::where("id", $examId)->update($data);
				$quiz['exam_id'] = $examId;
				$quizdata = array();
				$examQuestions = Quizquestions::where("quizId", $getQuiz->id)->get();
				$total_questions = count($examQuestions);
				foreach ($examQuestions as $key => $val) {
					$quizdata[$key]['id'] = $val->id;
					$quizdata[$key]['questions'] = $val->questions;
					$quizdata[$key]['image'] = !empty($val->image) ? asset('upload/quizquestions') . "/" . $val->image : '';
					$quizdata[$key]['marking'] = $val->marking;
					$queoptions = Quizoption::where("questionId", $val->id)->orderBy("id", "ASC")->get();
					$optiondata = array();
					foreach ($queoptions as $key1 => $value) {
						if ($key1 <= 3) {
							$optiondata[$key1]['id'] = $value->id;
							if ($value->val_type==0) {
								$optiondata[$key1]['option'] = !empty($value->quizoption) ? asset('upload/quizquestions') . "/" . $value->quizoption : '';
							} else {
								$optiondata[$key1]['option'] = $value->quizoption;
							}
							$optiondata[$key1]['val_type'] = $value->val_type;
						}
					}
					$quizdata[$key]['answers'] = $optiondata;
					$stAnswer = StudentExamAnswer::where("exam_id", $examId)->where("ques_id", $val->id)->first();
					$quizdata[$key]['given_answer'] = !empty($stAnswer->answer) ? $stAnswer->answer : 0;
				}
				$total_attemped = StudentExamAnswer::where("exam_id", $examId)->where("attemp", 1)->count();
				$quiz['total_attemped'] = $total_attemped;
				$quiz['total_unattemped'] = $total_questions - $total_attemped;
				$message = "Get all quiz questions list with previous exam.";
				return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("quiz" => $quiz, "quizdata" => $quizdata)]);
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
				$quiz['exam_id'] = $examId;
				$quizdata = array();
				$examQuestions = Quizquestions::where("quizId", $getQuiz->id)->get();
				$total_questions = count($examQuestions);
				foreach ($examQuestions as $key => $val) {
					$quizdata[$key]['id'] = $val->id;
					$quizdata[$key]['questions'] = $val->questions;
					$quizdata[$key]['image'] = !empty($val->image) ? asset('upload/quizquestions') . "/" . $val->image : '';
					$quizdata[$key]['marking'] = $val->marking;
					$queoptions = Quizoption::where("questionId", $val->id)->get();
					$optiondata = array();
					foreach ($queoptions as $key1 => $value) {
						if ($key1 <= 3) {
							$optiondata[$key1]['id'] = $value->id;
							if ($value->val_type==0) {
								$optiondata[$key1]['option'] = !empty($value->quizoption) ? asset('upload/quizquestions') . "/" . $value->quizoption : '';
							} else {
								$optiondata[$key1]['option'] = $value->quizoption;
							}
							$optiondata[$key1]['val_type'] = $value->val_type;
						}
					}
					$quizdata[$key]['answers'] = $optiondata;
					$quizdata[$key]['given_answer'] = 0;
				}
				$total_attemped = StudentExamAnswer::where("exam_id", $examId)->where("attemp", 1)->count();
				$quiz['total_attemped'] = $total_attemped;
				$quiz['total_unattemped'] = $total_questions - $total_attemped;
				$message = "Get all quiz questions list.";
				return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("quiz" => $quiz, "quizdata" => $quizdata)]);
			}
		} else {
			$message = "Quiz Not Found!";
			return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("quiz" => "", "quizdata" => "")]);
		}
	}
	public function pauseQuiz(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("exam_id" => "")]);
		}
		$examId = $request->examId;
		$remainingTime = $request->remainingTime;
		$studentExam = StudentExam::where("id", $examId)->where("user_id", $userId)->where('is_complete', 0)->orderBy("id","DESC")->first();
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
				'remaining_time' => $remainingTime,
				'updated_at' => date('Y-m-d H:i:s'),
			);
			$update = StudentExam::where("id", $examId)->update($data);
			$message = "Exam paused successfully.";
			return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("exam_id" => $examId)]);
		} else {
			$message = "Quiz Not Found!";
			return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("exam_id" => "")]);
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
		return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("ans_id" => $studentAnsId)]);
	}
	public function endQuiz(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("exam_id" => "")]);
		}
		$examId = $request->examId;
		$studentExam = StudentExam::where("id", $examId)->where("user_id", $userId)->where('is_complete', 0)->orderBy("id","DESC")->first();
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
				'is_complete' => 1,
				'updated_at' => date('Y-m-d H:i:s'),
			);
			$update = StudentExam::where("id", $examId)->update($data);
			
			$getStudentExam = StudentExam::where("id", $examId)->where("user_id", $userId)->where("is_complete", 1)->first();
			if (!empty($getStudentExam)) {
				$courseId = $getStudentExam->course_id;
				$lessionId = $getStudentExam->lession_id;
				$total_time = $getStudentExam->total_time;
				$attemped_date = date('d M, Y', strtotime($getStudentExam->created_at));
				if ($lessionId > 0) {
					$getQuiz = Quiz::where("courseId", $courseId)->where("lessionId", $lessionId)->where('islession', 0)->where('status', 1)->where('deleted', 0)->orderBy("id", "DESC")->first();
				} else {
					$getQuiz = Quiz::where("courseId", $courseId)->where("lessionId", $lessionId)->where('islession', 1)->where('status', 1)->where('deleted', 0)->orderBy("id", "DESC")->first();
				}
				if (!empty($getQuiz)) {
					$passing_percent = $getQuiz->passing_percent;
					$quizdata = array();
					$examQuestions = Quizquestions::where("quizId", $getQuiz->id)->get();
					$total_questions = count($examQuestions);
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
					//$percentage = number_format((($right * 100) / $total_questions), 2);
					$percentage = number_format((($score * 100) / $total_marking), 2);
					if ($percentage >= $passing_percent) {
						$download_status = 1;
					} else {
						$download_status = 0;
					}
					
					$user = User::where("id", $userId)->first();
					if ($download_status == 1) {
						$msg = 'Hi, '.$user->name.' Wonderful score on the recent quiz. Keep learning';
					} else {
						//$msg = 'Hi, '.$user->name.' Less score on the recent quiz. Keep learning';
						$msg = 'Sorry, Minimum '.$passing_percent.'% was needed to get the certificate. Please re-attempt the test again. All the best.';
					}
					$this->addNotification($userId,$msg);
				}
			}
			$message = "Exam ended successfully.";
			return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("exam_id" => $examId)]);
		} else {
			$message = "Quiz Not Found!";
			return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("exam_id" => "")]);
		}
	}
	public function cancelQuiz(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("quiz" => array("id" => ""))]);
		}
		$courseId = $request->courseId;
		$lessionId = $request->lessionId;
		if ($lessionId > 0) {
			$getQuiz = Quiz::where("courseId", $courseId)->where("lessionId", $lessionId)->where('islession', 0)->where('status', 1)->where('deleted', 0)->orderBy("id", "DESC")->first();
		} else {
			$getQuiz = Quiz::where("courseId", $courseId)->where("lessionId", $lessionId)->where('islession', 1)->where('status', 1)->where('deleted', 0)->orderBy("id", "DESC")->first();
		}
		if (!empty($getQuiz)) {
			$quiz['id'] = $getQuiz->id;
			$quiz['name'] = $getQuiz->name;
			$quiz['courseId'] = $courseId;
			$quiz['lessionId'] = $lessionId;
			//$cancelExam = StudentExam::where("user_id", $userId)->where("course_id", $courseId)->where("lession_id", $lessionId)->where('is_complete', 0)->delete();
			$studentExam = StudentExam::where("user_id", $userId)->where("course_id", $courseId)->where("lession_id", $lessionId)->where('is_complete', 0)->orderBy("id","DESC")->first();
			$examId = $studentExam->id;
			//$answerDel = StudentExamAnswer::where("exam_id", $examId)->delete();
			$countStudentExam = StudentExam::where("user_id", $userId)->where("course_id", $courseId)->where("lession_id", $lessionId)->where('is_complete', 1)->orderBy("id","DESC")->count();
			$completeStatus = -1;
			if ($countStudentExam > 1) {
				$completeStatus = 2; //Retake exam cancelled status
			}
			$data = array(
				'start_time' => '00:00:00',
				'end_time'   => '00:00:00',
				'total_time' => '00:00:00',
				'is_complete' => $completeStatus,
				'updated_at' => date('Y-m-d H:i:s'),
			);
			$update = StudentExam::where("id", $examId)->update($data);
			$message = "Quiz cancelled successfully.";
			return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("quiz" => $quiz)]);
		} else {
			$message = "Quiz Not Found!";
			return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("quiz" => array("id" => ""))]);
		}
	}

	public function attempedQuiz(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("quiz" => array("total_questions" => ""), "allquiz" => [], "attempedquiz" => [], "unattempedquiz" => [])]);
		}
		$examId = $request->examId;
		$quizId = $request->quizId;
		$quizdata = array();
		$attempeddata = array();
		$unattempeddata = array();
		$examQuestions = Quizquestions::where("quizId", $quizId)->get();
		$total_questions = count($examQuestions);
		if (!empty($examQuestions)) {
			foreach ($examQuestions as $key => $val) {
				$quizdata[$key]['id'] = $val->id;
				//$quizdata[$key]['questions'] = $val->questions;
				$quizdata[$key]['ques_num'] = $key + 1;
				$studentAns = StudentExamAnswer::where("exam_id", $examId)->where("ques_id", $val->id)->first();
				$quizdata[$key]['attemp'] = isset($studentAns->attemp) ? $studentAns->attemp : 2;
			}
			foreach ($examQuestions as $key1 => $val) {
				$studentAns = StudentExamAnswer::where("exam_id", $examId)->where("ques_id", $val->id)->first();
				if (!empty($studentAns) && $studentAns->attemp == 1) {
					$attemp['id'] = $val->id;
					//$attemp['questions'] = $val->questions;
					$attemp['ques_num'] = $key1 + 1;
					$attemp['attemp'] = $studentAns->attemp;
					array_push($attempeddata, $attemp);
				/*} else {
					$unattempeddata[$key1]['id'] = $val->id;
					//$unattempeddata[$key1]['questions'] = $val->questions;
					$unattempeddata[$key1]['ques_num'] = $key1 + 1;
					$unattempeddata[$key1]['attemp'] = 2;*/
				}
			}
			foreach ($examQuestions as $key2 => $val) {
				$studentAns = StudentExamAnswer::where("exam_id", $examId)->where("ques_id", $val->id)->first();
				if (empty($studentAns) || $studentAns->attemp == 0) {
					/*$unattempeddata[$key2]['id'] = $val->id;
					//$unattempeddata[$key2]['questions'] = $val->questions;
					$unattempeddata[$key2]['ques_num'] = $key2 + 1;
					$unattempeddata[$key2]['attemp'] = 2;*/
					$unattemp['id'] = $val->id;
					$unattemp['ques_num'] = $key2 + 1;
					$unattemp['attemp'] = isset($studentAns->attemp) ? 0 : 2;
					array_push($unattempeddata, $unattemp);
				}
			}
			$quiz['total_questions'] = $total_questions;
			$total_attemped = StudentExamAnswer::where("exam_id", $examId)->where("attemp", 1)->count();
			$quiz['total_attemped'] = $total_attemped;
			$quiz['total_unattemped'] = $total_questions - $total_attemped;
			$message = "Get all quiz questions list with attemped/unattemped data.";
			return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("quiz" => $quiz, "allquiz" => $quizdata, "attempedquiz" => $attempeddata, "unattempedquiz" => $unattempeddata)]);
		} else {
			$message = "Quiz Not Found!";
			return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("quiz" => "", "allquiz" => "", "attempedquiz" => "", "unattempedquiz" => "")]);
		}
	}
	public function getAllAttempedQuiz(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("attemped" => [])]);
		}
		$courseId = $request->courseId;
		$lessionId = $request->lessionId;
		$getStudentExams = StudentExam::where("user_id", $userId)->where("course_id", $courseId)->where("lession_id", $lessionId)->where("is_complete", 1)->get();
		$attempdata = array();
		if (!empty($getStudentExams)) {
			foreach ($getStudentExams as $key => $val) {
				$attemp = $key + 1;
				$attempdata[$key]['attemp'] = 'Attempt ('.$attemp.')';
				$attempdata[$key]['examId'] = $val->id;
			}
			$message = "Get all quiz attemped list by user.";
			return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("attemped" => $attempdata)]);
		} else {
			$message = "Quiz Attemped Not Found!";
			return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("attemped" => [])]);
		}
	}
	public function getQuizHistory(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("quiz" => array("quiz_id" => ""), "quizhistory" => [])]);
		}
		$examId = $request->examId;
		/*$quizId = $request->quizId;
		$getQuiz = Quiz::where("id", $quizId)->where("status", 1)->where("deleted", 0)->orderBy("id", "DESC")->first();
		$courseId = $request->courseId;
		$lessionId = $request->lessionId;*/
		$getStudentExam = StudentExam::where("id", $examId)->where("user_id", $userId)->where("is_complete", 1)->first();
		if (!empty($getStudentExam)) {
			$examId = $getStudentExam->id;
			$courseId = $getStudentExam->course_id;
			$lessionId = $getStudentExam->lession_id;
			if ($lessionId > 0) {
				$getQuiz = Quiz::where("courseId", $courseId)->where("lessionId", $lessionId)->where('islession', 0)->where('status', 1)->where('deleted', 0)->orderBy("id", "DESC")->first();
			} else {
				$getQuiz = Quiz::where("courseId", $courseId)->where("lessionId", $lessionId)->where('islession', 1)->where('status', 1)->where('deleted', 0)->orderBy("id", "DESC")->first();
			}
			if (!empty($getQuiz)) {
				$quiz['quiz_id'] = $getQuiz->id;
				$quiz['name'] = $getQuiz->name;
				$quiz['courseId'] = $courseId;
				$quiz['lessionId'] = $lessionId;
				$quizdata = array();
				$examQuestions = Quizquestions::where("quizId", $getQuiz->id)->get();
				$total_questions = count($examQuestions);
				$quiz['total_questions'] = $total_questions;
				foreach ($examQuestions as $key => $val) {
					$quizdata[$key]['id'] = $val->id;
					$quizdata[$key]['questions'] = $val->questions;
					$quizdata[$key]['image'] = !empty($val->image) ? asset('upload/quizquestions') . "/" . $val->image : '';
					$quizdata[$key]['marking'] = $val->marking;
					$quizdata[$key]['solution'] = $val->solution;
					$queoptions = Quizoption::where("questionId", $val->id)->get();
					$optiondata = array();
					foreach ($queoptions as $key1 => $value) {
						if ($key1 <= 3) {
							$optiondata[$key1]['id'] = $value->id;
							if ($value->val_type==0) {
								$optiondata[$key1]['option'] = !empty($value->quizoption) ? asset('upload/quizquestions') . "/" . $value->quizoption : '';
							} else {
								$optiondata[$key1]['option'] = $value->quizoption;
							}
							$optiondata[$key1]['val_type'] = $value->val_type;
						}
					}
					$quizdata[$key]['answers'] = $optiondata;
					$studentAns = StudentExamAnswer::where("exam_id", $examId)->where("ques_id", $val->id)->first();
					if (!empty($studentAns)) {
						$quizStAnswer = Quizoption::where("id", $studentAns->answer)->first();
					}
					//$quizdata[$key]['given_answer'] = isset($quizStAnswer->quizoption) ? $quizStAnswer->quizoption : 0;
					$quizdata[$key]['given_answer'] = isset($studentAns->answer) ? $studentAns->answer : 0;
					$quizAnswers = Quizoption::where("questionId", $val->id)->orderBy("id", "ASC")->get();
					$answer = '';
					foreach ($quizAnswers as $key1 => $value) {
						if ($key1 == ($val->currect_option - 1)){
							$answer = $value->id;
						}
					}
					$quizAnswer = Quizoption::where("id", $answer)->first();
					//$quizdata[$key]['correct_answer'] = isset($quizAnswer->quizoption) ? $quizAnswer->quizoption : 'NA';
					$quizdata[$key]['correct_answer'] = isset($answer) ? $answer : 'NA';
				}
				$message = "Get all quiz questions list history.";
				return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("quiz" => $quiz, "quizhistory" => $quizdata)]);
			} else {
				$message = "Quiz Not Found!";
				return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("quiz" => "", "quizhistory" => "")]);
			}
		} else {
			$message = "Quiz Attemped Not Found!";
			return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("quiz" => "", "quizhistory" => "")]);
		}
	}
	public function getQuizResult(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("quiz" => array("quiz_id" => ""))]);
		}
		$examId = $request->examId;
		/*$quizId = $request->quizId;
		$courseId = $request->courseId;
		$lessionId = $request->lessionId;*/
		$getStudentExam = StudentExam::where("id", $examId)->where("user_id", $userId)->where("is_complete", 1)->first();
		if (!empty($getStudentExam)) {
			//$examId = $getStudentExam->id;
			$courseId = $getStudentExam->course_id;
			$lessionId = $getStudentExam->lession_id;
			$total_time = $getStudentExam->total_time;
			$certificate = $getStudentExam->certificate;
			$attemped_date = date('d M, Y', strtotime($getStudentExam->created_at));
			//$getQuiz = Quiz::where("id", $quizId)->where("status", 1)->where("deleted", 0)->orderBy("id", "DESC")->first();
			if ($lessionId > 0) {
				$getQuiz = Quiz::where("courseId", $courseId)->where("lessionId", $lessionId)->where('islession', 0)->where('status', 1)->where('deleted', 0)->orderBy("id", "DESC")->first();
			} else {
				$getQuiz = Quiz::where("courseId", $courseId)->where("lessionId", $lessionId)->where('islession', 1)->where('status', 1)->where('deleted', 0)->orderBy("id", "DESC")->first();
			}
			if (!empty($getQuiz)) {
				$quiz['quiz_id'] = $getQuiz->id;
				$quiz['name'] = $getQuiz->name;
				$islession = $getQuiz->islession;
				$passing_percent = $getQuiz->passing_percent;
				$quiz['courseId'] = $courseId;
				$quiz['lessionId'] = $lessionId;
				$quizdata = array();
				$examQuestions = Quizquestions::where("quizId", $getQuiz->id)->get();
				$total_questions = count($examQuestions);
				$quiz['total_questions'] = $total_questions;
				$quiz['time_efficiency'] = $total_time;
				$quiz['attemped_date'] = $attemped_date;
				$total_marking = $score = $right = $wrong = $total_solved = $not_solved = 0;
				foreach ($examQuestions as $key => $val) {
					$quizdata[$key]['id'] = $val->id;
					$quizdata[$key]['questions'] = $val->questions;
					$quizdata[$key]['image'] = !empty($val->image) ? asset('upload/quizquestions') . "/" . $val->image : '';
					$quizdata[$key]['marking'] = $val->marking;
					$total_marking += $val->marking;
					/*$queoptions = Quizoption::where("questionId", $val->id)->get();
					$optiondata = array();
					foreach ($queoptions as $key1 => $value) {
						$optiondata[$key1]['id'] = $value->id;
						$optiondata[$key1]['option'] = $value->quizoption;
					}
					$quizdata[$key]['answers'] = $optiondata;*/
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
					$quiz['remark_status'] = 'Passed';
				} else {
					$download_status = 0;
					$quiz['remark_status'] = 'Failed';
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

				$message = "Get all quiz questions list score.";
				return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("quiz" => $quiz)]);
			} else {
				$message = "Quiz Not Found!";
				return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("quiz" => array("quiz_id" => ""))]);
			}
		} else {
			$message = "Quiz Attemped Not Found!";
			return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("quiz" => array("quiz_id" => ""))]);
		}
	}
	public function getQuizResultDetails(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("quiz" => array("total_questions" => ""), "allquiz" => [], "correctquiz" => [], "incorrectquiz" => [], "skipedquiz" => [])]);
		}
		$examId = $request->examId;
		/*$quizId = $request->quizId;
		$courseId = $request->courseId;
		$lessionId = $request->lessionId;*/
		$getStudentExam = StudentExam::where("id", $examId)->where("user_id", $userId)->where("is_complete", 1)->first();
		if (!empty($getStudentExam)) {
			//$examId = $getStudentExam->id;
			$courseId = $getStudentExam->course_id;
			$lessionId = $getStudentExam->lession_id;
			$total_time = $getStudentExam->total_time;
			$attemped_date = date('d M, Y', strtotime($getStudentExam->created_at));
			//$getQuiz = Quiz::where("id", $quizId)->where("status", 1)->where("deleted", 0)->orderBy("id", "DESC")->first();
			if ($lessionId > 0) {
				$getQuiz = Quiz::where("courseId", $courseId)->where("lessionId", $lessionId)->where('islession', 0)->where('status', 1)->where('deleted', 0)->orderBy("id", "DESC")->first();
			} else {
				$getQuiz = Quiz::where("courseId", $courseId)->where("lessionId", $lessionId)->where('islession', 1)->where('status', 1)->where('deleted', 0)->orderBy("id", "DESC")->first();
			}
			if (!empty($getQuiz)) {
				$quizdata = array();
				$correctdata = array();
				$incorrectdata = array();
				$unattempeddata = array();
				$examQuestions = Quizquestions::where("quizId", $getQuiz->id)->get();
				$total_questions = count($examQuestions);
				$quiz['total_questions'] = $total_questions;
				/*$quiz['time_efficiency'] = $total_time;
				$quiz['attemped_date'] = $attemped_date;*/
				$score = $right = $wrong = $total_solved = $not_solved = 0;
				foreach ($examQuestions as $key => $val) {
					$quizdata[$key]['id'] = $val->id;
					// $quizdata[$key]['questions'] = $val->questions;
					// $quizdata[$key]['image'] = !empty($val->image) ? asset('upload/quizquestions') . "/" . $val->image : '';
					// $quizdata[$key]['marking'] = $val->marking;
					$quizdata[$key]['ques_num'] = $key + 1;
					$studentAns = StudentExamAnswer::where("exam_id", $examId)->where("ques_id", $val->id)->first();
					$quizdata[$key]['attemp'] = isset($studentAns->attemp) ? $studentAns->attemp : 2;
					/*$queoptions = Quizoption::where("questionId", $val->id)->get();
					$optiondata = array();
					foreach ($queoptions as $key1 => $value) {
						$optiondata[$key1]['id'] = $value->id;
						$optiondata[$key1]['option'] = $value->quizoption;
					}
					$quizdata[$key]['answers'] = $optiondata;*/
					$studentAns = StudentExamAnswer::where("exam_id", $examId)->where("ques_id", $val->id)->first();
					if (!empty($studentAns)) {
						$quizAnswers = Quizoption::where("questionId", $val->id)->orderBy("id", "ASC")->get();
						$answer = '';
						foreach ($quizAnswers as $arr_key => $value) {
							if ($arr_key == ($val->currect_option - 1)){
								$answer = $value->id;
							}
						}
						//if ($val->currect_option == $studentAns->answer) {
						if ($answer == $studentAns->answer) {
							$right++;
							$score += $val->marking;
						} else {
							if ($studentAns->attemp == 1) {
								$wrong++;
							}
						}
					}
				}
				$total_solved = $right + $wrong;
				$not_solved = $total_questions - $total_solved;
				$quiz['total_attemped'] = $total_solved;
				$quiz['right_answer'] = $right;
				$quiz['wrong_answer'] = $wrong;
				$quiz['skiped_answer'] = $not_solved;
				$quiz['total_score'] = $score;
				
				foreach ($examQuestions as $key1 => $val) {
					$studentAns = StudentExamAnswer::where("exam_id", $examId)->where("ques_id", $val->id)->first();
					if (!empty($studentAns)) {
						$quizAnswers = Quizoption::where("questionId", $val->id)->orderBy("id", "ASC")->get();
						$answer = '';
						foreach ($quizAnswers as $arr_key => $value) {
							if ($arr_key == ($val->currect_option - 1)){
								$answer = $value->id;
							}
						}
						if ($answer == $studentAns->answer) {
							$correct['id'] = $val->id;
							//$correct['questions'] = $val->questions;
							$correct['ques_num'] = $key1 + 1;
							$correct['attemp'] = $studentAns->attemp;
							array_push($correctdata, $correct);
						} else {
							if ($studentAns->attemp == 1) {
								$incorrect['id'] = $val->id;
								//$incorrect['questions'] = $val->questions;
								$incorrect['ques_num'] = $key1 + 1;
								$incorrect['attemp'] = $studentAns->attemp;
								array_push($incorrectdata, $incorrect);
							}
						}
					}
				}
				foreach ($examQuestions as $key2 => $val) {
					$studentAns = StudentExamAnswer::where("exam_id", $examId)->where("ques_id", $val->id)->first();
					if (empty($studentAns) || $studentAns->attemp == 0) {
						$unattemp['id'] = $val->id;
						$unattemp['ques_num'] = $key2 + 1;
						$unattemp['attemp'] = 2;
						array_push($unattempeddata, $unattemp);
					}
				}

				$message = "Get all quiz questions list result details.";
				return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("quiz" => $quiz, "allquiz" => $quizdata, "correctquiz" => $correctdata, "incorrectquiz" => $incorrectdata, "skipedquiz" => $unattempeddata)]);
			} else {
				$message = "Quiz Not Found!";
				return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("quiz" => "", "allquiz" => "", "correctquiz" => "", "incorrectquiz" => "", "skipedquiz" => "")]);
			}
		} else {
			$message = "Quiz Attemped Not Found!";
			return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("quiz" => "", "allquiz" => "", "correctquiz" => "", "incorrectquiz" => "", "skipedquiz" => "")]);
		}
	}

	public function liveClasses(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("userSubscription" => "", "liveClassNow" => [], "liveClasses" => [])]);
		}
		$search = $request->search;
		$from = date('Y-m-d').' 00:00:00';
		$to = date('Y-m-d').' 23:59:59';
		//$dt = Carbon::now();
		$today	  = date('Y-m-d');
		$subscription = UserSubscription::where("user_id", $userId)->where("end_date", ">=", $today)->orderBy('id', 'DESC')->first();
		$userSubscription = !empty($subscription) ? 1 : 0;
		$liveClass = LiveClass::where("status", 1)->where("deleted", 0)->whereBetween('class_time', [$from, date('Y-m-d H:i:s')])->get();
		$liveClassNow = array();
		if (!empty($liveClass)) {
			foreach ($liveClass as $key => $val) {
				$user = User::where("id", $val['added_by'])->first();
				$liveClassNow[$key]['id'] = $val['id'];
				$liveClassNow[$key]['added_by'] = $user->name;
				$liveClassNow[$key]['title'] = $val['title'];
				$liveClassNow[$key]['subject'] = $val['subject'];
				$liveClassNow[$key]['image'] = asset('upload/liveclasses') . "/" . $val['image'];
				$liveClassNow[$key]['meeting_id'] = $val['meeting_id'];
				$liveClassNow[$key]['pass_code'] = $val['pass_code'];
				$liveClassNow[$key]['master_class'] = $val['master_class'];
				$liveClassNow[$key]['class_time'] = date('m/d/Y, h:i A', strtotime($val['class_time']));
				$liveClassNow[$key]['isFree'] 		= $val['isFree'];
				$check_interest = LiveclassNotify::where("user_id", $userId)->where("class_id", $val['id'])->first();
				$my_interest = !empty($check_interest) ? 1 : 0;
				$liveClassNow[$key]['my_interest'] = $my_interest;
				$total_interest = LiveclassNotify::where("class_id", $val['id'])->count();
				$liveClassNow[$key]['total_interest'] = $total_interest;
			}
			$liveClasses = LiveClass::where("status", 1)->where("deleted", 0)->whereBetween('class_time', [$from, $to]);
			if (!empty($liveClasses)) {
				$liveClasses = $liveClasses->where("title", 'like', "%" . $search . "%");
			}
			$liveClasses = $liveClasses->orderBy('class_time', 'ASC')->limit(10)->get();
			$liveClsdata = array();
			foreach ($liveClasses as $key => $val) {
				$user = User::where("id", $val['added_by'])->first();
				$liveClsdata[$key]['id'] = $val['id'];
				$liveClsdata[$key]['added_by'] = $user->name;
				$liveClsdata[$key]['title'] = $val['title'];
				$liveClsdata[$key]['subject'] = $val['subject'];
				$liveClsdata[$key]['image'] = asset('upload/liveclasses') . "/" . $val['image'];
				$liveClsdata[$key]['meeting_id'] = $val['meeting_id'];
				$liveClsdata[$key]['pass_code'] = $val['pass_code'];
				$liveClsdata[$key]['master_class'] = $val['master_class'];
				$liveClsdata[$key]['class_time'] = date('m/d/Y, h:i A', strtotime($val['class_time']));
				$liveClsdata[$key]['isFree'] 		= $val['isFree'];
				$check_interest = LiveclassNotify::where("user_id", $userId)->where("class_id", $val['id'])->first();
				$my_interest = !empty($check_interest) ? 1 : 0;
				$liveClsdata[$key]['my_interest'] = $my_interest;
				$total_interest = LiveclassNotify::where("class_id", $val['id'])->count();
				$liveClsdata[$key]['total_interest'] = $total_interest;
			}
			$message = "All Live Classes Data.";
			return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("userSubscription" => $userSubscription, "liveClassNow" => $liveClassNow, "liveClasses" => $liveClsdata)]);
		} else {
			$message = "Live Class Not Found!";
			return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("userSubscription" => $userSubscription, "liveClassNow" => "", "liveClasses" => "")]);
		}
	}
	public function pastUpcomingClasses(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("userSubscription" => "", "pastClasses" => [], "upcomingClasses" => [])]);
		}
		$search = $request->search;
		$now = date('Y-m-d H:i:s');
		//$dt = Carbon::now();
		$today	  = date('Y-m-d');
		$subscription = UserSubscription::where("user_id", $userId)->where("end_date", ">=", $today)->orderBy('id', 'DESC')->first();
		$userSubscription = !empty($subscription) ? 1 : 0;
		$pastClasses = LiveClass::where("status", 1)->where("deleted", 0)->where('class_time', '<', $now)->orderBy('class_time', 'ASC')->get();
		$pastClass = array();
		if (!empty($pastClasses)) {
			foreach ($pastClasses as $key => $val) {
				$user = User::where("id", $val['added_by'])->first();
				$pastClass[$key]['id']				= $val['id'];
				$pastClass[$key]['added_by']		= $user->name;
				$pastClass[$key]['title']			= $val['title'];
				$pastClass[$key]['subject']			= $val['subject'];
				$pastClass[$key]['image']			= asset('upload/liveclasses') . "/" . $val['image'];
				$pastClass[$key]['original_video']	= isset($val['video']) ? asset('upload/liveclasses') . "/" . $val['video'] : 'NA'; //'https://multiplatform-f.akamaihd.net/i/multi/april11/sintel/sintel-hd_,512x288_450_b,640x360_700_b,768x432_1000_b,1024x576_1400_m,.mp4.csmil/master.m3u8';
				if (!empty($val['video_1']) && $val['video_1']!='NA') {
					if(file_exists( public_path().'/upload/liveclasses/'.$val['video_1'] )) {
						$video_1 = asset('upload/liveclasses') . "/" . $val['video_1'];
					} else {
						$video_1 = $pastClass[$key]['original_video'];
					}
				} else {
					$video_1 = $pastClass[$key]['original_video'];
				}
				if (!empty($val['video_2']) && $val['video_2']!='NA') {
					if(file_exists( public_path().'/upload/liveclasses/'.$val['video_2'] )) {
						$video_2 = asset('upload/liveclasses') . "/" . $val['video_2'];
					} else {
						$video_2 = $pastClass[$key]['original_video'];
					}
				} else {
					$video_2 = $pastClass[$key]['original_video'];
				}
				if (!empty($val['video_3']) && $val['video_3']!='NA') {
					if(file_exists( public_path().'/upload/liveclasses/'.$val['video_3'] )) {
						$video_3 = asset('upload/liveclasses') . "/" . $val['video_3'];
					} else {
						$video_3 = $pastClass[$key]['original_video'];
					}
				} else {
					$video_3 = $pastClass[$key]['original_video'];
				}
				$pastClass[$key]['low_video']		= $video_1;
				$pastClass[$key]['medium_video']	= $video_2;
				$pastClass[$key]['high_video']		= $video_3;
				$pastClass[$key]['master_class']	= $val['master_class'];
				$pastClass[$key]['class_time']		= date('m/d/Y, h:i A', strtotime($val['class_time']));
				$pastClass[$key]['isFree'] 			= $val['isFree'];
				$check_interest = LiveclassNotify::where("user_id", $userId)->where("class_id", $val['id'])->first();
				$my_interest = !empty($check_interest) ? 1 : 0;
				$pastClass[$key]['my_interest']		= $my_interest;
				$total_interest = LiveclassNotify::where("class_id", $val['id'])->count();
				$pastClass[$key]['total_interest']	= $total_interest;
			}
		}
		$upcomingClasses = LiveClass::where("status", 1)->where("deleted", 0)->where('class_time', '>=', $now)->orderBy('class_time', 'ASC')->get();
		$upcomingClass = array();
		if (!empty($upcomingClasses)) {
			foreach ($upcomingClasses as $key => $val) {
				$user = User::where("id", $val['added_by'])->first();
				$upcomingClass[$key]['id'] = $val['id'];
				$upcomingClass[$key]['added_by'] = $user->name;
				$upcomingClass[$key]['title'] = $val['title'];
				$upcomingClass[$key]['subject'] = $val['subject'];
				$upcomingClass[$key]['image'] = asset('upload/liveclasses') . "/" . $val['image'];
				$upcomingClass[$key]['meeting_id'] = $val['meeting_id'];
				$upcomingClass[$key]['pass_code'] = $val['pass_code'];
				$upcomingClass[$key]['master_class'] = $val['master_class'];
				$upcomingClass[$key]['class_time'] = date('m/d/Y, h:i A', strtotime($val['class_time']));
				$upcomingClass[$key]['isFree'] 			= $val['isFree'];
				$check_interest = LiveclassNotify::where("user_id", $userId)->where("class_id", $val['id'])->first();
				$my_interest = !empty($check_interest) ? 1 : 0;
				$upcomingClass[$key]['my_interest'] = $my_interest;
				$total_interest = LiveclassNotify::where("class_id", $val['id'])->count();
				$upcomingClass[$key]['total_interest'] = $total_interest;
			}
		}
		$message = "All Past and Upcoming Live Classes Data.";
		return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("userSubscription" => $userSubscription, "pastClasses" => $pastClass, "upcomingClasses" => $upcomingClass)]);
	}
	public function notifyClass(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("notifyId" => "")]);
		}
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
			}
			$message = "Your Class Added Successfully.";
			return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("notifyId" => $insertId)]);
		} else {
			$message = "Wrong Paramenter Passed!";
			return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("notifyId" => "")]);
		}
	}

	public function getCourses(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("userSubscription" => "", "askFreeQuestions" => "", "askedQuestionCount" => "", "courses" => [])]);
		}
		$today	  = date('Y-m-d');
		$subscription = UserSubscription::where("user_id", $userId)->where("end_date", ">=", $today)->orderBy('id', 'DESC')->first();
		$userSubscription = !empty($subscription) ? 1 : 0;
		$askFreeQuestions = 3;
		$askedQuestionCount = QuestionAsk::where('user_id', $userId)->count();
		$courses  = Courses::where("status", 1)->where('deleted', 0)->orderBy('sort_id', 'ASC')->get();
		$coursedata = array();
		foreach ($courses as $key => $value) {
			$coursedata[$key]['id']  = $value['id'];
			$coursedata[$key]['name']  = $value['name'];
		}
		$message = "All Courses List.";
		return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("userSubscription" => $userSubscription, "askFreeQuestions" => $askFreeQuestions, "askedQuestionCount" => $askedQuestionCount, "courses" => $coursedata)]);
	}
	public function getLessionsBycourse(Request $request)
	{
		$courseId = $request->courseId;
		$lessions = Lession::where("courseId", $courseId)->where("status", 1)->where('deleted', 0)->orderBy('sort_id', 'ASC')->get();
		$lessiondata = array();
		if (!empty($lessions)) {
			foreach ($lessions as $key => $value) {
				$lessiondata[$key]['id']  = $value['id'];
				$lessiondata[$key]['name']  = $value['name'];
			}
			$message = "Lessions List by Course.";
			return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("lessions" => $lessiondata)]);
		} else {
			$message = "Lessions List not Found!";
			return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("lessions" => "")]);
		}
	}
	public function getTopicsByLession(Request $request)
	{
		$lessionId = $request->lessionId;
		$topics = Chapter::where("lessionId", $lessionId)->where("status", 1)->where('deleted', 0)->orderBy('sort_id', 'ASC')->get();
		$topicdata = array();
		if (!empty($topics)) {
			foreach ($topics as $key => $value) {
				$topicdata[$key]['id']  = $value['id'];
				$topicdata[$key]['name']  = $value['name'];
			}
			$message = "Topics List by Lession.";
			return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("topics" => $topicdata)]);
		} else {
			$message = "Topics List not Found!";
			return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("topics" => "")]);
		}
	}
	public function askQuestion(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("ques_id" => "")]);
		}
		$courseId 	= $request->courseId;
		$lessionId  = $request->lessionId;
		$topicId 	= $request->topicId;
		$question 	= $request->question;
		$msg = '';
		if (!empty($userId)  && !empty($courseId) && !empty($lessionId) || !empty($question) || isset($_FILES['image']['name']) ) {
			$questioncount = QuestionAsk::where('user_id', $userId)->count();
			if ($questioncount < 3) {
				$imagess = '';
				if (isset($_FILES['image']['name']) && $_FILES['image']['name']!='') {
					$quesimagename = $_FILES['image']['name'];
					$tmpimage1 = $_FILES['image']['tmp_name'];
					$newImage = rand(00000, 99999) . date('d') . $quesimagename;
					$location = "upload/questionask/";
					move_uploaded_file($tmpimage1, $location . $newImage);
					$url = 'upload/questionask/' . $newImage;
					$img = Image::make($url)->resize(200, 200);
					$imagess =  $img->basename;
				}
				$data = array(
					'user_id' 	 => $userId,
					'course_id'  => $courseId,
					'lession_id' => $lessionId,
					'topic_id' 	 => $topicId,
					'question'   => $question,
					'image'      => $imagess,
					'status'     => 0,
					'created_at' => date('Y-m-d H:i:s'),
				);
				$insertId = QuestionAsk::insertGetId($data);
				/*$user = User::where("id", $userId)->first();
				$msg = $user->name.' Asked a question '.$question.' in Q&A, check it now.';
				$users = User::where("id", "!=", $userId)->where("role_id", "!=", 1)->get();
				foreach ($users as $userval) {
					$this->addNotification($userval->id,$msg);
				}*/
				$message = 'Your Question Submitted Successfully, Team will approve it.';
				return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array('ques_id' => $insertId)]);
			} else {
				//Check subcription by user later work will be do.
				$subcriptionCheck = User::where('id', $userId)->where('status', 1)->first();
				if (!empty($subcriptionCheck)) {
					$imagess = '';
					if (isset($_FILES['image']['name']) && $_FILES['image']['name']!='') {
						$quesimagename = $_FILES['image']['name'];
						$tmpimage1 = $_FILES['image']['tmp_name'];
						$newImage = rand(00000, 99999) . date('d') . $quesimagename;
						$location = "upload/questionask/";
						move_uploaded_file($tmpimage1, $location . $newImage);
						$url = 'upload/questionask/' . $newImage;
						$img = Image::make($url)->resize(200, 200);
						$imagess =  $img->basename;
					}
					$data = array(
						'user_id' 	 => $userId,
						'course_id'  => $courseId,
						'lession_id' => $lessionId,
						'topic_id' 	 => $topicId,
						'question'   => $question,
						'image'      => $imagess,
						'status'     => 0,
						'created_at' => date('Y-m-d H:i:s'),
					);
					$insertId = QuestionAsk::insertGetId($data);
					/*$user = User::where("id", $userId)->first();
					$msg = $user->name.', Asked a question '.$question.' in Q&A, check it now.';
					$users = User::where("id", "!=", $userId)->where("role_id", "!=", 1)->get();
					foreach ($users as $userval) {
						$this->addNotification($userval->id,$msg);
					}*/
					$message = 'Your Question Submitted Successfully, Team will approve it.';
					return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("ques_id" => $insertId)]);
				} else {
					$message = "Please subscribed a package first to ask more questions!";
					return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("ques_id" => "")]);
				}
			}
		} else {
			$message = "Wrong Paramenter Passed!";
			return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("ques_id" => "")]);
		}
	}
	public function latestQuestion(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("latestQuestions" => [])]);
		}
		$search = $request->search;
		$dt = Carbon::now();
		$from = $dt->subMonth();
		$to = date('Y-m-d H:i:s');
		/*$from = date('Y-m-d').' 00:00:00';
		$to = date('Y-m-d').' 23:59:59';*/
		$latestQuesAsks = QuestionAsk::where("status", 1)->whereBetween("created_at", [$from, $to]);
		if (!empty($latestQuesAsks)) {
			$latestQuesAsks = $latestQuesAsks->where("question", 'like', "%" . $search . "%");
		}
		$latestQuesAsks = $latestQuesAsks->orderBy("id", "DESC")->get();
		$latestQuestion = array();
		if (!empty($latestQuesAsks)) {
			foreach ($latestQuesAsks as $key => $val) {
				$user = User::where("id", $val['user_id'])->first();
				$course = Courses::where("id", $val['course_id'])->first();
				$lession = Lession::where("id", $val['lession_id'])->first();
				$topic = Chapter::where("id", $val['topic_id'])->first();
				$courseLessionTopicName = '';
				if($val['topic_id'] > 0){
					$courseLessionTopicName = $course->name.' / '.$lession->name.' / '.$topic->name;
				}elseif($val['lession_id'] > 0){
					$courseLessionTopicName = $course->name.' / '.$lession->name;
				}else{
					if($val['course_id'] > 0){
						$courseLessionTopicName = $course->name;
					}
				}
				$latestQuestion[$key]['id']            = $val['id'];
				$latestQuestion[$key]['added_by']      = $user->name;
				$latestQuestion[$key]['profile_image'] = !empty($user->image) ? asset('upload/profile') . "/" . $user->image : '';
				$latestQuestion[$key]['course_name']   = $courseLessionTopicName;
				//$latestQuestion[$key]['lession_name']  = isset($lession->name) ? $lession->name : '';
				$latestQuestion[$key]['created_at']    = $val['created_at']->diffForHumans(); //date('h:i A', strtotime($val['created_at']));
				$latestQuestion[$key]['question']      = $val['question'];
				$latestQuestion[$key]['image']         = !empty($val['image']) ? asset('upload/questionask') . "/" . $val['image'] : '';
				$latestQuestion[$key]['total_answers'] = QuestionAnswer::where("ques_id", $val['id'])->count();
				$latestQuestion[$key]['share_url'] = route('questionAnswerView',$val['id']);
				if ($userId == $val['user_id']) {
					$latestQuestion[$key]['my_question']  = 1;
				} else {
					$latestQuestion[$key]['my_question']  = 0;
				}
			}
			$message = "All Latest Questions Data.";
			return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("latestQuestions" => $latestQuestion)]);
		} else {
			$message = "Latest Question Not Found!";
			return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("latestQuestions" => "")]);
		}
	}
	public function myQuestion(Request $request)
	{
		//echo $token = $request->bearerToken(); die;
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("myQuestions" => [])]);
		}
		/*$dt = Carbon::now();
		$from = $dt->subMonth();
		$to = date('Y-m-d H:i:s');*/
		$myQuestions = QuestionAsk::where("user_id", $userId)->where("status", 1)->where("deleted", 0)->orderBy("id", "DESC")->get();
		$myQuestion = array();
		if (!empty($myQuestions)) {
			foreach ($myQuestions as $key => $val) {
				$user = User::where("id", $val['user_id'])->first();
				$course = Courses::where("id", $val['course_id'])->first();
				$lession = Lession::where("id", $val['lession_id'])->first();
				$topic = Chapter::where("id", $val['topic_id'])->first();
				$courseLessionTopicName = '';
				if($val['topic_id'] > 0){
					$courseLessionTopicName = $course->name.' / '.$lession->name.' / '.$topic->name;
				}elseif($val['lession_id'] > 0){
					$courseLessionTopicName = $course->name.' / '.$lession->name;
				}else{
					if($val['course_id'] > 0){
						$courseLessionTopicName = $course->name;
					}
				}
				$myQuestion[$key]['id']            = $val['id'];
				$myQuestion[$key]['added_by']      = $user->name;
				$myQuestion[$key]['profile_image'] = !empty($user->image) ? asset('upload/profile') . "/" . $user->image : '';
				$myQuestion[$key]['course_name']   = $courseLessionTopicName;
				//$myQuestion[$key]['lession_name']  = isset($lession->name) ? $lession->name : '';
				$myQuestion[$key]['created_at']    = $val['created_at']->diffForHumans();
				$myQuestion[$key]['question']      = $val['question'];
				$myQuestion[$key]['image']         = !empty($val['image']) ? asset('upload/questionask') . "/" . $val['image'] : '';
				$myQuestion[$key]['total_answers'] = QuestionAnswer::where("ques_id", $val['id'])->count();
				$myQuestion[$key]['share_url'] = route('questionAnswerView',$val['id']);
			}
			$message = "All My Questions Data.";
			return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("myQuestions" => $myQuestion)]);
		} else {
			$message = "My Question Not Found!";
			return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("myQuestions" => "")]);
		}
	}
	public function answerAQuestion(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("answer_id" => "")]);
		}
		$quesId 	= $request->quesId;
		$answer 	= $request->answer;
		$msg = '';
		if (!empty($userId)  && !empty($quesId)) {
			$questioncheck = QuestionAsk::where('id', $quesId)->first();
			if (!empty($questioncheck)) {
				$imagess = '';
				if (isset($_FILES['image']['name']) && $_FILES['image']['name']!='') {
					$ansimagename = $_FILES['image']['name'];
					$tmpimage1 = $_FILES['image']['tmp_name'];
					$newImage = rand(00000, 99999) . date('d') . $ansimagename;
					$location = "upload/questionask/";
					move_uploaded_file($tmpimage1, $location . $newImage);
					$url = 'upload/questionask/' . $newImage;
					$img = Image::make($url)->resize(200, 200);
					$imagess =  $img->basename;
				}
				$data = array(
					'user_id' 	 => $userId,
					'ques_id'    => $quesId,
					'answer'     => $answer,
					'image'      => $imagess,
					'status'     => 1,
					'created_at' => date('Y-m-d H:i:s'),
				);
				$insertId = QuestionAnswer::insertGetId($data);
				$user = User::where("id", $userId)->first();
				$ques = QuestionAsk::where("id", $quesId)->first();
				$msg = $user->name.', Answered a question '.$ques->question.' in Q&A, check it now.';
				$this->addNotification($ques->user_id,$msg);
				/*$users = User::where("id", "!=", $userId)->where("role_id", "!=", 1)->get();
				foreach ($users as $userval) {
					$this->addNotification($userval->id,$msg);
				}*/
				$message = 'Your Answer Submitted Successfully.';
				return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("answer_id" => $insertId)]);
			} else {
				$message = "Question not Found!";
				return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("answer_id" => "")]);
			}
		} else {
			$message = "Wrong Paramenter Passed!";
			return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("answer_id" => "")]);
		}
	}
	public function viewAnswers(Request $request)
	{
		$quesId   = $request->quesId;
		$question = QuestionAsk::where("id", $quesId)->where("status", 1)->first();
		$questiondata = array();
		if (!empty($question)) {
			$user = User::where("id", $question->user_id)->first();
			$course = Courses::where("id", $question->course_id)->first();
			$lession = Lession::where("id", $question->lession_id)->first();
			$topic = Chapter::where("id", $question->topic_id)->first();
			$courseLessionTopicName = '';
			if($question->topic_id > 0){
				$courseLessionTopicName = $course->name.' / '.$lession->name.' / '.$topic->name;
			}elseif($question->lession_id > 0){
				$courseLessionTopicName = $course->name.' / '.$lession->name;
			}else{
				if($question->course_id > 0){
					$courseLessionTopicName = $course->name;
				}
			}
			$questiondata['id']            = $question->id;
			$questiondata['added_by']      = isset($user->name) ? $user->name : '';
			$questiondata['profile_image'] = !empty($user->image) ? asset('upload/profile') . "/" . $user->image : '';
			$questiondata['course_name']   = $courseLessionTopicName;
			//$questiondata['lession_name']  = isset($lession->name) ? $lession->name : '';
			$questiondata['created_at']    = $question->created_at->diffForHumans();
			$questiondata['question']      = $question->question;
			$questiondata['image']         = !empty($question->image) ? asset('upload/questionask') . "/" . $question->image : '';
			$questiondata['total_answers'] = QuestionAnswer::where("ques_id", $question->id)->count();
			$questiondata['share_url'] = route('questionAnswerView',$question->id);
			$answers = QuestionAnswer::where("ques_id", $quesId)->where("expert", "!=", 0)->where("status", 1)->orderBy("expert", "ASC")->orderBy("ans_like", "DESC")->get();
			$answerdata = array();
			$expertanswerdata = array();
			if (!empty($answers)) {
				foreach ($answers as $key => $val) {
					$user = User::where("id", $val['user_id'])->first();
					/*$answerdata[$key]['id']            = $val['id'];
					$answerdata[$key]['added_by']      = isset($user->name) ? $user->name : '';
					$answerdata[$key]['profile_image'] = !empty($user->image) ? asset('upload/profile') . "/" . $user->image : '';
					$answerdata[$key]['created_at']    = $val['created_at']->diffForHumans();
					$answerdata[$key]['answer']        = $val['answer'];
					$answerdata[$key]['image']         = !empty($val['image']) ? asset('upload/questionask') . "/" . $val['image'] : '';
					$answerdata[$key]['ans_like']      = $val['ans_like'];
					$answerdata[$key]['ans_unlike']    = $val['ans_unlike'];
					$answerdata[$key]['expert'] 	   = $val['expert'];*/
					$expertans['id']            = $val['id'];
					$expertans['added_by']      = isset($user->name) ? $user->name : '';
					$expertans['profile_image'] = !empty($user->image) ? asset('upload/profile') . "/" . $user->image : '';
					$expertans['created_at']    = $val['created_at']->diffForHumans();
					$expertans['answer']        = $val['answer'];
					$expertans['image']         = !empty($val['image']) ? asset('upload/questionask') . "/" . $val['image'] : '';
					$expertans['ans_like']      = $val['ans_like'];
					$expertans['ans_unlike']    = $val['ans_unlike'];
					$expertans['expert']		  = $val['expert'];
					array_push($expertanswerdata, $expertans);
				}
			}
			$useranswers = QuestionAnswer::where("ques_id", $quesId)->where("expert", 0)->where("status", 1)->orderBy("ans_like", "DESC")->get();
			$useranswerdata = array();
			if (!empty($useranswers)) {
				foreach ($useranswers as $key => $val) {
					$user = User::where("id", $val['user_id'])->first();
					$userans['id']            = $val['id'];
					$userans['added_by']      = isset($user->name) ? $user->name : '';
					$userans['profile_image'] = !empty($user->image) ? asset('upload/profile') . "/" . $user->image : '';
					$userans['created_at']    = $val['created_at']->diffForHumans();
					$userans['answer']        = $val['answer'];
					$userans['image']         = !empty($val['image']) ? asset('upload/questionask') . "/" . $val['image'] : '';
					$userans['ans_like']      = $val['ans_like'];
					$userans['ans_unlike']    = $val['ans_unlike'];
					$userans['expert']		  = $val['expert'];
					array_push($useranswerdata, $userans);
				}
			}
			$answerdata = array_merge($expertanswerdata, $useranswerdata);
			$message = "Get All Answers of a Question Successfully.";
			return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("question" => $questiondata, "answers" => $answerdata)]);
		} else {
			$message = "Question Not Found!";
			return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("question" => "", "answers" => "")]);
		}
	}
	public function likeAnswer(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("answer_id" => "")]);
		}
		$answerId = $request->answerId;
		$msg = '';
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
					$msg = 'Your Like Submitted Successfully.';
					return response()->json(['statusCode' => 200, 'message' => $msg, 'data' => array("answer_id" => $answerId)]);
				} else {
					$msg = 'You have already liked this answer.';
					return response()->json(['statusCode' => 200, 'message' => $msg, 'data' => array("answer_id" => $answerId)]);
				}
			} else {
				$msg = "Answer not Found!";
				return response()->json(['statusCode' => 400, 'message' => $msg, 'data' => array("answer_id" => "")]);
			}
		} else {
			$msg = "Wrong Paramenter Passed!";
			return response()->json(['statusCode' => 400, 'message' => $msg, 'data' => array("answer_id" => "")]);
		}
	}
	public function unlikeAnswer(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("answer_id" => "")]);
		}
		$answerId = $request->answerId;
		$msg = '';
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
					$msg = 'Your Unlike Submitted Successfully.';
					return response()->json(['statusCode' => 200, 'message' => $msg, 'data' => array("answer_id" => $answerId)]);
				} else {
					$msg = 'You have already disliked this answer.';
					return response()->json(['statusCode' => 200, 'message' => $msg, 'data' => array("answer_id" => $answerId)]);
				}
			} else {
				$msg = "Answer not Found!";
				return response()->json(['statusCode' => 400, 'message' => $msg, 'data' => array("answer_id" => "")]);
			}
		} else {
			$msg = "Wrong Paramenter Passed!";
			return response()->json(['statusCode' => 400, 'message' => $msg, 'data' => array("answer_id" => "")]);
		}
	}

	public function userDetail(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("user" => array("id"=>""))]);
		}
		$user     = User::where("id", $userId)->where("status", 1)->first();
		$userdata = array();
		if (!empty($user)) {
			$userdata['id']             = $user->id;
			$userdata['name']           = isset($user->name) ? $user->name : '';
			$userdata['email']          = isset($user->email) ? $user->email : '';
			$userdata['phone']          = isset($user->phone) ? $user->phone : '';
			$userdata['gender']         = isset($user->gender) ? $user->gender : '';
			$userdata['dob']            = isset($user->dob) ? date('m/d/Y', strtotime($user->dob)) : '';
			$userdata['image']          = !empty($user->image) ? asset('upload/profile') . "/" . $user->image : '';
			$userdata['class_name']     = isset($user->class_name) ? $user->class_name : '';
			$userdata['school_college'] = isset($user->school_college) ? $user->school_college : '';
			$userdata['state']          = isset($user->state) ? $user->state : '';
			$userdata['city']           = isset($user->city) ? $user->city : '';
			$userdata['postal_code']    = isset($user->postal_code) ? $user->postal_code : '';
			$userdata['earned_point']   = 0;
			$userdata['created_at']     = $user->created_at->diffForHumans();
			$message = "Get User Detail Successfully.";
			return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("user" => $userdata)]);
		} else {
			$message = "User Not Found!";
			return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("user" => "")]);
		}
	}
	public function updateProfile(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("id"=>"")]);
		}
		$userArray = array();
		$validator = Validator::make($request->all(), [
			'userId' => 'required|numeric',
			'name' => 'required|regex:/^[\pL\s\-]+$/u',
			'email' => 'required|string|email',
			'phone' => 'required|min:10|max:10',
			'postal_code' => 'numeric|min:6',
		]);

		if($validator->fails()){
        	$msg = $validator->messages()->first();
			return response()->json(['statusCode' => 400, 'message' => $msg, 'data' => array("id" => "")]);
		}

		$name 		    = ucwords($request->name);
		$email 			= $request->email;
		$phone 			= $request->phone;
		$gender 		= $request->gender;
		$dob 			= $request->dob;
		$class_name 	= $request->class_name;
		$school_college = $request->school_college;
		$state 			= $request->state;
		$city 			= $request->city;
		$postal_code 	= $request->postal_code;
		$checkUser = User::where('id', $userId)->first();
		if (!empty($checkUser)) {
			$imagess = '';
			//print_r($_FILES); exit;
			if (isset($_FILES['image']['name']) && $_FILES['image']['name']!='') {
				$profileimagename = $_FILES['image']['name'];
				$tmpimage1 = $_FILES['image']['tmp_name'];
				$newprofileImage = rand(00000, 99999) . date('d') . $profileimagename;
				$location = "upload/profile/";
				move_uploaded_file($tmpimage1, $location . $newprofileImage);
				$url = 'upload/profile/' . $newprofileImage;
				$img = Image::make($url)->resize(200, 200);
				$imagess =  $img->basename;
			} else {
				$imagess = $checkUser->image;
			}
			$otp = rand(1111, 9999);
			$updateData = User::where('id', $userId)->update([
				'name' 			 => $name,
				//'email' 		 => $email,
				//'phone' 		 => $phone,
				'gender' 		 => $gender,
				'dob' 			 => date('Y-m-d H:i:s', strtotime($dob)),
				'image' 		 => $imagess,
				'class_name' 	 => $class_name,
				'school_college' => $school_college,
				'state' 		 => $state,
				'city' 			 => $city,
				'postal_code' 	 => $postal_code,
				'otp_match' 	 => $otp,
				'updated_at' 	 => date('Y-m-d H:i:s')
			]);
			$userArray = $this->getuserDetail($userId);
			//echo $userArray['email']; die;
			if ($userArray['email']!=$email && $userArray['phone']!=$phone) {
				$changeStatus = 3;
				$newPhone = $phone;
				$newEmail = $email;
			} elseif ($userArray['email']!=$email && $userArray['phone']==$phone) {
				$changeStatus = 2;
				$newPhone = '';
				$newEmail = $email;
			} elseif ($userArray['email']==$email && $userArray['phone']!=$phone) {
				$changeStatus = 1;
				$newPhone = $phone;
				$newEmail = '';
			} else {
				$changeStatus = 0;
				$newPhone = '';
				$newEmail = '';
			}
			$userArray['changeStatus'] = $changeStatus;
			$userArray['newPhone'] = $newPhone;
			$userArray['newEmail'] = $newEmail;
			if ($changeStatus > 0) {
				//send otp
				$msg = 'Verification Otp Send, Please Check.';
				$this->sms($phone, $otp);
				/*$data = array('username' => $userArray['name'], 'OTP' => $otp, 'msg' => $msg);
				Mail::send('emails.otpmail', $data, function ($message) {
					$checkUser = User::where('id', $_POST['userId'])->first();
					$email = $checkUser->email;
					$message->to($email, 'From BrainyWood')->subject('BrainyWood: Verify OTP');
					$message->from('vedicbrainsoulutions@gmail.com', 'BrainyWood');
				});*/
				$this->sendEmail($userArray['email'], 'BrainyWood: Verify OTP', $data = array('userName' => $userArray['name'], 'message' => '<p>Thank you for connecting at BrainyWood,</p><p>You have got successfully your OTP: ' . $otp . '</p>'));

			}
			$message = 'Updated Successfully';
			return response()->json(['statusCode' => 200, 'message' => $message, 'data' => $userArray]);
		} else {
			$msg = "Invalid User Id ";
			return response()->json(['statusCode' => 400, 'message' => $msg, 'data' => array("id" => "")]);
		}
	}
	public function updatePhoneEmail(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("id"=>"")]);
		}
		$userArray = array();
		$validator = Validator::make($request->all(), [
			'userId' => 'required|numeric',
			'otp' => 'required|numeric',
			// 'email' => 'string|email',
			// 'phone' => 'min:10|max:13',
		]);

		if($validator->fails()){
        	$msg = $validator->messages()->first();
			return response()->json(['statusCode' => 400, 'message' => $msg, 'data' => array("id" => "")]);
		}

		$phone 	= $request->phone;
		$email 	= $request->email;
		$otp 	= $request->otp;
		$checkUser = User::where('id', $userId)->where('otp_match', $otp)->first();
		if (!empty($checkUser)) {
			if (!empty($phone)) {
				$checkPhone = User::where('id', '!=', $userId)->where('phone', $phone)->first();
				if (empty($checkPhone)) {
					$updateData = User::where('id', $userId)->update([
						'phone' 		 => $phone,
						'updated_at' 	 => date('Y-m-d H:i:s')
					]);
				}
			}
			if (!empty($email)) {
				$checkEmail = User::where('id', '!=', $userId)->where('email', $email)->first();
				if (empty($checkEmail)) {
					$updateData = User::where('id', $userId)->update([
						'email' 		 => $email,
						'updated_at' 	 => date('Y-m-d H:i:s')
					]);
				}
			}
			$userArray = $this->getuserDetail($userId);
			$message = 'Updated Successfully';
			return response()->json(['statusCode' => 200, 'message' => $message, 'data' => $userArray]);
		} else {
			$msg = "User Id or OTP not matched!";
			return response()->json(['statusCode' => 400, 'message' => $msg, 'data' => array("id" => "")]);
		}
	}
	public function phoneEmailResendOtp(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("otp"=>"")]);
		}
		$phone   = $request->phone;
		$email   = $request->email;
		if (!empty($userId)) {
			$checkUser = User::where('id', $userId)->first();
			if ($checkUser) {
				$otpnumber = rand(1111, 9999);
				if($phone==''){
					$phone = $checkUser->phone;
				}
				$update = DB::table('users')->where('id', $userId)->update(['otp_match' => $otpnumber]);
				if ($update) {
					$returndata['otp'] = $otpnumber;
					$msg = 'Verification Otp Send, Please Check.';
					$this->sms($phone, $otpnumber);
					/*$data = array('username' => $checkUser->name, 'OTP' => $otpnumber, 'msg' => $msg);
					Mail::send('emails.otpmail', $data, function ($message) {
						if (isset($_POST['email']) && $_POST['email']!=''){
							$email = $_POST['email'];
						} else {
							$checkUser = User::where('id', $_POST['userId'])->first();
							$email = $checkUser->email;
						}
						$message->to($email, 'From BrainyWood')->subject('BrainyWood: Verify OTP');
						$message->from('vedicbrainsoulutions@gmail.com', 'BrainyWood');
					});*/
					$this->sendEmail($checkUser->email, 'BrainyWood: Verify OTP', $data = array('userName' => $checkUser->name, 'message' => '<p>Thank you for connecting at BrainyWood,</p><p>You have got successfully your OTP: ' . $otpnumber . '</p>'));
					
					return response()->json(['statusCode' => 200, 'message' => $msg, "data" => $returndata]);
				} else {
					return response()->json(['statusCode' => 400, 'message' => 'Somthing Went Wrong!', 'data' => array("otp" => "")]);
				}
			} else {
				return response()->json(['statusCode' => 400, 'message' => 'Invaild User Id!', 'data' => array("otp" => "")]);
			}
		} else {
			return response()->json(['statusCode' => 400, 'message' => 'Wrong Paramenter Passed!', 'data' => array("otp" => "")]);
		}
	}

	public function changePassword(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("id"=>"")]);
		}
		$validator = Validator::make($request->all(), [
			'userId' => 'required|numeric',
			'current_password' => 'required',
			'password' => 'required|min:6',
			'confirm_password' => 'required|min:6|max:20|same:password',
		]);

		if($validator->fails()){
        	$msg = $validator->messages()->first();
			//return $this->sendError($validator->messages()->first());
			return response()->json(['statusCode' => 400, 'message' => $msg, 'data' => array("id" => "")]);
		}

		$currentPassword = $request->current_password;
		$newPassword = $request->password;
		$confirmPassword = $request->confirm_password;
		$user = User::where("id", $userId)->first();
		if (Hash::check($currentPassword, $user->password)) {
			if ($newPassword != $confirmPassword) {
				$msg = 'Password and Confirm password not matched!';
				return response()->json(['statusCode' => 400, 'message' => $msg, 'data' => array("id" => "")]);
			}
			$users = User::findOrFail($userId);
			$users->password = bcrypt($newPassword);
			$users->userpass = $newPassword;
			$users->save();

			$msg = 'Password updated successfully.';
			return response()->json(['statusCode' => 200, 'message' => $msg, 'data' => array("id" => $userId)]);
		} else {
			$msg = 'Current Password not matched!';
			return response()->json(['statusCode' => 400, 'message' => $msg, 'data' => array("id" => "")]);
		}
	}

	public function getSubscriptions(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("subscriptions" => [])]);
		}
		//$subscriptions  = Subscription::where("status", 1)->where("deleted", 0)->get();
		$subscriptions  = Subscription::where("deleted", 0)->get();
		$subscriptiondata = array();
		if (!empty($subscriptions)) {
			foreach ($subscriptions as $key => $value) {
				if ($value['status']==1) {
					$sub_plan['id']    = $value['id'];
					$sub_plan['name']  = $value['name'];
					$sub_plan['month'] = $value['month'];
					$sub_plan['price'] = $value['price'];
					$sub_plan['image'] = isset($value['image']) ? asset('upload/subscriptions') . "/" . $value['image'] : 'NA';
					$sub_plan['video'] = isset($value['video']) ? asset('upload/subscriptions') . "/" . $value['video'] : 'NA';
					$sub_plan['description'] = $value['description'];
					$faqs_arr = array();
					$faqs = json_decode($value['faqs'], true);
					if (!empty($faqs)) {
						foreach ($faqs as $val) {
							$faq['question'] = $val['question'];
							$faq['answer'] = $val['answer'];
							array_push($faqs_arr, $faq);
						}
					}
					$sub_plan['faqs']	= $faqs_arr;
					$subscription = UserSubscription::where("user_id", $userId)->where("subscription_id", $value['id'])->orderBy('id', 'DESC')->first();
					$sub_plan['start_date'] = !empty($subscription->start_date) ? $subscription->start_date : '';
					$sub_plan['end_date'] = !empty($subscription->end_date) ? $subscription->end_date : '';
					$sub_plan['status'] = !empty($subscription) ? 1 : 0;
					array_push($subscriptiondata, $sub_plan);
				} else {
					$subscription = UserSubscription::where("user_id", $userId)->where("subscription_id", $value['id'])->orderBy('id', 'DESC')->first();
					if (!empty($subscription)) {
						$inactive_sub_plan['id']    = $value['id'];
						$inactive_sub_plan['name']  = $value['name'];
						$inactive_sub_plan['month'] = $value['month'];
						$inactive_sub_plan['price'] = $value['price'];
						$inactive_sub_plan['image'] = isset($value['image']) ? asset('upload/subscriptions') . "/" . $value['image'] : 'NA';
						$inactive_sub_plan['video'] = isset($value['video']) ? asset('upload/subscriptions') . "/" . $value['video'] : 'NA';
						$inactive_sub_plan['description'] = $value['description'];
						$faqs_arr = array();
						$faqs = json_decode($value['faqs'], true);
						if (!empty($faqs)) {
							foreach ($faqs as $val) {
								$faq['question'] = $val['question'];
								$faq['answer'] = $val['answer'];
								array_push($faqs_arr, $faq);
							}
						}
						$inactive_sub_plan['faqs']	= $faqs_arr;
						$subscription = UserSubscription::where("user_id", $userId)->where("subscription_id", $value['id'])->orderBy('id', 'DESC')->first();
						$inactive_sub_plan['start_date'] = !empty($subscription->start_date) ? $subscription->start_date : '';
						$inactive_sub_plan['end_date'] = !empty($subscription->end_date) ? $subscription->end_date : '';
						$inactive_sub_plan['status'] = !empty($subscription) ? 1 : 0;
						array_push($subscriptiondata, $inactive_sub_plan);
					}
				}
			}
			$message = "Get Subscription List.";
			return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("subscriptions" => $subscriptiondata)]);
		} else {
			$message = "Subscription not Found.";
			return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("subscriptions" => "")]);
		}
	}

	public function applyCoupon(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("subscriptionId" => "", "orderId" => "", "paymentGateway" => "", "couponCode" => "")]);
		}
		$subscriptionId = $request->subscriptionId;
		$couponCode		= $request->couponCode;
		$discount = $discountAmt = $payableAmt = $coupon_no_of_users = $coupon_user_id = $coupon_subscription_id = 0;
		if (!empty($userId) && !empty($subscriptionId) && !empty($couponCode)) {
			$today	  = date('Y-m-d');
			$subscription = UserSubscription::where("user_id", $userId)->where("end_date", ">=", $today)->orderBy('id', 'DESC')->first();
			$userSubscription = !empty($subscription) ? 1 : 0;
			if ($userSubscription==1) {
				$message = "You have already subscribed a plan, after expired you can take new subscription!";
				return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("subscriptionId" => $subscriptionId, "orderId" => "", "paymentGateway" => "", "couponCode" => $couponCode)]);
			}
			//$getCoupon = CouponCode::where("user_id", $userId)->where("coupon", $couponCode)->where("status", 1)->where("deleted", 0)->first();
			$getCoupon = CouponCode::where("coupon", $couponCode)->where("end_date", ">=", $today)->where("status", 1)->where("deleted", 0)->first();
			if (!empty($getCoupon) && $getCoupon->discount > 0) {
				$discount = $getCoupon->discount;
			} else {
				$message = "This Coupon Code not found!";
				return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("subscriptionId" => $subscriptionId, "orderId" => "", "paymentGateway" => "", "couponCode" => $couponCode)]);
			}
			$checkSubscription = UserSubscription::where("user_id", $userId)->where("coupon_code", $couponCode)->first();
			if (!empty($checkSubscription)) {
				$message = "This Coupon Code already in used!";
				return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("subscriptionId" => $subscriptionId, "orderId" => "", "paymentGateway" => "", "couponCode" => $couponCode)]);
			} else {
				if ($getCoupon->condition_1 == 1){
					if ($getCoupon->user_id > 0){
						$coupon_user_id = $getCoupon->user_id;
						if ($userId != $coupon_user_id) {
							$message = "This Coupon Code not made for you!";
							return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("subscriptionId" => $subscriptionId, "orderId" => "", "paymentGateway" => "", "couponCode" => $couponCode)]);
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
						$message = "This Coupon Code not made for this subscription plan!";
						return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("subscriptionId" => $subscriptionId, "orderId" => "", "paymentGateway" => "", "couponCode" => $couponCode)]);
					}
				}
				if ($coupon_no_of_users > 0) {
					$totalUsedCouponCode = UserSubscription::where("coupon_code", $couponCode)->count();
					if ($totalUsedCouponCode >= $coupon_no_of_users) {
						$message = "This Coupon Code is expired!";
						return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("subscriptionId" => $subscriptionId, "orderId" => "", "paymentGateway" => "", "couponCode" => $couponCode)]);
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
					$genString = $this->generateRandomString(35);
					$key_id = 'rzp_live_DH2couh1DAwAFY';
					$secret = 'qIB1iMh3EIR6VyzycKhAzNzh';
					$api = new Api($key_id, $secret);

					$order  = $api->order->create([
					  'receipt' => 'order_rcptid_11',
					  'amount'  => $payableAmt * 100,
					  'currency' => 'INR'
					]);
					//echo '<pre />'; print_r($order); die;
					$orderId = $order['id'];
					$payment_gateway = 1;
					$message = "Order Id Created Successfully.";
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
					$message = "Subscription Plan Activated Successfully.";
				}
				return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("subscriptionId" => $subscriptionId, "orderId" => $orderId, "paymentGateway" => $payment_gateway, "couponCode" => $couponCode)]);
			} else {
				$message = "Subscription not found!";
				return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("subscriptionId" => $subscriptionId, "orderId" => "", "paymentGateway" => "", "couponCode" => $couponCode)]);
			}
		} else {
			$message = "Wrong Paramenter Passed!";
			return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("subscriptionId" => "", "orderId" => "", "paymentGateway" => "", "couponCode" => $couponCode)]);
		}
	}

	public function getRazorpayOrderid(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("subscriptionId" => "", "orderId" => "")]);
		}
		$subscriptionId = $request->subscriptionId;
		if (!empty($userId) && !empty($subscriptionId)) {
			$today	  = date('Y-m-d');
			$subscription = UserSubscription::where("user_id", $userId)->where("end_date", ">=", $today)->orderBy('id', 'DESC')->first();
			$userSubscription = !empty($subscription) ? 1 : 0;
			if ($userSubscription==1) {
				$message = "You have already subscribed a plan, after expired you can take new subscription!";
				return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("subscriptionId" => $subscriptionId, "orderId" => "")]);
			}
			$getSubscription = Subscription::where("id", $subscriptionId)->where("status", 1)->where("deleted", 0)->first();
			if (!empty($getSubscription) && $getSubscription->price > 1) {
				$amount = $getSubscription->price;
				$genString = $this->generateRandomString(35);
				$key_id = 'rzp_live_DH2couh1DAwAFY';
				$secret = 'qIB1iMh3EIR6VyzycKhAzNzh';
				$api = new Api($key_id, $secret);

				$order  = $api->order->create([
				  'receipt' => 'order_rcptid_11',
				  'amount'  => $amount * 100,
				  'currency' => 'INR'
				]);
				//echo '<pre />'; print_r($order); die;
				$orderId = $order['id'];
				$message = "Order Id Created Successfully.";
				return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("subscriptionId" => $subscriptionId, "orderId" => $orderId)]);
			} else {
				$message = "Subscription not found!";
				return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("subscriptionId" => $subscriptionId, "orderId" => "")]);
			}
		} else {
			$message = "Wrong Paramenter Passed!";
			return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("subscriptionId" => "", "orderId" => "")]);
		}
	}

	public function takeSubscription(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("id" => "","payment_status" => "","txn_id" => "")]);
		}
		$subscriptionId = $request->subscriptionId;
		$orderId 		= $request->orderId;
		$couponCode		= !empty($request->couponCode) ? $request->couponCode : '';
		if (!empty($userId) && !empty($subscriptionId) && !empty($orderId)) {
			$key_id = 'rzp_live_DH2couh1DAwAFY';
			$secret = 'qIB1iMh3EIR6VyzycKhAzNzh';
			$api = new Api($key_id, $secret);

			$payments = $api->order->fetch($orderId)->payments(); // Returns array of payment objects against an order
			//echo '<pre />'; print_r($payments); die;
			$txn_id = '';
			if (!empty($payments)) {
				$paymentStatus = isset($payments['items'][0]['status']) ? $payments['items'][0]['status'] : 'failed';
				if ($paymentStatus!='failed') {
					$txn_id = isset($payments['items'][0]['id']) ? $payments['items'][0]['id'] : '';
					if ($txn_id != '') {
						$paymentMode = 'Online';
						if(!empty($couponCode)){
							$paymentMode = 'Coupon & Online';
						}

						$getSubscription = Subscription::where("id", $subscriptionId)->where("status", 1)->where("deleted", 0)->first();
						$month = !empty($getSubscription->month) ? $getSubscription->month : 0;
						$today = date('Y-m-d');
						$end_date = date('Y-m-d', strtotime('+'.$month.' months'));
						$data1 = array(
							'user_id'			=> $userId,
							'subscription_id'	=> $subscriptionId,
							'start_date'		=> $today,
							'end_date'			=> $end_date,
							'txn_id'			=> $txn_id,
							'coupon_code'		=> $couponCode,
							'mode'				=> $paymentMode,
							'created_at'		=> date('Y-m-d H:i:s'),
						);
						$inserId = UserSubscription::insertGetId($data1);
						$user = User::where("id", $userId)->first();
						$msg = 'Subscription payment initiated';
						$this->addNotification($userId,$msg);
						$this->smsWithTemplate($user->phone, 'Mambership', $user->name, $getSubscription->name);
						/*$data = array('username' => $user->name, 'payment_id' =>  $txn_id, 'msg' =>  $msg);
						Mail::send('emails.payment', $data, function ($message) {
							$user = User::where("id", $_POST['userId'])->first();
							$email = $user->email;
							$message->to($email, 'From BrainyWood')->subject('BrainyWood: Subscription payment initiated');
							$message->from('vedicbrainsoulutions@gmail.com', 'BrainyWood');
						});*/
						$this->sendEmail($user->email, 'BrainyWood: Subscription payment initiated', $data = array('userName' => $user->name, 'message' => '<p>Thank you for payment initiated at BrainyWood,</p><p>You have subscribed a plan successfully with Payment id: ' . $txn_id . '</p>'));
						
						$message = "Your Subscription Added Successfully.";
						return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("id" => $inserId,"payment_status" => "success","txn_id" => $txn_id)]);
					} else {
						$message = "Payment not initiated!";
						return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("id" => "","payment_status" => "failed","txn_id" => "")]);
					}
				} else {
					$message = "Payment failed!";
					return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("id" => "","payment_status" => "failed","txn_id" => "")]);
				}
			} else {
				$message = "Payment not initiated!";
				return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("id" => "","payment_status" => "failed","txn_id" => "")]);
			}
		} else {
			$message = "Wrong Paramenter Passed!";
			return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("id" => "","payment_status" => "","txn_id" => "")]);
		}
	}

	public function contactUs(Request $request)
	{
		//echo '<pre />'; print_r($request->all()); die;
		$userId  = $request->userId;
		$message = $request->message;
		if (!empty($userId) && !empty($message)) {
			$data = array(
				'user_id'  		=> $userId,
				'message'  		=> $message,
				'created_at'    => date('Y-m-d H:i:s'),
			);
			$inserId = Contactus::insertGetId($data);
			$message = "Your Message Added Successfully.";
			return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("contactId" => $inserId)]);
		} else {
			$message = "Wrong Paramenter Passed!";
			return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("contactId" => "")]);
		}
	}

	public function getNotifications(Request $request)
	{
		$bearerToken = $request->bearerToken();
		$userId   = $request->userId;
		$userStatus = $this->isUserActive($userId,$bearerToken);
		if ($userStatus == 0) {
			$message = "User not Available.";
			return response()->json(['statusCode' => 203, 'message' => $message, 'data' => array("notifications" => [])]);
		}
		$notifications = Notification::where("user_id",$userId)->orderBy("id","DESC")->get();
		$notificationdata = array();
		if (!empty($notifications)) {
			foreach ($notifications as $key => $value) {
				$notificationdata[$key]['id']    = $value['id'];
				$notificationdata[$key]['message'] = $value['message'];
				$notificationdata[$key]['created_at'] = $value['created_at']->diffForHumans();
			}
			$message = "Get Notification List.";
			return response()->json(['statusCode' => 200, 'message' => $message, 'data' => array("notifications" => $notificationdata)]);
		} else {
			$message = "Notification not Found.";
			return response()->json(['statusCode' => 400, 'message' => $message, 'data' => array("notifications" => "")]);
		}
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
	public function notificationstatus(Request $request)
	{
		$userId = $request->header("userId");
		$noti = Notification::where('user_id', $userId)->where('status', 0)->update(['status' => 1]);
		$msg = "notification seen successfully";
		return response()->json(['statusCode' => 200, 'message' => $msg]);
	}

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

	public function testemail(Request $request)
	{
		$otp = 1234;
		/*$msg = 'Email Send Successfully.';
		$data = array('username' => "User", 'remember_token' =>  $otp, 'msg' =>  $msg);
		Mail::send('emails.forgot_password', $data, function ($message) {
			$email = $_POST['email'];
			$message->to($email, 'From BrainyWood')->subject('This is your testing mail');
			$message->from('vedicbrainsoulutions@gmail.com', 'BrainyWood');
		});*/
		//$this->sendEmail('rajendrakataria43@gmail.com', 'BrainyWood: Testing', $data = array('userName' => 'Rajendra', 'message' => '<p>Thank you for connected at BrainyWood,</p>'));

		$phone = '919588841525';
		$msg = 'SMS Send Successfully.';
		$this->sms($phone, $otp, $msg);
		return response()->json(['statusCode' => 200, 'message' => $msg, 'data' => ""]);
	}














	
	
	/*public function sms($phone, $otp)
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://2factor.in/API/V1/42e8defc-0910-11ea-9fa5-0200cd936042/SMS/' . $phone . '/' . $otp . '/Template',
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
		curl_close($curl);
	}*/
	public function bulksms($message, $phone,$template='insecuresmsAT')
	{
		$To               = $phone;
		$VAR1             = $message;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://2factor.in/API/V1/42e8defc-0910-11ea-9fa5-0200cd936042/ADDON_SERVICES/SEND/TSMS");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "From=SECURE&To=$To&TemplateName=$template&VAR1=$VAR1");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$server_output = curl_exec($ch);
		curl_close($ch);
	}
	public function sendtemplatesms($phone,$template='insecuresmsAT',$var1,$var2,$var3)
	{
		$senderId="SECURE";
		if($template=="medicalsmsAT"  || $template=="medicalsmsUT" )
		{
			$senderId="MEDICL";
		}
		if($template=="insecuresmsAT"  || $template=="insecuresmsUT" )
		{
			$senderId="SECURE";
		}
		
		//	$var3=strval($var3);
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, "http://2factor.in/API/V1/42e8defc-0910-11ea-9fa5-0200cd936042/ADDON_SERVICES/SEND/TSMS");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "From=$senderId&To=$phone&TemplateName=$template&VAR1=$var1&VAR2=$var2&VAR3= $var3");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$server_output = curl_exec($ch);
		//print_r($server_output); exit;
		curl_close($ch);
	}
	public function gpslocation(Request $request)
	{
		$id=$request->id;
		$users = DB::table('shorturl')->where("id",$id)->first();
		echo "<script> window.location.href='".$users->fullurl."'; </script>";
	}




}
