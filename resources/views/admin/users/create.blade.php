@extends('layouts.app')

@section('content')
	<style type="text/css">
		.field-icon{float: right; margin: -25px 5px; cursor: pointer;}
	</style>
	
	<h3 class="page-title">@lang('global.users.title')</h3>
	{!! Form::open(['method' => 'POST', 'route' => ['admin.users.store']]) !!}

	<div class="panel panel-default">
		<div class="panel-heading">
			@lang('global.app_create')
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
			@if(Request::path()=='admin/students/create')
			<div class="row">
				<div class="col-xs-12 form-group">
					<label for="dob">DOB</label>
					<input type="date" name="dob" class="form-control" placeholder="DOB">
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 form-group">
					<label for="gender">Gender</label>
					<select name="gender" class="form-control" id="sel1">
						<option value="Male">Male</option>
						<option value="Female">Female</option>
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
						<option value="{{$stclass->class_name}}">{{$stclass->class_name}}</option>
						@endforeach
						@endif
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 form-group">
					<label for="school_college">School / College Name</label>
					<input type="text" name="school_college" class="form-control" placeholder="School / College Name">
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 form-group">
					<label for="state">State Name</label>
					<select name="state" class="form-control select2" id="sel1">
						<option>--select state--</option>
						@if($states)
						@foreach($states as $state)
						<option value="{{$state->state}}">{{$state->state}}</option>
						@endforeach
						@endif
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 form-group">
					<label for="city">Town / City</label>
					<input type="text" name="city" class="form-control" placeholder="Town / City">
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 form-group">
					<label for="postal_code">Postcode / ZIP</label>
					<input type="text" name="postal_code" class="form-control" placeholder="Postcode / ZIP">
				</div>
			</div>
			@else
			@endif

			<div class="row">
				<div class="col-xs-12 form-group">
					{!! Form::label('password', 'Password*', ['class' => 'control-label']) !!}
					{!! Form::password('password', ['class' => 'form-control', 'id' => 'password-field', 'placeholder' => '', 'required' => '']) !!}
					<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
					<p class="help-block"></p>
					@if($errors->has('password'))
						<p class="help-block">
							{{ $errors->first('password') }}
						</p>
					@endif
				</div>
			</div>
			@if(Request::path()=='admin/students/create')
			<input type="hidden" name="roles[]" value="Student">
			@else
			<div class="row">
				<div class="col-xs-12 form-group">
					{!! Form::label('roles', 'Roles*', ['class' => 'control-label']) !!}
					<!--{!! Form::select('roles[]', $roles, old('roles'), ['class' => 'form-control select2', 'multiple' => 'multiple', 'required' => '']) !!}-->
					{!! Form::select('roles[]', $roles, old('roles'), ['class' => 'form-control select2', 'required' => '']) !!}
					<p class="help-block"></p>
					@if($errors->has('roles'))
						<p class="help-block">
							{{ $errors->first('roles') }}
						</p>
					@endif
				</div>
			</div>
			@endif
			
		</div>
	</div>

	{!! Form::submit(trans('global.app_save'), ['class' => 'btn btn-danger']) !!}
	{!! Form::close() !!}
@stop

