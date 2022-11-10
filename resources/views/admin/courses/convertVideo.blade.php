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
	@can('lession')

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">All Courses Converted Video</div>
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

						<div class="box-default text-right">
							<!-- <a class="btn btn-bitbucket float-right" href="{{route('admin.createLessionChapter')}}">Add New</a> -->
						</div>
						<p></p>
						<table class="table table-bordered" id="courses">
							<thead>
								<tr>
									<th>#</th>
									<th>Course Name</th>
									<th>Video Quality</th>
									<th>Created At</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$i = 1;
								$totalData = count($data);
							?>
							@foreach($data as $single)
								<tr>
									<td>{{$i}}</td>
									<td>{{$single->course->name}}</td>
									<td>@if($single->low_status == 1)Low @elseif($single->med_status == 1)Medium @elseif($single->high_status == 1)High @else @endif</td>
									<td>{{$single->created_at}}</td>
									<td>
										@if($single->low_status == 1)
										<a href="{{asset('course') . '/' . $single->low_video}}" target="_blank">View</a>
										@endif
										@if($single->med_status == 1)
										<a href="{{asset('course') . '/' . $single->med_video}}" target="_blank">View</a>
										@endif
										@if($single->high_status == 1)
										<a href="{{asset('course') . '/' . $single->high_video}}" target="_blank">View</a>
										@endif
										<a href="{{route('admin.approveVideoCourse',['id'=> $single->id])}}">Approve</a>
										<!-- <a href="{{route('admin.deleteLessionChapter',['id'=> $single->id])}}" onclick="return confirm('Are you sure you want to delete this?');">Delete</a> -->
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
