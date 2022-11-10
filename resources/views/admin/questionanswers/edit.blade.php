@extends('layouts.app')
@section('content')

	{{--section for instructor--}}
	@can('question_answer')
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

					<form action="{{route('admin.updateQuestionAnswer',['id'=> $data->id])}}" class="" method="post" enctype="multipart/form-data">

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
							<!-- <input type="text" name="user_id" class="form-control" placeholder="User Id" value="{{$data->user_id}}" required> -->@if($data->user_id>0){{$data->user->name}}@endif
						</div>
						<div class="form-group">
							<label for="question">Question: </label>
							<input type="text" name="question" class="form-control" placeholder="Asked Question" value="{{$data->question}}" required>
							@if($data->image!='')
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
						<div class="form-group col-md-6">
							<label for="user_id">Answer By: </label>
							{{$answer->user->name}}
						</div>
						<div class="form-group col-md-6">
							<a href="{{route('admin.deleteAnswer',$answer->id)}}" class="btn btn-danger pull-right" onclick="return confirm('Are you sure?');" title="Remove"><span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span> Remove</a>
						</div>
						<div class="form-group">
							<input type="hidden" name="ans_id[]" value="{{$answer->id}}">
							<label for="answer">Answer: </label>
							<textarea name="answer[]" class="form-control">{{$answer->answer}}</textarea>
						</div>

						<div class="form-group">
							<label for="image">Image: </label>
							<input type="file" name="image[]" class="form-control" accept="image/*">
							@if($answer->image!='')
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

						<div class="panel-heading"><h3><b>Add New Answer</b></h3></div>
						<div class="form-group">
							<label for="answer">Answer</label>
							<textarea name="adm_answer" class="form-control"></textarea>
						</div>

						<div class="form-group">
							<label for="image">Image</label>
							<input type="file" name="adm_image" class="form-control" accept="image/*">
						</div>

						<!-- <div class="form-group">
							<label for="status">Status</label>
							<input type="radio" name="adm_status" class="" value="1" checked>&nbsp;Active
							<input type="radio" name="adm_status" class="" value="0">&nbsp;In-Active
						</div> -->

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
