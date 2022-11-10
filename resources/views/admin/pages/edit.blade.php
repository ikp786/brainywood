@extends('layouts.app')

@section('content')

	{{--section for instructor--}}
	@can('page')

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">Edit Page</div>
					<div class="panel-body">


						<form action="{{route('admin.updatePage',['id'=> $page->id])}}" method="post" enctype="multipart/form-data">

							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							
							<div class="form-group">
								<label for="title">Title</label>
								<input type="text" name="title" class="form-control" placeholder="Title" required value="{{$page->title}}">
							</div>

							<div class="form-group">
								<label for="content">Content</label>
								<textarea name="content" class="form-control ckeditor" placeholder="Content" required>{!!$page->content!!}</textarea>
							</div>
						
							<div class="form-group">
								<label for="meta_title">Meta Title</label>
								<input type="text" name="meta_title" class="form-control" placeholder="Meta Title" value="{{$page->meta_title}}">
							</div>

							<div class="form-group">
								<label for="meta_description">Meta Description</label>
								<textarea name="meta_description" class="form-control" placeholder="Meta Description">{!!$page->meta_description!!}</textarea>
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
