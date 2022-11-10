@extends('layouts.app')

@section('content')

	{{--section for instructor--}}
	@can('page')

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">Edit About Us</div>
					<div class="panel-body">


						<form action="{{route('admin.updateAboutUs',['id'=> $about->id])}}" method="post" enctype="multipart/form-data">

							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							
							<div class="form-group">
								<label for="title">Title</label>
								<input type="text" name="title" class="form-control" placeholder="Title" required value="{{$about->title}}">
							</div>

							<!-- <div class="form-group">
								<label for="content">Content</label>
								<textarea name="content" class="form-control ckeditor" placeholder="Content" required>{!!$about->content!!}</textarea>
							</div> -->

							<div class="form-group">
								<label for="organization">Organization</label>
								<textarea name="organization" class="form-control ckeditor" placeholder="Organization" required>{!!$about->organization!!}</textarea>
							</div>

							<div class="form-group">
								<label for="vision">Vision</label>
								<textarea name="vision" class="form-control ckeditor" placeholder="Vision">{!!$about->vision!!}</textarea>
							</div>

							<div class="form-group">
								<label for="mission">Mission</label>
								<textarea name="mission" class="form-control ckeditor" placeholder="Mission" required>{!!$about->mission!!}</textarea>
							</div>

							<div class="form-group">
								<label for="process">Process</label>
								<textarea name="process" class="form-control ckeditor" placeholder="Process" required>{!!$about->process!!}</textarea>
							</div>

							<div class="form-group">
								<label for="courseID">Video Thumbnail (Image Diamention 700px X 700px)</label>
								<input type="file" name="image" class="form-control" accept="image/*">
								<?php if($about->image){
									?>
									<img class="img-responsive" src="<?php echo url('upload/aboutus') ?>/<?php echo $about->image; ?>" width="100">
									<?php
								} ?>
							</div>

							<div class="form-group">
								<label for="video">Video</label>
								<input type="file" name="video" class="form-control" accept="video/mp4,video/x-m4v,video/*">
								@if($about->video)
								<iframe width="560" height="315" src="{{asset('/upload/aboutus/'.$about->video)}}" frameborder="0" controls="0" autoplay="0" allowfullscreen sandbox></iframe>
								@endif
							</div>
						    
							<div class="form-group">
								<label for="facts">Interesting Facts</label>
								@php $interesting_facts = json_decode($about->interesting_facts, true); @endphp
								@if($interesting_facts)
								@foreach ($interesting_facts as $key => $value)
								<div class="input-group">
									<div class="form-group">
										<label for="icon">Icon (Image Diamention 75px X 75px)</label>
										<input type="file" name="fact_icon[]" class="form-control" accept="image/*">
										<input type="hidden" name="old_icon[]" value="<?php echo $value['fact_icon'] ?>">
									</div>
									<div class="form-group">
										<label for="title">Title</label>
										<input type="text" name="fact_title[]" class="form-control" placeholder="Title" value="<?php echo $value['fact_title'] ?>">
									</div>
									<div class="form-group">
										<label for="sub_title">Subtitle</label>
										<input type="text" name="fact_sub_title[]" class="form-control" placeholder="Subtitle" value="<?php echo $value['fact_sub_title'] ?>">
									</div>
									<div class="input-group-addon">
										<a href="javascript:void(0)" class="btn btn-danger removefact"><span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span> Remove</a>
									</div>
								</div>
								@endforeach
								@endif
								<div class="" id="addfact"></div>
								<a href="javascript:" id="addbtnfact" class="btn btn-primary" style="margin-top: 10px;">Add More </a>
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
