@extends('layouts.app')
@section('content')

	{{--section for instructor--}}
	@can('users_manage')
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
	</style>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Add New Subscription</div>
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

					<form action="{{route('admin.storeSubscription')}}" class="" method="post" enctype="multipart/form-data">

						<input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
						
						<div class="form-group">
							<label for="name">Plan Name</label>
							<input type="text" name="name" class="form-control" placeholder="Plan Name" required>
						</div>
						
						<div class="form-group">
							<label for="month">Number of Month</label>
							<input type="number" name="month" class="form-control" placeholder="Number of Month" required>
						</div>

						<div class="form-group">
							<label for="price">Subscription Price</label>
							<input type="number" name="price" class="form-control" placeholder="Subscription Price" required>
						</div>
						
						<div class="form-group">
							<label for="image">Image (Image Diamention 450px X 575px)</label>
							<input type="file" name="image" class="form-control" accept="image/*">
						</div>
						
						<div class="form-group">
							<label for="video">Video</label>
							<input type="file" name="video" class="form-control" accept="video/mp4,video/x-m4v,video/*">
						</div>
						
						<div class="form-group">
							<label for="description">Description</label>
							<textarea name="description" class="form-control ckeditor" placeholder="Description"></textarea>
						</div>
						    
						<div class="form-group">
							<label for="faqs">FAQs</label>
							<div class="input-group">
								<div class="form-group">
									<label for="question">Question</label>
									<input type="text" name="question[]" class="form-control" placeholder="Question">
								</div>
								<div class="form-group">
									<label for="answer">Answer</label>
									<textarea name="answer[]" class="form-control" placeholder="Answer"></textarea>
								</div>
								<div class="input-group-addon">
									<a href="javascript:void(0)" class="btn btn-danger removepricingfaq"><span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span> Remove</a>
								</div>
							</div>
							<div class="" id="addpricingfaq"></div>
							<a href="javascript:" id="addbtnpricingfaq" class="btn btn-primary" style="margin-top: 10px;">Add More </a>
						</div>
					    
						<div class="form-group">
							<button type="submit" class="btn btn-success">Save</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	@endcan
	{{--end section for instructor--}}

@endsection
