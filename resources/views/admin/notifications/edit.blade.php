@extends('layouts.app')
@section('content')

	{{--section for instructor--}}
	@can('notification')
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Edit Question Answers</div>
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

					<form action="{{route('admin.updateNotification',['id'=> $data->id])}}" class="" method="post" enctype="multipart/form-data">

						<input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
						
						<div class="form-group">
							<label for="user_id">Notification For</label>
							<select name="user_id" class="form-control select2" required>
								<option value="">--select user--</option>
								@if($users)
								@foreach($users as $user)
								<option value="{{$user->id}}" @if($user->id==$data->user_id) selected @endif>{{$user->name.' - '.$user->phone}}</option>
								@endforeach
								@endif
							</select>
						</div>

						<div class="form-group">
							<label for="message">Notification</label>
							<input type="text" name="message" class="form-control" value="{{$data->message}}" required>
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
