@extends('layouts.app')
@section('content')

	{{--section for instructor--}}
	@can('users_manage')
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Edit Subscription</div>
				<div class="panel-body">

					<form action="{{route('admin.updateSubscription',['id'=> $data->id])}}" class="" method="post" enctype="multipart/form-data">

						<input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
						
						<div class="form-group">
							<label for="name">Plan Name</label>
							<input type="text" name="name" class="form-control" placeholder="Plan Name" value="{{$data->name}}" required>
						</div>
						
						<div class="form-group">
							<label for="month">Number of Month</label>
							<input type="number" name="month" class="form-control" placeholder="Number of Month" value="{{$data->month}}" required>
						</div>

						<div class="form-group">
							<label for="price">Subscription Price</label>
							<input type="number" name="price" class="form-control" placeholder="Subscription Price" value="{{$data->price}}" required>
						</div>
						
						<div class="form-group">
							<label for="image">Image (Image Diamention 450px X 575px)</label>
							<input type="file" name="image" class="form-control" accept="image/*">
							@if($data->image)
								<img class="img-responsive" src="{{asset('upload/subscriptions/'.$data->image)}}" width="200">
							@endif
						</div>
						
						<div class="form-group">
							<label for="video">Video</label>
							<input type="file" name="video" class="form-control" accept="video/mp4,video/x-m4v,video/*">
							@if($data->video)
								<iframe width="560" height="315" src="{{asset('upload/subscriptions/'.$data->video)}}" frameborder="0" controls="0" autoplay="0" allowfullscreen sandbox></iframe>
							@endif
						</div>
						
						<div class="form-group">
							<label for="description">Description</label>
							<textarea name="description" class="form-control ckeditor" placeholder="Description">{!!$data->description!!}</textarea>
						</div>
						    
						<div class="form-group">
							<label for="faqs">FAQs</label>
							@php $faqs = json_decode($data->faqs, true); @endphp
							@if($faqs)
							@foreach ($faqs as $key => $value)
							<div class="input-group">
								<div class="form-group">
									<label for="question">Question</label>
									<input type="text" name="question[]" class="form-control" placeholder="Question" value="<?php echo $value['question']; ?>">
								</div>
								<div class="form-group">
									<label for="answer">Answer</label>
									<textarea name="answer[]" class="form-control" placeholder="Answer"><?php echo $value['answer']; ?></textarea>
								</div>
								<div class="input-group-addon">
									<a href="javascript:void(0)" class="btn btn-danger removepricingfaq"><span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span> Remove</a>
								</div>
							</div>
							@endforeach
							@endif
							<div class="" id="addpricingfaq"></div>
							<a href="javascript:" id="addbtnpricingfaq" class="btn btn-primary" style="margin-top: 10px;">Add More </a>
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
