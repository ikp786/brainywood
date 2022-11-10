@extends('layouts.app')

@section('content')
	<style type="text/css">
		.field-icon{float: right; margin: -25px 5px; cursor: pointer;}
	</style>
	
	<h3 class="page-title">@lang('global.users.title')</h3>
	
	{!! Form::model($user, ['method' => 'PUT', 'route' => ['admin.users.update', $user->id]]) !!}

	<div class="panel panel-default">
		<div class="panel-heading">
			@lang('global.app_edit')
		</div>

		<div class="panel-body">
			<div class="row">
				<div class="col-xs-12 form-group">
					{!! Form::label('name', 'Name*', ['class' => 'control-label']) !!}
					{!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
					<p class="help-block"></p>
					@if($errors->has('name'))
						<p class="help-block">
							{{ $errors->first('name') }}
						</p>
					@endif
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 form-group">
					{!! Form::label('email', 'Email*', ['class' => 'control-label']) !!}
					{!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
					<p class="help-block"></p>
					@if($errors->has('email'))
						<p class="help-block">
							{{ $errors->first('email') }}
						</p>
					@endif
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 form-group">
					{!! Form::label('phone', 'Mobile*', ['class' => 'control-label']) !!}
					{!! Form::text('phone', old('phone'), ['class' => 'form-control', 'placeholder' => '', 'maxlength' => '10']) !!}
					<p class="help-block"></p>
					@if($errors->has('phone'))
						<p class="help-block">
							{{ $errors->first('phone') }}
						</p>
					@endif
				</div>
			</div>
			@if(Request::path()!='admin/users/'.$user->id.'/student/edit')
			@else
			<div class="row">
				<div class="col-xs-12 form-group">
					<label for="dob">DOB</label>
					<input type="date" name="dob" class="form-control" placeholder="DOB" value="{{date('Y-m-d', strtotime($user->dob))}}">
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 form-group">
					<label for="gender">Gender</label>
					<select name="gender" class="form-control" id="sel1">
						<option value="Male" @if($user->gender=='Male')selected @endif>Male</option>
						<option value="Female" @if($user->gender=='Female')selected @endif>Female</option>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 form-group">
					<label for="class_name">Class Name</label>
					<select name="class_name" class="form-control select2" id="sel1">
						<option>--select class--</option>
						@if($studentClasses)
						@foreach($studentClasses as $stclass)
						<option value="{{$stclass->class_name}}" @if($stclass->class_name==$user->class_name)selected @endif>{{$stclass->class_name}}</option>
						@endforeach
						@endif
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 form-group">
					<label for="school_college">School / College Name</label>
					<input type="text" name="school_college" class="form-control" placeholder="School / College Name" value="{{$user->school_college}}">
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 form-group">
					<label for="state">State Name</label>
					<select name="state" class="form-control select2" id="sel1">
						<option>--select state--</option>
						@if($states)
						@foreach($states as $state)
						<option value="{{$state->state}}" @if($state->state==$user->state)selected @endif>{{$state->state}}</option>
						@endforeach
						@endif
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 form-group">
					<label for="city">Town / City</label>
					<input type="text" name="city" class="form-control" placeholder="Town / City" value="{{$user->city}}">
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 form-group">
					<label for="postal_code">Postcode / ZIP</label>
					<input type="text" name="postal_code" class="form-control" placeholder="Postcode / ZIP" value="{{$user->postal_code}}">
				</div>
			</div>
			
			@endif

			<div class="row">
				<div class="col-xs-12 form-group">
					{!! Form::label('password', 'Password', ['class' => 'control-label']) !!}
					{!! Form::password('password', ['class' => 'form-control', 'id' => 'password-field', 'placeholder' => '']) !!}
					<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
					<p class="help-block"></p>
					@if($errors->has('password'))
						<p class="help-block">
							{{ $errors->first('password') }}
						</p>
					@endif
				</div>
			</div>
			@if(Request::path()!='admin/users/'.$user->id.'/student/edit')
			<div class="row">
				<div class="col-xs-12 form-group">
					{!! Form::label('roles', 'Roles*', ['class' => 'control-label']) !!}
					<!--{!! Form::select('roles[]', $roles, old('roles') ? old('role') : $user->roles()->pluck('name', 'name'), ['class' => 'form-control select2', 'multiple' => 'multiple', 'required' => '']) !!}-->
					{!! Form::select('roles[]', $roles, old('roles') ? old('role') : $user->roles()->pluck('name', 'name'), ['class' => 'form-control select2', 'required' => '']) !!}
					<p class="help-block"></p>
					@if($errors->has('roles'))
						<p class="help-block">
							{{ $errors->first('roles') }}
						</p>
					@endif
				</div>
			</div>
			@else
			<input type="hidden" name="roles[]" value="Student">
			@endif
			
		</div>
	</div>

	{!! Form::submit(trans('global.app_update'), ['class' => 'btn btn-danger']) !!}
	{!! Form::close() !!}
@stop

