@inject('request', 'Illuminate\Http\Request')
@extends('layouts.front')
@section('meta_title')
{{$pagename}}
@endsection
@section('meta_description')
{{$pagename}}
@endsection
@section('head')
<link href="{{asset('front/assets/css/video-js.css')}}" rel="stylesheet" />
<style type="text/css">
	.brainywoods.lecture h2 {
		font-size: 25px;
		padding-top: 0;
		margin-top: 0;
	}
	.brainywoods.lecture #tabs .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
		padding: 8px 0px !important;
		border-radius: 0px;
		background: transparent !important;
	}
	.brainywoods.lecture .nav-tabs {
		border-bottom: 0px solid #dee2e6;
		background: #fff;
	}
	.brainywoods.lecture .Process {
		box-shadow: none;
	}
	.brainywoods.lecture nav>div a.nav-item.nav-link.active:after{
		display: none;
	}
	.brainywoods.lecture .nav-tabs .nav-link:focus, .nav-tabs .nav-link:hover {
		border-color:transparent !important;
	}
	.brainywoods.lecture #tabs .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active img {
		filter: grayscale(100%) brightness(115%) sepia(90%) hue-rotate(
			356deg
			) saturate(500%) contrast(0.9) !important;
	}
	.brainywoods.lecture #tabs .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link img {
		filter:invert(0) !important;
	}

	.brainywoods.lecture #tabs .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link {
		padding: 8px 0px !important;
	}
	.brainywoods.lecture h6 {
		text-align: center;
		padding: 15px 0px 15px;
	}

	label.btn.toggle-checkbox > i.fa:before { content:"\f096"; }
	label.btn.toggle-checkbox.active > i.fa:before { content:"\f046"; }

	label.btn.active { box-shadow: none; }
	label.btn.primary.active {
		background-color: #337ab7;
		border-color: #2e6da4;
		color: #ffffff;
		box-shadow: none;
	}
	label.btn.info.active {
		background-color: #5bc0de;
		border-color: #46b8da;
		color: #ffffff;
		box-shadow: none;
	}
	label.btn.success.active {
		background-color: #5cb85c;
		border-color: #4cae4c;
		color: #ffffff;
		box-shadow: none;
	}
	label.btn.warning.active {
		background-color: #f0ad4e;
		border-color: #eea236;
		color: #ffffff;
		box-shadow: none;
	}
	label.btn.danger.active {
		background-color: #d9534f;
		border-color: #d43f3a;
		color: #ffffff;
		box-shadow: none;
	}
	label.btn.inverse.active {
		background-color: #222222;
		border-color: #111111;
		color: #ffffff;
		box-shadow: none;
	}
	label.btn.btn-default.btn-lg.toggle-checkbox.active {
		background: #ff7a17;
		color: white;
		border: 1px solid #ff7a17;
	}
	label.btn.btn-default.btn-lg.toggle-checkbox {
		background: #fff;
		color: #00000;
		border: 1px solid #A9A9A9;
		font-size: 16px;
		border-radius: 25px;
		padding: 5px 20px;
	}
	.form-group.develop {
		text-align: center;
	}

	.leck h4.modal-title {
		text-align: center;
		margin: 0 auto;
	}
	.leck .modal-header .close {
		padding: 0px;
		margin: 0px;
	}

	.mail_sec label.btn.btn-default.btn-lg.toggle-checkbox {
		border: none !important;
	}
	.mail_sec {
		text-align: center;
	}
	label.btn.btn-default.btn-lg.toggle-checkbox.active img {
		background: transparent;
		color: white;
		border: 0px solid transparent;
		filter: grayscale(100%) brightness(115%) sepia(90%) hue-rotate( 
			336deg
			) saturate(500%) contrast(0.9) !important;
	}
	.mail_sec label.btn.btn-default.btn-lg.toggle-checkbox.active {
		background: transparent;
		border: none !important;
	}
	.mail_sec label.btn.btn-default.btn-lg.toggle-checkbox{
		padding: 5px 35px;
	}

	.video-js{
		margin: auto;
	}
	img.crown_pts {
		width: 25px;
		position: absolute;
		z-index: 9;
		top: 15px;
		left: 400px;
	}

</style>
@endsection

@section('hero_section')
<div class="cors-det-lgn">
	<!-- ======= Hero Section ======= -->
	<!-- <div class="innovative" class="d-flex">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 pt-5 order-2 order-lg-1 mb-3">
					<h1></h1>
				</div>
			</div>
		</div>
	</div> --><!-- End Hero -->
@endsection

@section('content')
	@if($request->query('error')=='subscription')
	<div class="alert alert-danger">
		<a class="close" data-dismiss="alert">×</a>
		<span>Please subscribed a plan first to download this PDF.</span>
	</div>
	@endif

	@php if($course->image){$poster = asset('course/'. $course->image); }else{$poster =''; } @endphp
	<!-- <div class="sec_del mt-3" data-aos="fade-right"> -->
	<div class="container text-center mt-3" style="position: relative;">
		<div class="pull-right">
			<!-- <a href="javascript:;" class="btn btn-warning" onclick="history.back()">Back</a> -->
			<a href="{{route('ourCourses')}}" class="btn btn-warning">Back</a>
		</div>
	    @if($course->isFree==1)
			<img src="{{asset('front/assets/img/crown1.png')}}" class="crown_pts" alt="paid">
		@endif
		<video class="video-js vjs-default-skin vjs-big-play-centered"
			id="my-video"
			class="video-js"
			controls
			preload="none"
			autoplay="false"
			width="640"
			height="264"
			poster="{{$poster}}"
			data-setup='{ "controls": true, "autoplay": false, "preload": "none" }'
		>
			<source src="{{asset('course/'. $course->video)}}" type="video/mp4" />
			<!-- <source src="MY_VIDEO.webm" type="video/webm" /> -->
			<p class="vjs-no-js">
			  To view this video please enable JavaScript, and consider upgrading to a
			  web browser that
			  <!-- <a href="https://videojs.com/html5-video-support/" target="_blank"
				>supports HTML5 video</a
			  > -->
			</p>
		</video>
	</div>
	<!-- </div> --> 

	<div class="container">
		<div class="text-prt">
			<h2>{{$course->name}}</h2>
			<!-- <p>Brain Science course designed specially for Kids aspiring to learn English.</p> -->
			<div class="row">
				<div class="col-lg-7 col-md-6">
					<h3 class="">Overview</h3>
				</div>
				<div class="col-lg-5 col-md-6 text-right">
					@if(!empty(auth()->user()) && auth()->user()->role_id==3)
					@if(isset($course->pdf) && $course->pdf!='')
					@if($course->isFree==1)
					@if($userSubscription==1)
					<a href="{{asset('course') . '/' . $course->pdf}}" class="buttonDownload" target="_blank"><img src="{{asset('front/assets/img/download.svg')}}"> Download</a>
					@else
					<a href="{{route('courseDetails',[$course->id,'error'=>'subscription'])}}" class="buttonDownload"><img src="{{asset('front/assets/img/download.svg')}}"> Download</a>
					@endif
					@else
					<a href="{{asset('course') . '/' . $course->pdf}}" class="buttonDownload" target="_blank"><img src="{{asset('front/assets/img/download.svg')}}"> Download</a>
					@endif
					@endif
					<!-- <a href="#" class="start_quiz" data-toggle="modal" data-target=".bs-example-modal-new"> <img src="{{asset('front/assets/img/smiless.svg')}}"> Rate </a> -->
					@if(isset($getQuiz->id))
					<a href="{{route('getQuiz', $getQuiz->id)}}" class="start_quiz"><img src="{{asset('front/assets/img/puzzle-piece.svg')}}"> Certification Test</a>
					@endif
					@else
					<a href="#myModal" data-toggle="modal" class="buttonDownload"><img src="{{asset('front/assets/img/download.svg')}}"> Download</a>
					<a href="#myModal" data-toggle="modal" class="start_quiz"><img src="{{asset('front/assets/img/smiless.svg')}}"> Rate </a>
					<a href="#myModal" data-toggle="modal" class="start_quiz"><img src="{{asset('front/assets/img/puzzle-piece.svg')}}"> Certification Test</a>
					@endif
				</div>
			</div>

			<!-- Modal: begins -->
			<div class="modal fade bs-example-modal-new" style="padding-right: 0px;z-index: 99999;" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				<div class="modal-dialog leck">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">How was the lecture</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
						<div class="modal-body">
							<form action="{{route('rateByUser')}}" method="post">	
								<input type="hidden" name="_token" value="{{ csrf_token() }}" />
								<input type="hidden" name="courseId" value="{{$course->id}}">
								<input type="hidden" name="lessionId" value="0">
								<input type="hidden" name="topicId" value="0">
								<div class="body-message">
									<div class="brainywoods lecture">
										<div class="container">
											<div class="row">
												<div class="col-md-12">
													<div class="Process">
														<div class="mail_sec ">
															<div class="btn-group btn-group-toggle" data-toggle="buttons">
																<label class="btn btn-default btn-lg toggle-checkbox primary active">
																	<input type="radio" name="ratingType" onclick="Check();" style="display: none;" value="Sad" checked />
																	<img src="{{asset('front/assets/img/sad.svg')}}">
																</label>
																<label class="btn btn-default btn-lg toggle-checkbox primary">
																	<input type="radio" name="ratingType" onclick="Check();" style="display: none;" value="Normal" />
																	<img src="{{asset('front/assets/img/sceptic.svg')}}">
																</label>
																<label class="btn btn-default btn-lg toggle-checkbox primary">
																	<input type="radio" name="ratingType" onclick="Check();" style="display: none;" value="Happy" />
																	<img src="{{asset('front/assets/img/happy.svg')}}">
																</label>
															</div>
														</div>
														<div class="text_1">
															<h6>Sad to hear that. What went wrong?</h6>
														</div>
														<div class="text_2" style="display: none;">
															<h6>Where can we improve?</h6>
														</div>
														<div class="text_3" style="display: none;">
															<h6>Glad you liked it. What worked for you?</h6>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group develop" data-toggle="buttons">
									@if($ratingMessages)
									@foreach($ratingMessages as $key => $value)
									<label class="btn btn-default btn-lg toggle-checkbox primary">
										<input type="checkbox" name="ratingMessage[]" autocomplete="off" class="" style="display: none;" value="{{$value->message}}" />
										{{$value->message}}
									</label>
									@endforeach
									@endif
								</div>

								<textarea name="message" rows="4" class="form-control form-control-sm" style="border-radius: 5px;padding: 10px;" placeholder="Enter your feedback here"></textarea>
								<button type="submit" class="btn btn-primary w-100 mt-4"> Submit </button>
							</form>
						</div>

					</div>
				</div>
			</div>
			<!-- Modal: ends -->

			<div class="cntnt-csdet">
				<p>{!!$course->overview!!}</p>
				<div class="row">
					@if($courseFeatures)
					<div class="col-md-12 col-12">
						<h3 class="mt-1">What you will get</h3>
					</div>
					<ul class="mis_dels">
						@foreach($courseFeatures as $feature)
						<li>{{$feature->feature}}</li>
						@endforeach
					</ul>
					@endif
				</div>

				@php $lession_id=0; @endphp
				@if(count($lessions)>0)
				<div class="row">
					<div class="col-md-6 col-6">
						<h6>Lessons</h6>
					</div>
					<!-- <div class="col-md-6 col-6 text-right">
						<h6>Status</h6>
					</div> -->
				</div>
				<ul>
					@foreach($lessions as $key => $lession)
					@php if($key==0){$img='checked-org.svg';}else{$img='checked-gry.svg';}
					if($key==0){$lession_id=$lession->id;} @endphp
					<li><a href="{{route('lessionDetails', $lession->id)}}">{{$key+1}}. {{$lession->name}} <img src="{{asset('front/assets/img/'.$img)}}"></a></li>
					@endforeach
				</ul>
				@endif
			</div>
			<!-- @if($lession_id > 0)
			<div class="row">
				<div class="col-md-12 text-right">
					<a href="{{route('lessionDetails', $lession_id)}}" class="buy">Next Lesson <img src="{{asset('front/assets/img/rgt-dbl-aro.svg')}}"></a>
				</div>
			</div>
			@endif -->

			<div class="subscriptions pt-0" data-aos="fade-up">
				<div class="container">
					<div class="row">
						<div class="col-lg-7 col-md-6">
							<h3>FAQs</h3>
						</div>
					</div>
					<div class="mobile_sec">
						<div id="accordionExample" class="accordion">
							@if($courseFaqs)
							@foreach($courseFaqs as $key => $faq)
							<div class="card">
								<div id="heading{{$key}}" class="card-header">
									<h5 class="mb-0"><button type="button" data-toggle="collapse" data-target="#collapse{{$key}}" aria-expanded="true" aria-controls="collapse{{$key}}" class="btn btn-link btn-block text-left @if($key!=0)collapsed @endif">
										{{$faq->title}} </button></h5>
								</div>
								<div id="collapse{{$key}}" aria-labelledby="heading{{$key}}" data-parent="#accordionExample" class="fade collapse @if($key==0)show @endif" style="">
									<div class="card-body">
										<p>{!!$faq->contant!!}</p>
									</div>
								</div>
							</div>
							@endforeach
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
@section('javascript')
<script src="{{asset('front/assets/js/video.min.js')}}"></script>

<script>
	$(document).ready(function () {
		videos = document.querySelectorAll("video"); 
		for(video of videos) {
			video.pause(); 
			//video.controls = true
		}
	});

	function Check() {
		var ratingType = $("input[name='ratingType']:checked").val();
		if (ratingType == 'Sad') {
			$('.text_1').show();
			$('.text_2').hide();
			$('.text_3').hide();
		} else if (ratingType == 'Normal') {
			$('.text_1').hide();
			$('.text_2').show();
			$('.text_3').hide();
		} else {
			$('.text_1').hide();
			$('.text_2').hide();
			$('.text_3').show();
		}
	}
</script>
@endsection