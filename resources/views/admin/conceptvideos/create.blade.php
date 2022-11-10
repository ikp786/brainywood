@extends('layouts.app')
@section('javascript')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
<script>
	$.noConflict();
	var SITEURL = "{{URL('/')}}";
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
				window.location.href = SITEURL +"/"+"admin/conceptvideos";
			}
		});
	});
</script>
@endsection
@section('content')

	{{--section for instructor--}}
	@can('concept_video')
	<style>
        .progress { position:relative; width:100%; }
        .bar { background-color: #FF7A17; width:0%; height:20px; }
        .percent { position:absolute; display:inline-block; left:50%; color: #040608; top: 0;}
    </style>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Add New Concept Video</div>
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

					<form action="{{route('admin.storeConceptVideo')}}" enctype="multipart/form-data" class="" method="post">

						<input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
						
						<div class="form-group">
							<label for="name">Video Name</label>
							<input type="text" name="name" class="form-control" placeholder="Name of Video" required>
						</div>

						<div class="form-group">
							<label for="image">Upload Video Thumbnail (Image Diamention 700px X 700px)</label>
							<input type="file" name="image" class="form-control" accept="image/*" required>
						</div>

						<div class="form-group">
							<label for="video">Upload Video</label>
							<input type="file" name="video" class="form-control" accept="video/mp4,video/x-m4v,video/*" required>
							<div class="progress">
	                            <div class="bar"></div>
	                            <div class="percent">0%</div>
	                        </div>
						</div>

						<div class="form-group">
							<label for="paid">Free Video</label>
							<!-- <input type="checkbox" name="paid" class="" value="1"> -->
							<select name="paid" class="form-control">
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
