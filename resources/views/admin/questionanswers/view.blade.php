@extends('layouts.app')
@section('content')

	{{--section for instructor--}}
	@can('question_answer')
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">View Question Answers</div>
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

					<form action="{{route('admin.updateQuestionAnswer',['id'=> $data->id])}}" enctype="multipart/form-data" class="" method="post">

						<input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
						
						<!-- <input type="hidden" name="id[]" value="{{$data->id}}"> -->
						<div class="form-group">
							<label for="course_id">Course Name: </label>
							@if($data->course_id>0){{$data->course->name}}@endif
						</div>
						<div class="form-group">
							<label for="lession_id">Lession Name: </label>
							@if($data->lession_id>0){{$data->lession->name}}@endif
						</div>
						<div class="form-group">
							<label for="topic_id">Topic Name: </label>
							@if($data->topic_id>0){{$data->topic->name}}@endif
						</div>
						<div class="form-group">
							<label for="user_id">Asked By: </label>
							@if($data->user_id>0){{$data->user->name}}@endif
						</div>
						<div class="form-group">
							<label for="question">Question: </label>
							{{$data->question}}
							<br>
							@if($data->image!='')
							<label for="image">Image: </label>
							@php
							$images = explode(',', $data->image);
							if(empty($images)){
								$images = array();
							}
							@endphp
							@foreach($images as $image)
							<img src="{{asset('/upload/questionask/'.$image)}}" width="100">
							@endforeach
							@endif
						</div>
						<hr>

						<div class="panel-heading"><h3><b>Given Answers</b></h3></div>
						@if($answers)
						@foreach($answers as $answer)
						<div class="form-group">
							<label for="user_id">Answer By: </label>
							@if($answer->user_id>0){{$answer->user->name}}@endif
						</div>
						<div class="form-group">
							<input type="hidden" name="ans_id[]" value="{{$answer->id}}">
							<label for="answer">Answer: </label>
							{{$answer->answer}}
						</div>

						<div class="form-group">
							@if($answer->image!='')
							<label for="image">Image: </label>
							@php
							$ansimages = explode(',', $answer->image);
							if(empty($ansimages)){
								$ansimages = array();
							}
							@endphp
							@foreach($ansimages as $ansimage)
							<img src="{{asset('/upload/questionask/'.$ansimage)}}" width="100">
							@endforeach
							@endif
						</div>

						<!-- <div class="form-group">
							<label for="status">Status</label>
							<input type="radio" name="status[]" value="1" @if($answer->status==1) checked @endif>&nbsp;Active
							<input type="radio" name="status[]" value="0" @if($answer->status==0) checked @endif>&nbsp;In-Active
						</div> -->
						<hr>
						@endforeach
						@endif

						<!-- <div class="form-group">
							<button type="submit" class="btn btn-primary">Update</button>
						</div> -->
					</form>
				</div>
			</div>
		</div>
	</div>
	@endcan
	{{--end section for instructor--}}

@endsection
