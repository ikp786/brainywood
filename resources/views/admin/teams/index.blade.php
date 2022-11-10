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
	@can('team_member')

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">All Team Members</div>
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
							<a class="btn btn-bitbucket float-right" href="{{route('admin.createTeam')}}">Add New</a>
						</div>
						<p></p>
						<table class="table table-bordered table-striped dt-select {{ count($data) > 0 ? 'datatable' : '' }}" id="courses">
							<thead>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th>Position</th>
									<th>Image</th>
									<th>Status</th>
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
									<td>{{$single->name}}</td>
									<td>{{$single->position}}</td>
									<td>@if($single->image)<img class="img-responsive" src="<?php echo url('upload/teams') ?>/<?php echo $single->image; ?>" width="100">@endif</td>
									<td>
										<?php if($single->status==1) { ?><a href="<?php echo url('admin/teams/updateStatus') ?>/<?php echo $single->id; ?>/0" class="label label-success">Active</a> <?php } else { ?><a href="<?php echo url('admin/teams/updateStatus') ?>/<?php echo $single->id; ?>/1" class="label label-danger">Inactive</a> <?php } ?>
									</td>
									<td>{{$single->created_at}}</td>
									<td>
										<a href="{{route('admin.editTeam',['id'=> $single->id])}}">Edit</a>
										<a href="{{route('admin.deleteTeam',['id'=> $single->id])}}" onclick="return confirm('Are you sure you want to delete this?');">Delete</a>
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
