@extends('layouts.app')

@section('content')

	{{--section for instructor--}}
	@can('blog')

		<style>
			.img-wrap { position: relative;}
			.img-wrap .close {position: absolute; top: -7px; z-index: 100; left: 98px; font-size: 25px; color: red;}
		</style>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">Edit Blog</div>
					<div class="panel-body">


						<form action="{{route('admin.updateBlog',['id'=> $blog->id])}}" method="post" enctype="multipart/form-data">

							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							
							<div class="form-group">
								<label for="title">Title</label>
								<input type="text" name="title" class="form-control" placeholder="Title" required value="{{$blog->title}}">
							</div>

							<div class="form-group">
								<label for="image">Image (Image Diamention 925px X 500px)</label>
								<input type="file" name="image" class="form-control" accept="image/*">
								@if($blog->image)
								<div class="img-wrap">
								    <a href="{{route('admin.imgremoveBlog', $blog->id)}}"><span class="close">&times;</span></a>
								    <img src="{{asset('/upload/blogs/'.$blog->image)}}" width="100">
								</div>
								@endif
							</div>

							<div class="form-group">
								<label for="description">Content</label>
								<textarea name="description" class="form-control ckeditor" placeholder="Content" required>{!!$blog->description!!}</textarea>
							</div>
						
							<!-- <div class="form-group">
								<label for="meta_title">Meta Title</label>
								<input type="text" name="meta_title" class="form-control" placeholder="Meta Title" value="{{$blog->meta_title}}">
							</div>

							<div class="form-group">
								<label for="meta_description">Meta Description</label>
								<textarea name="meta_description" class="form-control" placeholder="Meta Description">{!!$blog->meta_description!!}</textarea>
							</div> -->

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
