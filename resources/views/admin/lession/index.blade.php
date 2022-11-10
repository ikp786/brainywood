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
	@can('lession')

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">All Lessions</div>
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
                        <form name="filterfrm" action="{{route('admin.AllLessions')}}" method="GET">
                            <div class="row">
                                <div class="form-group col-md-3">
                                </div>
                                <div class="form-group col-md-3">
                                    <select name="course" class="form-control select2">
                                        <option value="">-select course-</option>
                                        @if($courses)
                                        @foreach($courses as $course)
                                        <option value="{{$course->id}}" @if($request->query('course')==$course->id)selected @endif>{{$course->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <a href="{{route('admin.AllLessions')}}" class="btn btn-warning">RESET</a>
                                    <button class="btn btn-info">GET</button>
                                </div>
                            </div>
                        </form>

						<div class="box-default text-right">
							<a class="btn btn-bitbucket float-right" href="{{route('admin.createLessionRoute')}}">Add new lession</a>
						</div>
						<p></p>
						<table class="table table-bordered table-striped dt-select {{ count($data) > 0 ? 'datatable' : '' }}" id="courses">
							<thead>
								<tr>
									<th>#</th>
									<th>Course Name</th>
									<th>Lession Name</th>
									<th>Created At</th>
									<th>Status</th>
									<th>Sort Order</th>
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
									<td>@if($single->courseId>0){{$single->courses->name}}@endif</td>
									<td>{{$single->name}}</td>
									<td>
										{{$single->created_at}}      
									</td>
									<td>
										<?php if($single->status==1) { ?><a href="<?php echo url('admin/lession/updateStatus') ?>/<?php echo $single->id; ?>/0" class="label label-success">Active</a> <?php } else { ?><a href="<?php echo url('admin/lession/updateStatus') ?>/<?php echo $single->id; ?>/1" class="label label-danger">Inactive</a> <?php } ?>
									</td>
									<td>
										@if($single->sort_id>1)<a href="{{route('admin.lessionsortUp',['id'=> $single->id,'sort_id'=>$single->sort_id])}}" title="Up"><i class="fa fa-arrow-circle-o-up"></i></a>@endif
										@if($single->sort_id<$totalData)<a href="{{route('admin.lessionsortDown',['id'=> $single->id,'sort_id'=>$single->sort_id])}}" title="Down"><i class="fa fa-arrow-circle-o-down"></i></a>@endif
									</td>
									<td>
										<a href="{{route('admin.editLession',['id'=> $single->id])}}">Edit</a>
										<!-- <a href="{{route('admin.deleteLession',['id'=> $single->id])}}" onclick="return confirm('Are you sure you want to delete this?');">Delete</a> -->
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


