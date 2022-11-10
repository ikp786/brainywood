@extends('layouts.app')
@section('javascript')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
<script>
	$.noConflict();
	var SITEURL = "{{URL('/')}}";
	
	var editor =  CKEDITOR.replace( 'content' );
	// The "change" event is fired whenever a change is made in the editor.
	editor.on( 'change', function( evt ) {
		// getData() returns CKEditor's HTML content.
		jQuery('#content').val(evt.editor.getData());
	});

	jQuery(document).ready(function($) {

		var bar = $('.bar');
		var percent = $('.percent');
		$('form').ajaxForm({
			beforeSend: function() {
				var percentVal = '0%';
				bar.width(percentVal)
				percent.html(percentVal);
			},
			uploadProgress: function(event, position, total, percentComplete) {
				var percentVal = percentComplete + '%';
				bar.width(percentVal)
				percent.html(percentVal);
			},
			complete: function(xhr) {
				alert('File Has Been Uploaded Successfully');
				window.location.href = SITEURL +"/"+"admin/lession-chapter";
			}
		});
	});
</script>
@endsection

@section('content')

	{{--section for instructor--}}
	@can('topic')
	<style>
		.progress { position:relative; width:100%; }
		.bar { background-color: #FF7A17; width:0%; height:20px; }
		.percent { position:absolute; display:inline-block; left:50%; color: #040608; top: 0;}
	</style>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Add New Lession Chapter</div>
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

					<form action="{{route('admin.storeLessionChapter')}}" class="" method="post" enctype="multipart/form-data">

						<input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />

						<div class="form-group">
							<label for="name">Select Course</label>
							<select name="courseId" id="courseId" class="form-control" required>
								<option value="">--Select--</option>
								<?php foreach ($courses as $key => $value) {
									?>
									<option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
									<?php
									 }
								?>
							</select>
						</div>

						<div class="form-group" id="lession">
							<label for="name">Select Lession</label>
							<select name="lessionId" id="lessionId" class="form-control" required>
								<option value="">--Select--</option>
							</select>
						</div>

						<div class="form-group">
							<label for="name">Chapter Name</label>
							<input type="text" name="name" class="form-control" placeholder="Name of Chapter" required>
						</div>

						<div class="form-group">
							<label for="image">Chapter Video Thumbnail (Image Diamention 700px X 700px)</label>
							<input type="file" name="thumb" class="form-control" accept="image/*" required>
						</div>

						<div class="form-group">
							<label for="video">Chapter Video</label>
							<input type="file" name="video" class="form-control" accept="video/mp4,video/x-m4v,video/*" required>
							<div class="progress">
								<div class="bar"></div>
								<div class="percent">0%</div>
							</div>
						</div>

						<div class="form-group">
							<label for="pdf">Chapter PDF</label>
							<input type="file" name="pdf" class="form-control" accept="application/pdf">
						</div>

						<div class="form-group">
							<label for="content">Chapter Overview</label>
							<textarea name="content" id="content" class="form-control ckeditor" placeholder="Chapter Overview" required></textarea>
						</div>

						<div class="form-group">
							<label for="free">Chapter Free</label>
							<select name="free" class="form-control">
								<option value="0">Yes</option>
								<option value="1">No</option>
							</select>
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
