@extends('layouts.app')

@section('content')

	{{--section for instructor--}}
	@can('team_member')
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Add New Team Member</div>
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

					<form action="{{route('admin.storeTeam')}}" enctype="multipart/form-data" class="" method="post">

						<input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
						
						<div class="form-group">
							<label for="name">Name</label>
							<input type="text" name="name" class="form-control" placeholder="Name of person" required>
						</div>

						<div class="form-group">
							<label for="department">Department</label>
							<select name="dept_id" class="form-control" required>
								@if($departments)
								@foreach($departments as $department)
								<option value="{{$department->id}}">{{$department->title}}</option>
								@endforeach
								@endif
							</select>
						</div>

						<div class="form-group">
							<label for="position">Position</label>
							<input type="text" name="position" class="form-control" placeholder="Position" required>
						</div>

						<div class="form-group">
							<label for="image">Image (Image Diamention 625px X 415px)</label>
							<input type="file" name="image" class="form-control" accept="image/*" required>
						</div>

						<div class="form-group">
							<label for="about">About</label>
							<textarea name="content" class="form-control" placeholder="About" required></textarea>
						</div>

						<div class="form-group">
							<label for="linkdin">Linkdin Url</label>
							<input type="text" name="linkdin" class="form-control" placeholder="Linkdin Url">
						</div>

						<div class="form-group">
							<label for="email_id">Email Id</label>
							<input type="email" name="email_id" class="form-control" placeholder="Email Id">
						</div>

						<div class="form-group">
							<label for="instagram">Instagram Url</label>
							<input type="text" name="instagram" class="form-control" placeholder="Instagram Url">
						</div>
						
						<div class="form-group">
							<button type="submit" class="btn btn-success"> Save </button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	@endcan
	{{--end section for instructor--}}

@endsection
