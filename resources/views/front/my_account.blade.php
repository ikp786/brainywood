@inject('request', 'Illuminate\Http\Request')
@extends('layouts.front')
@section('meta_title')
{{$pagename}}
@endsection
@section('meta_description')
{{$pagename}}
@endsection
@section('head')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<style type="text/css">
	.side_bars img{border-radius: 50%;}

	.disabled {
		pointer-events: none;
		cursor: default;
		opacity: 0.6;
	}
</style>
@endsection

@section('hero_section')
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
<div class="accout_start">
	<div class="container">
		<div class="vertical-tabs">
			<div class="row"> 
				<div class="col-lg-3 col-md-12 mt-5">
					<div class="side_bars">
						@if($user->image!='')
						<!-- <img src="{{asset('upload/profile') . '/' . $user->image}}" onerror="this.onerror=null;this.src='{{asset('front/assets/img/pro.svg')}}';" alt="Profile Image" style="width: 50%;"> <br><br> -->
						<img src="{{asset('upload/profile') . '/' . $user->image}}" alt="Profile Image" style="width: 50%;"> <br><br>
						@endif
						<a href="#imageModal" data-toggle="modal" class=""> 
							<i style="color: #ff7a17;" class="fa fa-pencil-square-o"></i> </a>
						<h4>{{$user->name}}</h4>
						<p><a href="javascript:;"> {{$user->email}} </a></p>
						<a href="{{route('myProfile')}}" class="views">View</a>
						<ul class="nav nav-tabs" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" data-toggle="tab" href="#pag1" role="tab" aria-controls="home">Account</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#pag2" role="tab" aria-controls="profile">Change Password</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#pag3" role="tab" aria-controls="messages">User Info</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#pag4" role="tab" aria-controls="settings">Subscriptions</a>
							</li>
							<!-- <li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#pag5" role="tab" aria-controls="settings">Registered Courses</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#pag7" role="tab" aria-controls="settings">Downloads</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#pag8" role="tab" aria-controls="settings">Inquiries</a>
							</li> -->
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#pag6" role="tab" aria-controls="settings">Contact Us</a>
							</li>
							<li class="nav-item">
								<a href="#logout" class="nav-link" onclick="$('#logout').submit();">Logout</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="col-lg-9 col-md-12 mt-5">
					<div class="detail_section">
						<div class="tab-content">

							<div class="tab-pane active" id="pag1" role="tabpanel">
								<div class="sv-tab-panel one">
									<form action="{{route('updateAccount')}}" method="post">
										<input type="hidden" name="_token" value="{{ csrf_token() }}" />
										<h3>Account</h3>
										<!-- <a class="rewuests" href="#"> Request Verification </a> -->
										<div class="row">
											<div class="col-lg-6 col-md-12 form-line">
												<!-- <div class="form-group">
													<label for="name">Full Name</label>
													<input type="text" name="name" class="form-control" placeholder="Full Name" value="{{$user->name}}">
												</div> -->
												<div class="form-group">
												<label for="phone">Mobile Number</label>
												 <a style="float: right;" href="#mobileModal" data-toggle="modal" class=""> 
												 <i style="color: #ff7a17;" class="fa fa-pencil-square-o"></i> </a>
													<input type="tel" name="phone" class="form-control" placeholder="Mobile Number" value="{{$user->phone}}" readonly>
												</div>
												<div class="form-group">
													<label for="telephone">Email Address</label>
													<a style="float: right;" href="#emailModal" data-toggle="modal" class=""> 
												 <i style="color: #ff7a17;" class="fa fa-pencil-square-o"></i> </a>
													<input type="email" name="email" class="form-control" placeholder="Email Address" value="{{$user->email}}" readonly>
												</div>
											</div>

											<!-- <div class="col-lg-6 col-md-12 form-line">
											</div> -->

										</div>
										<!-- <button type="submit" class="btn btn-default submit"> Update Account </button> -->
									</form>
								</div>
							</div>

							<div class="tab-pane" id="pag2" role="tabpanel">
								<div class="sv-tab-panel two">
									<form action="{{route('changePassword')}}" method="post">
										<input type="hidden" name="_token" value="{{ csrf_token() }}" />
										<h3>Change Password</h3>
										<div class="row">
											<div class="col-lg-6 col-md-12 form-line">
												<div class="form-group">
													<label for="current_password">Current Password</label>
													<input type="password" name="current_password" class="form-control" placeholder="Current Password">
												</div>
												<div class="form-group">
													<label for="new_password">New Password</label>
													<input type="password" name="new_password" class="form-control" placeholder="New Password">
												</div>  
												<div class="form-group">
													<label for="confirm_password">Confirm Password</label>
													<input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
												</div>
											</div>
										</div>
										<button type="submit" class="btn btn-default submit"> Update Password </button>
									</form>
								</div>
							</div>

							<div class="tab-pane" id="pag3" role="tabpanel">
								<div class="sv-tab-panel three">
									<form action="{{route('updateInfo')}}" method="post">
										<input type="hidden" name="_token" value="{{ csrf_token() }}" />
										<h3>User Info</h3>
										<div class="row">
											<div class="col-lg-6 col-md-12 form-line">
												<div class="form-group">
													<label for="name">Full Name</label>
													<input type="text" name="name" class="form-control" placeholder="Full Name" value="{{$user->name}}">
												</div>
												<div class="form-group">
													<label for="dob">DOB</label>
													<input type="date" name="dob" class="form-control" placeholder="DOB" value="{{date('Y-m-d', strtotime($user->dob))}}">
												</div>
												<div class="form-group">
													<label for="gender">Gender</label>
													<select name="gender" class="" id="sel1">
														<option value="Male" @if($user->gender=='Male')selected @endif>Male</option>
														<option value="Female" @if($user->gender=='Female')selected @endif>Female</option>
														<option value="Non Binary" @if($user->gender=='Non Binary')selected @endif>Non Binary</option>
													</select>
												</div>
												<div class="form-group">
													<label for="class_name">Class Name</label>
													<select name="class_name" class="" id="sel1">
														<option>--select class--</option>
														@if($studentClasses)
														@foreach($studentClasses as $stclass)
														<option value="{{$stclass->class_name}}" @if($stclass->class_name==$user->class_name)selected @endif>{{$stclass->class_name}}</option>
														@endforeach
														@endif
													</select>
												</div>
												<div class="form-group">
													<label for="school_college">School / College Name</label>
													<input type="text" name="school_college" class="form-control" placeholder="School / College Name" value="{{$user->school_college}}">
												</div>
												<div class="form-group">
													<label for="state">State Name</label>
													<select name="state" class="stateName" id="sel1">
														<option>--select state--</option>
														@if($states)
														@foreach($states as $state)
														<option value="{{$state->state}}" @if($state->state==$user->state)selected @endif>{{$state->state}}</option>
														@endforeach
														@endif
													</select>
												</div>
												<div class="form-group">
													<label for="city">Town / City</label>
													<!-- <input type="text" name="city" class="form-control" placeholder="Town / City" value="{{$user->city}}"> -->
													<select name="city" class="cityName" id="sel1">
														<option>--select city--</option>
														@if($cities)
														@foreach($cities as $city)
														<option value="{{$city->city}}" @if($city->city==$user->city)selected @endif>{{$city->city}}</option>
														@endforeach
														@endif
													</select>
												</div>
												<div class="form-group">
													<label for="postal_code">Postcode / ZIP</label>
													<input type="text" name="postal_code" class="form-control" placeholder="Postcode / ZIP" value="{{$user->postal_code}}">
												</div>
												<!-- <label class="mt-3"><input type="checkbox" name="terms"> Update the Billing Address used for  of my active subscriptions (optional) </label> -->
											</div>
										</div>
										<button type="submit" class="btn btn-default submit"> Save Info </button>
									</form>
								</div>
							</div>

							<div class="tab-pane" id="pag4" role="tabpanel">
								<div class="sv-tab-panel six">
									<h3>Subscriptions</h3>
									<div class="well">
										<table class="table">
											<thead>
												<tr>
													<th>Subscription</th>
													<th>Month</th>
													<th>Start Date</th>
													<th>End Date</th>
													<th>Status</th>
												</tr>
											</thead>
											<tbody>
												@if($subscriptions)
												@foreach($subscriptions as $key => $subscription)
												<tr>
													<td>#{{$key+1}}</td>
													<td>{{$subscription->subscription->month}}</td>
													<td>{{$subscription->start_date}}</td>
													<td><i class="fa fa-eye" aria-hidden="true"></i> {{$subscription->end_date}}</td>
													<td>@if(strtotime($subscription->end_date) > strtotime(date('Y-m-d')))<a href="javascript:;" class="comple">Active </a> @else <a href="javascript:;" class="nactive"> Inactive </a> @endif</td>
												</tr>
												@endforeach
												@else
												<tr>
													<td>No Record Found!</td>
												</tr>
												@endif
											</tbody>
										</table>
									</div>
								</div>
							</div>

							<div class="tab-pane" id="pag5" role="tabpanel">
								<div class="sv-tab-panel five">
									<h3>Registered Courses</h3>
									<div class="well">
										<table class="table">
											<thead>
												<tr>
													<th>Courses Name</th>
													<th>Status</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>BRAIN SCIENCE FOR KIDS (ENGLISH)</td>
													<td><a class="actives" href="#"> Active </a></td>
													<td><i class="fa fa-eye" aria-hidden="true"></i></td>
												</tr>
												<tr>
													<td>General Knowledge Series</td>
													<td><a class="nactive" href="#"> Inactive </a></td>
													<td><i class="fa fa-eye" aria-hidden="true"></i></td>
												</tr>
												<tr>
													<td>BRAIN SCIENCE TRAINING - LEVEL 5</td>
													<td><a class="actives" href="#">  Active </a></td>
													<td><i class="fa fa-eye" aria-hidden="true"></i></td>
												</tr>
												<tr>
													<td>BRAIN SCIENCE CONCEPT VIDEOS - FREE</td>
													<td><a class="actives" href="#"> Active </a></td>
													<td><i class="fa fa-eye" aria-hidden="true"></i></td>
												</tr>
												<tr>
													<td>BRAIN SCIENCE TRAINING - LEVEL 4</td>
													<td><a class="nactive" href="#">  Inactive </a></td>
													<td><i class="fa fa-eye" aria-hidden="true"></i></td>
												</tr>
												<tr>
													<td>BRAIN SCIENCE TRAINING - LEVEL 3</td>
													<td><a class="nactive" href="#"> Inactive </a></td>
													<td><i class="fa fa-eye" aria-hidden="true"></i></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>

							<div class="tab-pane" id="pag7" role="tabpanel">
								<div class="sv-tab-panel seven">
									<h3>Downloads</h3>
									<div class="well">
										<table class="table">
											<thead>
												<tr>
													<th>Date</th>
													<th>Course Name</th>
													<th>Valid Till</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td> March 3, 2021</td>
													<td> VIBGYOR Method </a></td>
													<td> VIBGYOR Method </td>
													<td><i class="fa fa-eye"></i> <i class="fa fa-download"></i></td>
												</tr>
												<tr>
													<td> March 3, 2021</td>
													<td> VIBGYOR Method </a></td>
													<td> VIBGYOR Method </td>
													<td><i class="fa fa-eye"></i> <i class="fa fa-download"></i></td>
												</tr>
												<tr>
													<td> March 3, 2021</td>
													<td> VIBGYOR Method </a></td>
													<td> VIBGYOR Method </td>
													<td><i class="fa fa-eye"></i> <i class="fa fa-download"></i></td>
												</tr>
												<tr>
													<td> March 3, 2021</td>
													<td> VIBGYOR Method </a></td>
													<td> VIBGYOR Method </td>
													<td><i class="fa fa-eye"></i> <i class="fa fa-download"></i></td>
												</tr>
												<tr>
													<td> March 3, 2021</td>
													<td> VIBGYOR Method </a></td>
													<td> VIBGYOR Method </td>
													<td><i class="fa fa-eye"></i> <i class="fa fa-download"></i></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>

							<div class="tab-pane" id="pag8" role="tabpanel">
								<div class="sv-tab-panel eight">
									<h3>Inquiries</h3>
									<div class="well">
										<table class="table">
											<thead>
												<tr>
													<th>Query</th>
													<th>Product</th>
													<th>Additional Info</th>
													<th>Actions</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>You do not have any enquiry yet!</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>

							<div class="tab-pane" id="pag6" role="tabpanel">
								<div class="sv-tab-panel four">
									<h3>Contact Us</h3>
									<form action="{{route('postContact')}}" method="post">
										<input type="hidden" name="_token" value="{{ csrf_token() }}" />
										<div class="row">
											<div class="col-md-6 form-line">
												<div class="form-group">
													<label for="name">Your name</label>
													<input type="text" name="name" class="form-control" value="{{$user->name}}">
												</div>
												<div class="form-group">
													<label for="phone">Phone Number</label>
													<input type="tel" name="phone" class="form-control" value="{{$user->phone}}">
												</div>  

												<div class="form-group">
													<label for="telephone">Email</label>
													<input type="email" name="email" class="form-control" value="{{$user->email}}">
												</div>
											</div>
											<div class="col-md-6">
											<div  class="form-group">
													<label for="description">Message</label>
													<textarea style="border-radius: 5px;" name="message" class="form-control">{!!old('message')!!}</textarea>
												</div>
											</div>
										</div>
										<button type="submit" class="btn btn-primary submit"> Submit</button>
									</form>
								</div>
							</div>

						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

{!! Form::open(['route' => 'frontlogout', 'style' => 'display:none;', 'id' => 'logout']) !!}
<button type="submit">@lang('global.logout')</button>
{!! Form::close() !!}

<div class="modal fade" id="imageModal" role="dialog">
	<div class="modal-dialog img_sec">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Upload Profile Image</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label=""><span>×</span></button>
			</div>          
			<form action="{{route('uploadProfile')}}" method="post" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" />
				<div class="modal-body">                       
					<div class="form-group">
						<input type="file" name="image" class="form-control">
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-default">Upload</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="mobileModal" role="dialog">
	<div class="modal-dialog img_sec">
		<div class="modal-content">
			<div class="modal-header">
				<h4>New Mobile Number</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label=""><span>×</span></button>
			</div> 
			<div class="modal-body">
				<div class="form-group">
					<label for="phone">New Mobile Number</label>
					<input type="tel" name="phone" id="phone" class="form-control" placeholder="New Mobile Number" value="" autocomplete="off" maxlength="10" required>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-default mobileUpdate">Update</button>
			</div>
		</div>
	</div>
</div>

@php if($request->session()->has('new_phone')){ $sessionPhone = $request->session()->get('new_phone'); }else{ $sessionPhone = ''; } @endphp
<div class="modal fade" id="mobileUpdateModal" role="dialog">
	<div class="modal-dialog img_sec">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Otp Verification</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label=""><span>×</span></button>
			</div>          
			<div class="modal-body">                       
				<div class="form-group">
					<label for="phone">Otp</label>
					<input type="hidden" name="new_phone" id="new_phone" value="{{$sessionPhone}}">
					<input type="tel" name="otp" id="otp" class="form-control" maxlength="4" placeholder="OTP" value="" autocomplete="off">
				</div>
			</div>
			<div class="modal-footer">
				@if($sessionPhone)
					<span id="count"></span>
					<!-- <a href="#phone_resend_otp" class="btn btn-default " onclick="$('#phone_resend_otp').submit();" style="color: #FF7A17;">Resend OTP</a> -->
					<a href="#phone_resend_otp" class="btn btn-default phone_resend_otp" style="color: #FF7A17;">Resend OTP</a>
				@endif
				<button type="submit" class="btn btn-default mobileOtpSend">Submit</button>
			</div>
		</div>
	</div>
</div>
{!! Form::open(['route' => 'resendOtp', 'style' => 'display:none;', 'id' => 'phone_resend_otp']) !!}
<input type="hidden" name="phone" value="{{$sessionPhone}}" />
<button type="submit">Resend OTP</button>
{!! Form::close() !!}


<div class="modal fade" id="emailModal" role="dialog">
	<div class="modal-dialog img_sec">
		<div class="modal-content">
			<div class="modal-header">
				<h4>New Email Address</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label=""><span>×</span></button>
			</div>          
			<div class="modal-body">                       
				<div class="form-group">
					<label for="email">New Email Address</label>
					<input type="email" name="email" id="email" class="form-control" placeholder="New Email Address" value="" autocomplete="off" required>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-default emailUpdate">Update</button>
			</div>
		</div>
	</div>
</div>

@php if($request->session()->has('new_email')){ $sessionEmail = $request->session()->get('new_email'); $sessionPhone = $request->session()->get('new_email_phone'); }else{ $sessionEmail = ''; $sessionPhone = ''; } @endphp
<div class="modal fade" id="emailUpdateModal" role="dialog">
	<div class="modal-dialog img_sec">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Otp Verification</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label=""><span>×</span></button>
			</div>          
			<div class="modal-body">                       
				<div class="form-group">
					<label for="phone">Otp</label>
					<input type="hidden" name="new_email" id="new_email" value="{{$sessionEmail}}">
					<input type="tel" name="otp" id="otp_email" class="form-control" maxlength="4" placeholder="OTP" value="" autocomplete="off" required>
				</div>
			</div>
			<div class="modal-footer">
				@if($sessionPhone)
					<span id="count1"></span>
					<!-- <a href="#acc_resend_otp" class="btn btn-default" onclick="$('#acc_resend_otp').submit();" style="color: #FF7A17;">Resend OTP</a> -->
					<a href="#acc_resend_otp" class="btn btn-default acc_resend_otp" style="color: #FF7A17;">Resend OTP</a>
				@endif
				<button type="submit" class="btn btn-default emailOtpSend">Submit</button>
			</div>
		</div>
	</div>
</div>

{!! Form::open(['route' => 'resendOtp', 'style' => 'display:none;', 'id' => 'acc_resend_otp']) !!}
<input type="hidden" name="phone" value="{{$sessionPhone}}" />
<button type="submit">Resend OTP</button>
{!! Form::close() !!}

@endsection
@section('javascript')
<script type="text/javascript">
	$(document).ready(function () {
		@if($request->session()->has('new_phone'))
			$('#mobileUpdateModal').modal('show');
		@endif
		@if($request->session()->has('new_email'))
			$('#emailUpdateModal').modal('show');
		@endif

		$('.mobileUpdate').click(function(){
			var phone = $("#phone").val();
			//alert(phone);
			if(phone != ''){
				//$("#plan_id").val(planId);
				//var _token = $('meta[name="csrf-token"]').attr('content');
				$.ajax({
					url:"{{route('mobileUpdate')}}",
					method:"POST",
					data:{ _token:"{{ csrf_token() }}", phone:phone },
					success: function(result){
						if(result==='Done'){
							//$('#mobileUpdateModal').modal('show');
							//$(".apply_msg").html('Please enter OTP.');
							/*swal(
								"Success",
								"Please enter OTP.",
								"success"
							)*/
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
							window.location.href = "{{route('myAccount')}}";
						}, 5000);
					}
				});
			}
		});
		$('.mobileOtpSend').click(function(){
			var new_phone = $("#new_phone").val();
			var otp = $("#otp").val();
			//alert(otp);
			if(otp != ''){
				$.ajax({
					url:"{{route('mobileOtpSend')}}",
					method:"POST",
					data:{ _token:"{{ csrf_token() }}", new_phone:new_phone, otp:otp },
					success: function(result){
						//$('#mobileUpdateModal').modal('show');
						if(result==='Done'){
							swal(
								"Success",
								"Mobile Number Updated Successfully.",
								"success"
							)
						}else{
							swal(
								"Error!",
								result,
								"error"
							)
						}
						setTimeout(function(){
							//console.log("Hello World");
							window.location.href = "{{route('myAccount')}}";
						}, 5000);
					}
				});
			}
		});

		$('.emailUpdate').click(function(){
			var email = $("#email").val();
			//alert(email);
			if(email != ''){
				$.ajax({
					url:"{{route('emailUpdate')}}",
					method:"POST",
					data:{ _token:"{{ csrf_token() }}", email:email },
					success: function(result){
						if(result==='Done'){
							//$('#emailUpdateModal').modal('show');
							//$(".apply_msg").html('Please enter OTP.');
							/*swal(
								"Success",
								"Please enter OTP.",
								"success"
							)*/
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
							window.location.href = "{{route('myAccount')}}";
						}, 5000);
					}
				});
			}
		});
		$('.emailOtpSend').click(function(){
			var new_email = $("#new_email").val();
			var otp = $("#otp_email").val();
			//alert(otp);
			if(otp != ''){
				$.ajax({
					url:"{{route('emailOtpSend')}}",
					method:"POST",
					data:{ _token:"{{ csrf_token() }}", new_email:new_email, otp:otp },
					success: function(result){
						//$('#emailUpdateModal').modal('show');
						if(result==='Done'){
							swal(
								"Success",
								"Email id Updated Successfully.",
								"success"
							)
						}else{
							swal(
								"Error!",
								result,
								"error"
							)
						}
						setTimeout(function(){
							//console.log("Hello World");
							window.location.href = "{{route('myAccount')}}";
						}, 5000);
					}
				});
			}
		});

		$(".phone_resend_otp").click(function() {
			//alert("working");

			var counter = 45;
			setInterval(function() {
				counter--;
				if (counter >= 0) {
					span = document.getElementById("count");
					span.innerHTML = "waiting... " + counter;
					$(".phone_resend_otp").addClass("disabled");
				}
				if (counter === 0) {
					//alert('sorry, out of time');
					$('#phone_resend_otp').submit();
					clearInterval(counter);
					$(".phone_resend_otp").removeClass("disabled");
				}
			}, 1000);

		});

		$(".acc_resend_otp").click(function() {
			//alert("working");

			var counter = 45;
			setInterval(function() {
				counter--;
				if (counter >= 0) {
					span = document.getElementById("count1");
					span.innerHTML = "waiting... " + counter;
					$(".acc_resend_otp").addClass("disabled");
				}
				if (counter === 0) {
					//alert('sorry, out of time');
					$('#acc_resend_otp').submit();
					clearInterval(counter);
					$(".acc_resend_otp").removeClass("disabled");
				}
			}, 1000);
			
		});

		$(".stateName").change(function () {
			if ($(this).val() != "") {
				var _token = $('input[name="_token"]').val();
				var value = $(this).val();
				$.ajax({
					url: "get_cities_by_state",
					method: "POST",
					data: { _token: _token,state: value },
					success: function (result) {
						$(".cityName").html(result);
					},
				});
			}
		});

	});
</script>
@endsection
