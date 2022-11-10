@extends('layouts.front')
@section('meta_title')
{{$pagename}}
@endsection
@section('meta_description')
{{$pagename}}
@endsection
@section('head')
<style>
	video.thevideo {
		height: 100%;
		width: 260%;
		margin-left: -82%;
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
		box-shadow: 0px 0px 10px #c5c5c5;
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
	img.crown_pt {
		width: 30px;
		position: absolute;
		z-index: 9999;
		left: 30px;
		top: 15px;
	}
	.boxc1 {
		height: 360px;
		object-fit: cover;
	}
</style>
@endsection
@section('hero_section')
<!-- ======= Hero Section ======= -->
<div class="innovative" class="d-flex align-items-center Learning">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h1>Our Courses</h1>
				<h2>Brainywood is an Ed-tech company engaged in research & development in the field of innovative learning and brain <br> science having it’s headquarter in Rajasthan, India.</h2>
			</div>
		</div>
	</div>
</div><!-- End Hero -->
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div id="custom-search-input">
			<form name="srchfrm" action="{{route('ourCourses')}}" method="GET">
				<div class="input-group col-md-12">
					<input type="text" name="search" class="search-query form-control" placeholder="Search Courses" value="{{$search}}" />
					<button type="button" class="btn btn-danger">
						<!-- <i class="fa fa-search"></i> --> Search
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="our_vid" data-aos="zoom-in" data-aos-delay="100">
	<div class="container">
		@if(count($courses)>0)
		<div class="row">
			@foreach($courses as $key => $course)
			@php $total_lessions = \App\Lession::where("courseId", $course->id)->where("status", 1)->where('deleted', 0)->count(); @endphp
			<div class="col-md-6 col-lg-3 mb-4">
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
					@if($course->isFree==0)
					<div class="video boxc">
						<img src="{{asset('front/assets/img/volume_off.svg')}}" onclick='toggleSound(this);' class="mutebtn">
						<video class="thevideo" loop preload="none">
							<source src="{{asset('course/'. $course->video)}}" type="video/mp4">
							<!-- <source src="assets/videowebm.webm" type="video/webm"> -->
						</video>
					</div>
					@elseif($userSubscription==1)
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
			@endforeach
		</div>
		@else
		<div class="mt-5 text-center">Course not available!</div>
		@endif
	</div>
</div>

<br>
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
				<a href="#" class="">
					<img class="img-fluid" src="{{asset('front/assets/img/app-store.svg')}}" alt="">
				</a>
			</div>
		</div>
	</div>
</div>

@endsection

@section('javascript')
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

@endsection