@extends('layouts.app')

@section('content')

	{{--section for instructor--}}
	@can('team_member')

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">Edit Team Member</div>
					<div class="panel-body">


						<form action="{{route('admin.updateTeam',['id'=> $team->id])}}" method="post" enctype="multipart/form-data">

							<input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
							
							<div class="form-group">
								<label for="name">Name</label>
								<input type="text" name="name" class="form-control" placeholder="Name of person" required value="{{$team->name}}">
							</div>

							<div class="form-group">
								<label for="department">Department</label>
								<select name="dept_id" class="form-control" required>
									@if($departments)
									@foreach($departments as $department)
									<option value="{{$department->id}}" @if($department->id==$team->dept_id)selected @endif>{{$department->title}}</option>
									@endforeach
									@endif
								</select>
							</div>

							<div class="form-group">
								<label for="position">Position</label>
								<input type="text" name="position" class="form-control" placeholder="Position" required value="{{$team->position}}">
							</div>

							<div class="form-group">
								<label for="image">Image (Image Diamention 625px X 415px)</label>
								<input type="file" name="image" class="form-control" accept="image/*">
								<?php if($team->image){
									?>
									<img class="img-responsive" src="<?php echo url('upload/teams') ?>/<?php echo $team->image; ?>" width="200">
									<?php
								} ?>
							</div>

							<div class="form-group">
								<label for="about">About</label>
								<textarea name="content" class="form-control" placeholder="About" required>{!!$team->about!!}</textarea>
							</div>

							<div class="form-group">
								<label for="linkdin">Linkdin Url</label>
								<input type="text" name="linkdin" class="form-control" placeholder="Linkdin Url" value="{{$team->linkdin}}">
							</div>

							<div class="form-group">
								<label for="email_id">Email Id</label>
								<input type="email" name="email_id" class="form-control" placeholder="Email Id" value="{{$team->email_id}}">
							</div>

							<div class="form-group">
								<label for="instagram">Instagram Url</label>
								<input type="text" name="instagram" class="form-control" placeholder="Instagram Url" value="{{$team->instagram}}">
							</div>

							<div class="form-group">
								<button type="submit" class="btn btn-primary"> Update </button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	@endcan
	{{--end section for instructor--}}

@endsection
