@extends('layouts.app')

@section('content')
	<h3 class="page-title">@lang('global.users.title')</h3>
	
	<!-- {!! Form::model($user, ['method' => 'PUT', 'route' => ['admin.users.update', $user->id]]) !!} -->

	<div class="panel panel-default">
		<div class="panel-heading">View</div>

		<div class="panel-body">
			<div class="row">
				<div class="col-xs-12 form-group">
					<label for="postal_code">Role</label>
					<div>@if($user->role_id==1)Administrator @elseif($user->role_id==2)Teacher @else Student @endif</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 form-group">
					{!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
					<div>{{$user->name}}</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 form-group">
					{!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
					<div>{{$user->email}}</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 form-group">
					{!! Form::label('phone', 'Mobile', ['class' => 'control-label']) !!}
					<div>{{$user->phone}}</div>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-12 form-group">
					<label for="password">Password</label>
					<div>{{$user->userpass}}</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 form-group">
					<label for="dob">DOB</label>
					<div>{{$user->dob}}</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 form-group">
					<label for="gender">Gender</label>
					<div>{{$user->gender}}</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 form-group">
					<label for="class_name">Class Name</label>
					<div>{{$user->class_name}}</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 form-group">
					<label for="school_college">School / College Name</label>
					<div>{{$user->school_college}}<div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 form-group">
					<label for="state">State Name</label>
					<div>{{$user->state}}</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 form-group">
					<label for="city">Town / City</label>
					<div>{{$user->city}}</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 form-group">
					<label for="postal_code">Postcode / ZIP</label>
					<div>{{$user->postal_code}}</div>
				</div>
			</div>
			
		</div>
	</div>

	<!-- {!! Form::submit(trans('global.app_update'), ['class' => 'btn btn-danger']) !!}
	{!! Form::close() !!} -->
@stop

