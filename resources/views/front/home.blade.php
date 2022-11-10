@extends('layouts.front')
@section('meta_title')
{{$pagename}}
@endsection
@section('meta_description')
{{$pagename}}
@endsection
@section('head')
<link rel="stylesheet" type="text/css" href="{{asset('front/assets/css/slick.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('front/assets/css/slick-theme.css')}}"/>

<script src="{{asset('front/assets/js/slick.min1.8.1.js')}}"></script>

<link rel="stylesheet" href="{{asset('front/assets/css/slick-theme1.8.1.css')}}" />

<link rel="stylesheet" href="{{asset('front/assets/css/slick-theme.min1.8.1.css')}}" />

<link rel="stylesheet" href="{{asset('front/assets/css/slick1.8.1.css')}}" />

<script src="{{asset('front/assets/js/slick1.8.1.js')}}"></script>

<link href="{{asset('front/assets/css/video-js.css')}}" rel="stylesheet" />

<style type="text/css">
	.carousel-control-next, .carousel-control-prev {
		width: 4%;
	}
	.bg_section .carousel-caption {
		right: 3%;
		left: 7%;
	}
	span.left_sec {
		position: absolute;
		font-weight: 600;
		bottom: 55px;
		background: white !important;
	}
	p#demo {
		font-weight: 500;
		font-size: 28px;
		color: white;
		background: #ff7a17;
		padding: 10px 20px;
		border-radius: 10px;
		width: 50%;
		text-align: right;
	}

	video.audi_vis {
		border-radius: 20px;
	}
	img.top_img {
		width: 75%;
		margin: 0 auto;
		text-align: center;
		display: block;
	}	
	/*.element.element.slick-slide{
	height:500px;
	}*/
	a.btn-get-started.cou_sea {
		margin: 30px auto 0;
		font-family: 'Fira Sans', sans-serif;
		font-weight: 400;
		font-size: 17px;
		display: block;
		border-radius: 30px;
		transition: 0.5s;
		color: #fff;
		background: #FF7A17;
		width: 20%;
		padding: 10px 25px;
		text-align: center;
	}
	.slick-slide {
		height: auto;
	}
	ul.breakpoint_section li a {
		background: transparent !important;
		color: black !important;
		line-height: 0px;
		padding-left: 0px !important;
		padding: 0px !important; 
	}
	ul.breakpoint_section {
		padding-left: 0px;
		list-style: none;
	}
	.dwnld-btns img {
		width: 90%;
	}
	div#countdown ul {
		list-style: none;
		display: flex;
	}
	div#countdown ul {
		list-style: none;
		display: flex;
		background: #ff7a17;
		padding: 8px;
		border-radius: 5px;
		width:35%;
		font-size: 30px;
		font-weight: 600;
		color: white;
		text-align: center;
	}
	div#countdown ul li {
		text-align: center;
		margin: 0 auto;
	}
	div#countdown ul li span {
		padding: 10px 10px;
		background: transparent;
		color: white;
		font-size: 30px;
		font-weight: 600;
	}

	.zoom {
	 /* padding: 50px;
	  background-color: green;
	  transition: transform .2s;
	  width: 200px;
	  height: 200px;
	  margin: 0 auto;*/
	}
	.zoom:hover {
	  -ms-transform: scale(0.9); /* IE 9 */
	  -webkit-transform: scale(0.9); /* Safari 3-8 */
	  transform: scale(0.9); 
	}
	.wrapper {
	  width: 1280px;
	  margin: 0 auto;
	}
	.zoom-effect-container {
		float: none;
		position: relative;
		width: 640px;
		height: 400px;
		margin: 0 auto;
		overflow: hidden;
	}
	.image-card {
	  position: absolute;
	  top: 0;
	  left: 0;
	  
	}
	.image-card img {
	  -webkit-transition: 0.4s ease;
	  transition: 0.4s ease;
	}
	.zoom-effect-container:hover .image-card img {
	  -webkit-transform: scale(1.08);
	  transform: scale(1.08);
	}
</style>
<style>
	video.thevideo {
		object-fit: none;
		height: 35em;
		width: 100%;
	}
	.contentc a {
		color: #ffffff;
		background: #ff7a17;
		padding: 6px 30px;
		border-radius: 22px;
	}
	 
	.video {
		height: 360px;
		width: 100%; 
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;   
	}

	/* Hide Play button + controls on iOS */
	video::-webkit-media-controls {
		display:none !important;
	}

	.boxc{ 
		position: relative;
		height: 360px!important;
		border-radius: 1rem!important;
		-o-object-fit: cover!important;
		object-fit: cover!important;
		overflow: hidden!important;
		width: 100%!important;
		box-shadow: 0px 0px 2px #bdbdbd;
	}
	.boxc:hover img.boxc  { 
		display: none;
	}
	.boxc:hover .video.boxc{ 
		display: block;
	}
	.mutebtn {    
		position: absolute;
		top: 10px;
		right: -110px;
		width: 20px;
		height: 20px;
	}
	.contentc h5, .contentc h6 { 
		color: #fff;
		margin-bottom: .5rem;
		font-weight: 500;
		line-height: 1.2;
	}
	.contentc h5 {
		font-size: 1.25rem;
	}
	.contentc h6 {
		font-size: 1rem;
	}
	.contentc {
		position: absolute;
		bottom: 0;
		left: 0;
		right: 0;
		z-index: 9;
		text-align: center;
		padding-bottom: 10px;
	}
	.boxc1 {
		height: 360px;
		object-fit: cover;
	}
	video.thevideo {
	    height: 100%;
	    width: 260%;
	    margin-left: -82%;
	    object-fit: unset;
	}
	img.crown_pt {
		width: 30px;
		position: absolute;
		z-index: 9999;
		left: 30px;
		top: 15px;
	}
	img.crown_pt_pop {
		width: 30px;
		position: relative;
		z-index: 9999;
		left: 30px;
		top: 40px;
	}
</style>
@endsection

@section('hero_section')
<!-- ======= Hero Section ======= -->
<div class="banner">
	<div id="carouselExampleControls" class="carousel slide" data-ride="carousel" data-interval="false">
		<div class="carousel-inner">
			<div class="carousel-item active">
				<div class="bg_section">
					<!-- <img src="admin/image/1617430452.jpeg" class="d-block w-100" alt=""> -->
					<div class="carousel-caption d-md-block">
						<div class="home_sld" style="background-image: none;">
							<div class="row" style="margin: 0 auto;">
								<div class="col-lg-6">
									<p><span>Learning has never been easier</span></p>
									<h1>Brainywood App is <br> Available on All Platforms</h1>
									<h2>Start learning the skills you have always been dreaming of.</h2>
									<ul>
										<li><img src="{{asset('front/assets/img/mobile-g.png')}}">Mobiles</li>
										<li><img src="{{asset('front/assets/img/tablet.png')}}">Tablets</li>
										<li><img src="{{asset('front/assets/img/Laptop.png')}}">Desktops</li>
									</ul>
									<div class="d-lg-flex dwnld-btns">
										<a href="https://play.google.com/store/apps/details?id=com.sharad.brainywood" target="_blank"><img class="img-fluid" src="{{asset('front/assets/img/google-play.svg')}}" alt=""></a>
										<a href="javascript:void(0)"><img class="img-fluid" src="{{asset('front/assets/img/app-store.svg')}}" alt=""></a>
									</div>
								</div>
								<div class="col-lg-6">
									<section id="clients sections" class="clients">
										<div class="owl-carousel clients-carousel sld_secod" data-aos="fade-up" data-aos-delay="100">
											<div class="testimonial">
												<div class="row">
													<div class="col-md-12">
														<h2 class="dell">ddd</h2>
														<img class="zoom" src="{{asset('front/assets/img/banner-img.png')}}">
														<!-- <div class="wrapper">
															<div class="zoom-effect-container">
																<div class="image-card">
																	<img src="{{asset('front/assets/img/banner-img.png')}}"/>
																</div>
															</div>
														</div> -->
													</div>
												</div>
											</div>
										</div>
									</section>
								</div>
							</div>
						</div>
					</div>  
				</div>  
			</div>
		
			<div class="carousel-item">
				<div class="bg_section">
					<div class="carousel-caption d-md-block">
						<div class="counsellor" style="background-image: none;">
							<div class="cont-page">
								<div class="container">
									<div class="row">
										<div class="col-md-5 Tarun-pt">

											<form action="{{route('saveLead')}}" id="contact-form" method="post" enctype="multipart/form-data">
												<input type="hidden" name="_token" value="{!!csrf_token()!!}">
												<div class="controls">
													<h2>Need Help. Talk to our counsellor for FREE</h2>
													<p>Please enter the following details:</p>
													<div class="row">
														<div class="col-md-12">
															<div class="form-group">
																<input type="text" name="name" id="enq_name" class="form-control" placeholder="Name" required="required" value="{{old('name')}}">
															</div>
														</div>
														<div class="col-md-12">
															<div class="form-group">
																<input type="email" name="email" id="enq_email" class="form-control" placeholder="Email" required="required" value="{{old('email')}}">
															</div>
														</div>      
													</div>
													<div class="row">
														<div class="col-md-12">
															<div class="form-group">
																<input type="text" name="phone" id="enq_phone" class="form-control" placeholder="Mobile Number" required="required" value="{{old('phone')}}">
															</div>            
														</div>
														<div class="col-md-12">
															<div class="form-group">
																<input type="text" name="city" id="enq_city" class="form-control" placeholder="City" required="required">
															</div>            
														</div>
														<div class="col-md-12">
															<select name="st_class" id="enq_st_class" class="selectpicker form-control">
																<option selected="selected">Class</option>
																@if($studentClasses)
																@foreach($studentClasses as $studentClass)
																<option value="{{$studentClass->class_name}}">{{$studentClass->class_name}} </option>
																@endforeach
																@endif
															</select>
														</div>
													</div>
													<div class="row">            
														<div class="col-md-12">              
															<input type="submit" class="btn btn-success btn-send enquiry_btn" value="Schedule it for FREE">            
														</div>          
													</div>                 
												</div>    
											</form>

										</div>
										<div class="col-md-7">
											<div class="sao-part">
												<h4>The future of online learning is here</h4> 
												<!-- <h4>Learn New Skills to Change Your Life</h4> --> 
												<h4 class="bt_strt"> <span style="color: #ff7a17 !important;"> New courses added every month </span> <br> Students deserve better </h4> 
												<div class="row">
													<div class="col-md-6">
														<p><img src="{{asset('front/assets/img/org-tick.svg')}}">&nbsp; Stress-free education  </p>
												<p><img src="{{asset('front/assets/img/org-tick.svg')}}">&nbsp; Holistic development  </p>
												<p><img src="{{asset('front/assets/img/org-tick.svg')}}">&nbsp; Scientific approach  </p>

													</div>
													<div class="col-md-6">
														<p><img src="{{asset('front/assets/img/org-tick.svg')}}">&nbsp;	Memorise anything  </p>
												<p><img src="{{asset('front/assets/img/org-tick.svg')}}">&nbsp; Reasonable price</p>
												<p><img src="{{asset('front/assets/img/org-tick.svg')}}">&nbsp; Innovative learning</p>

													</div>
												</div>


												<!-- <p><img src="{{asset('front/assets/img/org-tick.svg')}}">&nbsp; Stress-free education  </p>
												<p><img src="{{asset('front/assets/img/org-tick.svg')}}">&nbsp; Holistic development  </p>
												<p><img src="{{asset('front/assets/img/org-tick.svg')}}">&nbsp; Scientific approach  </p>
												<p><img src="{{asset('front/assets/img/org-tick.svg')}}">&nbsp;	Memorise anything  </p>
												<p><img src="{{asset('front/assets/img/org-tick.svg')}}">&nbsp; Reasonable price</p>
												<p><img src="{{asset('front/assets/img/org-tick.svg')}}">&nbsp; innovative learning</p> -->
											</div>    
										</div> 
									</div>  
								</div>
							</div>
						</div>
					</div>
				</div>  
			</div>
		
		</div>
		<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>
</div>
<!-- End Hero -->
@endsection

@section('content')
<main id="main">
	<!-- ======= About Section ======= -->
	<section id="about" class="about abt_prt">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-12">
					<!-- <img src="{{asset('front/assets/img/vid-im.svg')}}"> -->
					<video class="video-js vjs-default-skin vjs-big-play-centered"
					    id="my-video"
					    class="video-js"
					    controls
					    preload="none"
						autoplay="false"
					    width="640"
					    height="264"
					    muted="muted" 
					    poster="{{asset('front/assets/img/sharman_vid.png')}}"
						data-setup='{ "controls": true, "autoplay": false, "preload": "none" }'
					  >
					    <source src="{{asset('front/assets/video/sharman joshi final video.mp4')}}" type="video/mp4" />
					    <p class="vjs-no-js">
					      To view this video please enable JavaScript, and consider upgrading to a
					      web browser that
					    </p>
					</video>
					<!-- <img src="{{asset('front/assets/img/sharman_vid.png')}}" alt="alt text" class="img-fluid boxc">
					<div class="video boxc">
						<img src="{{asset('front/assets/img/volume_off.svg')}}" onclick='toggleSound(this);' class="mutebtn">
						<video class="thevideo" loop preload="none">
							<source src="{{asset('front/assets/video/sharman joshi final video.mp4')}}" type="video/mp4">
						</video>
					</div> -->
					
					<!-- <section id="clients" class="clients equipped">
						<div class="owl-carousel clients-carousel" data-aos="fade-up" data-aos-delay="100">
							<div class="testimonial">
								<div class="row">
									<div class="col-md-12">
										<video class="audi_vis" width="500px" height="280px" controls>
											<source src="{{asset('front/assets/img/Brainywood_doctor.mp4')}}" type="video/mp4">
											<source src="{{asset('front/assets/img/Brainywood_doctor.mp4')}}" type="video/ogg">
										</video>
									</div>
								</div>
							</div>
							<div class="testimonial">
								<div class="row">
									<div class="col-md-12">
										<img class="mid-pty" style="width: 80%;" src="{{asset('front/assets/img/vid-im.svg')}}">
									</div>
								</div>
							</div>

							<div class="testimonial">
								<div class="row">
									<div class="col-md-12">
										<video class="audi_vis" width="500px" height="280px" controls>
											<source src="{{asset('front/assets/img/Brainywood_doctor.mp4')}}" type="video/mp4">
											<source src="{{asset('front/assets/img/Brainywood_doctor.mp4')}}" type="video/ogg">
										</video>
									</div>
								</div>
							</div>
						</div>
					</section> -->
				</div>
				<div class="col-lg-6 col-md-12">
					<div class="section-title" data-aos="fade-up">
						<span>India’s first brain training programs</span>
						<h2>India’s best innovative learning platform equipped with brain science.</h2>
						<p class="permanent">India’s first brain training programs which makes learning easy, effective, permanent and converts knowledge into skills. Make Your Studies Interesting and Meaningful.</p>
						<a href="{{route('services')}}" class="btn-get-started">Know More <img src="{{asset('front/assets/img/right-w.svg')}}"></a>
					</div>
				</div>
			</div>
			<div class="row mt-5 pt-5">
				<div class="col-lg-6 col-md-12 mt-3">
					<div class="section-title mt-5" data-aos="fade-up">
						<span>4th Dimension of Education</span>
						<h2>Introducing 4th Dimension of Education</h2>
						<p>Training of Retention and Recollection Skills to make study easy, enjoyable, effective and everlasting. It lays down the ultimate foundation of desired success.</p>
						<ul class="breakpoint_section">
							<li><a href="#"> <img src="{{asset('front/assets/img/org-tick.svg')}}">&nbsp; Complete Study Solution at One Place </a></li>
							<li><a href="#"> <img src="{{asset('front/assets/img/org-tick.svg')}}">&nbsp; Techniques for Struggling students </a></li>
							<li><a href="#"> <img src="{{asset('front/assets/img/org-tick.svg')}}">&nbsp; Subjects into Audio-Visual Content </a></li>
							<li><a href="#"> <img src="{{asset('front/assets/img/org-tick.svg')}}">&nbsp; Specialised Memory Courses </a></li>
						</ul>
						<!-- <a href="#" class="btn-get-started">Know More <img src="{{asset('front/assets/img/right-w.svg')}}"></a> -->
					</div>
				</div>
				<div class="col-lg-6 col-md-12 mt-5 text-right">
					<img class="vid_phts" src="{{asset('front/assets/img/vid-im1.svg')}}">
				</div>
			</div>
		</div>
	</section><!-- End About Section -->

	@if($conceptvideos)
	<section class="conspt-vid py-5">
		<div class="container">
			<div class="section-title mt-5" data-aos="fade-up">
				<h2>Concept Videos</h2>
				<p>Training of Retention and Recollection Skills to make study easy, enjoyable, effective and everlasting. It lays down the ultimate foundation of desired success.</p>
			</div>
			<div class="tabs_wrapper">
				<ul class="tabs">
					@foreach($conceptvideos as $key => $video)
					@php
					if($key==0){$img='yellow-d.svg';}elseif($key==1){$img='baggy-d.svg';}elseif($key==2){$img='purple-d.svg';}elseif($key==3){$img='green-d.svg';}elseif($key==4){$img='blue-d.svg';}else{$img='baggy-d.svg';}
					@endphp
					<li class="@if($key==0)active @endif" rel="tab{{$key+1}}"><img src="{{asset('front/assets/img/'.$img)}}">&nbsp; {{$video->name}}</li>
					@endforeach
				</ul>
				<div class="tab_container">
					@php $video_url = ''; $paid_cls = ''; @endphp
					@foreach($conceptvideos as $key => $video)
					@if($video->paid==1)
					@if($userSubscription==1)
					@php $video_url = asset('upload/conceptvideos') . '/' . $video->video; @endphp
					@else
					@php
					$video_url = '';
					$paid_cls = 'paid_cls';
					@endphp
					@endif
					@else
					@php $video_url = asset('upload/conceptvideos') . '/' . $video->video; $paid_cls = ''; @endphp
					@endif
					<h3 class="@if($key==0)d_active @endif tab_drawer_heading" rel="tab{{$key+1}}">{{$video->name}}</h3>
					<div id="tab{{$key+1}}" class="tab_content">
						<!-- <iframe src="{{asset('upload/conceptvideos') . '/' . $video->video}}" frameborder="0" controls="0" autoplay="0" allowfullscreen sandbox></iframe> -->
						@if($video->paid==1)
							<img src="{{asset('front/assets/img/crown1.png')}}" class="crown_pt_pop" alt="paid">
						@endif
						<video class="video-js vjs-default-skin vjs-big-play-centered {{$paid_cls}}"
						    id="my-video"
						    class="video-js"
						    controls
						    preload="none"
							autoplay="false"
						    width="740"
						    height="464"
						    poster="{{asset('upload/conceptvideos') . '/' . $video->video_thumb}}"
							data-setup='{ "controls": true, "autoplay": false, "preload": "none" }'
						>
						    <source src="{{$video_url}}" type="video/mp4" />
						    <!-- <source src="MY_VIDEO.webm" type="video/webm" /> -->
						    <p class="vjs-no-js">
						      To view this video please enable JavaScript, and consider upgrading to a
						      web browser that
						    </p>
						</video>
					</div>

					@endforeach
				</div>

			</div>
		</div>  
	</section>
	@endif
	

	<section class="gft-you py-2 coupan_section">
		<div class="container">
			<div class="row">
				<div class="col-md-5">
					<img class="top_img mt-2" src="{{asset('front/assets/img/app-scrn.svg')}}">
					<a href="#myModalone" data-toggle="modal" class="btn-get-started">Signup Now <img src="{{asset('front/assets/img/right-w.svg')}}"></a>
				</div>
				<div class="col-md-1"></div>
				<div class="col-md-6">
					<div class="section-title" data-aos="fade-up">
						<span>A gift which you will open again and again</span>
						<h2>Gift Yourself the Joy of Learning</h2>
						<p><img src="{{asset('front/assets/img/org-tick.svg')}}">&nbsp; Scientific Approach, Holistic Development, Synchronize</p>
						<p><img src="{{asset('front/assets/img/org-tick.svg')}}">&nbsp; Left - Right Brain and Develop Audio - Visual Memory</p>
						<p><img src="{{asset('front/assets/img/org-tick.svg')}}">&nbsp; Explore all courses at One Price. </p>
						<div class="dis-ofr">
							<p>Get Introductory Offer</p>
							<div class="row">
								<div class="col-md-6"><img src="{{asset('front/assets/img/10percent.svg')}}"></div>
								<div class="col-md-6 cpn-code">
									Use Coupon Code <br>
									<span>Joy 10</span>
								</div>
							</div>
						</div>
						<p id="demo"> </p>  <span class="left_sec">Days Left</span>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- ======= Testimonials Section ======= -->
	<div class="integrity">
		<div class="container mt-5">
			<h2>Hear more about us from</h2>
			<ul class="nav nav-tabs" role="tablist">
				@if($relates)
				@foreach($relates as $key => $relate)
				<li class="nav-item">
					<a class="nav-link @if($key==0)active @endif" data-toggle="tab" href="#tab{{$key}}">{{$relate->title}}</a>
				</li>
				@endforeach
				@endif
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
				@if($relates)
				@foreach($relates as $key => $relate)
				@php $testimonials = \App\Testimonial::where("related", $relate->id)->where("status", 1)->where('deleted', 0)->orderBy('id', 'DESC')->limit(15)->get(); @endphp
				<div id="tab{{$key}}" class="container tab-pane @if($key==0)active @endif"><br>
					<section id="clients" class="clients testimon more_informate">
						<div class="container">
							<h5>{{$relate->title}}</h5>
							<div class="owl-carousel clients-carousel" data-aos="fade-up" data-aos-delay="100">
								@foreach($testimonials as $key => $testimonial)
								<div class="testimonial">
									<div class="row">
										<div class="col-lg-1 col-md-0"></div>
										<div class="col-lg-4 col-md-12">
											<img src="{{asset('upload/testimonials/'.$testimonial->image)}}">
											<span>{{$testimonial->name}}
												<small>{{$testimonial->profession}}</small>
											</span>
										</div>
										<div class="col-lg-5 col-md-12">
											<div class="containt_part">
											<p>{!!$testimonial->content!!}</p>
										</div>
										</div>
										<div class="col-lg-1 col-md-0"></div>
									</div>
								</div>
								@endforeach
							</div>
						</div>
					</section>
				</div>
				@endforeach
				@endif
			</div>
		</div>
	</div>
	<!-- End Testimonials Section -->

	<!-- ======= Courses Section ======= -->
	<div class="our_portfolio cor_se" style="background-color:#F5F5F5;">
		<div class="container">
			<h2 style="color: #000;">Most Popular Courses</h2>
			<div class="slick-slidersss mt-3">
				@if($courses)
				@foreach($courses as $key => $course)
				@php $total_lessions = \App\Lession::where("courseId", $course->id)->where("status", 1)->where('deleted', 0)->count(); @endphp
				<div class="element element-{{$key + 1}}">
				@if(!empty(auth()->user()) && auth()->user()->role_id==3)
					@if($course->isFree==1)
						@if($userSubscription==1)
							<div class="col-md-6 col-lg-3 mb-4" style="min-width: 100%;padding: 0px;">
								@if($course->isFree==1)
									<img src="{{asset('front/assets/img/crown1.png')}}" class="crown_pt" alt="paid">
								@endif
								<div class="boxc">
									<div class="contentc">
										<h5>{{$course->name}}</h5>
										<h6>{{$total_lessions}} Lessons</h6>
										<a href="{{route('courseDetails', $course->id)}}" class="btn-get-started">View</a>
									</div>
									<img src="{{asset('course') . '/' . $course->image}}" alt="alt text" class="img-fluid boxc">
									<div class="video boxc">
										<img src="{{asset('front/assets/img/volume_off.svg')}}" onclick='toggleSound(this);' class="mutebtn">
										<video class="thevideo" loop preload="none">
											<source src="{{asset('course/'. $course->video)}}" type="video/mp4">
											<!-- <source src="assets/videowebm.webm" type="video/webm"> -->
										</video>
									</div>
								</div> 
							</div>
							<!-- <a href="{{route('courseDetails',$course->id)}}">
								<div class="box_del">
									<img src="{{asset('course/'. $course->image)}}">
									<div class="srvc-text">
										<h5>{{$course->name}}</h5>
										<p>{{$total_lessions}} Lessons</p>
									</div>
								</div>
							</a> -->
						@else
							<div class="col-md-6 col-lg-3 mb-4" style="min-width: 100%;padding: 0px;">
								@if($course->isFree==1)
									<img src="{{asset('front/assets/img/crown1.png')}}" class="crown_pt" alt="paid">
								@endif
								<div class="boxc">
									<div class="contentc">
										<h5>{{$course->name}}</h5>
										<h6>{{$total_lessions}} Lessons</h6>
										<a href="{{route('home',['error'=>'subscription'])}}" class="btn-get-started">View</a>
									</div>
									<img src="{{asset('course') . '/' . $course->image}}" alt="alt text" class="img-fluid boxc">
									@if($course->isFree==0)
									<div class="video boxc">
										<img src="{{asset('front/assets/img/volume_off.svg')}}" onclick='toggleSound(this);' class="mutebtn">
										<video class="thevideo" loop preload="none">
											<source src="{{asset('course/'. $course->video)}}" type="video/mp4">
											<!-- <source src="assets/videowebm.webm" type="video/webm"> -->
										</video>
									</div>
									@else
									<img src="{{asset('course') . '/' . $course->image}}" alt="alt text" class="img-fluid boxc1">
									@endif
								</div> 
							</div>
							<!-- <a href="{{route('home',['error'=>'subscription'])}}">
								<div class="box_del">
									<img src="{{asset('course/'. $course->image)}}">
									<div class="srvc-text">
										<h5>{{$course->name}}</h5>
										<p>{{$total_lessions}} Lessons</p>
									</div>
								</div>
							</a> -->
						@endif
					@else
						<div class="col-md-6 col-lg-3 mb-4" style="min-width: 100%;padding: 0px;">
							@if($course->isFree==1)
								<img src="{{asset('front/assets/img/crown1.png')}}" class="crown_pt" alt="paid">
							@endif
							<div class="boxc">
								<div class="contentc">
									<h5>{{$course->name}}</h5>
									<h6>{{$total_lessions}} Lessons</h6>
									<a href="{{route('courseDetails', $course->id)}}" class="btn-get-started">View</a>
								</div>
								<img src="{{asset('course') . '/' . $course->image}}" alt="alt text" class="img-fluid boxc">
								@if($course->isFree==0 && $userSubscription==1)
								<div class="video boxc">
									<img src="{{asset('front/assets/img/volume_off.svg')}}" onclick='toggleSound(this);' class="mutebtn">
									<video class="thevideo" loop preload="none">
										<source src="{{asset('course/'. $course->video)}}" type="video/mp4">
										<!-- <source src="assets/videowebm.webm" type="video/webm"> -->
									</video>
								</div>
								@else
								<img src="{{asset('course') . '/' . $course->image}}" alt="alt text" class="img-fluid boxc1">
								@endif
							</div> 
						</div>
						<!-- <a href="{{route('courseDetails',$course->id)}}">
							<div class="box_del">
								<img src="{{asset('course/'. $course->image)}}">
								<div class="srvc-text">
									<h5>{{$course->name}}</h5>
									<p>{{$total_lessions}} Lessons</p>
								</div>
							</div>
						</a> -->
					@endif
				@else
					<div class="col-md-6 col-lg-3 mb-4" style="min-width: 100%;padding: 0px;">
						@if($course->isFree==1)
							<img src="{{asset('front/assets/img/crown1.png')}}" class="crown_pt" alt="paid">
						@endif
						<div class="boxc">
							<div class="contentc">
								<h5>{{$course->name}}</h5>
								<h6>{{$total_lessions}} Lessons</h6>
								<a href="#myModal" data-toggle="modal" class="btn-get-started">View</a>
							</div>
							<img src="{{asset('course') . '/' . $course->image}}" alt="alt text" class="img-fluid boxc">
							@if($course->isFree==0)
							<div class="video boxc">
								<img src="{{asset('front/assets/img/volume_off.svg')}}" onclick='toggleSound(this);' class="mutebtn">
								<video class="thevideo" loop preload="none">
									<source src="{{asset('course/'. $course->video)}}" type="video/mp4">
									<!-- <source src="assets/videowebm.webm" type="video/webm"> -->
								</video>
							</div>
							@else
							<img src="{{asset('course') . '/' . $course->image}}" alt="alt text" class="img-fluid boxc1">
							@endif
						</div> 
					</div>
					<!-- <a href="#myModal" data-toggle="modal">
						<div class="box_del">
							<img src="{{asset('course/'. $course->image)}}">
							<div class="srvc-text">
								<h5>{{$course->name}}</h5>
								<p>{{$total_lessions}} Lessons</p>
							</div>
						</div>
					</a> -->
				@endif
				</div>
				@endforeach
				@endif
			</div> 
		</div>
		<a href="{{route('ourCourses')}}" class="btn-get-started cou_sea">View All Courses <img src="{{asset('front/assets/img/right-w.svg')}}"></a>
	</div>
	<!-- End Courses Section -->
	 <!-- <div class="container mt-3"><button style="border-radius: 15px;padding: 3px 20px;background: #ff7a17;color: white;border: none;" id="success">Success</button> </div> -->
	<br>

	<div class="container back_one">
		<div class="row">
			<div class="col-md-2">
				<img src="{{asset('front/assets/img/web-logo.png')}}">
			</div>
			<div class="col-md-6">
				<h2>Download the Brainywood App!!</h2>
			</div>
			<div class="col-md-4">
				<div class="d-lg-flex dwnld-btns">
					<a href="https://play.google.com/store/apps/details?id=com.sharad.brainywood" target="_blank">
						<img class="img-fluid" src="{{asset('front/assets/img/google-play.svg')}}" alt="">
					</a>
					<a href="javascript:void(0)" class="">
						<img class="img-fluid" src="{{asset('front/assets/img/app-store.svg')}}" alt="">
					</a>
				</div>
			</div>
		</div>
	</div>

</main><!-- End #main -->

@endsection

@section('javascript')
<script src="{{asset('front/assets/js/video.min.js')}}"></script>
<script type="text/javascript" src="{{asset('front/assets/js/slick.min.js')}}"></script>
<!-- <script type="text/javascript" src="js/slick.min.js"></script> -->

<script>
	$(document).ready(function () {
		videos = document.querySelectorAll("video"); 
		for(video of videos) {
			video.pause(); 
			//video.controls = true
		}
	});
</script>
<script>
	$(".slick-slidersss").slick({
		slidesToShow: 4,
		slidesToScroll: 1,
		autoplay: true,
		autoplaySpeed: 2000,
		arrows:true,
		/* dots: false,*/
		responsive: [
		{
			breakpoint: 1024,
			settings: {
				slidesToShow: 2,
				slidesToScroll: 2,
				infinite: true,
				/* dots: true*/
			}
		},
		{
			breakpoint: 600,
			settings: {
				slidesToShow: 2,
				slidesToScroll: 2
			}
		},
		{
			breakpoint: 480,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			}
		}
		// You can unslick at a given breakpoint now by adding:
		// settings: "unslick"
		// instead of a settings object
		]

	});

	// Image Slider Demo:
	// https://codepen.io/vone8/pen/gOajmOo
</script>

<script type="text/javascript">
	$(document).ready(function () {
		/*$('.enquiry_btn').click(function(){
			var name = $("#enq_name").val();
			var email = $("#enq_email").val();
			var phone = $("#enq_phone").val();
			var city = $("#enq_city").val();
			var st_class = $("#enq_st_class").val();
			alert(name);
			if(name != '' && email != '' && phone != ''){
				$.ajax({
					url:"{{route('saveLead')}}",
					method:"POST",
					data:{ _token:"{{ csrf_token() }}", name:name, email:email, phone:phone, city:city, st_class:st_class },
					success: function(result){
						if(result==='Done'){
							swal(
								"Success",
								"Your Information Submitted Successfully.",
								"success"
							)
						}else{
							swal(
								"Error!",
								result,
								"error"
							)
						}
					}
				});
			}
		});*/
	});
</script>

<script>
	// Set the date we're counting down to
	var countDownDate = new Date("{{$couponCodeLastDate}}").getTime();

	// Update the count down every 1 second
	var x = setInterval(function() {

	  // Get today's date and time
	  var now = new Date().getTime();
		
	  // Find the distance between now and the count down date
	  var distance = countDownDate - now;
		
	  // Time calculations for days, hours, minutes and seconds
	  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
	  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
	  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
		
	  // Output the result in an element with id="demo"
	  document.getElementById("demo").innerHTML = days + "D " + hours + "H "
	  + minutes + "M "; 
		
	  // If the count down is over, write some text 
	  if (distance < 0) {
		clearInterval(x);
		document.getElementById("demo").innerHTML = "EXPIRED";
	  }
	}, 1000);
</script>
<script type="text/javascript">
	(function () {
		const second = 1000,
		minute = second * 60,
		hour = minute * 60,
		day = hour * 24;

		let birthday = "Sep 30, 2021 00:00:00",
		countDown = new Date(birthday).getTime(),
		x = setInterval(function() {    

			let now = new Date().getTime(),
			distance = countDown - now;

			document.getElementById("hours").innerText = Math.floor((distance % (day)) / (hour)),
			document.getElementById("minutes").innerText = Math.floor((distance % (hour)) / (minute)),
			document.getElementById("seconds").innerText = Math.floor((distance % (minute)) / second);

			//do something later when date is reached
			if (distance < 0) {
				let headline = document.getElementById("headline"),
				countdown = document.getElementById("countdown"),
				content = document.getElementById("content");

				headline.innerText = "It's my birthday!";
				countdown.style.display = "none";
				content.style.display = "block";

				clearInterval(x);
			}
			//seconds
		}, 0)
	}());
</script>

<!-- <script type="text/javascript">
	$('.carousel').carousel({
	  wrap: false
	});
</script> -->


<script src="{{asset('front/assets/js/jquery-3.2.1.slim.min.js')}}"></script>
<script src="{{asset('front/assets/js/popper.min.js')}}"></script>
<script src="{{asset('front/assets/js/bootstrap.min4.0.0.js')}}"></script>

<script>
	var figure = $(".video").hover( hoverVideo, hideVideo );

	function hoverVideo(e) {  
		// console.log($('video', this).get(0));
		// $('video', this).get(0).play();  
		var video =  $('video', this).get(0);  
		var isPlaying = video.currentTime > 0 && !video.paused && !video.ended 
			&& video.readyState > video.HAVE_CURRENT_DATA;

		if (!isPlaying) {
		video.play();
		// console.log('assadf');
		} 
	}

	function hideVideo(e) {
		$('video', this).get(0).pause();   
		$(".mutebtn+video").prop('muted', true);
		$(".mutebtn").prop("src", "{{asset('front/assets/img/volume_off.svg')}}");
	}

	$(".mutebtn+video").prop('muted', true); 
	$(".mutebtn").click(function () {
		if ($(".mutebtn+video").prop('muted')) {
			$(".mutebtn+video").prop('muted', false);  
		} else {
			$(".mutebtn+video").prop('muted', true); 
		} 
	});

	function toggleSound(img) { 
		img.src= img.src.includes("{{asset('front/assets/img/volume_off.svg')}}") ? "{{asset('front/assets/img/volume_up.svg')}}" : "{{asset('front/assets/img/volume_off.svg')}}";
	}

</script>
<script type="text/javascript">
	$(document).ready(function () {
		$('.paid_cls').click(function(){
			swal(
				"Error!",
				"Please subscribed a plan first to proceed.",
				"error"
			)
		});
	});
</script>
@endsection