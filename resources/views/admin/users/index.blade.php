@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
	<h3 class="page-title">@if(Request::path()=='admin/teachers')Teacher @elseif(Request::path()=='admin/students')Student @else Administrator @endif @lang('global.users.title')</h3>
	<p>
		@if(Request::path()!='admin/students')
			<a href="{{ route('admin.users.create') }}" class="btn btn-success">@lang('global.app_add_new')</a>
		@else
			<a href="{{ route('admin.createStudent') }}" class="btn btn-success">@lang('global.app_add_new')</a>
		@endif
	</p>

	<div class="panel panel-default">
		<div class="panel-heading">
			@lang('global.app_list')
		</div>
		@if(Request::path()=='admin/students')
		<div class="panel-body">
			<form name="filterfrm" action="{{route('admin.students')}}" method="GET">
				<div class="row">
					<!-- <div class="form-group col-md-2">
						<select name="created" class="form-control">
							<option value="">-select day-</option>
							<option value="today" @if($request->query('created')=='today')selected @endif>Today</option>
							<option value="week" @if($request->query('created')=='week')selected @endif>This Week</option>
							<option value="month" @if($request->query('created')=='month')selected @endif>This Month</option>
							<option value="year" @if($request->query('created')=='year')selected @endif>This Year</option>
							<option value="before" @if($request->query('created')=='before')selected @endif>Before This Year</option>
						</select>
					</div> -->
					<div class="form-group col-md-2">
						<select name="gender" class="form-control">
							<option value="">-select gender-</option>
							<option value="Male" @if($request->query('gender')=='Male')selected @endif>Male</option>
							<option value="Female" @if($request->query('gender')=='Female')selected @endif>Female</option>
							<!-- <option value="Other" @if($request->query('gender')=='Other')selected @endif>Other</option> -->
						</select>
					</div>
					<div class="form-group col-md-2">
						<select name="school" class="form-control select2">
							<option value="">-select school/college-</option>
							@if($schools)
							@foreach($schools as $school)
							<option value="{{$school->school_college}}" @if($request->query('school')==$school->school_college)selected @endif>{{$school->school_college}}</option>
							@endforeach
							@endif
						</select>
					</div>
					<div class="form-group col-md-2">
						<select name="class" class="form-control select2">
							<option value="">-select class-</option>
							@if($classes)
							@foreach($classes as $class)
							<option value="{{$class->class_name}}" @if($request->query('class')==$class->class_name)selected @endif>{{$class->class_name}}</option>
							@endforeach
							@endif
						</select>
					</div>
					<div class="form-group col-md-2">
						<select name="state" class="form-control select2 stateName">
							<option value="">-select state-</option>
							@if($states)
							@foreach($states as $state)
							<option value="{{$state->state}}" @if($request->query('state')==$state->state)selected @endif>{{$state->state}}</option>
							@endforeach
							@endif
						</select>
					</div>
					<div class="form-group col-md-2">
						<select name="city" class="form-control select2 cityName">
							<option value="">-select city-</option>
							@if($cities)
							@foreach($cities as $loc)
							<option value="{{$loc->city}}" @if($request->query('city')==$loc->city)selected @endif>{{$loc->city}}</option>
							@endforeach
							@endif
						</select>
					</div>
					<div class="form-group col-md-2">
						<select name="subscription" class="form-control">
							<option value="">-select subscription-</option>
							<option value="paid" @if($request->query('subscription')=='paid')selected @endif>Paid</option>
							<option value="unpaid" @if($request->query('subscription')=='unpaid')selected @endif>Unpaid</option>
						</select>
					</div>
					<div class="form-group col-md-2">
						<input type="date" name="from" class="form-control" value="@if($request->query('from')){{$request->query('from')}}@endif">
					</div>
					<div class="form-group col-md-2">
						<input type="date" name="to" class="form-control" value="@if($request->query('to')){{$request->query('to')}}@endif">
					</div>
					<div class="form-group col-md-2">
						<a href="{{route('admin.students')}}" class="btn btn-warning">RESET</a>
						<button class="btn btn-info">GET</button>
					</div>
				</div>
			</form>
		</div>
		@endif

		<div class="panel-body table-responsive">
			<table class="table table-bordered table-striped {{ count($users) > 0 ? 'datatable' : '' }} dt-select">
				<thead>
					<tr>
						<!-- <th style="text-align:center;"><input type="checkbox" id="select-all" /></th> -->
						<th>#</th>
						<th>@lang('global.users.fields.name')</th>
						<th>@lang('global.users.fields.email')</th>
						<th>Phone</th>
						@if(Request::path()!='admin/students')
						<th>@lang('global.users.fields.roles')</th>
						@endif
						@if(Request::path()=='admin/students')
						<th>Gender</th>
						<th>Class</th>
						<th>School/College</th>
						<th>Postal Code</th>
						<th>City</th>
						<th>State</th>
						<th>Paid / Unpaid</th>
						@endif
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@if (count($users) > 0)
                        @php $i = 1; @endphp
						@foreach ($users as $user)
							@php
								$userId   = $user->id;
								$today	  = date('Y-m-d');
								$subscription = \App\UserSubscription::where("user_id", $userId)->where("end_date", ">=", $today)->orderBy('id', 'DESC')->first();
								$userSubscription = !empty($subscription) ? 1 : 0;
							@endphp
							@if($request->query('subscription')=='paid')
								@if($userSubscription==1)
								<tr data-entry-id="{{ $user->id }}">
									<td>{{$i}}</td>
									<td>{{ $user->name }}</td>
									<td>{{ $user->email }}</td>
									<td>{{ $user->phone }}</td>
									@if(Request::path()!='admin/students')
									<td>
										@foreach ($user->roles()->pluck('name') as $role)
											<span class="label label-info label-many">{{ $role }}</span>
										@endforeach
									</td>
									@endif
									@if(Request::path()=='admin/students')
									<td>{{ $user->gender }}</td>
									<td>{{ $user->class_name }}</td>
									<td>{{ $user->school_college }}</td>
									<td>{{ $user->postal_code }}</td>
									<td>{{ $user->city }}</td>
									<td>{{ $user->state }}</td>
									<td>@if($userSubscription==1)Paid @else Unpaid @endif</td>
									@endif
									<td>
										<?php if($user->status==1) { ?><a href="<?php echo url('admin/users/updateStatus') ?>/<?php echo $user->id; ?>/0" class="label label-success">Active</a> <?php } else { ?><a href="<?php echo url('admin/users/updateStatus') ?>/<?php echo $user->id; ?>/1" class="label label-danger">Inactive</a> <?php } ?>
									</td>
									<td>
										@if(Request::path()=='admin/teachers')
											<a href="{{ route('admin.users.edit',[$user->id.'/teacher']) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
										@elseif(Request::path()=='admin/students')
									        <a href="{{ route('admin.usersView',[$user->id]) }}" class="btn btn-xs btn-info">View</a>
											<a href="{{ route('admin.users.edit',[$user->id.'/student']) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
										@else
											<a href="{{ route('admin.users.edit',[$user->id]) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
										@endif
										@if($user->role_id!=1)
											{!! Form::open(array(
												'style' => 'display: inline-block;',
												'method' => 'DELETE',
												'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
												'route' => ['admin.users.destroy', $user->id])) !!}
											{!! Form::submit(trans('global.app_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
											{!! Form::close() !!}
										@endif
									</td>
								</tr>
								@endif
							@elseif($request->query('subscription')=='unpaid')
								@if($userSubscription==0)
								<tr data-entry-id="{{ $user->id }}">
									<td>{{$i}}</td>
									<td>{{ $user->name }}</td>
									<td>{{ $user->email }}</td>
									<td>{{ $user->phone }}</td>
									@if(Request::path()!='admin/students')
									<td>
										@foreach ($user->roles()->pluck('name') as $role)
											<span class="label label-info label-many">{{ $role }}</span>
										@endforeach
									</td>
									@endif
									@if(Request::path()=='admin/students')
									<td>{{ $user->gender }}</td>
									<td>{{ $user->class_name }}</td>
									<td>{{ $user->school_college }}</td>
									<td>{{ $user->postal_code }}</td>
									<td>{{ $user->city }}</td>
									<td>{{ $user->state }}</td>
									<td>@if($userSubscription==1)Paid @else Unpaid @endif</td>
									@endif
									<td>
										<?php if($user->status==1) { ?><a href="<?php echo url('admin/users/updateStatus') ?>/<?php echo $user->id; ?>/0" class="label label-success">Active</a> <?php } else { ?><a href="<?php echo url('admin/users/updateStatus') ?>/<?php echo $user->id; ?>/1" class="label label-danger">Inactive</a> <?php } ?>
									</td>
									<td>
										@if(Request::path()=='admin/teachers')
											<a href="{{ route('admin.users.edit',[$user->id.'/teacher']) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
										@elseif(Request::path()=='admin/students')
									        <a href="{{ route('admin.usersView',[$user->id]) }}" class="btn btn-xs btn-info">View</a>
											<a href="{{ route('admin.users.edit',[$user->id.'/student']) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
										@else
											<a href="{{ route('admin.users.edit',[$user->id]) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
										@endif
										@if($user->role_id!=1)
											{!! Form::open(array(
												'style' => 'display: inline-block;',
												'method' => 'DELETE',
												'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
												'route' => ['admin.users.destroy', $user->id])) !!}
											{!! Form::submit(trans('global.app_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
											{!! Form::close() !!}
										@endif
									</td>
								</tr>
								@endif
							@else
							<tr data-entry-id="{{ $user->id }}">
								<td>{{$i}}</td>
								<td>{{ $user->name }}</td>
								<td>{{ $user->email }}</td>
								<td>{{ $user->phone }}</td>
								@if(Request::path()!='admin/students')
								<td>
									@foreach ($user->roles()->pluck('name') as $role)
										<span class="label label-info label-many">{{ $role }}</span>
									@endforeach
								</td>
								@endif
								@if(Request::path()=='admin/students')
								<td>{{ $user->gender }}</td>
								<td>{{ $user->class_name }}</td>
								<td>{{ $user->school_college }}</td>
								<td>{{ $user->postal_code }}</td>
								<td>{{ $user->city }}</td>
								<td>{{ $user->state }}</td>
								<td>@if($userSubscription==1)Paid @else Unpaid @endif</td>
								@endif
								<td>
									<?php if($user->status==1) { ?><a href="<?php echo url('admin/users/updateStatus') ?>/<?php echo $user->id; ?>/0" class="label label-success">Active</a> <?php } else { ?><a href="<?php echo url('admin/users/updateStatus') ?>/<?php echo $user->id; ?>/1" class="label label-danger">Inactive</a> <?php } ?>
								</td>
								<td>
									@if(Request::path()=='admin/teachers')
										<a href="{{ route('admin.users.edit',[$user->id.'/teacher']) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
									@elseif(Request::path()=='admin/students')
								        <a href="{{ route('admin.usersView',[$user->id]) }}" class="btn btn-xs btn-info">View</a>
										<a href="{{ route('admin.users.edit',[$user->id.'/student']) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
									@else
										<a href="{{ route('admin.users.edit',[$user->id]) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
									@endif
									@if($user->role_id!=1)
										{!! Form::open(array(
											'style' => 'display: inline-block;',
											'method' => 'DELETE',
											'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
											'route' => ['admin.users.destroy', $user->id])) !!}
										{!! Form::submit(trans('global.app_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
										{!! Form::close() !!}
									@endif
								</td>
							</tr>
							@endif
                        	@php $i++; @endphp
						@endforeach
					@else
						<tr>
							<td colspan="9">@lang('global.app_no_entries_in_table')</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
@stop

@section('javascript') 
	@if(auth()->user()->role_id!=1)
	<script>
		window.route_mass_crud_entries_destroy = '{{ route('admin.users.mass_destroy') }}';
	</script>
	@endif
<script type="text/javascript">
	$(document).ready(function () {
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