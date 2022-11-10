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
				window.location.href = SITEURL +"/"+"admin/courses";
			}
		});
	});
</script>
@endsection

@section('content')

	{{--section for instructor--}}
	@can('course')
	<style type="text/css">
		.input-group .input-group-addon {
			border-radius: 0;
			border-color: #ffffff;
			background-color: #fff;
		}
		.removefat{
			margin-top: 16px;
		}
		.removefaq{
			margin-top: 16px;
		}
        .progress { position:relative; width:100%; }
        .bar { background-color: #FF7A17; width:0%; height:20px; }
        .percent { position:absolute; display:inline-block; left:50%; color: #040608; top: 0;}
    </style>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Add New Course</div>
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

					<form action="{{route('admin.courseStore')}}" class="" method="post" enctype="multipart/form-data">

						<input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
						
						<div class="form-group">
							<label for="name">Course Name</label>
							<input required class="form-control" type="text" name="name" placeholder="Name of course">
						</div>

						<div class="form-group">
							<label for="courseID">Course Image (Image Diamention 700px X 700px)</label>
							<input type="file" name="image" class="form-control" accept="image/*" required>
						</div>
						<div class="form-group">
							<label for="courseID">Course Video</label>
							<input type="file" name="video" class="form-control" accept="video/mp4,video/x-m4v,video/*" required>
							<div class="progress">
	                            <div class="bar"></div>
	                            <div class="percent">0%</div>
	                        </div>
						</div>

						<div class="form-group">
							<label for="pdf">Course PDF</label>
							<input type="file" name="pdf" class="form-control" accept="application/pdf">
						</div>

						<div class="form-group">
							<label for="courseID">Course Duration</label>
							<input required class="form-control" type="text" name="video_duration" placeholder="Course Duration">
						</div>

						<div class="form-group">
							<label for="overview">Course Descrpition</label>
							<textarea name="overview" id="content" class="form-control ckeditor" placeholder="Course Descrpition" required></textarea>
						</div>

						<div class="form-group">
							<label for="features">Course Features</label>

							<div class="form-group">
								<label for="courseID">Features</label>
								<input required class="form-control" type="text" name="featu[]">
							</div>
							<div class="" id="addfet"></div>
							<a href="javascript:" id="addftbtn" class="btn btn-primary" style="margin-top: 10px;">Add More Feature</a>
						</div>
						
						<div class="form-group">
							<label for="courseFAQs">Course Faqs</label>
							<div class="input-group" style="width: 100%;">
								<div class="form-group">
									<label for="question">Question</label>
									<input required class="form-control" type="text" name="faqTitle[]">
								</div>
								<div class="form-group">
									<label for="answer">Answer</label>
									<textarea name="faqcontant[]" class="form-control" placeholder="Contant" required></textarea>
								</div>
								<!--  <div class="input-group-addon"><a href="javascript:void(0)" class="btn btn-success addMore1"><span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span> Add</a></div> -->
							</div>
							  <div class="" id="addfaq"></div>
							<a href="javascript:" id="addbtnfaq" class="btn btn-primary" style="margin-top: 10px;">Add More Faq</a>
						</div>

						<div class="form-group">
							<label for="free">Course Free</label>
							<select class="form-control" name="free">
								<option value="0">Yes</option>
								<option value="1">No</option>
							</select>
						</div>
						
						<div class="form-group">
							<button type="submit" class="btn btn-success"> Save Course</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	@endcan
	{{--end section for instructor--}}

@endsection
