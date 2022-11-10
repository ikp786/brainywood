@extends('layouts.front')
@section('meta_title')
{{$pagename}}
@endsection
@section('meta_description')
{{$pagename}}
@endsection

@section('hero_section')
<!-- ======= Hero Section ======= -->
<div class="profile_start" class="d-flex align-items-center Learning">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 pt-5 order-2 order-lg-1 mb-3">
				<h1>{{$pagename}}</h1>
			</div>
		</div>
	</div>
</div><!-- End Hero -->
@endsection

@section('content')
<div class="maps">
	<img src="{{asset('front/assets/img/map.png')}}">
</div>

<div class="get_touch" data-aos="zoom-in" data-aos-delay="100">
	<div class="container">
		<h2>Get In Touch</h2>
		<div class="row">
			<div class="col-lg-4 mt-3">
				<div class="phone">
					<img src="{{asset('front/assets/img/phone-receiver.svg')}}">
					<h3>PHONE</h3>
					<p>FOR FRANCHISE PARTNER <br>ENQUIRY: +919950368500</p>
				</div>
			</div>
			<div class="col-lg-4 mt-3">
				<div class="email">
					<img src="{{asset('front/assets/img/mail.png')}}">
					<h3>EMAIL</h3>
					<p>CRMBRAINYWOOD@GMAIL.COM
					VEDICBRAINSOLUTIONS@GMAIL.COM</p>
				</div>
			</div>
			<div class="col-lg-4 mt-3">
				<div class="address">
					<img src="{{asset('front/assets/img/phone-receiver.png')}}">
					<h3>ADDRESS</h3>
					<p>NEAR 9 NO. PETROL PUMP, NASIRABAD ROAD, GOPALGANJ, NAGRA, AJMER(305001)</p>
				</div>
			</div>
		</div>
	</div>
</div>

<section id="contact">
	<div class="container">
		<h2>Send Us A Message</h2>
		<form name="contactfrm" action="{{route('postContact')}}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<div class="row">
				<div class="col-md-6 form-line">
					<!-- <div class="form-group">
						<label for="name">Your name</label>
						<input type="text" name="name" class="form-control" value="@if(!empty(auth()->user())){{auth()->user()->name}}@else{{old('name')}}@endif">
					</div>
					<div class="form-group">
						<label for="phone">Phone Number</label>
						<input type="tel" name="phone" class="form-control" maxlength="10" value="@if(!empty(auth()->user())){{auth()->user()->phone}}@else{{old('phone')}}@endif">
					</div>  
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" name="email" class="form-control" value="@if(!empty(auth()->user())){{auth()->user()->email}}@else{{old('email')}}@endif">
					</div> -->
					<div class="form-group">
						<label for="name">Your name</label>
						<input type="text" name="name" class="form-control" value="{{old('name')}}" required>
					</div>
					<div class="form-group">
						<label for="phone">Phone Number</label>
						<input type="tel" name="phone" class="form-control" maxlength="10" value="{{old('phone')}}" required>
					</div>  
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" name="email" class="form-control" value="{{old('email')}}" required>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="message">Message</label>
						<textarea name="message" class="form-control" required>{!!old('message')!!}</textarea>
					</div>
				</div>
			</div>
			<button type="submit" class="btn btn-default submit"> Submit</button>
		</form>
	</div>
</section>

@endsection