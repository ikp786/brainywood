@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')
@section('javascript')
	<script type="text/javascript">
		$(document).ready(function () {
			$(".courseId").change(function () {
				if ($(this).val() != "") {
					var _token = $('input[name="_token"]').val();
					var value = $(this).val();
					$.ajax({
						url: "get_lessions_by_course",
						method: "POST",
						data: { _token: _token,courseId: value },
						success: function (result) {
							$(".lessionId").html(result);
						},
					});
				}
			});

			$(".lessionId").change(function () {
				if ($(this).val() != "") {
					var _token = $('input[name="_token"]').val();
					var courseId = $(".courseId").val();
					var value = $(this).val();
					var question = $("#question").val();
					$.ajax({
						url: "get_topics_by_lession",
						method: "POST",
						data: { _token: _token,courseId: courseId,lessionId: value,search: question },
						success: function (result) {
							$(".topicId").html(result);
						},
					});
				}
			});
		});
	</script>
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
	@can('question_answer')

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">All Question Answers (Q & A)</div>
					<div class="panel-body">
						<div class="box-default text-right">
							<!-- <a class="btn btn-bitbucket float-right" href="{{route('admin.createQuestionAnswer')}}">Add New Question Answer</a> -->
						</div>

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
						<form name="filterfrm" action="{{route('admin.AllQuestionAnswer')}}" method="GET">
							<div class="row">
								<div class="form-group col-md-2">
									<select name="course" class="form-control select2 courseId">
										<option value="">-select course-</option>
										@if($courses)
										@foreach($courses as $course)
										<option value="{{$course->id}}" @if($request->query('course')==$course->id)selected @endif>{{$course->name}}</option>
										@endforeach
										@endif
									</select>
								</div>
								<div class="form-group col-md-2">
									<select name="lession" class="form-control select2 lessionId">
										<option value="">-select lession-</option>
										@if($lessions)
										@foreach($lessions as $lession)
										<option value="{{$lession->id}}" @if($request->query('lession')==$lession->id)selected @endif>{{$lession->name}}</option>
										@endforeach
										@endif
									</select>
								</div>
								<div class="form-group col-md-2">
									<select name="topic" class="form-control select2 topicId">
										<option value="">-select topic-</option>
										@if($topics)
										@foreach($topics as $topic)
										<option value="{{$topic->id}}" @if($request->query('topic')==$topic->id)selected @endif>{{$topic->name}}</option>
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
							</div>
							<div class="row">
								<div class="form-group col-md-5"></div>
								<div class="form-group col-md-2">
									<a href="{{route('admin.AllQuestionAnswer')}}" class="btn btn-warning">RESET</a>
									<button class="btn btn-info">GET</button>
								</div>
							</div>
						</form>

						<div class="row">
							<div class="col-md-6">
								<div class="bg-primary">
									<h2><i class="fa fa-quora" aria-hidden="true"></i> {{$totalQuestions}}</h2>
									<span>Total Question Asked</span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="bg-info">
									<h2><i class="fa fa-comments" aria-hidden="true"></i> {{$totalAnswers}}</h2>
									<span>Total Given Answer</span>
								</div>
							</div>
						</div>
						<p></p>
						<table class="table table-bordered table-striped dt-select {{ count($data) > 0 ? 'datatable' : '' }}" id="courses">
							<thead>
								<tr>
									<th>#</th>
									<th>Course Name</th>
									<th>Lession Name</th>
									<th>Topic Name</th>
									<th>Question</th>
									<th>Asked By</th>
									<th>Created At</th>
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
											<td>@if($val->course_id>0){{$val->course->name}}@endif</td>
											<td>@if($val->lession_id>0){{$val->lession->name}}@endif</td>
											<td>@if($val->topic_id>0){{$val->topic->name}}@endif</td>
											<td>@if(strlen($val->question) > 50){{substr($val->question,0,50)}} @else{{$val->question}}@endif</td>
											<td>@if($val->user_id>0){{$val->user->name.' - '.$val->user->phone}}@endif</td>
											<td>{{$val->created_at}}</td>
											<td>
												<?php if($val->status==1) { ?><a href="<?php echo url('admin/questionanswers/updateStatus') ?>/<?php echo $val->id; ?>/0" class="label label-success">Active</a> <?php } else { ?><a href="<?php echo url('admin/questionanswers/updateStatus') ?>/<?php echo $val->id; ?>/1" class="label label-danger">Inactive</a> <?php } ?>
											</td>
											<td>
												<a href="{{route('admin.viewQuestionAnswer',['id'=> $val->id])}}">View</a>
												<a href="{{route('admin.editQuestionAnswer',['id'=> $val->id])}}">Edit</a>
												<!-- <a href="{{route('admin.deleteQuestionAnswer',['id'=> $val->id])}}" onclick="return confirm('Are you sure you want to delete this?');">Delete</a> -->
											</td>
										</tr>
									@endif
								@elseif($request->query('status')=='inactive')
									@if($val->status==0)
										<tr>
											<td>{{$i}}</td>
											<td>@if($val->course_id>0){{$val->course->name}}@endif</td>
											<td>@if($val->lession_id>0){{$val->lession->name}}@endif</td>
											<td>@if($val->topic_id>0){{$val->topic->name}}@endif</td>
											<td>@if(strlen($val->question) > 50){{substr($val->question,0,50)}} @else{{$val->question}}@endif</td>
											<td>@if($val->user_id>0){{$val->user->name.' - '.$val->user->phone}}@endif</td>
											<td>{{$val->created_at}}</td>
											<td>
												<?php if($val->status==1) { ?><a href="<?php echo url('admin/questionanswers/updateStatus') ?>/<?php echo $val->id; ?>/0" class="label label-success">Active</a> <?php } else { ?><a href="<?php echo url('admin/questionanswers/updateStatus') ?>/<?php echo $val->id; ?>/1" class="label label-danger">Inactive</a> <?php } ?>
											</td>
											<td>
												<a href="{{route('admin.viewQuestionAnswer',['id'=> $val->id])}}">View</a>
												<a href="{{route('admin.editQuestionAnswer',['id'=> $val->id])}}">Edit</a>
												<!-- <a href="{{route('admin.deleteQuestionAnswer',['id'=> $val->id])}}" onclick="return confirm('Are you sure you want to delete this?');">Delete</a> -->
											</td>
										</tr>
									@endif
								@else
									<tr>
										<td>{{$i}}</td>
										<td>@if($val->course_id>0){{$val->course->name}}@endif</td>
										<td>@if($val->lession_id>0){{$val->lession->name}}@endif</td>
										<td>@if($val->topic_id>0){{$val->topic->name}}@endif</td>
										<td>@if(strlen($val->question) > 50){{substr($val->question,0,50)}} @else{{$val->question}}@endif</td>
										<td>@if($val->user_id>0){{$val->user->name.' - '.$val->user->phone}}@endif</td>
										<td>{{$val->created_at}}</td>
										<td>
											<?php if($val->status==1) { ?><a href="<?php echo url('admin/questionanswers/updateStatus') ?>/<?php echo $val->id; ?>/0" class="label label-success">Active</a> <?php } else { ?><a href="<?php echo url('admin/questionanswers/updateStatus') ?>/<?php echo $val->id; ?>/1" class="label label-danger">Inactive</a> <?php } ?>
										</td>
										<td>
											<a href="{{route('admin.viewQuestionAnswer',['id'=> $val->id])}}">View</a>
											<a href="{{route('admin.editQuestionAnswer',['id'=> $val->id])}}">Edit</a>
											<!-- <a href="{{route('admin.deleteQuestionAnswer',['id'=> $val->id])}}" onclick="return confirm('Are you sure you want to delete this?');">Delete</a> -->
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
