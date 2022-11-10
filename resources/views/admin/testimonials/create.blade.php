@extends('layouts.app')

@section('content')

	{{--section for instructor--}}
	@can('testimonial')
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Add New Testimonial</div>
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

					<form action="{{route('admin.storeTestimonial')}}" class="" method="post" enctype="multipart/form-data">

						<input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />

						<div class="form-group">
							<label for="related">Related</label>
							<select name="related" class="form-control" required>
								@if($relates)
								@foreach($relates as $relate)
								<option value="{{$relate->id}}">{{$relate->title}}</option>
								@endforeach
								@endif
							</select>
						</div>
						
						<div class="form-group">
							<label for="name">Name</label>
							<input type="text" name="name" class="form-control" placeholder="Name of person" required>
						</div>

						<div class="form-group">
							<label for="profession">Profession</label>
							<input type="text" name="profession" class="form-control" placeholder="Profession" required>
						</div>

						<div class="form-group">
							<label for="courseID">Image (Image Diamention 200px X 200px)</label>
							<input type="file" name="image" class="form-control" accept="image/*" required>
						</div>

						<div class="form-group">
							<label for="courseID">Content</label>
							<textarea name="content" class="form-control" maxlength="700" placeholder="Content" required></textarea>
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
