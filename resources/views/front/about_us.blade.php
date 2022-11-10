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
	.slick-slide {
		height: auto;
	}
	.our_portfolio .slick-list.draggable {
	    padding: 0px !important;
	}

	.video-js{
		margin: auto;
	}
</style>

@endsection

@section('hero_section')
<!-- ======= Hero Section ======= -->
<div class="back_pht" class="d-flex align-items-center Learning more_se">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 pt-5 order-2 order-lg-1">
				<h1>{{$aboutus->title}}</h1>
				<div class="through_sec">
					<p><a href="#"> <img src="{{asset('front/assets/img/roud.svg')}}"> Stress Free Education  </a> </p>
					<p><a href="#"><img src="{{asset('front/assets/img/roud.svg')}}"> Brain Science Learning  </a> </p>
					<p><a href="#"><img src="{{asset('front/assets/img/roud.svg')}}"> Quality Learning </a> </p>
				</div>
			</div>
		</div>
	</div>
</section><!-- End Hero -->
@endsection

<!-- <div class="back_pht">

</div> -->

@section('content')
<div class="brainywoods relates">
	<div class="container">
		<h2>Brainywood's Process</h2>
		<div class="row">
			<div class="col-md-12">
				<p class="bt-sec">{!!$aboutus->content!!}</p>
				<div class="Process">
					<nav>
						<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
							<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"> <img src="{{asset('front/assets/img/organization.svg')}}"> <br> Organization</a>
							<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"> <img src="{{asset('front/assets/img/economy.svg')}}"> <br> Vision</a>
							<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false"> <img src="{{asset('front/assets/img/business.svg')}}"> <br> Mission</a>
							<a class="nav-item nav-link" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-controls="nav-about" aria-selected="false"><img src="{{asset('front/assets/img/process.svg')}}"> <br> Process</a>
						</div>
					</nav>
					<div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
						<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
							<h4>Organization</h4>
							<p>{!!$aboutus->organization!!}</p>
						</div>
						<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
							<h4>Vision</h4>
							<p>{!!$aboutus->vision!!}</p>
						</div>
						<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
							<h4>Mission</h4>
							<p>{!!$aboutus->mission!!}</p>
						</div>
						<div class="tab-pane fade" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
							<h4>Process</h4>
							<p>{!!$aboutus->process!!}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- <div class="persnal abt_vid">
	<div class="container mt-5">
		<iframe src="{{asset('upload/aboutus/'.$aboutus->video)}}" frameborder="0" controls="0" autoplay="0" allowfullscreen sandbox></iframe>
	</div>
</div> -->
@php if($aboutus->image){$poster = asset('upload/aboutus/'. $aboutus->image); }else{$poster =''; } @endphp
<div class="container text-center mt-3">
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
    <source src="{{asset('upload/aboutus/'. $aboutus->video)}}" type="video/mp4" />
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

<div class="interesting_fact" data-aos="fade-up">
	<div class="container">
		<h2>Interesting Facts</h2>
		<div class="row">
			@php $interesting_facts = json_decode($aboutus->interesting_facts, true); @endphp
			@if($interesting_facts)
			@foreach ($interesting_facts as $key => $value)
			<div class="col-lg-3 col-md-6 mt-3">
				<div class="box_1">
					<img src="{{asset('upload/aboutus/'.$value['fact_icon'])}}">
					<h3>{{$value['fact_title']}}</h3>
					<p>{{$value['fact_sub_title']}}</p>
				</div>
			</div>
			@endforeach
			@endif
		</div>
	</div>
</div>

<div class="our_portfolio" data-aos="zoom-in" data-aos-delay="100">
	<div class="container">
		<h2>Our Portfolio</h2>
		<div class="slick-slider mt-3">
			@if($firstPortfolios)
			@foreach($firstPortfolios as $key => $firstPort)
			<div class="element element-{{$key + 1}}">
				<div class="box_del">
					<img src="{{asset('upload/portfolios/'.$firstPort->image)}}">
					<h5>{{$firstPort->title}}</h5>
					<h6>{{$firstPort->sub_title}}</h6>
				</div>
			</div>
			@endforeach
			@endif
		</div>
		<div class="slick-slider mt-3">
			@if($secondPortfolios)
			@foreach($secondPortfolios as $key1 => $secondPort)
			<div class="element element-{{$key1 + 1}}">
				<div class="box_del">
					<img src="{{asset('upload/portfolios/'.$secondPort->image)}}">
					<h5>{{$secondPort->title}}</h5>
					<h6>{{$secondPort->sub_title}}</h6>
				</div>
			</div>
			@endforeach
			@endif
			<!-- <div class="element element-1">
				<div class="box_del">
					<img src="{{asset('front/assets/img/Naseeruddin.svg')}}">
					<h5>Naseeruddin Shah</h5>
				</div>
			</div>
			<div class="element element-2">
				<div class="box_del">
					<img src="{{asset('front/assets/img/Rn.svg')}}">
					<h5>R. N. Goel</h5>
				</div>
			</div>
			<div class="element element-3">
				<div class="box_del">
					<img src="{{asset('front/assets/img/ctime.svg')}}">
					<h5>C T Times</h5>
				</div>
			</div>
			<div class="element element-4">
				<div class="box_del">
					<img src="{{asset('front/assets/img/sushi.svg')}}">
					<h5>Sushil Gupta</h5>
				</div>
			</div>
			<div class="element element-5">
				<div class="box_del">
					<img src="{{asset('front/assets/img/brain.svg')}}">
					<h5>Brain Science Workshop</h5>
				</div>
			</div>
			<div class="element element-6">
				<div class="box_del">
					<img src="{{asset('front/assets/img/vinod.svg')}}">
					<h5>Vinod Sharma’s Profile</h5>
				</div>
			</div>
			<div class="element element-7">
				<div class="box_del">
					<img src="{{asset('front/assets/img/indi.svg')}}">
					<h5>Indian Record Holders</h5>
				</div>
			</div>
			<div class="element element-8">
				<div class="box_del">
					<img src="{{asset('front/assets/img/Naseeruddin.svg')}}">
					<h5>Asia Book of Records</h5>
				</div>
			</div> -->
		</div>
	</div>
</div>

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
				<section id="clients" class="clients testimon">
					<div class="container">
						<h5>{{$relate->title}}</h5>
						<div class="owl-carousel clients-carousel" data-aos="fade-up" data-aos-delay="100">
							@foreach($testimonials as $key => $testimonial)
							<div class="testimonial">
								<div class="row">
									<div class="col-lg-2 col-md-0"></div>
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
<script src="{{asset('front/assets/js/video.min.js')}}"></script>
<script type="text/javascript" src="{{asset('front/assets/js/slick.min.js')}}"></script>

<script>
	$(document).ready(function () {
		videos = document.querySelectorAll("video"); 
		for(video of videos) {
			video.pause(); 
			//video.controls = true
		}
	});
	
	$(".slick-slider").slick({
		slidesToShow: 4,
		slidesToScroll: 1,
		autoplay: true,
		autoplaySpeed: 1000,
		arrows:true,
		/* dots: true,
		arrows: true,*/
		responsive: [
		{
			breakpoint: 768,
			settings: {
				arrows: false,
				centerMode: true,
				centerPadding: '40px',
				slidesToShow: 2
			}
		},
		{
			breakpoint: 480,
			settings: {
				arrows: false,
				centerMode: true,
				centerPadding: '40px',
				slidesToShow: 1
			}
		}
		]
	});
</script>

@endsection