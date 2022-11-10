@extends('layouts.app')

@section('content')

	{{--section for instructor--}}
	@can('quiz')
	<style type="text/css">
		.input-group .input-group-addon {
			border-radius: 0;
			border-color: #ffffff;
			background-color: #fff;
		}
		.removefat{
			margin-top: 16px;
		}
		.removefaq{
			margin-top: 16px;
		}
	</style>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Add New Quiz</div>
				<div class="panel-body">
					@if(Session::has('msg'))
						<div class="alert alert-info">
							<a class="close" data-dismiss="alert">×</a>
							<strong>{!!Session::get('msg')!!}</strong>
						</div>
					@endif
					@if(Session::has('error'))
						<div class="alert alert-danger">
							<a class="close" data-dismiss="alert">×</a>
							<strong>{!!Session::get('error')!!}</strong>
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

					<form action="{{route('admin.quizStore')}}" class="" method="post" enctype="multipart/form-data">

						<input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
						<div class="form-group">
							<label for="name">Quiz Title</label>
							<input type="text" name="name" class="form-control" placeholder="Quiz Title" required>
						</div>

						<div class="form-group">
							<label for="type">Quiz Type</label>
							<select name="type" id="type" class="form-control">
								<option value="0">Lession</option>
								<option value="1">Course</option>
							</select>
						</div>

						<div class="form-group">
							<label for="courseId">Select Course</label>
							<select name="courseId" id="courseId" class="form-control" required>
								<option value="">--Select--</option>
								<?php foreach ($courses as $key => $value) {
									?>
									<option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
									<?php
									 }
								?>
							</select>
						</div>

						<div class="form-group" id="lession">
							<label for="lessionId">Select Lession</label>
							<select name="lessionId" id="lessionId" class="form-control">
								<option value="0">--Select--</option>
							</select>
						</div>

						<div class="form-group">
							<label for="duration">Quiz Total Time</label>
						</div>
						<div class="form-group">
							<div class="col-md-6">
								<label for="duration">Hours</label>
								<select name="hours" class="form-control">
									<?php
										for ($i=0; $i <= 12; $i++) {
											if ($i < 10){
												$i = '0'.$i;
											}
									?>
									<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-md-6">
								<label for="duration">Minutes</label>
								<select name="minutes" class="form-control">
									<?php
										for ($i=0; $i <= 59; $i++) {
											if ($i < 10){
												$i = '0'.$i;
											}
									?>
									<option value="<?php echo $i; ?>" <?php if($i==15){echo "selected"; } ?>><?php echo $i; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label for="guideline">Guideline</label>
							<textarea name="guideline" class="form-control ckeditor" required></textarea>
						</div>

						<div class="form-group">
							<label for="passing_percent">Minimum Passing Percentage</label>
							<input type="number" name="passing_percent" class="form-control" value="60.00" required>
						</div>

						<div class="ll">
							<div class="form-group">
								<label for="question">Quiz Question</label>
								<input type="text" name="question[]" class="form-control" placeholder="Enter a Question?" required>
							</div>
							<div class="form-group">
								<label for="image">Quiz Question Image</label>
								<input type="file" name="image[]" class="form-control" accept="image/*">
							</div>
							<div class="form-group col-md-6">
								<label for="courseID">Option-1 <input type="radio" name="option_1" onclick="Check();" value="1" checked>Text <input type="radio" name="option_1" onclick="Check();" value="0">Image </label>
								<div class="text_1">
									<input type="text" name="option[0][]" class="form-control">
								</div>
								<div class="image_1" style="display: none;">
									<input type="file" name="option[0][]" class="form-control" accept="image/*">
								</div>
							</div>
							<div class="form-group col-md-6">
								<label for="courseID">Option-2 <input type="radio" name="option_2" onclick="Check();" value="1" checked>Text <input type="radio" name="option_2" onclick="Check();" value="0">Image </label>
								<div class="text_2">
									<input type="text" name="option[0][]" class="form-control">
								</div>
								<div class="image_2" style="display: none;">
									<input type="file" name="option[0][]" class="form-control" accept="image/*">
								</div>
							</div>
							<div class="form-group col-md-6">
								<label for="courseID">Option-3 <input type="radio" name="option_3" onclick="Check();" value="1" checked>Text <input type="radio" name="option_3" onclick="Check();" value="0">Image </label>
								<div class="text_3">
									<input type="text" name="option[0][]" class="form-control">
								</div>
								<div class="image_3" style="display: none;">
									<input type="file" name="option[0][]" class="form-control" accept="image/*">
								</div>
							</div>
							<div class="form-group col-md-6">
								<label for="courseID">Option-4 <input type="radio" name="option_4" onclick="Check();" value="1" checked>Text <input type="radio" name="option_4" onclick="Check();" value="0">Image </label>
								<div class="text_4">
									<input type="text" name="option[0][]" class="form-control">
								</div>
								<div class="image_4" style="display: none;">
									<input type="file" name="option[0][]" class="form-control" accept="image/*">
								</div>
							</div>
							<div class="form-group">
								<label for="Currectoption">Currect option</label><br>
								<label><input type="radio" name="Currectoption[0][]" value="1" checked> Option-1 </label>
								<label><input type="radio" name="Currectoption[0][]" value="2"> Option-2 </label>
								<label><input type="radio" name="Currectoption[0][]" value="3"> Option-3 </label>
								<label><input type="radio" name="Currectoption[0][]" value="4"> Option-4 </label>
							</div>
							<div class="form-group">
								<label for="marks">Marks</label>
								<input type="number" name="marks[]" class="form-control" required>
							</div>
							<div class="form-group">
								<label for="solution">Solution</label>
								<textarea name="solution[]" class="form-control" required></textarea>
							</div>
						</div>

						<div id="addmQUiz"></div>
						<a href="javascript:" class="btn btn-primary" id="addmoreQuiz">Add More</a>

						<div class="form-group" style="margin-top: 10px;">
							<button type="submit" class="btn btn-success"> Save Quiz</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	@endcan
	{{--end section for instructor--}}

@endsection

@section('javascript')
<script>
	function Check() {
		var option_1 = $("input[name='option_1']:checked").val();
	    if (option_1 == 1) {
	        $('.text_1').show();
	        $('.image_1').hide();
	    } else {
	        $('.image_1').show();
	        $('.text_1').hide();
	    }
		var option_2 = $("input[name='option_2']:checked").val();
	    if (option_2 == 1) {
	        $('.text_2').show();
	        $('.image_2').hide();
	    } else {
	        $('.image_2').show();
	        $('.text_2').hide();
	    }
		var option_3 = $("input[name='option_3']:checked").val();
	    if (option_3 == 1) {
	        $('.text_3').show();
	        $('.image_3').hide();
	    } else {
	        $('.image_3').show();
	        $('.text_3').hide();
	    }
		var option_4 = $("input[name='option_4']:checked").val();
	    if (option_4 == 1) {
	        $('.text_4').show();
	        $('.image_4').hide();
	    } else {
	        $('.image_4').show();
	        $('.text_4').hide();
	    }
	}
</script>
@endsection
