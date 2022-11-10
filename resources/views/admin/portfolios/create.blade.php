@extends('layouts.app')

@section('content')

	{{--section for instructor--}}
	@can('page')
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Add Portfolio</div>
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

					<form action="{{route('admin.storePortfolio')}}" class="" method="post" enctype="multipart/form-data">

						<input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
						
						<div class="form-group">
							<label for="title">Title</label>
							<input type="text" name="title" class="form-control" placeholder="Title" required>
						</div>

						<div class="form-group">
							<label for="sub_title">Sub Title</label>
							<input type="text" name="sub_title" class="form-control" placeholder="Sub Title"></textarea>
						</div>
						
						<div class="form-group">
							<label for="image">Image (Image Diamention 265px X 200px)</label>
							<input type="file" name="image" class="form-control" accept="image/*" required>
						</div>

						<div class="form-group">
							<label for="select_row">Select Row</label>
							<select name="select_row" class="form-control">
								<option value="1">First Row</option>
								<option value="2">Second Row</option>
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
