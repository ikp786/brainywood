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
						window.location.href = SITEURL +"/"+"admin/liveclasses";
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
	@can('liveclasses')
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
				<div class="panel-heading">Edit Live Class</div>
				<div class="panel-body">

					<form action="{{route('admin.updateLiveclass',['id'=> $liveClass->id])}}" class="" id="form1" method="post" enctype="multipart/form-data">

						<input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
						
						@if($user->role_id!=2)
						<div class="form-group">
							<label for="added_by">Added By</label>
							<select name="added_by" class="form-control select2" required>
								<option value=""> --select-- </option>
								@foreach($teachers as $teacher)
								<option value="{{$teacher->id}}" @if($teacher->id==$liveClass->added_by) selected @endif> {{$teacher->name}} </option>
								@endforeach
							</select>
						</div>
						@else
						<input type="hidden" name="added_by" value="{{$user->id}}">
						@endif
						
						<div class="form-group">
							<label for="title">Class Name</label>
							<input type="text" name="title" class="form-control" placeholder="Name of class" value="{{$liveClass->title}}" required>
						</div>

						<div class="form-group">
							<label for="subject">Subject</label>
							<input type="text" name="subject" class="form-control" placeholder="Subject" value="{{$liveClass->subject}}" required>
						</div>

						<div class="form-group">
							<label for="image">Image (Image Diamention 350px X 300px)</label>
							<input type="file" name="image" class="form-control" accept="image/*">
							@if($liveClass->image)
							<div class="img-wrap">
							    <a href="{{route('admin.imgremoveLiveclass', $liveClass->id)}}"><span class="close">&times;</span></a>
								<img src="{{asset('/upload/liveclasses/'.$liveClass->image)}}" width="100">
							</div>
							@endif
						</div>

						<div class="form-group">
							<label for="video">Live Class Video</label>
							<input type="file" name="video" id="video_file" class="form-control" accept="video/mp4,video/x-m4v,video/*">
							<div class="progress">
	                            <div class="bar"></div>
	                            <div class="percent"></div>
	                        </div>
							@if($liveClass->video)
							<div class="vid-wrap">
							    <a href="{{route('admin.vidremoveLiveclass', $liveClass->id)}}"><span class="close">&times;</span></a>
								<iframe width="560" height="315" src="{{asset('/upload/liveclasses/'.$liveClass->video)}}" frameborder="0" controls="0" autoplay="0" allowfullscreen sandbox></iframe>
							</div>
							@endif
						</div>

						<div class="form-group">
							<label for="meeting_id">Meeting Id</label>
							<input type="text" name="meeting_id" class="form-control" placeholder="Meeting Id" onkeypress="return AvoidSpace(event)" value="{{$liveClass->meeting_id}}" required>
						</div>

						<div class="form-group">
							<label for="pass_code">Meeting Password</label>
							<input type="text" name="pass_code" class="form-control" placeholder="Meeting Password" onkeypress="return AvoidSpace(event)" value="{{$liveClass->pass_code}}" required>
						</div>

						<div class="form-group">
							<label for="class_time">Class Start Datetime</label>
							<input type="datetime-local" name="class_time" class="form-control" placeholder="Class Datetime" value="{{date('Y-m-d', strtotime($liveClass->class_time)).'T'.date('H:i', strtotime($liveClass->class_time))}}" required>
						</div>

						<div class="form-group">
							<label for="end_time">Class End Datetime</label>
							<input type="datetime-local" name="end_time" class="form-control" placeholder="Class End Datetime" value="{{date('Y-m-d', strtotime($liveClass->end_time)).'T'.date('H:i', strtotime($liveClass->end_time))}}" required>
						</div>

						<div class="form-group">
							<label for="free">Class Free</label>
							<select name="free" class="form-control">
								<option value="0" @if($liveClass->isFree==0) selected @endif>Yes</option>
								<option value="1" @if($liveClass->isFree==1) selected @endif>No</option>
							</select>
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-primary">Update</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	@endcan
	{{--end section for instructor--}}

@endsection

@section('javascript')
    <script type="text/javascript">
        function AvoidSpace(event) {
            var k = event ? event.which : window.event.keyCode;
            if (k == 32) return false;
        }
    </script>
@endsection
