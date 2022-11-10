@extends('layouts.app')
@section('content')

	{{--section for instructor--}}
	@can('coupon_code')
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Edit Coupon Code</div>
				<div class="panel-body">
					@if(Session::has('msg'))
						<div class="alert alert-info">
							<a class="close" data-dismiss="alert">×</a>
							<strong>{!!Session::get('msg')!!}</strong>
						</div>
					@endif
					@if ($errors->any())
						<div class="alert alert-danger">
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form action="{{route('admin.updateCoupon',['id'=> $data->id])}}" enctype="multipart/form-data" class="" method="post">

						<input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />

						<div class="form-group">
							<label for="condition1">
								<input type="radio" name="condition_1" onclick="CheckCondition1();" value="0" @if($data->condition_1==0) checked @endif>Code for All
								<input type="radio" name="condition_1" onclick="CheckCondition1();" value="1" @if($data->condition_1==1) checked @endif>Code for a User
								<input type="radio" name="condition_1" onclick="CheckCondition1();" value="2" @if($data->condition_1==2) checked @endif>Code for a Subscription Plan
							</label>
							<div class="userlist"  @if($data->condition_1!=1) style="display: none;" @endif>
								<div class="form-group col-md-12">
									<label for="user_id">Issued to User</label>
									<select name="user_id" class="form-control select2">
										<option value="0">--select user--</option>
										@if($users)
										@foreach($users as $user)
										<option value="{{$user->id}}" @if($data->user_id==$user->id) selected @endif>{{$user->name.' - '.$user->phone}}</option>
										@endforeach
										@endif
									</select>
								</div>
							</div>
							<div class="planlist">
								<div class="form-group col-md-12">
									<label for="subscription_id">Subscription Plan</label>
									<select name="subscription_id" class="form-control select2">
										<option value="0">--select plan--</option>
										@if($subscriptions)
										@foreach($subscriptions as $subscription)
										<option value="{{$subscription->id}}" @if($data->subscription_id==$subscription->id) selected @endif>{{$subscription->name}}</option>
										@endforeach
										@endif
									</select>
								</div>
							</div>
						</div>

						<div class="form-group fixed_users" @if($data->condition_1==1) style="display: none;" @endif>
							<label for="condition2">Is this code for fixed users?
								<input type="radio" name="condition_2" onclick="CheckCondition2();" value="1" @if($data->no_of_users>0) checked @endif>Yes
								<input type="radio" name="condition_2" onclick="CheckCondition2();" value="0" @if($data->no_of_users==0) checked @endif>No
							</label>
							<div class="no_of_users" @if($data->no_of_users==0) style="display: none;" @endif>
								<div class="form-group col-md-12">
									<label for="no_of_users">Number of Users</label>
									<input type="number" name="no_of_users" class="form-control" value="{{$data->no_of_users}}">
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="coupon">Coupon Code</label>
							<input type="text" name="coupon" class="form-control" value="{{$data->coupon}}" required>
						</div>

						<div class="form-group">
							<label for="discount">Discount (%)</label>
							<input type="number" name="discount" class="form-control" value="{{$data->discount}}" required>
						</div>

						<!-- <div class="form-group">
							<label for="validity">Validity in months</label>
							<input type="number" name="validity" class="form-control" value="{{$data->validity}}" required>
						</div> -->
						<div class="form-group">
							<label for="end_date">End Date</label>
							<input type="date" name="end_date" class="form-control" min="{{date('Y-m-d')}}" value="{{$data->end_date}}" required>
						</div>

						<div class="form-group">
							<label for="description">Description</label>
							<textarea name="description" class="form-control">{!!$data->description!!}</textarea>
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-primary">Update</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	@endcan
	{{--end section for instructor--}}

@endsection

@section('javascript')
<script>
	function CheckCondition1() {
		var condition_1 = $("input[name='condition_1']:checked").val();
		if (condition_1 == 0) {
			$('.userlist').hide();
			//$('.planlist').hide();
			$('.fixed_users').show();
		} else if (condition_1 == 1) {
			$('.userlist').show();
			//$('.planlist').hide();
			$('.fixed_users').hide();
		} else {
			$('.userlist').hide();
			//$('.planlist').show();
			$('.fixed_users').show();
		}
	}
	function CheckCondition2() {
		var condition_2 = $("input[name='condition_2']:checked").val();
		if (condition_2 == 1) {
			$('.no_of_users').show();
		} else {
			$('.no_of_users').hide();
		}
	}
</script>
@endsection
