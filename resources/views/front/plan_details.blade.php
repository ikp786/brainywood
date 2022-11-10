@inject('request', 'Illuminate\Http\Request')
@extends('layouts.front')
@section('meta_title')
{{$pagename}}
@endsection
@section('meta_description')
{{$pagename}}
@endsection
@section('head')
<link href="https://vjs.zencdn.net/7.11.4/video-js.css" rel="stylesheet" />

<style type="text/css">
	.pri_des h2 {
		padding-top: 10px;
		text-align: left;
		font-size: 25px;
		line-height: 36px;

	}

	.video-js{
		margin: auto;
	}
</style>
@endsection

@section('hero_section')
<!-- ======= Hero Section ======= -->
<!-- <div class="innovative pri_ban profile_start" class="d-flex align-items-center Learning Affordable">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 pt-5 order-2 order-lg-1 mb-3">
				<h1>Pricing</h1>
				<h2>India’s Most Affordable Education Plan Let quality education reach to all users</h2>
			</div>
		</div>
	</div>
</div> -->
<!-- End Hero -->
@endsection

<!-- <div class="back_phts">

</div> -->

@section('content')
<!-- <div class="plan mt-5" data-aos="fade-right">
	<div class="container">
		<img src="{{asset('front/assets/img/pla.png')}}" class="w-100">
	</div>
</div> -->

<div class="membership_plan" data-aos="fade-up">
	<div class="container">
		<h2>Our Membership plans</h2>
		<div class="row">
			<div class="col-md-6">
				@if($subscription->video)
					@php if($subscription->image){$poster = asset('upload/subscriptions/'. $subscription->image); }else{$poster =''; } @endphp
					<video class="video-js vjs-default-skin vjs-big-play-centered"
						id="my-video"
						class="video-js"
						controls
						preload="none"
						autoplay="false"
						width="440"
						height="264"
						poster="{{$poster}}"
						data-setup='{ "controls": true, "autoplay": false, "preload": "none" }'
					>
						<source src="{{asset('upload/subscriptions/'. $subscription->video)}}" type="video/mp4" />
						<!-- <source src="MY_VIDEO.webm" type="video/webm" /> -->
						<p class="vjs-no-js">
							To view this video please enable JavaScript, and consider upgrading to a web browser that
							<!-- <a href="https://videojs.com/html5-video-support/" target="_blank" >supports HTML5 video</a> -->
						</p>
					</video>
				@elseif($subscription->image)
					<img src="{{asset('upload/subscriptions/'.$subscription->image)}}" class="w-100">
				@else
					<!-- <img src="{{asset('front/assets/img/img2.png')}}" class="w-100"> -->
				@endif
			</div>
			<div class="col-md-6 pri_des">
				<h2>{{$subscription->name}}</h2>
				<h3>{{$subscription->month}} Month Plan<br>
				<span>Rs.</span>{{$subscription->price}}<span style="font-size:small;">(inclusive of all taxes)</span></h3>
				<hr>
				<h4>Description of {{$subscription->name}}</h4>
				<p>{!!$subscription->description!!}</p>
				@if(!empty(auth()->user()) && auth()->user()->role_id==3)
					<div class="apply_msg"></div>
					<a href="javascript:;" class="apply_coupon pull-right">Apply Coupon?</a>
					<div class="apply_coupon_frm" style="display: none;">
						<input type="hidden" name="userId" id="userId" value="@if(!empty(auth()->user())){{auth()->user()->id}}@else{{'0'}}@endif">
						<input type="hidden" name="subscriptionId" id="subscriptionId" value="{{$subscription->id}}">
						<input type="text" name="coupon_code" id="coupon_code" class="form-control">
						<button type="submit" name="submit" class="btn btn-warning apply_code">Apply</button>
					</div>
					@php
						if($request->session()->has('planId') && $request->session()->get('planId')==$subscription->id){
							if($request->session()->has('payableAmt')){
								$payableAmt = $request->session()->get('payableAmt');
							}else{
								$payableAmt = $subscription->price;
							}
						}else{
							$payableAmt = $subscription->price;
						}
					@endphp
					@if($userSubscription==1)
						<a href="javascript:;" class="buttonDownload already_have"> Buy Now</a>
					@else
						<form action="{!!route('payment',$subscription->id)!!}" method="POST">
							<input type="hidden" name="_token" value="{!!csrf_token()!!}">
							<script src="https://checkout.razorpay.com/v1/checkout.js"
									data-key="{{ env('RAZOR_KEY') }}"
									data-amount="{{($payableAmt*100)}}"
									data-buttontext="Buy Now"
									data-name="Brainywood"
									data-description="Subscription Plan Payment"
									data-image="{{asset('front/assets/img/web-logo.png')}}"
									data-prefill.name="@if(!empty(auth()->user())){{auth()->user()->name}}@else{{'name'}}@endif"
									data-prefill.email="@if(!empty(auth()->user())){{auth()->user()->email}}@else{{'email'}}@endif"
									data-theme.color="#ff7529">
							</script>
						</form>
					@endif
				@else
					<a href="#myModal" data-toggle="modal" class="buttonDownload"> Buy Now</a>
				@endif
			</div>
		</div>

		<div class="subscriptions" data-aos="fade-up">
			<div class="container">
				<div class="row">
					<div class="col-lg-7 col-md-6">
						<h3>FAQs</h3>
					</div>
				</div>
				<div class="mobile_sec">
					<div id="accordionExample" class="accordion">
						@php $faqs = json_decode($subscription->faqs, true); @endphp
						@if($faqs)
						@foreach ($faqs as $key => $value)
						<div class="card">
							<div id="heading{{$key}}" class="card-header">
								<h5 class="mb-0"><button type="button" data-toggle="collapse" data-target="#collapse{{$key}}" aria-expanded="true" aria-controls="collapseOne" class="btn btn-link btn-block text-left @if($key!=0)collapsed @endif">
									{{$value['question']}} </button></h5>
							</div>
							<div id="collapse{{$key}}" aria-labelledby="heading{{$key}}" data-parent="#accordionExample" class="fade collapse @if($key==0)show @endif" style="">
								<div class="card-body">
									<p>{!!$value['answer']!!}</p>
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
<script src="https://vjs.zencdn.net/7.11.4/video.min.js"></script>

<script type="text/javascript">
	$(document).ready(function () {
		$('.apply_coupon').click(function(){
			$('.apply_coupon_frm').toggle();
		});

		$('.apply_code').click(function(){
			var userId = $("#userId").val();
			var subscriptionId = $("#subscriptionId").val();
			var coupon_code = $("#coupon_code").val();
			//alert(coupon_code);
			if(coupon_code != ''){
				//$("#plan_id").val(planId);
				var _token = $('meta[name="csrf-token"]').attr('content');
				$.ajax({
					url:"{{route('apply_coupon_code')}}",
					method:"POST",
					data:{ _token:"{{ csrf_token() }}", userId:userId, subscriptionId:subscriptionId, couponCode:coupon_code },
					success: function(result){
						if(result==='Done'){
							//$(".apply_msg").html('Coupon code applied successfully.');
							swal(
								"Success",
								"Coupon code applied successfully, click on Buy Now button to payment initiate.",
								"success"
							)
						}else if(result==='Activated'){
							//$(".apply_msg").html('Subscription Plan Activated Successfully.');
							swal(
								"Success",
								"Subscription Plan Activated Successfully.",
								"success"
							)
						}else{
							//$(".apply_msg").html(result);
							swal(
								"Error!",
								result,
								"error"
							)
						}
						setTimeout(function(){
							//console.log("Hello World");
							window.location.href = "{{route('planDetails', $subscription->id)}}";
						}, 8000);
					}
				});
			}
		});
		
		$('.already_have').click(function(){
			swal(
				"Success",
				"You have already subscribed a plan, after expired you can take new subscription!",
				"success"
			)
		});

		videos = document.querySelectorAll("video"); 
		for(video of videos) {
			video.pause(); 
			//video.controls = true
		}
	});
</script>
@endsection