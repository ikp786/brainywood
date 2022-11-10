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
	@can('liveclasses')

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">All Live Classes</div>
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
						<form name="filterfrm" action="{{route('admin.AllLiveclasses')}}" method="GET">
							<div class="row">
								<div class="form-group col-md-2">
									<select name="added_by" class="form-control select2">
										<option value="">-select added by-</option>
										@if($users)
										@foreach($users as $user)
										<option value="{{$user->id}}" @if($request->query('added_by')==$user->id)selected @endif>{{$user->name.' - '.$user->phone}}</option>
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
									<select name="status" class="form-control">
										<option value="">-select status-</option>
										<option value="active" @if($request->query('status')=='active')selected @endif>Active</option>
										<option value="inactive" @if($request->query('status')=='inactive')selected @endif>Inactive</option>
									</select>
								</div>
								<div class="form-group col-md-2">
									<a href="{{route('admin.AllLiveclasses')}}" class="btn btn-warning">RESET</a>
									<button class="btn btn-info">GET</button>
								</div>
							</div>
						</form>

						<div class="box-default text-right">
							<a class="btn btn-bitbucket float-right" href="{{route('admin.createLiveclass')}}">Add New Live Class</a>
						</div>
						<p></p>
						<table class="table table-bordered table-striped dt-select {{ count($data) > 0 ? 'datatable' : '' }}" id="courses">
							<thead>
								<tr>
									<th>#</th>
									<th>Added By</th>
									<th>Title</th>
									<th>Subject</th>
									<th>Class Time</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							<?php $i = 1; ?>
							@foreach($data as $val)
								@if($request->query('status')=='active')
									@if($val->status==1)
										<tr>
											<td>{{$i}}</td>
											<!--<td><img class="img-responsive" src="<?php echo asset('upload/liveclasses') ?>/<?php echo $val->image; ?>" width="100"></td>-->
											<td>{{$val->user->name}}</td>
											<td>{{$val->title}}</td>
											<td>{{$val->subject}}</td>
											<td>{{$val->class_time}}</td>
											<td>
												<?php if($val->status==1) { ?><a href="<?php echo url('admin/liveclasses/updateStatus') ?>/<?php echo $val->id; ?>/0" class="label label-success">Active</a> <?php } else { ?><a href="<?php echo url('admin/liveclasses/updateStatus') ?>/<?php echo $val->id; ?>/1" class="label label-danger">Inactive</a> <?php } ?>
											</td>
											<td>
												<a href="{{route('admin.editLiveclass',['id'=> $val->id])}}">Edit</a>
												<!-- <a href="{{route('admin.deleteLiveclass',['id'=> $val->id])}}" onclick="return confirm('Are you sure you want to delete this?');">Delete</a> -->
											</td>
										</tr>
									@endif
								@elseif($request->query('status')=='inactive')
									@if($val->status==0)
										<tr>
											<td>{{$i}}</td>
											<!--<td><img class="img-responsive" src="<?php echo asset('upload/liveclasses') ?>/<?php echo $val->image; ?>" width="100"></td>-->
											<td>{{$val->user->name}}</td>
											<td>{{$val->title}}</td>
											<td>{{$val->subject}}</td>
											<td>{{$val->class_time}}</td>
											<td>
												<?php if($val->status==1) { ?><a href="<?php echo url('admin/liveclasses/updateStatus') ?>/<?php echo $val->id; ?>/0" class="label label-success">Active</a> <?php } else { ?><a href="<?php echo url('admin/liveclasses/updateStatus') ?>/<?php echo $val->id; ?>/1" class="label label-danger">Inactive</a> <?php } ?>
											</td>
											<td>
												<a href="{{route('admin.editLiveclass',['id'=> $val->id])}}">Edit</a>
												<!-- <a href="{{route('admin.deleteLiveclass',['id'=> $val->id])}}" onclick="return confirm('Are you sure you want to delete this?');">Delete</a> -->
											</td>
										</tr>
									@endif
								@else
									<tr>
										<td>{{$i}}</td>
										<!--<td><img class="img-responsive" src="<?php echo asset('upload/liveclasses') ?>/<?php echo $val->image; ?>" width="100"></td>-->
										<td>{{$val->user->name}}</td>
										<td>{{$val->title}}</td>
										<td>{{$val->subject}}</td>
										<td>{{$val->class_time}}</td>
										<td>
											<?php if($val->status==1) { ?><a href="<?php echo url('admin/liveclasses/updateStatus') ?>/<?php echo $val->id; ?>/0" class="label label-success">Active</a> <?php } else { ?><a href="<?php echo url('admin/liveclasses/updateStatus') ?>/<?php echo $val->id; ?>/1" class="label label-danger">Inactive</a> <?php } ?>
										</td>
										<td>
											<a href="{{route('admin.editLiveclass',['id'=> $val->id])}}">Edit</a>
											<!-- <a href="{{route('admin.deleteLiveclass',['id'=> $val->id])}}" onclick="return confirm('Are you sure you want to delete this?');">Delete</a> -->
										</td>
									</tr>
								@endif
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
