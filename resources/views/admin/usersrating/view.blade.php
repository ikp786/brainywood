@extends('layouts.app')
@section('content')

	{{--section for instructor--}}
	@can('user_rating')
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">View Users Rating</div>
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

					<form action="{{route('admin.updateUserRating',['id'=> $data->id])}}" enctype="multipart/form-data" class="" method="post">

						<input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
						
						<div class="form-group">
							<label for="user">User Name</label>
							<div>@if($data->userId>0){{$data->user->name}}@endif</div>
						</div>

						<div class="form-group">
							<label for="course">Course Name</label>
							<div>@if($data->courseId>0){{$data->course->name}}@endif</div>
						</div>

						<div class="form-group">
							<label for="lession">Lession Name</label>
							<div>@if($data->lessionId>0){{$data->lession->name}}@endif</div>
						</div>

						<div class="form-group">
							<label for="topic">Topic Name</label>
							<div>@if($data->topicId>0){{$data->topic->name}}@endif</div>
						</div>

						<div class="form-group">
							<label for="ratingType">Rating Type</label>
							<div>{{$data->ratingType}}</div>
						</div>

						<div class="form-group">
							<label for="ratingMessage">Rating Message</label>
							<div>{{$data->ratingMessage}}</div>
						</div>

						<div class="form-group">
							<label for="message">Message</label>
							<div>{{$data->message}}</div>
						</div>

						<!--<div class="form-group">
							<button type="submit" class="btn btn-primary">Update</button>
						</div>-->
					</form>
				</div>
			</div>
		</div>
	</div>
	@endcan
	{{--end section for instructor--}}

@endsection
