@extends('layouts.front')
@section('meta_title')
{{$pagename}}
@endsection
@section('meta_description')
{{$pagename}}
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

			<!-- <div class="cntnt-csdet quz-rslt">
				<div class="container my-1">
					<div class="question pt-2">
						<h2>Results</h2>
						<p><span>{{$quiz->right_answer}}</span> of <span>{{$quiz->total_questions}}</span> questions answered correctly</p>
						<p class="mb-0">Your time</p>
						<div class="digi-time">{{$quiz->time_efficiency}}</div>
						<p class="mt-4">You have reached {{$quiz->right_answer}} of {{$quiz->total_questions}} points, (<span>{{$quiz->percentage}}%</span>)</p>
						<div class="row">
							<div class="col-md-12 text-center">
								<a href="{{route('getQuiz', $quiz->id)}}" class="buy">Restart Quiz</a>
							</div>
						</div>
					</div>
				</div>
			</div> -->

			@if($quizdata)
			@foreach($quizdata as $key => $val)
			<div class="cntnt-csdet quz-rslt mt-5 p-4">
				<div class="container my-1">
					<div class="question pt-2 text-left">
						<h3 class="mt-0">{{$val['questions']}}</h3>
						@if($val['image'])
						<img src="{{asset('upload/quizquestions') . '/' . $val['image']}}" class="img-responsive" alt="question img">
						@endif
						<div class="pt-sm-0 pt-3" id="options">
							@foreach($val['answers'] as $key1 => $option)
							@php
								if(!empty($val['given_answer']) && $option['id']==$val['given_answer']){$checked = 'checked';}else{$checked = '';}

								if($val['given_answer']==$val['correct_answer'] && $val['correct_answer']==$option['id'] && $val['given_answer']!='NA'){$bcolor = '2px solid green';}elseif($val['correct_answer']==$option['id'] && $val['correct_answer']!='NA'){$bcolor = '2px solid green';}elseif($val['given_answer']=='NA' || $val['correct_answer']=='NA'){$bcolor = '';}elseif($val['given_answer']!=$val['correct_answer']){$bcolor = '1px solid red';}else{$bcolor = '';}
							@endphp
							<label class="options ml-0" style="border: {{$bcolor}};">{{$option['option']}} <input type="radio" name="answer{{$val['id']}}" value="{{$option['id']}}" {{$checked}}> <span class="checkmark"></span> </label>
							@endforeach
						</div>
					</div>
					@if($val['given_answer']==$val['correct_answer'] && $val['given_answer']!='NA')
					<p class="text-left text-success font-weight-bold">Correct</p>
					@else
					<p class="text-left text-danger font-weight-bold">Incorrect</p>
					@endif
					<p class="text-left font-weight-bold">Solution</p>
					<div class="text-left">{!!$val['solution']!!}</div>
				</div>
			</div>
			@endforeach
			@endif
			
		</div>
	</div>
</div>

@endsection
