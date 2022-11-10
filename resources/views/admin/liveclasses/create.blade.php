@extends('layouts.app')
@section('content')

	{{--section for instructor--}}
	@can('liveclasses')
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Add New Live Class</div>
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

					<form action="{{route('admin.storeLiveclass')}}" class="" method="post" enctype="multipart/form-data">

						<input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
						
						@if($user->role_id!=2)
						<div class="form-group">
							<label for="added_by">Added By</label>
							<select name="added_by" class="form-control select2" required>
								<option value="">--select--</option>
								@foreach($teachers as $teacher)
								<option value="{{$teacher->id}}">{{$teacher->name}}</option>
								@endforeach
							</select>
						</div>
						@else
						<input type="hidden" name="added_by" value="{{$user->id}}">
						@endif
						
						<div class="form-group">
							<label for="title">Class Name</label>
							<input type="text" name="title" class="form-control" placeholder="Name of class" required>
						</div>

						<div class="form-group">
							<label for="subject">Subject</label>
							<input type="text" name="subject" class="form-control" placeholder="Subject" required>
						</div>

						<div class="form-group">
							<label for="image">Image (Image Diamention 350px X 300px)</label>
							<input type="file" name="image" class="form-control" accept="image/*" required>
						</div>

						<div class="form-group">
							<label for="meeting_id">Meeting Id</label>
							<input type="text" name="meeting_id" class="form-control" placeholder="Meeting Id" onkeypress="return AvoidSpace(event)" required>
						</div>

						<div class="form-group">
							<label for="pass_code">Meeting Password</label>
							<input type="text" name="pass_code" class="form-control" onkeypress="return AvoidSpace(event)" placeholder="Meeting Password" required>
						</div>

						<div class="form-group">
							<label for="class_time">Class Start Datetime</label>
							<input type="datetime-local" name="class_time" class="form-control" min="{{date('Y-m-d')}}T{{date('H:i')}}" placeholder="Class Datetime" required>
						</div>

						<div class="form-group">
							<label for="end_time">Class End Datetime</label>
							<input type="datetime-local" name="end_time" class="form-control" min="{{date('Y-m-d')}}T{{date('H:i')}}" placeholder="Class End Datetime" required>
						</div>

						<div class="form-group">
							<label for="free">Class Free</label>
							<select name="free" class="form-control">
								<option value="0">Yes</option>
								<option value="1">No</option>
							</select>
						</div>
					    
						<div class="form-group">
							<button type="submit" class="btn btn-success"> Save Class</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	@endcan
	{{--end section for instructor--}}

@endsection

@section('javascript')
    <script type="text/javascript">
        function AvoidSpace(event) {
            var k = event ? event.which : window.event.keyCode;
            if (k == 32) return false;
        }
    </script>
@endsection
