@extends('layouts.app')

@section('content')

	{{--section for instructor--}}
	@can('page')

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">Edit Portfolio</div>
					<div class="panel-body">


						<form action="{{route('admin.updatePortfolio',['id'=> $portfolio->id])}}" method="post" enctype="multipart/form-data">

							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							
							<div class="form-group">
								<label for="title">Title</label>
								<input type="text" name="title" class="form-control" placeholder="Title" required value="{{$portfolio->title}}">
							</div>

							<div class="form-group">
								<label for="sub_title">Sub Title</label>
								<input type="text" name="sub_title" class="form-control" placeholder="Content" value="{{$portfolio->sub_title}}">
							</div>

							<div class="form-group">
								<label for="image">Image (Image Diamention 265px X 200px)</label>
								<input type="file" name="image" class="form-control" accept="image/*">
								@if($portfolio->image)
								<img src="{{asset('/upload/portfolios/'.$portfolio->image)}}" class="img-responsive">
								@endif
							</div>

							<div class="form-group">
								<label for="select_row">Select Row</label>
								<select name="select_row" class="form-control">
									<option value="1" @if($portfolio->select_row==1)selected @endif>First Row</option>
									<option value="2" @if($portfolio->select_row==2)selected @endif>Second Row</option>
								</select>
							</div>

							<div class="form-group">
								<button type="submit" class="btn btn-primary"> Update </button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	@endcan
	{{--end section for instructor--}}

@endsection
