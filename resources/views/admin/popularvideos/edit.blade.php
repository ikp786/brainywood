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
						window.location.href = SITEURL +"/"+"admin/popularvideos";
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
	@can('popular_video')
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
				<div class="panel-heading">Edit Popular Video</div>
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

					<form action="{{route('admin.updatePopularVideo',['id'=> $data->id])}}" class="" id="form1" method="post" enctype="multipart/form-data">

						<input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
						
						<div class="form-group">
							<label for="name">Video Name</label>
							<input type="text" name="name" class="form-control" placeholder="Name of Video" value="{{$data->name}}" required>
						</div>

						<div class="form-group">
							<label for="image">Upload Video Thumbnail (Image Diamention 700px X 700px)</label>
							<input type="file" name="image" class="form-control" accept="image/*">
							@if($data->video_thumb)
							<div class="img-wrap">
							    <a href="{{route('admin.imgremovePopularVideo', $data->id)}}"><span class="close">&times;</span></a>
							    <img src="{{asset('/upload/popularvideos/'.$data->video_thumb)}}" width="100">
							</div>
							@endif
						</div>

						<div class="form-group">
							<label for="video">Upload Video</label>
							<input type="file" name="video" id="video_file" class="form-control" accept="video/mp4,video/x-m4v,video/*">
							<div class="progress">
	                            <div class="bar"></div>
	                            <div class="percent"></div>
	                        </div>
							<div class="vid-wrap">
							    <a href="{{route('admin.vidremovePopularVideo', $data->id)}}"><span class="close">&times;</span></a>
								<iframe width="560" height="315" src="{{asset('/upload/popularvideos/'.$data->video)}}" frameborder="0" controls="0" autoplay="0" allowfullscreen sandbox></iframe>
							</div>
						</div>

						<div class="form-group">
							<label for="paid">Free Video</label>
							<!-- <input type="checkbox" name="paid" class="" value="1" @if($data->paid==1) checked @endif> -->
							<select name="paid" class="form-control">
								<option value="0" <?php if($data->paid==0) { echo 'selected'; } ?>>Yes</option>
								<option value="1" <?php if($data->paid==1) { echo 'selected'; } ?>>No</option>
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
