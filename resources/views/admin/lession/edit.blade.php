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
						window.location.href = SITEURL +"/"+"admin/lession";
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
	@can('lession')
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
					<div class="panel-heading">Edit Lession</div>
					<div class="panel-body">


						<form action="{{route('admin.lessionUpdate',['id'=> $lession->id])}}" class="" id="form1" method="post" enctype="multipart/form-data">

							<input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />

							<div class="form-group">
								<label for="name">Select Course</label>
								<select name="courseId" class="form-control" required>
									<option value="">--Select--</option>
									<?php foreach ($course as $key => $value) {
										?>
										<option <?php if($value['id']==$lession->courseId) { echo 'selected'; } ?> value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
										<?php
										 }
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="name">Lession Name</label>
								<input value="<?php echo $lession->name;  ?>" required class="form-control" type="text" name="name" placeholder="Name of lession">
							</div>
							<div class="form-group">
								<label for="image">Lession Video Thumbnail (Image Diamention 700px X 700px)</label>
								<input type="file" name="thumb" class="form-control" accept="image/*">
								@if($lession->video_thumb)
									<div class="img-wrap">
									    <a href="{{route('admin.imgremoveLession', $lession->id)}}"><span class="close">&times;</span></a>
										<img width="100" src="<?php echo url('lessions/').'/'.$lession->video_thumb.''; ?>">
									</div>
								@endif
							</div>
							<div class="form-group">
								<label for="video">Lession Video</label>
								<input type="file" name="video" id="video_file" class="form-control" accept="video/mp4,video/x-m4v,video/*">
								<div class="progress">
		                            <div class="bar"></div>
		                            <div class="percent"></div>
		                        </div>
								@if($lession->fullvideo)
								<div class="vid-wrap">
								    <a href="{{route('admin.vidremoveLession', $lession->id)}}"><span class="close">&times;</span></a>
									<iframe width="560" height="315" src="{{asset('/lessions/'.$lession->fullvideo)}}" frameborder="0" controls="0" autoplay="0" allowfullscreen sandbox></iframe>
								</div>
								@endif
							</div>
							<div class="form-group">
								<label for="pdf">Lession PDF</label>
								<input type="file" name="pdf" class="form-control" accept="application/pdf">
								@if($lession->pdf)
									<div class="img-wrap">
									    <a href="{{route('admin.pdfremoveLession', $lession->id)}}"><span class="close">&times;</span></a>
										<a href="{{ asset('lessions/').'/'.$lession->pdf }}" title="PDF" target="_blank"><i class="fa fa-file-pdf-o" style="font-size:88px;color:red"></i></a>
									</div>
								@endif
							</div>
							<div class="form-group">
								<label for="courseID">Lession Overview</label>
								<textarea name="content" class="form-control ckeditor" placeholder="Lession Overview" required>{!!$lession->content!!}</textarea>
							</div>
							<div class="form-group">
								<label for="name">Lession Free</label>
								<select class="form-control" name="free">
									<option value="1" <?php if($lession->isFree==1) { echo 'selected'; } ?>>No</option>
									<option value="0" <?php if($lession->isFree==0) { echo 'selected'; } ?>>Yes</option>
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