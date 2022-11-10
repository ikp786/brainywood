@extends('layouts.front')
@section('meta_title')
{{$pagename}}
@endsection
@section('meta_description')
{{$pagename}}
@endsection

@section('head')
<style type="text/css">
	.my-deb #options label {
		padding: 15px 0px 0px 40px!important;
		line-height: 20px !important;
	}
	
	/*#options label{
		height: 40px;
	}*/
	#msform {
		width: 70%;
		margin: 0px auto;
		text-align: center;
		position: relative;
		background: white;
		border: 0 none;
		border-radius: 15px;
		box-shadow: 0 0 15px 1px rgb(162 162 162 / 40%); 
	}
	#msform fieldset {
		padding: 20px 30px;
		box-sizing: border-box;
		width: 100%;
		margin: 0 auto;
		position: relative !important;
	}
	#msform fieldset:not(:first-of-type) {
		display: none;
	}
	#msform input, #msform textarea {
		padding: 15px;
		border: 1px solid #ccc;
		border-radius: 3px;
		margin-bottom: 10px;
		width: 100%;
		box-sizing: border-box;
		color: #2C3E50;
		font-size: 13px;
	}
	#msform .action-button {
		width: 100px;
		background: #FF7A17;
		color: white;
		border: 0 none;
		border-radius: 24px;
		cursor: pointer;
		padding: 10px 5px;
		margin: 10px 30px;
	}
	#msform .action-button:hover, #msform .action-button:focus {
		box-shadow: 0 0 0 2px white, 0 0 0 3px #27AE60;
	}
	.fs-title {
		font-size: 15px;
		text-transform: uppercase;
		color: #2C3E50;
		margin-bottom: 10px;
	}
	.fs-subtitle {
		font-weight: normal;
		font-size: 13px;
		color: #666;
		margin-bottom: 20px;
	}
	#progressbar {
		margin-bottom: 30px;
		overflow: hidden;
		counter-reset: step;
	}
	#progressbar li {
		list-style-type: none;
		color: white;
		text-transform: uppercase;
		font-size: 9px;
		width: 33.33%;
		float: left;
		position: relative;
	}
	#progressbar li:before {
		content: counter(step);
		counter-increment: step;
		width: 20px;
		line-height: 20px;
		display: block;
		font-size: 10px;
		color: #333;
		background: white;
		border-radius: 3px;
		margin: 0 auto 5px auto;
	}
	#progressbar li:after {
		content: '';
		width: 100%;
		height: 2px;
		background: white;
		position: absolute;
		left: -50%;
		top: 9px;
		z-index: -1; /*put it behind the numbers*/
	}
	#progressbar li:first-child:after {
		/*connector not needed before the first step*/
		content: none; 
	}
	/*marking active/completed steps green*/
	/*The number of the step and the connector before it = green*/
	#progressbar li.active:before,  #progressbar li.active:after{
		background: #27AE60;
		color: white;
	}
	.fieldset{
		transform: none;
	}
	div#countdown ul {
		list-style: none;
		display: flex;
	}
	div#countdown ul {
		list-style: none;
		display: flex;
		background: #ff7a17;
		padding: 8px;
		border-radius: 5px;
		width:20%;
		font-size: 30px;
		font-weight: 600;
		color: white;
		margin: 0 auto;
		text-align: center;
	}
	div#countdown ul li{
		margin:0px 0px;
		margin: 0 auto;
		text-align: center;
	}
	div#countdown ul li span{
		padding:10px 10px;
	}  
	.qiuz_part {
		display: inline-block;
		vertical-align: super;
		position: relative;
		left: 200px;
		bottom: 45px;
	}

	#options label{
		width: 90%;
		vertical-align: bottom;
		margin-bottom: 20px;
	}


</style>
@endsection

@section('hero_section')
<div class="cors-det-lgn quiz-p">
	<!-- ======= Hero Section ======= -->
	<!-- <div class="innovative" class="d-flex">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 pt-5 order-2 order-lg-1 mb-3">
					<h1></h1>
				</div>
			</div>
		</div>
	</div> -->
	<!-- End Hero -->
@endsection 

@section('content')
	<div class="plan mt-3" data-aos="fade-right">
		<div class="container">
		</div>
	</div>
	<div class="container">
		<div class="text-prt text-center">
			<h2>Quiz – {{$quiz->name}}</h2>
			<p class="mb-5">Feeling good about what you learnt? Time to evaluate</p>
			<!-- <div class="digi-times">00:58:55</div> -->
			<div id="countdown">
				<ul>
					<li><span id="hours"></span>:</li>
					<li><span id="minutes"></span>:</li>
					<li><span id="seconds"></span></li>
				</ul>
			</div> 
			<div class="qiuz_part">
				<a href="javascript:;" class="pausebtn"> <img src="{{asset('front/assets/img/pause.svg')}}"> </a>
				<a href="{{route('quizList',['id' => $quiz->id, 'examId' => $examId])}}"> <img src="{{asset('front/assets/img/list.svg')}}"> </a>
			</div>
		</div>
	</div>

</div>


<form id="msform" action="#" method="post">
	@if($examQuestions)
	@php $totalQuestion = count($examQuestions); @endphp
	@foreach($examQuestions as $key => $examQues)
	@php
		$questionOptions = \App\Quizoption::where("questionId", $examQues->id)->get();
		$stAnswer = \App\StudentExamAnswer::where("exam_id", $examId)->where("ques_id", $examQues->id)->first();
	@endphp
	<fieldset>
		<div class="question pt-2 my-deb">
			<h2>{{$examQues->questions}}</h2>
			@if($examQues->image)
			<img src="{{asset('upload/quizquestions') . '/' . $examQues->image}}" class="img-responsive" alt="question img">
			@endif
			<input type="hidden" name="examId" class="examId" value="{{$examId}}">
			<input type="hidden" name="quesId" class="quesId{{$examQues->id}}" value="{{$examQues->id}}">
			<div class="pt-sm-0 pt-3" id="options">
				@foreach($questionOptions as $key1 => $option)
				@if($key1 <= 3)
				@php if(!empty($stAnswer->answer) && $option->id==$stAnswer->answer){$checked = 'checked';}else{$checked = '';} @endphp
				<label @if($option->val_type==0) style="background: transparent;" @endif class="options">@if($option->val_type==0)<img  style="width: 100%;height: 300px;" src="{{asset('upload/quizquestions') . '/' . $option->quizoption}}" class="img-responsive" alt="option img"> @else{{$option->quizoption}}@endif <input type="radio" name="answer{{$examQues->id}}" value="{{$option->id}}" {{$checked}}> <span class="checkmark"></span> </label>
				@endif
				@endforeach
			</div>
		</div>
		@if($key!=0)
		<input type="button" name="previous" class="previous action-button" value="Previous" />
		@endif
		@if(($totalQuestion-1)>$key)
		<input type="button" name="next" class="next action-button nextbtn{{$examQues->id}}" value="Next" />
		@else
		<input type="submit" name="submit" class="submit action-button endquiz{{$examQues->id}}" value="Submit" />
		@endif
	</fieldset>
	@endforeach
	@endif
</form>

@endsection

@section('javascript')
<script type="text/javascript">
	//jQuery time
	var current_fs, next_fs, previous_fs; //fieldsets
	var left, opacity, scale; //fieldset properties which we will animate
	var animating; //flag to prevent quick multi-click glitches

	$(".next").click(function(){
		if(animating) return false;
		animating = true;
		
		current_fs = $(this).parent();
		next_fs = $(this).parent().next();
		
		//activate next step on progressbar using the index of next_fs
		$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
	  
		//show the next fieldset
		next_fs.show(); 
		//hide the current fieldset with style
		current_fs.animate({opacity: 0}, {
			step: function(now, mx) {
				//as the opacity of current_fs reduces to 0 - stored in "now"
				//1. scale current_fs down to 80%
				scale = 1 - (1 - now) * 0.2;
				//2. bring next_fs from the right(50%)
				left = (now * 50)+"%";
				//3. increase opacity of next_fs to 1 as it moves in
				opacity = 1 - now;
				current_fs.css({
					'transform': 'scale('+scale+')',
					'position': 'absolute'
				});
				next_fs.css({'left': left, 'opacity': opacity});
			}, 
			duration: 800, 
			complete: function(){
				current_fs.hide();
				animating = false;
			}, 
			//this comes from the custom easing plugin
			easing: 'easeInOutBack'
		});
	});

	$(".previous").click(function(){
		if(animating) return false;
		animating = true;
		
		current_fs = $(this).parent();
		previous_fs = $(this).parent().prev();
		
		//de-activate current step on progressbar
		$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
		  
		//show the previous fieldset
		previous_fs.show(); 
		//hide the current fieldset with style
		current_fs.animate({opacity: 0}, {
			step: function(now, mx) {
				//as the opacity of current_fs reduces to 0 - stored in "now"
				//1. scale previous_fs from 80% to 100%
				scale = 0.8 + (1 - now) * 0.2;
				//2. take current_fs to the right(50%) - from 0%
				left = ((1-now) * 50)+"%";
				//3. increase opacity of previous_fs to 1 as it moves in
				opacity = 1 - now;
				current_fs.css({'left': left});
				previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
			}, 
			duration: 800, 
			complete: function(){
				current_fs.hide();
				animating = false;
			}, 
			//this comes from the custom easing plugin
			easing: 'easeInOutBack'
		});
	});

	$(".submit").click(function(){
		return false;
	})
</script>

<script type="text/javascript">
	(function () {
		const second = 1000,
		minute = second * 60,
		hour = minute * 60,
		day = hour * 24;

		let birthday = "{{$quizTime}}",
		countDown = new Date(birthday).getTime(),
		x = setInterval(function() {    

			let now = new Date().getTime(),
			distance = countDown - now;

			if (distance > 0) {

				document.getElementById("hours").innerText = Math.floor((distance % (day)) / (hour)),
				document.getElementById("minutes").innerText = Math.floor((distance % (hour)) / (minute)),
				document.getElementById("seconds").innerText = Math.floor((distance % (minute)) / second);
				
				/*var days = Math.floor((distance % (day)) / (hour));
				var hours = Math.floor((distance % (hour)) / (minute));
				var seconds = Math.floor((distance % (minute)) / second);
				document.getElementById("countdown").innerHTML = "<ul><li><span id='hours'>" + days + "</span>:</li><li><span id='minutes'>" + hours + "</span>:</li><li><span id='seconds'>" + seconds +"</span></li></ul>";*/
			} else {

				//do something later when date is reached
				//if (distance < 0) {
					clearInterval(x);
					document.getElementById("countdown").innerHTML = "<ul><li><span id='hours'>00</span>:</li><li><span id='minutes'>00</span>:</li><li><span id='seconds'>00</span></li></ul>";

					var examId = "{{$examId}}";
					//alert(examId);
					$.ajax({
						url: APP_URL + "/auto_end_quiz",
						method: "POST",
						data: { _token: "{{ csrf_token() }}", examId: examId },
						success: function (result) {
							$(".message").html(result);
							window.location.href = APP_URL + '/quiz-list/' + '{{$quiz->id}}' + '/' + examId;
						},
					});
					
					let headline = document.getElementById("headline"),
					countdown = document.getElementById("countdown"),
					content = document.getElementById("content");

					headline.innerText = "It's quiz time over!";
					countdown.style.display = "none";
					content.style.display = "block";

					clearInterval(x);
				//}
			}
			//seconds
		}, 0)
	}());
</script>

<script type="text/javascript">
	$(document).ready(function () {
		$(".pausebtn").click(function () {
			var _token = $('input[name="_token"]').val();
			var examId = $(".examId").val();
			//alert(examId);
			$.ajax({
				url: APP_URL + "/pause_quiz",
				method: "POST",
				data: { _token: _token,examId: examId },
				success: function (result) {
					$(".message").html(result);
					//alert(result);
					window.location.href = APP_URL + '/quiz-list/' + '{{$quiz->id}}' + '/' + examId;
				},
			});
		});
	});
</script>
@if($examQuestions)
@foreach($examQuestions as $key => $examQues)
<script type="text/javascript">
	$(document).ready(function () {
		$(".nextbtn{{$examQues->id}}").click(function () {
			if ($(this).val() != "") {
				var _token = $('input[name="_token"]').val();
				var examId = $(".examId").val();
				var quesId = $(".quesId{{$examQues->id}}").val();
				var answer = $("input[type='radio'][name='answer"+quesId+"']:checked").val();
				var value = $(this).val();
				//alert(quesId+' Ans '+answer);
				$.ajax({
					url: APP_URL + "/submit_quiz_answer",
					method: "POST",
					data: { _token: _token,examId: examId,quesId: quesId,answer: answer },
					success: function (result) {
						$(".message").html(result);
					},
				});
			}
		});
	});
</script>
<script type="text/javascript">
	$(document).ready(function () {
		$(".endquiz{{$examQues->id}}").click(function () {
			if ($(this).val() != "") {
				var _token = $('input[name="_token"]').val();
				var examId = $(".examId").val();
				var quesId = $(".quesId{{$examQues->id}}").val();
				var answer = $("input[type='radio'][name='answer"+quesId+"']:checked").val();
				var value = $(this).val();
				//alert(quesId+' Ans '+answer);
				$.ajax({
					url: APP_URL + "/end_quiz_answer",
					method: "POST",
					data: { _token: _token,examId: examId,quesId: quesId,answer: answer },
					success: function (result) {
						$(".message").html(result);
						window.location.href = APP_URL + '/quiz-list/' + '{{$quiz->id}}' + '/' + examId;
					},
				});
			}
		});
	});
</script>
@endforeach
@endif
@endsection
