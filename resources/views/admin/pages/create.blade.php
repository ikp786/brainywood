@extends('layouts.app')

@section('content')

	{{--section for instructor--}}
	@can('page')
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Add New Page</div>
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

					<form action="{{route('admin.storePage')}}" enctype="multipart/form-data" class="" method="post">

						<input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
						
						<div class="form-group">
							<label for="title">Title</label>
							<input type="text" name="title" class="form-control" placeholder="Title" required>
						</div>

						<div class="form-group">
							<label for="content">Content</label>
							<textarea name="content" class="form-control ckeditor" placeholder="Content" required></textarea>
						</div>
						
						<div class="form-group">
							<label for="meta_title">Meta Title</label>
							<input type="text" name="meta_title" class="form-control" placeholder="Meta Title" required>
						</div>

						<div class="form-group">
							<label for="meta_description">Meta Description</label>
							<textarea name="meta_description" class="form-control" placeholder="Meta Description" required></textarea>
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
