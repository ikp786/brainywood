@extends('layouts.app')
@section('content')

	{{--section for instructor--}}
	@can('quiz')
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Edit Quiz</div>
				<div class="panel-body">
					@if(Session::has('error'))
						<div class="alert alert-danger">
							<a class="close" data-dismiss="alert">×</a>
							<strong>{!!Session::get('error')!!}</strong>
						</div>
					@endif


					<form action="{{route('admin.quizUpdate',['id'=> $quiz->id])}}" enctype="multipart/form-data" class="" method="post">
						
						<input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
				
					    <div class="form-group">
							<label for="name">Quiz Title</label>
							<input type="text" name="name" class="form-control" placeholder="Quiz Title" value="<?php echo $quiz->name; ?>" required>
						</div>

						<div class="form-group">
							<label for="name">Quiz Type</label>
							<select name="type" id="type" class="form-control">
								<option value="0" <?php if($quiz->type==0) { echo 'selected'; } ?>>Lession</option>
								<option value="1" <?php if($quiz->type==1) { echo 'selected'; } ?>>Course</option>
							</select>
						</div>

						<div class="form-group">
							<label for="name">Select Course</label>
							<select name="courseId" id="courseId" class="form-control" required>
								<option value="">--Select--</option>
								<?php foreach ($course as $key => $value) {
									?>
									<option <?php if($value->id==$quiz->courseId) { echo 'selected'; } ?> value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
									<?php
									 }
								?>
							</select>
						</div>

						<div class="form-group" id="lession">
							<label for="name">Select Lession</label>
							<select name="lessionId" id="lessionId" class="form-control">
								<option value="0">--Select--</option>
								 <?php foreach ($lession as $key => $value) {
									?>
									<option <?php if($value->id==$quiz->lessionId) { echo 'selected'; } ?> value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
									<?php
									 }
								?>
							</select>
						</div>

						<div class="form-group">
							<label for="duration">Quiz Total Time</label>
						</div>
						<?php $time = explode(':', $quiz->duration); ?>
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
									<option value="<?php echo $i; ?>" <?php if(isset($time[0]) && $time[0]==$i){echo "selected"; } ?>><?php echo $i; ?></option>
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
									<option value="<?php echo $i; ?>" <?php if(isset($time[1]) && $time[1]==$i){echo "selected"; } ?>><?php echo $i; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label for="guideline">Guideline</label>
							<textarea name="guideline" class="form-control ckeditor" required><?php echo $quiz->guideline; ?></textarea>
						</div>

						<div class="form-group">
							<label for="passing_percent">Minimum Passing Percentage</label>
							<input type="number" name="passing_percent" class="form-control" value="<?php echo $quiz->passing_percent; ?>" required>
						</div>

						<?php foreach ($Response as $key => $value) { ?>
						<div class="input-group ll">
							<div class="row" style="margin:10px 0px 20px;border-top:1px solid #eee;">
								<div class="form-group">
									<label for="quizquestion">Quiz Question</label>
									<input type="text" name="question[]" class="form-control" placeholder="Enter a Question?" value="<?php echo $value['name']; ?>" required>
									<input type="hidden" name="questionId[<?php echo $key; ?>]" value="<?php echo $value['id']; ?>">
								</div>
								<div class="form-group">
									<label for="image">Quiz Question Image</label>
									<input type="file" name="image[]" class="form-control" accept="image/*">
									<?php if(!empty($value['image'])){ ?>
									<img src="<?php echo asset('upload/quizquestions') . "/" . $value['image']; ?>" width="100">
									<?php } ?>
								</div>
							</div>
							<div class="row">
							<?php if (isset($value['options']) && !empty($value['options'])) { ?>
							<?php foreach ($value['options'] as $key1 => $value1) { ?>
							<?php if ($key1 <= 3) { ?>
								<?php if($value1['val_type']==0){$inputType = 'file'; } else {$inputType = 'text'; } ?>
								<div class="form-group col-md-6">
									<label for="options">Option-<?php echo $key1 + 1; ?> <input type="radio" name="option_type" value="1" <?php if($value1['val_type']==1){echo "checked"; } ?>>Text <input type="radio" name="option_type" value="0" <?php if($value1['val_type']==0){echo "checked"; } ?>>Image </label>
									<div class="text_<?php echo $key1 + 1; ?>" <?php if($value1['val_type']==0){ } ?>>
										<input type="<?php echo $inputType; ?>" name="option[<?php echo $key; ?>][]" class="form-control" value="<?php echo $value1['name']; ?>">
									</div>
									 <?php if($value1['val_type']==0 && $value1['name']!='') { ?>
									 	<img src="<?php echo asset('upload/quizquestions') . "/" . $value1['name']; ?>" width="100">
									 <?php } ?>
									<input type="hidden" name="optionId[<?php echo $key; ?>][]" value="<?php echo $value1['id']; ?>">
								</div>
							<?php } ?>
							<?php } ?>
							<?php } ?>
							</div>
						    
							<div class="form-group">
								<label for="Currectoption">Currect option</label><br>
								<label><input type="radio" name="Currectoption[<?php echo $key; ?>][]" value="1" <?php if($value['currect_option']==1){echo 'checked'; } ?>> Option-1 </label>
								<label><input type="radio" name="Currectoption[<?php echo $key; ?>][]" value="2" <?php if($value['currect_option']==2){echo 'checked'; } ?>> Option-2 </label>
								<label><input type="radio" name="Currectoption[<?php echo $key; ?>][]" value="3" <?php if($value['currect_option']==3){echo 'checked'; } ?>> Option-3 </label>
								<label><input type="radio" name="Currectoption[<?php echo $key; ?>][]" value="4" <?php if($value['currect_option']==4){echo 'checked'; } ?>> Option-4 </label>
							</div>
							<div class="form-group">
								<label for="marks">Marks</label>
								<input type="number" name="marks[]" class="form-control" value="<?php echo $value['marking']; ?>" required>
							</div>
							<div class="form-group">
								<label for="solution">Solution</label>
								<textarea name="solution[]" class="form-control" required><?php echo $value['solution']; ?></textarea>
							</div>

							<div class="input-group-addon">
								<a title="<?php echo $value['id']; ?>" href="javascript:void(0)" class="btn btn-danger removefaq"><span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span> Remove</a>
							</div>
						</div>
						<?php } ?>
					  

						<div id="addmQUiz"></div>
						<a href="javascript:;" class="btn btn-primary" id="addmoreQuiz">Add More</a>

						<div class="form-group" style="margin-top: 10px;">
							<button type="submit" class="btn btn-primary"> Save </button>
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
		<?php
			foreach ($Response as $key => $value) {
				if (isset($value['options']) && !empty($value['options'])) {
					foreach ($value['options'] as $key1 => $value1) {
		?>
		var option_<?php echo $key1 + 1; ?> = $("input[name='option_<?php echo $key1 + 1; ?>']:checked").val();
	    if (option_<?php echo $key1 + 1; ?> == 1) {
	        $('.text_<?php echo $key1 + 1; ?>').show();
	        $('.image_<?php echo $key1 + 1; ?>').hide();
	    } else {
	        $('.image_<?php echo $key1 + 1; ?>').show();
	        $('.text_<?php echo $key1 + 1; ?>').hide();
	    }
		<?php
					}
				}
			}
		?>
	}
</script>
@endsection