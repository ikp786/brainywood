@extends('layouts.front')
@section('meta_title')
{{$pagename}}
@endsection
@section('meta_description')
{{$pagename}}
@endsection
@section('head')
<link href="{{asset('front/assets/css/video-js.css')}}" rel="stylesheet" />

@endsection

@section('hero_section')
<!-- ======= Hero Section ======= -->
<!-- <div class="live_class" class="d-flex align-items-center Learning">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h1>{{$pagename}}</h1>
				<h2>Drawing is not a talent. It's a skill anyone can learn.</h2>
			</div>
		</div>
	</div>
</div> --><!-- End Hero -->
@endsection

<style type="text/css">
	[data-aos=fade-up] {
		transform: translate3d(0,10px,0)  !important;
		opacity: 1 !important;
	}

	div#my-video {
		height: 30.5em;
		width: 100%;
	}
	img.crown_pt {
		width: 30px;
		position: absolute;
		z-index: 9999;
		left: 30px;
		top: 15px;
	}
</style>

@section('content')
<div class="ask_question upcome">
	<div class="container mt-5">
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" data-toggle="tab" href="#pastClass">Past</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#liveClass">Live</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#upcomingClass">Live Upcoming</a>
			</li>
		</ul>
		<!-- Tab panes -->
		<div class="tab-content">

			<div id="pastClass" class="container tab-pane active"><br>
				<div class="container">
					@if(count($pastClasses)>0)
					<div class="row">
						@php $video_url = ''; $paid_cls = ''; @endphp
						@foreach($pastClasses as $key => $past)
						@php $total_interest = \App\LiveclassNotify::where("class_id", $past->id)->count(); @endphp
						<div class="col-lg-3 col-md-6 mt-3 mb-3">
							@if($past->isFree==1)
								<img src="{{asset('front/assets/img/crown1.png')}}" class="crown_pt" alt="paid">
							@endif
							<div class="discussion">
								@if($past->video!='')
									@if($past->isFree==1)
									@if($userSubscription==1)
									@php $video_url = asset('upload/liveclasses/'. $past->video); @endphp
									@else
									@php
									$video_url = '';
									$paid_cls = 'paid_cls';
									@endphp
									@endif
									@else
									@php $video_url = asset('upload/liveclasses/'. $past->video); $paid_cls = ''; @endphp
									@endif
									<!-- <div class="embed-responsive embed-responsive-4by3">
										<iframe class="embed-responsive-item" src="{{asset('upload/liveclasses') . '/' . $past->video}}" title="Video player" frameborder="0" controls="0" autoplay="0" allowfullscreen sandbox></iframe>
									</div> -->
									@php if($past->image){$poster = asset('upload/liveclasses/'. $past->image); }else{$poster = ''; } @endphp
									<video class="video-js vjs-default-skin vjs-big-play-centered {{$paid_cls}}"
										id="my-video"
										class="video-js"
										controls
										preload="none"
										autoplay="false"
										width="255"
										height="220"
										poster="{{$poster}}"
										data-setup='{ "controls": true, "autoplay": false, "preload": "none" }'
									>
										<source src="{{$video_url}}" type="video/mp4" />
										<!-- <source src="MY_VIDEO.webm" type="video/webm" /> -->
										<p class="vjs-no-js">
											To view this video please enable JavaScript, and consider upgrading to a web browser that
											<!-- <a href="https://videojs.com/html5-video-support/" target="_blank" >supports HTML5 video</a> -->
										</p>
									</video>
								@else
									<img src="{{asset('upload/liveclasses') . '/' . $past->image}}" onerror="this.onerror=null;this.src='{{asset('front/assets/img/levels.svg')}}';" class="img-fluid">
								@endif
								<div class="bot-part">
									<div class="button-area">
										<ul>
											<li><a href="#">{{$past->subject}} | </a></li>
											<li><a href="#">{{$total_interest}} Intersted</a></li>
										</ul>
									</div>
									<h4>{{$past->title}}</h4>
									<span>{{date('Y-m-d h:i A', strtotime($past->class_time))}}</span>
									<div class="button-areaed mt-3">
										<ul>
											<!-- <li><a class="active" href="#">45 mins </a></li> -->
											<li><a href="#"> By: {{$past->user->name}}</a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						@endforeach
					</div>
					@else
					<div class="mt-5 text-center">No Classes available!</div>
					@endif
				</div>
			</div>

			<div id="liveClass" class="container tab-pane fade show">
				<div class="container">
					@if(count($liveClasses)>0)
					<div class="row">
						@foreach($liveClasses as $key => $live)
						@php $total_interest = \App\LiveclassNotify::where("class_id", $live->id)->count(); @endphp
						<div class="col-lg-3 col-md-6 mt-5 ">
							@if($live->isFree==1)
								<img src="{{asset('front/assets/img/crown1.png')}}" class="crown_pt" alt="paid">
							@endif
							<div class="discussion">
								<img src="{{asset('upload/liveclasses') . '/' . $live->image}}" onerror="this.onerror=null;this.src='{{asset('front/assets/img/levels.svg')}}';" class="img-fluid">
								<div class="bot-part">
									<a class="live_btn" href="#">Live</a>
									<div class="button-area">
									
										<ul>
											<li><a href="#">{{$live->subject}} | </a></li>
											<li><a href="#">{{$total_interest}} Intersted</a></li>
										</ul>
									</div>
									<h4>{{$live->title}}</h4>
									<span>{{date('Y-m-d h:i A', strtotime($live->class_time))}}</span>
									<div class="button-areaed mt-3">
										<ul>
											<!-- <li><a href="#" class="active">45 mins </a></li> -->
											<li><a href="#"> By: {{$live->user->name}}</a></li>
											<li>
												@if($live->isFree==1)
												@if($userSubscription==1)
												<a href="<?php  echo url('/'); ?>/public/zoom/CDN?meeting_number={{$live->meeting_id}}&meeting_pwd={{$live->pass_code}}" class="notif">Join Now</a>
												@else
												<a href="{{route('liveClasses',['error'=>'subscription'])}}" class="notif">Join Now</a>
												@endif
												@else
												<a href="<?php  echo url('/'); ?>/public/zoom/CDN?meeting_number={{$live->meeting_id}}&meeting_pwd={{$live->pass_code}}" class="notif">Join Now</a>
												@endif
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						@endforeach
					</div>
					@else
					<div class="mt-5 text-center">No Classes available!</div>
					@endif
				</div>
			</div>

			<div id="upcomingClass" class="container tab-pane fade show">
				<div class="container">
					@if(count($upcomingClasses)>0)
					<div class="row">
						@foreach($upcomingClasses as $key => $upcoming)
						@php $total_interest = \App\LiveclassNotify::where("class_id", $upcoming->id)->count(); @endphp
						<div class="col-lg-3 col-md-6 mt-5">
							@if($upcoming->isFree==1)
								<img src="{{asset('front/assets/img/crown1.png')}}" class="crown_pt" alt="paid">
							@endif
							<div class="discussion">
								<img src="{{asset('upload/liveclasses') . '/' . $upcoming->image}}" onerror="this.onerror=null;this.src='{{asset('front/assets/img/levels.svg')}}';" class="img-fluid">
								<div class="bot-part">
									<!-- <a href="#" class="live_btn">Live</a> -->
									<div class="button-area">
										<ul>
											<li><a href="#">{{$upcoming->subject}} | </a></li>
											<li><a href="#">{{$total_interest}} Intersted</a></li>
										</ul>
									</div>
									<h4>{{$upcoming->title}}</h4>
									<span>{{date('Y-m-d h:i A', strtotime($upcoming->class_time))}}</span>
									<div class="button-areaed mt-3">
										<ul>
											<!-- <li><a href="#" class="active">45 mins </a></li> -->
											<li><a href="#"> By: {{$upcoming->user->name}}</a></li>
											<li>
												@if($upcoming->isFree==1)
												@if($userSubscription==1)
												<a href="javascript:;" class="notif notify_me" data-upcoming_class_id="{{$upcoming->id}}"> <img style="width: 15px;" src="{{asset('front/assets/img/notification-bell.svg')}}"> Notify Me</a>
												@else
												<a href="{{route('liveClasses',['error'=>'subscription'])}}" class="notif"> <img style="width: 15px;" src="{{asset('front/assets/img/notification-bell.svg')}}"> Notify Me</a>
												@endif
												@else
												<a href="javascript:;" class="notif notify_me" data-upcoming_class_id="{{$upcoming->id}}"> <img style="width: 15px;" src="{{asset('front/assets/img/notification-bell.svg')}}"> Notify Me</a>
												@endif
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						@endforeach
					</div>
					@else
					<div class="mt-5 text-center">No Classes available!</div>
					@endif
				</div>
			</div>

		</div>
	</div>
</div>

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

@endsection
@section('javascript')
<script src="{{asset('front/assets/js/video.min.js')}}"></script>

<script type="text/javascript">
	$(document).ready(function () {
		videos = document.querySelectorAll("video"); 
		for(video of videos) {
			video.pause(); 
			//video.controls = true
		}
	});
	
	$(document).ready(function () {
		$('.notify_me').click(function(){
			var classId = $(this).data("upcoming_class_id");
			//alert(classId);
			if(classId != ''){
				//$("#plan_id").val(planId);
				$.ajax({
					url:"{{route('notify_me')}}",
					method:"POST",
					data:{ _token:"{{ csrf_token() }}", classId:classId },
					success: function(result){
						if(result==='Done'){
							swal(
								"Success",
								"Your Class Request Added Successfully.",
								"success"
							)
						}else{
							swal(
								"Error!",
								result,
								"error"
							)
						}
						/*setTimeout(function(){
							//console.log("Hello World");
							window.location.href = "{{route('liveClasses')}}";
						}, 8000);*/
					}
				});
			}
		});

	 var body = document.body;
	 body.classList.add("live_call");

	});
</script>
<script type="text/javascript">
	AOS.init({
  duration: 0,
})

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