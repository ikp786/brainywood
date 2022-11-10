@extends('layouts.app')

@section('content')

	{{--section for instructor--}}
	@can('student_class')

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">Edit Class</div>
					<div class="panel-body">


						<form action="{{route('admin.updateStudentClass',['id'=> $stClass->id])}}" method="post" enctype="multipart/form-data">

							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							
							<div class="form-group">
								<label for="class_name">Class Name</label>
								<input type="text" name="class_name" class="form-control" placeholder="Class Name" required value="{{$stClass->class_name}}">
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
