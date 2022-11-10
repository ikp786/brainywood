@extends('layouts.front')
@section('meta_title')
{{$pagename}}
@endsection
@section('meta_description')
{{$pagename}}
@endsection

<style type="text/css">
	[data-aos=fade-up] {
    transform: translate3d(0,10px,0)  !important;
    opacity: 1 !important;
}

</style>

@section('hero_section')
<!-- ======= Hero Section ======= -->
<!-- <div class="question_person" class="d-flex align-items-center Learning">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 pt-5 order-2 order-lg-1 mb-3">
				<h1>Q&A</h1>
				@if($userSubscription==0 && $questioncount<=3)
				<h2 style="color: #FF7A17;">Free Q&A - {{$questioncount}}/3</h2>
				@endif
			</div>
		</div>
	</div>
</div> --><!-- End Hero -->
@endsection

@section('content')
<div class="ask_question">
	<div class="container mt-5">
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" data-toggle="tab" href="#home">Ask Question</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#menu1">Latest Question</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#menu2">My Question</a>
			</li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			<div id="home" class="container tab-pane active"><br>
				<div class="ask_secton">
					<form action="{{route('saveQuestion')}}" method="post" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
						<div class="row bar-sec">
							<div class="form-group col-md-4">
								<select name="courseId" id="sel1" class="courseId">
									<option>Select Course</option>
									@if($courses)
									@foreach($courses as $key => $course)
									<option value="{{$course->id}}">{{$course->name}}</option>
									@endforeach
									@endif
								</select>
							</div>
							<div class="form-group col-md-4">
								<select name="lessionId" id="sel1" class="lessionId">
									<option>Select Lession</option>
								</select>
							</div>
							<div class="form-group col-md-4">
								<select name="topicId" id="sel1" class="topicId">
									<option>Select Topic</option>
								</select>
							</div>
						</div>
						<div class="form-group descrip mt-3 mb-3">
							<textarea rows="7" name="question" id="question" class="form-control" placeholder="Write your question here or tap on camera icon to upload image of your question"></textarea>
							<!-- <input type="file" name="image" class="form-control" accept="image/*"> -->
							<input type="file" name="image[]" class="form-control" accept="image/*" multiple>
						</div>
						<h4>Suggested Questions</h4>
						<ul class="suggested_questions">
							@if($suggestedQues)
							@foreach($suggestedQues as $suggest)
							<li>
								<a href="{{route('questionAnswerView',$suggest->id)}}" target="_blank"> {{$suggest->question}} </a>
							</li>
							@endforeach
							@endif
							<!-- <li>
								<a href="#"> Content of a page when looking at its ? </a>
							</li>
							<li>
								<a href="#"> It is a long established distracte its layout. ? </a>
							</li> -->
						</ul>
						<!-- <a class="sub_mit" data-toggle="modal" href="#ignismyModal"> Submit </a> -->
						<button type="submit" class="btn btn-default sub_mit">Submit</button>
					</form>
				</div>
			</div>

			<div id="menu1" class="container tab-pane fade"><br>
				@if($latestQuesAsks)
				@foreach($latestQuesAsks as $key => $latest)
				@php
					$total_answers = \App\QuestionAnswer::where("ques_id", $latest->id)->count();
					$courseLessionTopicName = '';
					if($latest->topic_id > 0){
						$courseLessionTopicName = $latest->course->name.' / '.$latest->lession->name.' / '.$latest->topic->name;
					}elseif($latest->lession_id > 0){
						$courseLessionTopicName = $latest->course->name.' / '.$latest->lession->name;
					}else{
						if($latest->course_id > 0){
							$courseLessionTopicName = $latest->course->name;
						}
					}
				@endphp
				<div class="Anuradhaa @if($key!=0)mt-5 @endif">
					<div class="readable">
						@if($latest->user_id>0 && $latest->user->image!='')
						<!-- <img src="{{asset('upload/profile') . '/' . $latest->user->image}}" onerror="this.onerror=null;this.src='{{asset('front/assets/img/anu.svg')}}';"> -->
						<img src="{{asset('upload/profile') . '/' . $latest->user->image}}">
						@endif
						<h5>By @if($latest->user_id>0){{$latest->user->name}}@endif <br><span>{{$courseLessionTopicName}}  |  {{$latest->created_at->diffForHumans()}}</span> </h5>
					</div>
					<p>{!!$latest->question!!}</p>
					@if($latest->image)
					@php
					$images = explode(',', $latest->image);
					if(empty($images)){
						$images = array();
					}
					@endphp
					@foreach($images as $image)
					<img class=" ans_pht mt-3" src="{{asset('upload/questionask/thumb') . '/' . $image}}">
					@endforeach
					<hr>
					@endif
					<div class="areaed mt-3">
						<ul>
							<li><a href="javascript:;" class="activate place_answer" data-ques_id="{{$latest->id}}" data-question="{!!$latest->question!!}"> Answer It </a></li>
							<li><a href="javascript:;"> {{$total_answers}} Answers |</a></li>
							<!-- <li><a href="#" class="notifate"><img style="width: 15px;" src="{{asset('front/assets/img/share.svg')}}"> Share |</a></li> -->
							<li><a href="{{route('questionAnswerView',$latest->id)}}" class="answer">View Answer</a></li>
						</ul>
					</div>
				</div>
				@endforeach
				@endif
			</div>

			<div id="menu2" class="container tab-pane fade"><br>
				@if(count($myQuestions)>0)
				@foreach($myQuestions as $key => $myques)
				@php
					$total_answers = \App\QuestionAnswer::where("ques_id", $myques->id)->count();
					$courseLessionTopicName = '';
					if($myques->topic_id > 0){
						$courseLessionTopicName = $myques->course->name.' / '.$myques->lession->name.' / '.$myques->topic->name;
					}elseif($myques->lession_id > 0){
						$courseLessionTopicName = $myques->course->name.' / '.$myques->lession->name;
					}else{
						if($myques->course_id > 0){
							$courseLessionTopicName = $myques->course->name;
						}
					}
				@endphp
				<div class="Anuradhaa @if($key!=0)mt-5 @endif">
					<div class="readable">
						@if($myques->user_id>0 && $myques->user->image!='')
						<!-- <img src="{{asset('upload/profile') . '/' . $myques->user->image}}" onerror="this.onerror=null;this.src='{{asset('front/assets/img/anu.svg')}}';"> -->
						<img src="{{asset('upload/profile') . '/' . $myques->user->image}}">
						@endif
						<h5>By @if($myques->user_id>0){{$myques->user->name}}@endif <br><span>{{$courseLessionTopicName}}  |  {{$myques->created_at->diffForHumans()}}</span> </h5>
					</div>
					<p>{!!$myques->question!!}</p>
					@if($myques->image)
					@php
					$myquesimages = explode(',', $myques->image);
					if(empty($myquesimages)){
						$myquesimages = array();
					}
					@endphp
					@foreach($myquesimages as $myquesimage)
					<img class="mt-3" src="{{asset('upload/questionask/thumb') . '/' . $myquesimage}}">
					@endforeach
					<hr>
					@endif
					<div class="areaed mt-3">
						<ul>
							<li><a href="javascript:;" class="activate place_answer" data-ques_id="{{$myques->id}}" data-question="{!!$myques->question!!}"> Answer It </a></li>
							<li><a href="javascript:;"> {{$total_answers}} Answers |</a></li>
							<!-- <li><a href="#" class="notifate"><img style="width: 15px;" src="{{asset('front/assets/img/share.svg')}}"> Share |</a></li> -->
							<li><a href="{{route('questionAnswerView',$myques->id)}}" class="answer">View Answer</a></li>
						</ul>
					</div>
				</div>
				@endforeach
				@else
				<div class="mt-5 text-center">Questions not available!</div>
				@endif
			</div>

		</div>
	</div>
</div>


<div class="modal fade" id="answerModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Answer This Question</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label=""><span>×</span></button>
			</div>
			<form action="{{route('answerAQuestion')}}" method="post" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{ csrf_token() }}" />
				<input type="hidden" name="quesId" id="ques_id" value="" />
				<div class="modal-body">
					<div id="thisQuestion"></div>
					<textarea name="answer" rows="4" class="form-control form-control-sm" style="border-radius: 5px;padding: 10px;margin: 15px 0 5px;" placeholder="Enter your answer here"></textarea>
					<!-- <input type="file" name="image" class="form-control" accept="image/*"> -->
					<input type="file" name="image[]" class="form-control" accept="image/*" multiple>
					<button type="submit" class="btn btn-primary w-100 mt-4"> Submit </button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="ignismyModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label=""><span>×</span></button>
			</div>          
			<div class="modal-body">                       
				<div class="thank-you-pop">
					<img src="http://goactionstations.co.uk/wp-content/uploads/2017/03/Green-Round-Tick.png" alt="">
					<h1>Thank You!</h1>
					<p>Your submission is received and we will contact you soon</p>
					<h3 class="cupon-pop">Your Id: <span>12345</span></h3>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
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
						//get asked questions
						$.ajax({
							url: "get_questions_by_lession",
							method: "POST",
							data: { _token: _token,courseId: value },
							success: function (result) {
								$(".suggested_questions").html(result);
							},
						});
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
						//get asked questions
						$.ajax({
							url: "get_questions_by_lession",
							method: "POST",
							data: { _token: _token,courseId: courseId,lessionId: value,search: question },
							success: function (result) {
								$(".suggested_questions").html(result);
							},
						});
					},
				});
			}
		});

		$(".topicId").change(function () {
			if ($(this).val() != "") {
				var _token = $('input[name="_token"]').val();
				var courseId = $(".courseId").val();
				var lessionId = $(".lessionId").val();
				var value = $(this).val();
				var question = $("#question").val();
				$.ajax({
					url: "get_questions_by_lession",
					method: "POST",
					data: { _token: _token,courseId: courseId,lessionId: lessionId,topicId: value,search: question },
					success: function (result) {
						$(".suggested_questions").html(result);
					},
				});
			}
		});

		$('.place_answer').click(function(){
			var ques_id = $(this).data("ques_id");
			var question = $(this).data("question");
			//alert(ques_id);
			if(ques_id != ''){
				$("#ques_id").val(ques_id);
				$("#thisQuestion").html(question);
				$('#answerModal').modal('show');
			}
		});

      var body = document.body;
     body.classList.add("live_call");

	});
</script>
<script type="text/javascript">
	AOS.init({
  duration: 0,
})

</script>
@endsection
