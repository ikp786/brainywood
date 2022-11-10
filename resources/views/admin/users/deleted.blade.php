@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
	<h3 class="page-title">Deleted @lang('global.users.title')</h3>

	<div class="panel panel-default">
		<div class="panel-heading">
			@lang('global.app_list')
		</div>

		<div class="panel-body table-responsive">
			<table class="table table-bordered table-striped {{ count($users) > 0 ? 'datatable' : '' }} dt-select">
				<thead>
					<tr>
						<!-- <th style="text-align:center;"><input type="checkbox" id="select-all" /></th> -->
						<th>#</th>
						<th>@lang('global.users.fields.name')</th>
						<th>@lang('global.users.fields.email')</th>
						<th>Phone</th>
						<th>@lang('global.users.fields.roles')</th>
						<!-- <th>Status</th> -->
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@if (count($users) > 0)
                        @php $i = 1; @endphp
						@foreach ($users as $user)
							<tr data-entry-id="{{ $user->id }}">
								<td>{{$i}}</td>
								<td>{{ $user->name }}</td>
								<td>{{ $user->email }}</td>
								<td>{{ $user->phone }}</td>
								<td>@if($user->role_id==1)Administrator @elseif($user->role_id==2)Teacher @elseif($user->role_id==3)Student @else - @endif</td>
								<!-- <td>
									<?php if($user->status==1) { ?><a href="<?php echo url('admin/users/updateStatus') ?>/<?php echo $user->id; ?>/0" class="label label-success">Deactive</a> <?php } else { ?><a href="<?php echo url('admin/users/updateStatus') ?>/<?php echo $user->id; ?>/1" class="label label-danger">Active</a> <?php } ?>
								</td> -->
								<td>
									<a href="{{ route('admin.restoreUsers',[$user->id]) }}" class="btn btn-xs btn-info">Restore</a>
								</td>
							</tr>
                        	@php $i++; @endphp
						@endforeach
					@else
						<tr>
							<td colspan="9">@lang('global.app_no_entries_in_table')</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
@stop

@section('javascript') 
	@if(auth()->user()->role_id!=1)
	<script>
		window.route_mass_crud_entries_destroy = '{{ route('admin.users.mass_destroy') }}';
	</script>
	@endif
@endsection