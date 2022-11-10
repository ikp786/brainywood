@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')
@section('javascript')
	<script>
		jQuery(document).ready(function($) {
			var dt = $('#courses').DataTable();
			var export_filename = 'Filename-' + tools.date( '%d-%M-%Y' );
			new $.fn.dataTable.Buttons( dt, {
				buttons: [
					{
						text: '<i class="fa fa-lg fa-print"></i> Print Assets',
						extend: 'print',
						className: 'btn btn-primary btn-sm m-5 width-140 assets-select-btn export-print'
					}
				]
			} );

// Add the Print button to the toolbox
			dt.buttons( 1, null ).container().appendTo( '#anrbtn' );
		} );
	</script>
@endsection

@section('content')

	{{--section for instructor--}}
	@can('quiz')

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">All Quiz</div>
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
						<form name="filterfrm" action="{{route('admin.AllQuizs')}}" method="GET">
							<div class="row">
								<div class="form-group col-md-3">
									<select name="course" id="courseId" class="form-control select2">
										<option value="">-select course-</option>
										@if($courses)
										@foreach($courses as $course)
										<option value="{{$course->id}}" @if($request->query('course')==$course->id)selected @endif>{{$course->name}}</option>
										@endforeach
										@endif
									</select>
								</div>
								<div class="form-group col-md-3">
									<select name="lession" id="lessionId" class="form-control select2">
										<option value="">-select lession-</option>
										@if($lessions)
										@foreach($lessions as $lession)
										<option value="{{$lession->id}}" @if($request->query('lession')==$lession->id)selected @endif>{{$lession->name}}</option>
										@endforeach
										@endif
									</select>
								</div>
                                <div class="form-group col-md-2">
                                    <input type="date" name="from" class="form-control" value="@if($request->query('from')){{$request->query('from')}}@endif">
                                </div>
                                <div class="form-group col-md-2">
                                    <input type="date" name="to" class="form-control" value="@if($request->query('to')){{$request->query('to')}}@endif">
                                </div>
								<div class="form-group col-md-2">
									<a href="{{route('admin.AllQuizs')}}" class="btn btn-warning">RESET</a>
									<button class="btn btn-info">GET</button>
								</div>
							</div>
						</form>

						<div class="box-default text-right">
							<a class="btn btn-bitbucket float-right" href="{{route('admin.createQuizRoute')}}">Add new quiz</a>
						</div>
						<p></p>
						<table class="table table-bordered table-striped dt-select {{ count($data) > 0 ? 'datatable' : '' }}" id="courses">
							<thead>
							<tr>

								<th>#</th>
								<th>Quiz</th>
								<th>Course Name</th>
								<th>Lession Name</th>
								<th>Created At</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
							<?php $i = 1; ?>
							@foreach($data as $single)
								<tr>
									<td>{{$i}}</td>
									 <td>{{$single->name}}</td>
									<td>{{@$single->courses->name}}</td>
									  <td>{{@$single->lession->name}}</td>
									
									<td>
										{{$single->created_at}}      
									</td>
									  <td>
										<?php if($single->status==1) { ?><a href="<?php echo url('admin/quizs/updateStatus') ?>/<?php echo $single->id; ?>/0" class="label label-success">Active</a> <?php } else { ?><a href="<?php echo url('admin/quizs/updateStatus') ?>/<?php echo $single->id; ?>/1" class="label label-danger">Inactive</a> <?php } ?>
									</td>
									<td>
										<a href="{{route('admin.editQuiz',['id'=> $single->id])}}">Edit</a>
										<!-- <a href="{{route('admin.deleteQuiz',['id'=> $single->id])}}" onclick="return confirm('Are you sure you want to delete this?');">Delete</a> -->
									</td>
								</tr>
								  <?php $i++; ?>
							@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	@endcan
	{{--end section for instructor--}}



@endsection


