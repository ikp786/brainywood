@extends('layouts.front')
@section('meta_title')
{{$pagename}}
@endsection
@section('meta_description')
{{$pagename}}
@endsection

@section('hero_section')

<style type="text/css">
	.tp_part img{border-radius: 50%;}
</style>

<!-- ======= Hero Section ======= -->
<!-- <div class="profile_start">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 pt-5 order-2 order-lg-1 mb-3">
				<h1>{{$pagename}}</h1>
			</div>
		</div>
	</div>
</div> --><!-- End Hero -->
@endsection

@section('content')
<div class="pro_page">
	<div class="container">
		<div class="tp_part">
			@if($user->image!='')
			<!-- <img src="{{asset('upload/profile') . '/' . $user->image}}" onerror="this.onerror=null;this.src='{{asset('front/assets/img/pro.svg')}}';" alt="Profile Image"> -->
			<img src="{{asset('upload/profile') . '/' . $user->image}}" alt="Profile Image">
			@endif
			<h4>{{$user->name}}</h4>
			<!-- <p><a href="#"> Request Verification </a></p> -->
			<a href="{{route('myAccount')}}" class="views">Edit</a>
		</div>
		<form>
			<div class="row">
				<div class="col-lg-12 col-md-12 form-line">
					<div class="row">
					<div class="form-group col-md-6">
						<label for="name">Full Name</label>
						<input type="text" class="form-control" placeholder="Full Name" value="{{$user->name}}" readonly>
					</div>
					<div class="form-group col-md-6">
						<label for="dob">DOB</label>
						<input type="text" class="form-control" placeholder="DOB" value="{{$user->dob}}" readonly>
					</div>  
					<div class="form-group col-md-6">
						<label for="gender">Gender</label>
						<input type="text" class="form-control" placeholder="Gender" value="{{$user->gender}}" readonly>
					</div>
					<div class="form-group col-md-6">
						<label for="phone">Mobile Number</label>
						<input type="text" class="form-control" placeholder="Mobile Number" value="{{$user->phone}}" readonly>
					</div>
					<div class="form-group col-md-6">
						<label for="email">Email Address</label>
						<input type="text" class="form-control" placeholder="Email Address" value="{{$user->email}}" readonly>
					</div>
					<div class="form-group col-md-6">
						<label for="class_name">Class Name</label>
						<input type="text" class="form-control" placeholder="Class Name" value="{{$user->class_name}}" readonly>
					</div>
					<div class="form-group col-md-6">
						<label for="school_college">School / College Name</label>
						<input type="text" class="form-control" placeholder="School / College Name" value="{{$user->school_college}}" readonly>
					</div>
					<div class="form-group col-md-6">
						<label for="city">Town / City</label>
						<input type="text" class="form-control" placeholder="Town / City" value="{{$user->city}}" readonly>
					</div>
				</div>
					<!-- <div class="form-group">
						<label for="exampleInputEmail">WC Billing state</label>
						<br>
						<select class="" id="sel1" name="country">
							<option>Rajasthan</option>
							<option value="1">Haryana</option>
						</select>
					</div>
					<div class="form-group">
						<label for="exampleInputEmail">My Points</label>
						<input type="text" class="form-control" id="exampleInputEmail" placeholder="55 Points" value="{{$user->name}}" readonly>
					</div> -->
				</div>
			</div>
		</form>
	</div>
</div>

@endsection
