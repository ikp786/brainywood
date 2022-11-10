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

<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css" integrity="sha512-6lLUdeQ5uheMFbWm3CP271l14RsX1xtx+J5x2yeIDkkiBpeVTNhTqijME7GgRKKi6hCqovwCoBTlRBEC20M8Mg==" crossorigin="anonymous" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css" integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw==" crossorigin="anonymous" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.js" integrity="sha512-WNZwVebQjhSxEzwbettGuQgWxbpYdoLf7mH+25A7sfQbbxKeS5SQ9QBf97zOY4nOlwtksgDA/czSTmfj4DUEiQ==" crossorigin="anonymous"></script>
@endsection

@section('hero_section')
<!-- ======= Hero Section ======= -->
<div class="team_parts" class="d-flex align-items-center">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 pt-5 order-2 order-lg-1 mb-3">
				<h1>Team</h1>
				<!-- <h2>India’s Most Affordable Education Plan Let quality education reach to all users</h2> -->
			</div>
		</div>
	</div>
</div><!-- End Hero -->
@endsection


@section('content')

@if($departments)
@foreach($departments as $dept)
<div class="membership_plan whats mt-5" style="background-color:#F5F5F5;height: 420px;">
	<div class="container">
		<h2 style="color: #000;">{{$dept->title}}</h2>
		<div class="slick-slidern mt-3">
			@php
				$teamMembers = \App\Team::where("dept_id", $dept->id)->where("status", 1)->where('deleted', 0)->orderBy('id', 'DESC')->get();
			@endphp
			@if(count($teamMembers)>0)
			@foreach($teamMembers as $key => $member)
			@php
				if($member->linkdin!=''){$linkdin_url = $member->linkdin; }else{$linkdin_url = '#';}
				if($member->instagram!=''){$instagram_url = $member->instagram; }else{$instagram_url = '#';}
			@endphp
			<div class="element element-{{$key + 1}}">
				<div class="team-member">
					<div class="team-img">
						<img src="{{asset('upload/teams') . '/' . $member->image}}" alt="team member" class="img-responsive">
					</div>
					<div class="team-hover">
						<div class="desk">
							<h4>{{$member->name}}</h4>
							<p>{!!$member->about!!}</p>
						</div>
						<div class="s-link">
							<!-- <a href="#"><i class="fa fa-facebook"></i></a>
							<a href="#"><i class="fa fa-twitter"></i></a>
							<a href="#"><i class="fa fa-google-plus"></i></a> -->
							<a href="{{$linkdin_url}}" class="linkedin" target="_blank"><i class="bx bxl-linkedin"></i></a>
							<a href="mailto:{{$member->email_id}}"><i class="fa fa-envelope"></i></a>
							<a href="{{$instagram_url}}" target="_blank"><i style="font-size: 20px;vertical-align: middle;" class="bx bxl-instagram"></i></a>
						</div>
					</div>
				</div>
				<!-- <div class="team-title_s">
					<h5>{{$member->name}}</h5>
					<span>{{$member->position}}</span>
				</div> -->
			</div>
			@endforeach
			@else
			<div class="text-center">No Member Found!</div>
			@endif
		</div>
	</div>
</div>
@endforeach
@endif


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
				<a style="" href="#" class="">
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
<script type="text/javascript" src="{{asset('front/assets/js/slick.min.js')}}"></script>
<script type="text/javascript" src="js/slick.min.js"></script>

<script>
	$(".slick-slidern").slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		autoplay: true,
		autoplaySpeed: 2000,
		arrows:false,
		/* dots: false,*/
		responsive: [
		{
			breakpoint: 1024,
			settings: {
				slidesToShow: 2,
				slidesToScroll: 2,
				infinite: true,
				arrows:false,
				/* dots: true*/
			}
		},
		{
			breakpoint: 600,
			settings: {
				arrows:false,
				slidesToShow: 2,
				slidesToScroll: 2
			}
		},
		{
			breakpoint: 480,
			settings: {
				arrows:false,
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
 
@endsection