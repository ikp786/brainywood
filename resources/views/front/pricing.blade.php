@extends('layouts.front')
@section('meta_title')
{{$pagename}}
@endsection
@section('meta_description')
{{$pagename}}
@endsection

@section('hero_section')
<!-- ======= Hero Section ======= -->
<div class="innovative pri_ban profile_start" class="d-flex align-items-center Learning Affordable">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 pt-5 order-2 order-lg-1 mb-3">
				<h1>Pricing</h1>
				<h2>India’s Most Affordable Education Plan Let quality education reach to all users</h2>
			</div>
		</div>
	</div>
</div><!-- End Hero -->
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
		<div class="row" style="justify-content:center;">
			@if($subscriptions)
			@foreach($subscriptions as $key => $subscription)
			<div class="col-lg-3 col-md-6 mt-3 mb-3">
				<div class="box_plan">
					<h6>{{$subscription->name}}<br>{{$subscription->month}} Month Plan</h6>
					<h1><span>Rs.</span>{{$subscription->price}}</h1>
					<p>{{substr($subscription->description, 0, 50)}}</p>
					<!-- <a class="buy" href="">Buy this Plan</a> -->
					<!-- <a href="#" class="View_s" data-toggle="modal" data-target="#exampleModal_s{{$key}}"> View </a> -->
					<!-- <a href="#" class="View_s" data-toggle="modal" data-target="#basicModal"> View </a> -->
					<a href="{{route('planDetails', $subscription->id)}}" class="View_s"> View </a>
					<!-- <a href="#" class="View_s plan_details" data-plan_id="{{$subscription->id}}"> View </a> -->
				</div>
			</div>
			@endforeach
			@endif
		</div>
	</div>
</div>

<!-- ======= FAQs Section ======= -->
@if($subscriptions)
<div class="subscriptions" data-aos="fade-up">
	<div class="container">
		<div class="row">
			<div class="col-lg-7 col-md-6">
				<h3>FAQs</h3>
			</div>
		</div>
		<div class="mobile_sec">
			<div id="accordionExample" class="accordion">
				@foreach($subscriptions as $key => $subscription)
				@php $faqs = json_decode($subscription->faqs, true); @endphp
				@if($faqs)
				@foreach ($faqs as $key1 => $value)
				<div class="card">
					<div id="heading{{$key.$key1}}" class="card-header">
						<h5 class="mb-0"><button type="button" data-toggle="collapse" data-target="#collapse{{$key.$key1}}" aria-expanded="true" aria-controls="collapseOne" class="btn btn-link btn-block text-left @if($key1!=0)collapsed @endif">
							{{$value['question']}} </button></h5>
					</div>
					<div id="collapse{{$key.$key1}}" aria-labelledby="heading{{$key.$key1}}" data-parent="#accordionExample" class="fade collapse @if($key.$key1==00)show @endif" style="">
						<div class="card-body">
							<p>{!!$value['answer']!!}</p>
						</div>
					</div>
				</div>
				@endforeach
				@endif
				@endforeach
			</div>
		</div>
	</div>
</div>
@endif
<!-- ======= End FAQs ======= -->

<!-- <div class="row mb-4">
	<div class="col text-center">
		<h3>The Basic Modal</h3>
		<a href="#" class="btn btn-lg btn-success" data-toggle="modal" data-target="#basicModal">Click to open Modal</a>
	</div>
</div> -->						

<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
	<div class="modal-dialog regis_ters">
		<div class="modal-content ">
			<div class="modal-header">
				<!-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> -->
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="plan_data"></div>
				<div class="container">
					<div class="row">
						<div class="col-md-6">
							<img src="{{asset('course/img2.png')}}" class="w-100">
						</div>
						<div class="col-md-6 pri_des">
							<h2>Little Birbal Membership</h2>
							<h3>6 Month Plan<br>
							<span>Rs.</span>3999<span style="font-size:small;">(inclusive of all taxes)</span></h3>
							<hr>
							<h4>Description of Little Birbal Membership</h4>
							<p>India's most affordable education plan is just one step away.</p>
							<a href="#myModal" data-toggle="modal" class="buttonDownload"> Buy Now</a>
							<!-- <button type="button" class="btn btn-primary">Buy this Plan</button> -->
						</div>
					</div>
				</div>

				<div class="subscriptions aos-init aos-animate" data-aos="fade-up">
					<div class="container">
						<div class="mobile_sec">
							<div id="accordionExample" class="accordion">
								<div class="card">
									<div id="headingOnes" class="card-header">
										<h5 class="mb-0"><button type="button" data-toggle="collapse" data-target="#collapseOnes" aria-expanded="true" aria-controls="collapseOnes" class="btn btn-link btn-block text-left collapsed">
											Why do we use it? </button></h5>
									</div>
									<div id="collapseOnes" aria-labelledby="headingOnes" data-parent="#accordionExample" class="fade collapse " style="">
										<div class="card-body">
											<p>All successful bidders can confirm their winning bid by checking the “abb”. In addition, all successful bidders will receive an email notifying them of their winning bid after the auction closes.</p>
										</div>
									</div>
								</div>
								<div class="card">
									<div id="headingTwos" class="card-header">
										<h5 class="mb-0"><button type="button" data-toggle="collapse" data-target="#collapseTwos" aria-expanded="false" aria-controls="collapseTwos" class="btn btn-link btn-block text-left ">How can i setup my user profile?</button></h5>
									</div>
									<div id="collapseTwos" aria-labelledby="headingTwos" data-parent="#accordionExample" class="fade collapse show" style="">
										<div class="card-body">
											<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum</p>
										</div>
									</div>
								</div>
								<div class="card">
									<div id="headingThrees" class="card-header">
										<h5 class="mb-0"><button type="button" data-toggle="collapse" data-target="#collapseThrees" aria-expanded="false" aria-controls="collapseThrees" class="btn btn-link collapsed btn-block text-left">Where does it come from?</button></h5>
									</div>
									<div id="collapseThrees" aria-labelledby="headingThrees" data-parent="#accordionExample" class="collapse fade">
										<div class="card-body">
											<p>All successful bidders can confirm their winning bid by checking the “abb”. In addition, all successful bidders will receive an email notifying them of their winning bid after the auction closes.</p>
										</div>
									</div>
								</div>
								<div class="card">
									<div id="headingFours" class="card-header">
										<h5 class="mb-0"><button type="button" data-toggle="collapse" data-target="#collapseFours" aria-expanded="false" aria-controls="collapseFours" class="btn btn-link collapsed btn-block text-left">
										Where can I get some? </button></h5>
									</div>
									<div id="collapseFours" aria-labelledby="headingFours" data-parent="#accordionExample" class="collapse fade">
										<div class="card-body">
											<p>All successful bidders can confirm their winning bid by checking the “abb”. In addition, all successful bidders will receive an email notifying them of their winning bid after the auction closes.</p>
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

<style type="text/css">
	/*.modal-backdrop{display: none;
	}*/
	div#exampleModal_s0 {
		overflow-y: hidden;
	}
	.modal-dialog.regis_ters .modal-body {
		overflow-y: scroll;
		height: 430px;
	}
	.pri_des h2 {
		padding-top: 10px;
		text-align: left;
		font-size: 25px;
		line-height: 36px;

	}

</style>

@endsection

@section('javascript')
<script type="text/javascript">
	$(document).ready(function () {
		$('.plan_details').click(function(){
			var planId = $(this).data("plan_id");
			alert(planId);
			if(planId != ''){
				$("#plan_id").val(planId);
				var _token = $('meta[name="csrf-token"]').attr('content');
				$.ajax({
					url:"get_plan_by_id",
					method:"POST",
					data:{ _token:"{{ csrf_token() }}", plan_id:planId },
					success: function(result){
						$(".plan_data").html(result);
						$('#basicModal').modal('show');
					}
				});
			}
		});
	});
</script>
@endsection