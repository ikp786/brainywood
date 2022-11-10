@inject('request', 'Illuminate\Http\Request')
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<title>@yield('meta_title') - Brainywood</title>
	<meta name="descriptison" content="@yield('meta_description')">
	<meta name="keywords" content="">

	<!-- Favicons -->
	<link href="{{asset('front/assets/img/favicon.png')}}" rel="icon">
	<link href="{{asset('front/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

	<!-- Google Fonts -->
	<link href="{{asset('front/assets/css/google_fonts.css')}}" rel="stylesheet">
	<link href="{{asset('front/assets/css/font-awesome.min.css')}}">

	<!-- Vendor CSS Files -->
	<link href="{{asset('front/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{asset('front/assets/vendor/icofont/icofont.min.css')}}" rel="stylesheet">
	<link href="{{asset('front/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
	<!-- <link href="{{asset('front/assets/vendor/venobox/venobox.css')}}" rel="stylesheet"> -->
	<link href="{{asset('front/assets/vendor/owl.carousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
	<link href="{{asset('front/assets/vendor/aos/aos.css')}}" rel="stylesheet">

	<!-- Template Main CSS File -->
	<link href="{{asset('front/assets/css/style.css')}}" rel="stylesheet">

	<!-- Font Awesome CSS -->
	<link rel="stylesheet" href="{{asset('front/assets/css/font-awesome4.5.0.min.css')}}">
	<!-- SweetAlert2 -->
	<link rel="stylesheet" href="{{asset('front/assets/css/sweetalert2.min.css')}}">

	@yield('head')

	@if($request->server->get('SERVER_NAME')=='brainywoodindia.com')
	<!-- Global site tag (gtag.js) - Google Ads: 339858082 -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=AW-339858082"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'AW-339858082');
	</script>

	<script>
		window.addEventListener('load',function(){
			jQuery('[href*="tel:"]').click(function(){
				gtag('event', 'conversion', {'send_to': 'AW-339858082/SSuKCMmG7dECEKKlh6IB'});
			});
			var set_int=setInterval(function(){
				if(jQuery(".swal2-animate-success-icon").is(':visible')){
					gtag('event', 'conversion', {'send_to': 'AW-339858082/dRWDCO_X7dECEKKlh6IB'});
					clearInterval(set_int);
				}
			},1000);
		})
	</script>
	@endif
	<style type="text/css">
		body {
			overflow-x: hidden; /* Hide scrollbars */
		}
		a.log_ou {
		    background: transparent !important;
		    color: black !important;
		}
		.field-icon {
		  float: right;
		  margin-left: -25px;
		  margin-top: -25px;
		  position: relative;
		  z-index: 2;
		}
		.login-form.login-signin.conti .input-group-addon {
		    position: absolute;
		    right: 15px;
		    top: 5px;
		}
		#otpModal {
		    opacity: 1;
		    /*z-index: 999999;*/
		}
		.modal-backdrop {
			overflow: hidden;
			position: relative!important;
		}
		.modal-backdrop.fade.show {
		    height: 0;
		}

		#password {
		    width: 100%;
		}
		.figure {
		    display: inline-block;
		}
		div#strength_human {
		    color: #ff7a17;
		}

		.disabled {
			pointer-events: none;
			cursor: default;
			opacity: 0.6;
		}

		#WAButton {
			bottom: 75px;
			z-index: 9999;
		}
	</style>
</head>

<body>

<!-- ======= Header ======= -->
<header id="header" class="fixed-top">
	<div class="container d-flex">
		<div class="logo mr-auto">
			<h1 class="text-light"><a href="@if(!empty(auth()->user()) && auth()->user()->role_id==3)javascript:; @else{{route('home')}}@endif"><img src="{{asset('front/assets/img/web-logo.png')}}" alt="BrainyWood"></a></h1>
		</div>
		<nav class="nav-menu d-none d-lg-block">
			<div class="topnav">
				<form name="srchfrm" action="{{route('ourCourses')}}" method="GET">
					<input type="text" name="search" placeholder="Search..">
				</form>
			</div>
			<ul>
				@if(!empty(auth()->user()) && auth()->user()->role_id==3)
				@else
				<li class="active"><a href="{{route('home')}}">Home</a></li>
				<li class="dropdown">
					<a class="dropbtn" href="{{route('aboutUs')}}">About Us</a>
					<div class="dropdown-content">
						<a href="{{route('ourTeam')}}">Our Team</a>
						<a href="#">Franchise Enquiry</a>
					</div>
				</li>
				@endif
				<li><a href="{{route('ourCourses')}}">Courses</a></li>
				<li><a href="{{route('pricing')}}">Pricing</a></li>
				<!-- <li><a href="https://brainywood.in/blog/">Blog</a></li> -->
				@if(!empty(auth()->user()) && auth()->user()->role_id==3)
				<li><a href="{{route('liveClasses')}}">Live classes</a></li>
				<li><a href="{{route('questionAnswer')}}">Q&A</a></li>
				<!-- <li class="get-started"><a href="{{route('myProfile')}}"><img src="{{asset('front/assets/img/user.svg')}}"> Profile</a></li> -->
				<li class="dropdown get-started">
					<a style="color: white !important;" class="dropbtn" href="{{route('myAccount')}}"> <img src="{{asset('front/assets/img/user.svg')}}"> @if(!empty(auth()->user()) && auth()->user()->role_id==3) @php $username = explode(" ", auth()->user()->name); @endphp {{$username[0]}} @else{{'Profile'}}@endif</a>
					<!-- <div class="dropdown-content">
						<a href="#logout" class="log_ou" onclick="$('#logout').submit();">logout</a>
					</div> -->
				</li>
				<li><a href="#logout" class="log_out" onclick="$('#logout').submit();" title="Logout"><i class="fa fa-sign-out" aria-hidden="true" style="transform: rotate(270deg);"></i></a></li>
				@else
				<li><a href="#myModalone" data-toggle="modal">Register</a></li>
				<li  class="get-started"><a style="color: white !important;" href="#myModal" data-toggle="modal"><img src="{{asset('front/assets/img/user.svg')}}"> Login</a></li>
				@endif
			</ul>
		</nav>
		<!-- .nav-menu -->
	</div>
</header><!-- End Header -->

@yield('hero_section')

<div style="width: 100%;margin: 0 auto;" class="row">
	<div class="col-md-12">
		<!-- @if (Session::has('success'))
			<div class="alert alert-success">
				<p>{{ Session::get('success') }}</p>
			</div>
		@endif
		@if (Session::has('error'))
			<div class="alert alert-danger">
				<p>{{ Session::get('error') }}</p>
			</div>
		@endif
		@if ($errors->count() > 0)
			<div class="alert alert-danger">
				<ul class="list-unstyled">
					@foreach($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif -->
	</div>
</div>

@yield('content')

<!-- ======= Footer ======= -->
<footer id="footer">
	<div class="footer-top">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 footer-contact" data-aos="fade-up" data-aos-delay="100">
				<a href="{{route('home')}}"><img src="{{asset('front/assets/img/web-logo.png')}}" alt=""></a>
					<p>General knowledge is something that helps us to grow both on a personal as well as academic level. </p>
				</div>
				<div class="col-lg-1"></div>
				<div class="col-lg-2 col-md-4 footer-links" data-aos="fade-up" data-aos-delay="200">
					<ul>
						<li><a href="{{route('aboutUs')}}">About us</a></li>
						<li><a href="{{route('ourCourses')}}">Courses</a></li>
						<li><a href="{{route('pricing')}}">Pricing</a></li>
						<li><a href="{{route('services')}}">Services</a></li>
						<!-- <li><a href="{{route('ourTeam')}}">Team</a></li> -->
					</ul>
				</div>
				<div class="col-lg-3 col-md-4 footer-links" data-aos="fade-up" data-aos-delay="300">
					<ul>
						<li><a href="{{route('contactUs')}}">Contact us</a></li>
						@php $pages = \App\Page::where("status", 1)->where("deleted", 0)->get(); @endphp
						@if($pages)
						@foreach($pages as $page)
						<li><a href="{{route('staticPage', $page->slug_url)}}">{{$page->title}}</a></li>
						@endforeach
						@endif
						<!-- <li><a href="#">Terms of use</a></li>
						<li><a href="#">Privacy policy</a></li>
						<li><a href="#">Refund policy</a></li> -->
					</ul>
				</div>
				<div class="col-lg-3 col-md-4 footer-links" data-aos="fade-up" data-aos-delay="300">
					<h4 class="mob-center">Connect with us</h4>
					<div class="social-links">
						<a href="https://www.facebook.com/Brainywoodofficial" class="facebook" target="_blank"><i class="bx bxl-facebook"></i></a>
						<a href="https://twitter.com/_brainywood" class="twitter" target="_blank"><i class="bx bxl-twitter"></i></a>
						<a href="https://www.instagram.com/brainywoodofficial/" class="instagram" target="_blank"><i class="bx bxl-instagram"></i></a>
						<a href="https://www.linkedin.com/company/brainywoodofficial" class="linkedin" target="_blank"><i class="bx bxl-linkedin"></i></a>
					</div>
					<p> <b>Phone:-</b> <a href="tel:+919950368500"> +919950368500 </a></p>
					<p><b> Email:- </b> <a href="mailto: Vedicbrainsolutions@gmail.com"> Vedicbrainsolutions@gmail.com </a> </p>
					<p><b>Address:- </b> Near 9 No. Petrol Pump, Nasirabad Road, Gopalganj, Nagra, Ajmer (305001) </p>
				</div>
			</div>
		</div>
	</div>
	<div class="copyright">A Venture of Vedic Brain Solutions Pvt Ltd</div>
</footer>
<!-- End Footer -->

<div class="container">
	<div class="modal fade p-0" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog skills m-0">
			<div class="modal-content">
				<div class="modal-body" style="padding: 0px;">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<div class="row">
						<div class="col-md-4" style="padding: 0px;">
							<div class="teachers">
								<img src="{{asset('front/assets/img/web-logo.png')}}" alt="Apelo Panel">
								<ul class="tuitions">
								<li><a href="javascript:;"><img src="{{asset('front/assets/img/checked.svg')}}"> Stress-free Education</a></li>
								<li><a href="javascript:;"><img src="{{asset('front/assets/img/checked.svg')}}"> New Courses added every month</a></li>
								<li><a href="javascript:;"><img src="{{asset('front/assets/img/checked.svg')}}"> Get access to Live classes</a></li>
								<li><a href="javascript:;"><img src="{{asset('front/assets/img/checked.svg')}}"> Unlock all features of the platform.</a></li>
								</ul>
							</div>
						</div>
						<div class="col-md-8">
							<div class="students">
								<div class="login-form login-signin">
									<form action="{{route('frontlogin')}}" method="post" class="form fv-plugins-bootstrap fv-plugins-framework">
										<input type="hidden" name="_token" value="{{ csrf_token() }}" />
										<div class="pb-13 pt-lg-0 pt-5">
											<h3>Login to continue</h3>
										</div>
										<div class="form-group fv-plugins-icon-container">
											<input type="text" name="email" id="email" class="form-control" placeholder="Mobile or E-mail" required>
											<div class="fv-plugins-message-container"></div>
										</div>
										<div class="form-group fv-plugins-icon-container">
											<input type="password" id="password-field" name="password" class="form-control" placeholder="Password" required>
											<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
											<label class="mt-3"><input type="checkbox" name="terms"> Keep me signed in</label>
											<!-- <a href="#forgotModal" data-toggle="modal" class="pt-3" style="color: #FF7A17 !important; float: right;" id="kt_login_forgot">Forgot Password ?</a> -->
											<a href="#forgotPassword" class="pt-3 forgotPassword" style="color: #FF7A17 !important; float: right;">Forgot Password ?</a>
										</div>
										<div class="pb-lg-0 pb-5">
											<button type="submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-2 my-3 mr-3 w-100">Login</button>
										</div>
										<p>Don't have account? <a href="#myModalone" data-toggle="modal"> Register </a></p>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@php
	$cities = \DB::table('cities')->orderBy('city', 'ASC')->get();
	$studentClasses = \App\StudentClass::where('status',1)->where('deleted',0)->orderBy('id', 'ASC')->get();
@endphp
<div class="container">
	<div class="modal fade p-0" id="myModalone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog skills m-0">
			<div class="modal-content">
				<div class="modal-body" style="padding: 0px;">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<div class="row">
						<div class="col-md-4" style="padding: 0px;">
							<div class="teachers">
								<img src="{{asset('front/assets/img/web-logo.png')}}" alt="Apelo Panel">
								<ul class="tuitions">
								<li><a href="javascript:;"><img src="{{asset('front/assets/img/checked.svg')}}"> Stress-free Education</a></li>
								<li><a href="javascript:;"><img src="{{asset('front/assets/img/checked.svg')}}"> New Courses added every month</a></li>
								<li><a href="javascript:;"><img src="{{asset('front/assets/img/checked.svg')}}"> Get access to Live classes</a></li>
								<li><a href="javascript:;"><img src="{{asset('front/assets/img/checked.svg')}}"> Unlock all features of the platform.</a></li>
								</ul>
							</div>
						</div>
						<div class="col-md-8">
							<div class="students">
								<div class="login-form login-signin conti">
									<form action="{{route('frontregister')}}" method="post" class="form fv-plugins-bootstrap fv-plugins-framework">
										<input type="hidden" name="_token" value="{{ csrf_token() }}" />
										<div class="pb-13 pt-lg-0 pt-5">
											<h3>Signup to continue</h3>
										</div>
										<div class="form-group fv-plugins-icon-container">
											<input type="text" name="name" class="form-control" placeholder="Full Name" required="required" value="{{old('name')}}">
											<div class="fv-plugins-message-container"></div>
										</div>
										<div class="form-group fv-plugins-icon-container">
											<!-- <input type="text" name="city" class="form-control" placeholder="City" value="{{old('city')}}" required> -->
											<select name="city" class="form-control selectpicker" id="sel1" data-live-search="true" required>
												<option value="">--select city--</option>
												@if($cities)
												@foreach($cities as $city)
												<option value="{{$city->city}}">{{$city->city}}</option>
												@endforeach
												@endif
											</select>
											<div class="fv-plugins-message-container"></div>
										</div>
										<div class="form-group fv-plugins-icon-container">
											<select name="class_name" class="form-control" id="sel1" required>
												<option value="">--select class--</option>
												@if($studentClasses)
												@foreach($studentClasses as $stclass)
												<option value="{{$stclass->class_name}}">{{$stclass->class_name}}</option>
												@endforeach
												@endif
											</select>
											<div class="fv-plugins-message-container"></div>
										</div>
										<div class="form-group fv-plugins-icon-container">
											<input type="email" name="email" class="form-control" placeholder="Email" value="{{old('email')}}" required>
											<div class="fv-plugins-message-container"></div>
										</div>
										<div class="form-group fv-plugins-icon-container">
											<input type="tel" name="phone" class="form-control" placeholder="Mobile Number" maxlength="10" value="{{old('phone')}}" required>
											<div class="fv-plugins-message-container"></div>
										</div>
										<div class="form-group fv-plugins-icon-container">
											<label>Gender</label>
											<label><input type="radio" name="gender" value="Male" checked> Male </label>
											<label><input type="radio" name="gender" value="Female"> Female </label>
											<label><input type="radio" name="gender" value="Non Binary"> Non Binary </label>
											<div class="fv-plugins-message-container"></div>
										</div>
										<div class="form-group fv-plugins-icon-container">
											<div class="input-group" id="show_hide_password">
												<input type="password" name="password" id="password" class="form-control" style="z-index: inherit;" placeholder="Password" value="{{old('password')}}" required>
												<div class="input-group-addon">
													<a href="javascript:;"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                    							</div>
												<div class="fv-plugins-message-container"></div>
												
											</div>
											<div class="str mt-2">
												    Password Strength:
												    <div class="figure" id="strength_human">Weak</div>    
												    <!-- (<div class="figure" id="strength_score"></div>) -->
												</div>
										</div>
										<div class="form-group fv-plugins-icon-container">
											<div class="input-group" id="show_hide_passwords">
												<input type="password" style="z-index: inherit;"  name="confirm_password" class="form-control" placeholder="Confirm Password" value="{{old('confirm_password')}}" required>
												<div class="input-group-addon">
	                        						<a href="javascript:;"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
	                    						</div>
												<div class="fv-plugins-message-container"></div>
											</div>
										</div>
										<div class="pb-lg-0 pb-5">
											<button type="submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-2 my-3 mr-3 w-100">Register</button>
										</div>
										<p>Already have account? <a href="#myModal" id="loginId" data-toggle="modal"> Log In </a></p>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="forgotModal" role="dialog">
	<div class="modal-dialog img_sec">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Forgot Password</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label=""><span>×</span></button>
			</div>          
			<form action="{{route('forgotPassword')}}" method="post" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" />
				<div class="modal-body">                       
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" name="email" class="form-control">
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-default">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>

@php if($request->session()->has('phone')){ $sessionPhone = $request->session()->get('phone'); }else{ $sessionPhone = ''; } @endphp
<!-- <div class="modal" id="otpModal" role="dialog">
	<div class="modal-dialog img_sec">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Verify Your Account</h4>
				<button type="button" class="close close_verification" data-dismiss="modal" aria-label=""><span>×</span></button>
			</div>
			<form action="{{route('verifyAccountByOtp')}}" method="post" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" />
				<input type="hidden" name="phone" value="{{$sessionPhone}}" />
				<div class="modal-body">                       
					<div class="form-group">
						<label for="otp">OTP</label>
						<input type="text" name="otp" class="form-control" maxlength="4">
					</div>
				</div>
				<div class="modal-footer">
					<a href="#resend_otp" class="btn btn-default" onclick="$('#resend_otp').submit();">Resend OTP</a>
					<button type="submit" class="btn btn-default">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div> -->

<!-- <div class="wrap">
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-new">
    open modal
  </button>
</div> -->
 
<div class="modal fade bs-example-modal-new" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog img_sec">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Verify Your Account</h4>
				<a href="{{route('closeVerification')}}"><button type="button" class="close close_verification" data-dismiss="modal" aria-label=""><span>×</span></button></a>
			</div>
			<form action="{{route('verifyAccountByOtp')}}" method="post" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" />
				<input type="hidden" name="phone" value="{{$sessionPhone}}" />
				<div class="modal-body">                       
					<div class="form-group">
						<label for="otp">OTP</label>
						<input type="text" name="otp" class="form-control" maxlength="4">
					</div>
				</div>
				<div class="modal-footer">
					<span id="count"></span>
					<!-- <a href="#resend_otp" class="btn btn-default resend_otp" onclick="$('#resend_otp').submit();">Resend OTP</a> -->
					<a href="#resend_otp" class="btn btn-default resend_otp" style="color: #FF7A17;">Resend OTP</a>
					<button type="submit" class="btn btn-default">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>

@php if($request->session()->has('forgotPassPhone')){ $forgotPassPhone = $request->session()->get('forgotPassPhone'); }else{ $forgotPassPhone = ''; } @endphp
<div class="modal fade forgot_password_otp_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog img_sec">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Forgot Password OTP</h4>
				<!-- <a href="{{route('closeVerification')}}"><button type="button" class="close close_verification" data-dismiss="modal" aria-label=""><span>×</span></button></a> -->
				<a href="{{route('closeVerification')}}" class="close"><span>×</span></a>
			</div>
			<form action="{{route('forgotPasswordByOtp')}}" method="post" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" />
				<input type="hidden" name="phone" value="{{$forgotPassPhone}}" />
				<div class="modal-body">                       
					<div class="form-group">
						<label for="otp">OTP</label>
						<input type="text" name="otp" class="form-control" maxlength="4">
					</div>
				</div>
				<div class="modal-footer">
					<span id="forgot_count"></span>
					<a href="#forgot_resend_otp" class="btn btn-default forgot_resend_otp" style="color: #FF7A17;">Resend OTP</a>
					<button type="submit" class="btn btn-default">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>


<a href="#" class="back-to-top"><i class="icofont-arrow-up"></i></a>

{!! Form::open(['route' => 'frontlogout', 'style' => 'display:none;', 'id' => 'logout']) !!}
<button type="submit">@lang('global.logout')</button>
{!! Form::close() !!}

{!! Form::open(['route' => 'resendOtp', 'style' => 'display:none;', 'id' => 'resend_otp']) !!}
<input type="hidden" name="phone" value="{{$sessionPhone}}" />
<button type="submit">Resend OTP</button>
{!! Form::close() !!}

{!! Form::open(['route' => 'forgotResendOtp', 'style' => 'display:none;', 'id' => 'forgot_resend_otp']) !!}
<input type="hidden" name="phone" value="{{$forgotPassPhone}}" />
<button type="submit">Resend OTP</button>
{!! Form::close() !!}

{!! Form::open(['route' => 'forgotPassword', 'style' => 'display:none;', 'id' => 'forgotPassword']) !!}
<input type="hidden" name="email" id="forgot_email" value="" />
<button type="submit">Forgot Password</button>
{!! Form::close() !!}

<!-- Vendor JS Files -->
<script src="{{asset('front/assets/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('front/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('front/assets/vendor/jquery.easing/jquery.easing.min.js')}}"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" /> -->


<script src="{{asset('front/assets/vendor/owl.carousel/owl.carousel.min.js')}}"></script>
<script src="{{asset('front/assets/vendor/aos/aos.js')}}"></script>

<!-- SweetAlert2 -->
<script src="{{asset('front/assets/js/sweetalert2.all.min.js')}}"></script>
<!-- Template Main JS File -->
<script src="{{asset('front/assets/js/main.js')}}"></script>

<script type="text/javascript">
var APP_URL = {!! json_encode(url('/')) !!}
</script>

<script>
	$(function() {
		$('.selectpicker').selectpicker();
	});
</script>

<script type="text/javascript">
	$(".tab_content").hide();
	$(".tab_content:first").show();

	/* if in tab mode */
	$("ul.tabs li").click(function() {
		$(".tab_content").hide();
		var activeTab = $(this).attr("rel");
		//alert(activeTab);
		$("#"+activeTab).show();

		$("ul.tabs li").removeClass("active");
		$(this).addClass("active");

		$(".tab_drawer_heading").removeClass("d_active");
		$(".tab_drawer_heading[rel^='"+activeTab+"']").addClass("d_active");

		/*$(".tabs").css("margin-top", function(){ 

			return ($(".tab_container").outerHeight() - $(".tabs").outerHeight() ) / 2;

		});*/
	});

	$(".tab_container").css("min-height", function(){ 
		return $(".tabs").outerHeight() + 50;
	});

	/* if in drawer mode */
	$(".tab_drawer_heading").click(function() {
		$(".tab_content").hide();
		var d_activeTab = $(this).attr("rel");
		$("#"+d_activeTab).fadeIn();
		$(".tab_drawer_heading").removeClass("d_active");
		$(this).addClass("d_active");

		$("ul.tabs li").removeClass("active");
		$("ul.tabs li[rel^='"+d_activeTab+"']").addClass("active");
	});
</script>

<script type="text/javascript">
	window.onscroll = function() {myFunction()};

	var header = document.getElementById("header");
	var sticky = header.offsetTop;

	function myFunction() {
		if (window.pageYOffset > sticky) {
			header.classList.add("stickybg");
		} else {
			header.classList.remove("stickybg");
		}
	}
</script>

<script type="text/javascript">
	$(document).ready(function () {
		//right click disable
	    $("body").on("contextmenu",function(e){
	    	return false;
	    });
	    $(document).keydown(function(event) {
  
            // 86 is the keycode of u
            if (event.ctrlKey == true && (event.which == '85')) {
                $("#d2").text('ctrl u. not allowed!');
                event.preventDefault();
            }

            // 86 is the keycode of v
            if (event.ctrlKey == true && (event.which == '86')) {
                $("#d2").text('paste. not allowed!');
                event.preventDefault();
            }

            // 88 is the keycode of x
            if (event.ctrlKey == true && (event.which == '88')) {
                $("#d2").text('cut. not allowed!');
                event.preventDefault();
            }

            // 67 is the keycode of c
            if (event.ctrlKey == true && (event.which == '67')) {
                $("#d2").text('copy. not allowed!');
                event.preventDefault();
            }

            // To disable F12 options
            if (event.keyCode == 123) {
                $("#d2").text('F12. not allowed!');
                event.preventDefault();
            }

            // Above all three can be combined into one, above is 
            // executed separately for understanding purposes.
            /* if (event.ctrlKey==true && (event.which == '86' 
            || event.which == '67' || event.which == '88')) {
                alert('cut. copy. paste. not allowed!');
                event.preventDefault();
            } */
        });
	});

	/*$(".login_modal").click(function() {
		$("#myModalone").hide();
		$("#myModal").show();
	});
	$(".register_modal").click(function() {
		$("#myModal").hide();
		$("#myModalone").show();
	});*/
</script>

<script>
	$(".toggle-password").click(function() {
	 
		$(this).toggleClass("fa-eye fa-eye-slash");
		var input = $($(this).attr("toggle"));
		if (input.attr("type") == "password") {
		    input.attr("type", "text");
		} else {
		    input.attr("type", "password");
		}
	});    
</script>

<script>
	$(document).ready(function() {
	    $("#show_hide_password a").on('click', function(event) {
	        event.preventDefault();
	        if($('#show_hide_password input').attr("type") == "text"){
	            $('#show_hide_password input').attr('type', 'password');
	            $('#show_hide_password i').addClass( "fa-eye-slash" );
	            $('#show_hide_password i').removeClass( "fa-eye" );
	        }else if($('#show_hide_password input').attr("type") == "password"){
	            $('#show_hide_password input').attr('type', 'text');
	            $('#show_hide_password i').removeClass( "fa-eye-slash" );
	            $('#show_hide_password i').addClass( "fa-eye" );
	        }
	    });

		@if($sessionPhone!='')
			//$("#otpModal").show();
			$(".bs-example-modal-new").modal('show');
		@endif

		@if($forgotPassPhone!='')
			$(".forgot_password_otp_modal").modal('show');
		@endif
	});
</script>

<script>
	$(document).ready(function() {
	    $("#show_hide_passwords a").on('click', function(event) {
	        event.preventDefault();
	        if($('#show_hide_passwords input').attr("type") == "text"){
	            $('#show_hide_passwords input').attr('type', 'password');
	            $('#show_hide_passwords i').addClass( "fa-eye-slash" );
	            $('#show_hide_passwords i').removeClass( "fa-eye" );
	        }else if($('#show_hide_passwords input').attr("type") == "password"){
	            $('#show_hide_passwords input').attr('type', 'text');
	            $('#show_hide_passwords i').removeClass( "fa-eye-slash" );
	            $('#show_hide_passwords i').addClass( "fa-eye" );
	        }
	    });
	});
</script>
<script>
	function scorePassword(pass) {
		var score = 0;
		if (!pass)
			return score;

		  // award every unique letter until 5 repetitions
		  var letters = new Object();
		  for (var i = 0; i < pass.length; i++) {
		  	letters[pass[i]] = (letters[pass[i]] || 0) + 1;
		  	score += 5.0 / letters[pass[i]];
		  }

		  // bonus points for mixing it up
		  var variations = {
		  	digits: /\d/.test(pass),
		  	lower: /[a-z]/.test(pass),
		  	upper: /[A-Z]/.test(pass),
		  	nonWords: /\W/.test(pass),
		  }

		  variationCount = 0;
		  for (var check in variations) {
		  	variationCount += (variations[check] == true) ? 1 : 0;
		  }
		  score += (variationCount - 1) * 10;

		  return parseInt(score);
	}

	function checkPassStrength(pass) {
		var score = scorePassword(pass);
		if (score > 50)
			return "Strong";
		if (score > 20)
			return "Good";
		if (score >= 10)
			return "Weak";

		return "";
	}

	$(document).ready(function() {
		$("#password").on("keypress keyup keydown", function() {
			var pass = $(this).val();
			$("#strength_human").text(checkPassStrength(pass));
			$("#strength_score").text(scorePassword(pass));
		});
	});

</script>

<script type="text/javascript">
	$(document).ready(function () {
	    $("#loginId").click(function(){
	    	$('#myModalone').modal('hide');
	    });

		$(".resend_otp").click(function() {
			//alert("working");

			var counter = 45;
			setInterval(function() {
				counter--;
				if (counter >= 0) {
					span = document.getElementById("count");
					span.innerHTML = "waiting... " + counter;
					$(".resend_otp").addClass("disabled");
				}
				if (counter === 0) {
					//alert('sorry, out of time');
					$('#resend_otp').submit();
					clearInterval(counter);
					$(".resend_otp").removeClass("disabled");
				}
			}, 1000);
			
			/*var phone = "{{$sessionPhone}}";
			$.ajax({
				url:"{{route('resendOtp')}}",
				method:"POST",
				data:{ _token:"{{ csrf_token() }}", phone:phone },
				success: function(result){
					alert(result);
					//location.reload();
				}
			});*/
	    });

		$(".forgot_resend_otp").click(function() {
			//alert("working");

			var counter = 45;
			setInterval(function() {
				counter--;
				if (counter >= 0) {
					span = document.getElementById("forgot_count");
					span.innerHTML = "waiting... " + counter;
					$(".forgot_resend_otp").addClass("disabled");
				}
				if (counter === 0) {
					//alert('sorry, out of time');
					$('#forgot_resend_otp').submit();
					clearInterval(counter);
					$(".forgot_resend_otp").removeClass("disabled");
				}
			}, 1000);
	    });

		$(".forgotPassword").click(function() {
			//alert("working");
			var forgot_email = $("#email").val();
			if(forgot_email != ''){
				$("#forgot_email").val(forgot_email);
				$('#forgotPassword').submit();
			}else{
				swal(
					"Error!",
					"Please enter your Mobile or Email id",
					"error"
				)
			}
	    });

		/*$(".close_verification").click(function() {
			//alert("working");
			$('.bs-example-modal-new').modal('hide');
			var phone = "{{$sessionPhone}}";
			$.ajax({
				url:"{{route('closeVerification')}}",
				method:"POST",
				data:{ _token:"{{ csrf_token() }}", phone:phone },
				success: function(result){
					alert(result);
					//location.reload();
				}
			});
	    });*/

	});
</script>

<script type="text/javascript">
	@if (Session::has('success'))
		swal(
			"Success",
			"{{ Session::get('success') }}",
			"success"
		)
		{{ Session::forget('success') }}
		{{ Session::save() }}
	@endif
	@if (Session::has('error'))
		swal(
			"Error!",
			"{{ Session::get('error') }}",
			"error"
		)
	@endif
	@if ($errors->count() > 0)
		swal(
			"Error!",
			@foreach($errors->all() as $error)
				"{{ $error }}",
			@endforeach
			
			"error"
		)
	@endif
	@if($request->query('error')=='subscription')
		swal(
			"Error!",
			"Please subscribed a plan first to proceed.",
			"error"
		)
	@endif
</script>
<script type="text/javascript">
	// Alert Modal Type
		/*$(document).on('click', '#success', function(e) {
			swal(
				'Success',
				'You clicked the <b style="color:green;">Success</b> button!',
				'success'
			)
		});

		$(document).on('click', '#error', function(e) {
			swal(
				'Error!',
				'You clicked the <b style="color:red;">error</b> button!',
				'error'
			)
		});

		$(document).on('click', '#warning', function(e) {
			swal(
				'Warning!',
				'You clicked the <b style="color:coral;">warning</b> button!',
				'warning'
			)
		});

		$(document).on('click', '#info', function(e) {
			swal(
				'Info!',
				'You clicked the <b style="color:cornflowerblue;">info</b> button!',
				'info'
			)
		});

		$(document).on('click', '#question', function(e) {
			swal(
				'Question!',
				'You clicked the <b style="color:grey;">question</b> button!',
				'question'
			)
		});*/

	// Alert With Custom Icon and Background Image
		/*$(document).on('click', '#icon', function(event) {
			swal({
				title: 'Custom icon!',
				text: 'Alert with a custom image.',
				imageUrl: 'https://image.shutterstock.com/z/stock-vector--exclamation-mark-exclamation-mark-hazard-warning-symbol-flat-design-style-vector-eps-444778462.jpg',
				imageWidth: 200,
				imageHeight: 200,
				imageAlt: 'Custom image',
				animation: false
			})
		});

		$(document).on('click', '#image', function(event) {
			swal({
				title: 'Custom background image, width and padding.',
				width: 700,
				padding: 150,
				background: '#fff url(https://image.shutterstock.com/z/stock-vector--exclamation-mark-exclamation-mark-hazard-warning-symbol-flat-design-style-vector-eps-444778462.jpg)'
			})
		});*/

	// Alert With Input Type
		/*$(document).on('click', '#subscribe', function(e) {
			swal({
			  title: 'Submit email to subscribe',
			  input: 'email',
			  inputPlaceholder: 'Example@email.xxx',
			  showCancelButton: true,
			  confirmButtonText: 'Submit',
			  showLoaderOnConfirm: true,
			  preConfirm: (email) => {
				return new Promise((resolve) => {
				  setTimeout(() => {
					if (email === 'example@email.com') {
					  swal.showValidationError(
						'This email is already taken.'
					  )
					}
					resolve()
				  }, 2000)
				})
			  },
			  allowOutsideClick: false
			}).then((result) => {
			  if (result.value) {
				swal({
				  type: 'success',
				  title: 'Thank you for subscribe!',
				  html: 'Submitted email: ' + result.value
				})
			  }
			})
		});*/

	// Alert Redirect to Another Link
		/*$(document).on('click', '#link', function(e) {
			swal({
				title: "Are you sure?", 
				text: "You will be redirected to https://utopian.io", 
				type: "warning",
				confirmButtonText: "Yes, visit link!",
				showCancelButton: true
			})
				.then((result) => {
					if (result.value) {
						window.location = 'https://utopian.io';
					} else if (result.dismiss === 'cancel') {
						swal(
						  'Cancelled',
						  'Your stay here :)',
						  'error'
						)
					}
				})
		});*/
</script>

@yield('javascript')

<!--Whatsapp script-->
<script>
    var url = 'https://wati-integration-service.clare.ai/ShopifyWidget/shopifyWidget.js?47237';
    var s = document.createElement('script');
    s.type = 'text/javascript';
    s.async = true;
    s.src = url;
    var options = {
	  "enabled":true,
	  "chatButtonSetting":{
	      "backgroundColor":"#4dc247",
	      "ctaText":"",
	      "borderRadius":"25",
	      "marginLeft":"0",
	      "marginBottom":"50",
	      "marginRight":"50",
	      "position":"right"
	  },
	  "brandSetting":{
	      "brandName":"Brainywood",
	      "brandSubTitle":"Success is in brain...",
	      "brandImg":"https://brainywoodindia.com/front/assets/img/web-logo.png",
	      "welcomeText":"Hi there!\nHow can I help you?",
	      //"messageText":"Hello, I have a question about ",
	      "backgroundColor":"#0a5f54",
	      "ctaText":"Start Chat",
	      "borderRadius":"25",
	      "autoShow":false,
	      "phoneNumber":"919887470545"
	  }
	};
    s.onload = function() {
        CreateWhatsappChatWidget(options);
    };
    var x = document.getElementsByTagName('script')[0];
    //x.parentNode.insertBefore(s, x);
</script>
<!--OR-->
<link rel="stylesheet" href="{{asset('front/assets/css/floating-wpp.min.css')}}">
<!--Floating WhatsApp javascript-->
<script type="text/javascript" src="{{asset('front/assets/js/floating-wpp.min.js')}}"></script>

<script>
	$(function() {
		$('#WAButton').floatingWhatsApp({
		    phone: '9950368500', //WhatsApp Business phone number International format-
		    //Get it with Toky at https://toky.co/en/features/whatsapp.
		    headerTitle: 'Chat with us on WhatsApp!', //Popup Title
		    popupMessage: 'Hello, how can we help you?', //Popup Message
		    showPopup: true, //Enables popup display
		    buttonImage: '<img src="{{asset('front/assets/img/whatsapp.png')}}" />', //Button Image
		    //headerColor: 'crimson', //Custom header color
		    //backgroundColor: 'crimson', //Custom background button color
		    position: "right"    
		});
	});
</script>


<!--Div where the WhatsApp will be rendered-->
  <div id="WAButton"></div>
</body>
</html>