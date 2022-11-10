@extends('layouts.app')
@section('javascript')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
<script>
	$.noConflict();
	var SITEURL = "{{URL('/')}}";
	var isVideo=0;
	jQuery(document).ready(function($) {
		$('#video_file').change(function() {
			isVideo=1;
			$('#isvideo').val(1); 
	    });
		$("#form1").submit(function(e) {
			e.preventDefault();
			//alert();
			var bar = $('.bar');
			var percent = $('.percent');
			var isvideo=$('#isvideo').val();
			//alert(isvideo);
			if(isvideo==1)
			{
				$('#form1').ajaxSubmit({
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
			}else{
				//alert("form");
				sumitForm();
			}
		});
	});

	function sumitForm()
	{
		$('#form1')[0].submit();
	}
</script>
@endsection

@section('content')

	{{--section for instructor--}}
	@can('course')
	<style>
        .progress { position:relative; width:100%; }
        .bar { background-color: #FF7A17; width:0%; height:20px; }
        .percent { position:absolute; display:inline-block; left:50%; color: #040608; top: 0;}
        .img-wrap { position: relative;}
		.img-wrap .close {position: absolute; top: -7px; z-index: 100; left: 98px; font-size: 25px; color: red;}
        .vid-wrap { position: relative;}
		.vid-wrap .close {position: absolute; top: -7px; z-index: 100; left: 558px; font-size: 25px; color: red;}
    </style>
		<input type="hidden" id="isvideo" value='0'>

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">Edit Course</div>
					<div class="panel-body">


						<form action="{{route('admin.courseUpdate',['id'=> $course->id])}}" class="" id="form1" method="post" enctype="multipart/form-data">

							<input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
							
							<div class="form-group">
								<label for="name">Course Name</label>
								<input type="text" name="name" class="form-control" placeholder="Name of course" required value="{{$course->name}}">
							</div>

							<div class="form-group">
								<label for="courseID">Course Image (Image Diamention 700px X 700px)</label>
								<input type="file" name="image" class="form-control" accept="image/*">
								<?php if($course->image){
									?>
									<div class="img-wrap">
									    <a href="{{route('admin.imgremoveCourse', $course->id)}}"><span class="close">&times;</span></a>
										<img class="img-responsive" src="<?php echo url('course') ?>/<?php echo $course->image; ?>" width="100">
									</div>
									<?php
								} ?>
							</div>
							
							<div class="form-group">
								<label for="courseID">Course Video</label>
								<input type="file" name="video" id="video_file" class="form-control" accept="video/mp4,video/x-m4v,video/*">
								<div class="progress">
		                            <div class="bar"></div>
		                            <div class="percent"></div>
		                        </div>
								@if($course->video)
								<div class="vid-wrap">
								    <a href="{{route('admin.vidremoveCourse', $course->id)}}"><span class="close">&times;</span></a>
									<iframe width="560" height="315" src="{{asset('/course/'.$course->video)}}" frameborder="0" controls="0" autoplay="0" allowfullscreen sandbox></iframe>
								</div>
								@endif
							</div>

							<div class="form-group">
								<label for="pdf">Course PDF</label>
								<input type="file" name="pdf" class="form-control" accept="application/pdf">
								@if($course->pdf)
									<div class="img-wrap">
									    <a href="{{route('admin.pdfremoveCourse', $course->id)}}"><span class="close">&times;</span></a>
										<a href="{{ asset('course/').'/'.$course->pdf }}" title="PDF" target="_blank"><i class="fa fa-file-pdf-o" style="font-size:88px;color:red"></i></a>
									</div>
								@endif
							</div>

							<div class="form-group">
								<label for="courseID">Course Duration</label>
								<input type="text" name="video_duration" class="form-control" placeholder="Course Duration" required value="{{$course->video_duration}}">
							</div>

							<div class="form-group">
								<label for="courseID">Course Descrpition</label>
								<textarea name="overview" class="form-control ckeditor" placeholder="Course Descrpition" required>{{$course->overview}}</textarea>
							</div>

							<div class="form-group">
								<label for="courseID">Course Features</label>
								<?php foreach ($Coursefeature as $key => $value) {
									?>
									<div class="input-group"><div class="form-group"><label for="courseID">Feature</label><input type="text" name="featu[]" class="form-control" value="<?php echo $value['feature'] ?>" required=""></div><div class="input-group-addon"><a href="javascript:void(0)" class="btn btn-danger removefat"><span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span> Remove</a></div></div>
								<?php
								} ?>
								<div class="" id="addfet"></div>
								<a href="javascript:" id="addftbtn" class="btn btn-primary" style="margin-top: 10px;">Add More Feature</a>
							</div>
						    
							<div class="form-group">
								
								<label for="courseID">Course Faqs</label>
								<?php foreach ($Coursefeq as $key => $value) {
									?>
								<div class="input-group"><div class="form-group"><label for="courseID">Question</label><input type="text" name="faqTitle[]" class="form-control" required="" value="<?php echo $value['title'] ?>"></div><div class="form-group"><label for="courseID">Answer</label><textarea name="faqcontant[]" class="form-control" placeholder="Contant" required=""><?php echo $value['contant'] ?></textarea></div><div class="input-group-addon"><a href="javascript:void(0)" class="btn btn-danger removefaq"><span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span> Remove</a></div></div>
								<?php  } ?>
								<div class="" id="addfaq"></div>
								<a href="javascript:" id="addbtnfaq" class="btn btn-primary" style="margin-top: 10px;">Add More Faq</a>
							</div>

							<div class="form-group">
								<label for="free">Course Free</label>
								<select name="free" class="form-control">
									<option value="0" @if($course->isFree==0) selected @endif>Yes</option>
									<option value="1" @if($course->isFree==1) selected @endif>No</option>
								</select>
							</div>

							<div class="form-group">
								<button type="submit" class="btn btn-primary"> Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	@endcan
	{{--end section for instructor--}}

@endsection
