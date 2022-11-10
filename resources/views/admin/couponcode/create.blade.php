@extends('layouts.app')
@section('content')

	{{--section for instructor--}}
	@can('coupon_code')
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Add New Coupon Code</div>
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

					<form action="{{route('admin.storeCoupon')}}" class="" method="post" enctype="multipart/form-data">

						<input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />

						<div class="form-group">
							<label for="condition1">
								<input type="radio" name="condition_1" onclick="CheckCondition1();" value="0" checked>Code for All
								<input type="radio" name="condition_1" onclick="CheckCondition1();" value="1">Code for a User
								<input type="radio" name="condition_1" onclick="CheckCondition1();" value="2">Code for a Subscription Plan
							</label>
							<div class="userlist" style="display: none;">
								<div class="form-group col-md-12">
									<label for="user_id">Issued to User</label>
									<select name="user_id" class="form-control select2">
										<option value="0">--select user--</option>
										@if($users)
										@foreach($users as $user)
										<option value="{{$user->id}}">{{$user->name.' - '.$user->phone}}</option>
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
										<option value="{{$subscription->id}}">{{$subscription->name}}</option>
										@endforeach
										@endif
									</select>
								</div>
							</div>
						</div>

						<div class="form-group code_for">
							<label for="condition3">Is coupon code for?
								<input type="radio" name="condition_3" onclick="CheckCondition3();" value="0" checked>Single
								<input type="radio" name="condition_3" onclick="CheckCondition3();" value="1">Multiple
							</label>
							<div class="no_of_codes" style="display: none;">
								<!-- <input type="hidden" name="no_of_users" value="1"> -->
								<div class="form-group col-md-12">
									<label for="no_of_codes">Number of Coupon Codes</label>
									<input type="number" name="no_of_codes" class="form-control">
								</div>
							</div>
						</div>

						<div class="form-group fixed_users">
							<label for="condition2">Is this code for fixed users?
								<input type="radio" name="condition_2" onclick="CheckCondition2();" value="1">Yes
								<input type="radio" name="condition_2" onclick="CheckCondition2();" value="0" checked>No
							</label>
							<div class="no_of_users" style="display: none;">
								<div class="form-group col-md-12">
									<label for="no_of_users">Number of Users</label>
									<input type="number" name="no_of_users" class="form-control">
								</div>
							</div>
						</div>

						<div class="form-group single_code">
							<label for="coupon">Coupon Code <a href="javascript:void(0);" class="generateCode">Generate Code</a></label>
							<input type="text" name="coupon" id="coupon" class="form-control">
						</div>

						<div class="form-group">
							<label for="discount">Discount (%)</label>
							<input type="number" name="discount" class="form-control" required>
						</div>

						<!-- <div class="form-group">
							<label for="validity">Validity in months</label>
							<input type="number" name="validity" class="form-control" required>
						</div> -->
						<div class="form-group">
							<label for="end_date">End Date</label>
							<input type="date" name="end_date" class="form-control" min="{{date('Y-m-d')}}" required>
						</div>

						<div class="form-group">
							<label for="description">Description</label>
							<textarea name="description" class="form-control"></textarea>
						</div>
						
						
						<div class="form-group">
							<button type="submit" class="btn btn-success">Save</button>
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
			$('.code_for').show();
		} else if (condition_1 == 1) {
			$('.userlist').show();
			//$('.planlist').hide();
			$('.fixed_users').hide();
			$('.code_for').hide();
		} else {
			$('.userlist').hide();
			//$('.planlist').show();
			$('.fixed_users').show();
			$('.code_for').hide();
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
	function CheckCondition3() {
		var condition_3 = $("input[name='condition_3']:checked").val();
		if (condition_3 == 1) {
			$('.no_of_codes').show();
			$('.fixed_users').hide();
			$('.single_code').hide();
		} else {
			$('.no_of_codes').hide();
			$('.fixed_users').show();
			$('.single_code').show();
		}
	}
</script>
@endsection
