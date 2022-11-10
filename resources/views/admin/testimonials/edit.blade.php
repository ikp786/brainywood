@extends('layouts.app')

@section('content')

	{{--section for instructor--}}
	@can('testimonial')

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">Edit Testimonial</div>
					<div class="panel-body">


						<form action="{{route('admin.updateTestimonial',['id'=> $testimonial->id])}}" method="post" enctype="multipart/form-data">

							<input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />

							<div class="form-group">
								<label for="related">Related</label>
								<select name="related" class="form-control" required>
									@if($relates)
									@foreach($relates as $relate)
									<option value="{{$relate->id}}" @if($relate->id==$testimonial->related)selected @endif>{{$relate->title}}</option>
									@endforeach
									@endif
								</select>
							</div>
							
							<div class="form-group">
								<label for="name">Name</label>
								<input type="text" name="name" class="form-control" placeholder="Name of person" value="{{$testimonial->name}}" required>
							</div>

							<div class="form-group">
								<label for="profession">Profession</label>
								<input type="text" name="profession" class="form-control" placeholder="Profession" value="{{$testimonial->profession}}" required>
							</div>

							<div class="form-group">
								<label for="image">Image (Image Diamention 200px X 200px)</label>
								<input type="file" name="image" class="form-control" accept="image/*">
								<?php if($testimonial->image){
									?>
									<img class="img-responsive" src="<?php echo url('upload/testimonials') ?>/<?php echo $testimonial->image; ?>" width="200">
									<?php
								} ?>
							</div>

							<div class="form-group">
								<label for="content">Content</label>
								<textarea name="content" class="form-control" maxlength="700" placeholder="Content" required>{{$testimonial->content}}</textarea>
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
