@extends('layouts.app')
@section('content')

	{{--section for instructor--}}
	@can('users_manage')
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

					<form action="{{route('admin.storeCoupon')}}" enctype="multipart/form-data" class="" method="post">

						<input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
						
						<div class="form-group">
							<label for="user_id">Issued to</label>
							<select name="user_id" class="form-control" required>
								<option value="">--select user--</option>
								@if($users)
								@foreach($users as $user)
								<option value="{{$user->id}}">{{$user->name}}</option>
								@endforeach
								@endif
							</select>
						</div>

						<div class="form-group">
							<label for="coupon">Coupon Code</label>
							<input type="text" name="coupon" class="form-control" required>
						</div>

						<div class="form-group">
							<label for="discount">Discount (%)</label>
							<input type="text" name="discount" class="form-control" required>
						</div>

						<div class="form-group">
							<label for="validity">Validity in months</label>
							<input type="text" name="validity" class="form-control" required>
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
