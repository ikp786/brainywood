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
			<div class="cntnt-csdet quz-rslt">
				<div class="container my-1">
					<div class="question pt-2">
						<h2>Results</h2>
						<p>{{$quiz->attemped_date}}</p>
						<div class="row">
							<div class="col-md-6">Total Questions</div>
							<div class="col-md-6">{{$quiz->total_questions}}</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-6">Correct</div>
							<div class="col-md-6">{{$quiz->right_answer}}</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-6">Incorrect</div>
							<div class="col-md-6">{{$quiz->wrong_answer}}</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-6">Score</div>
							<div class="col-md-6">{{$quiz->total_score}}</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-6">Percentage</div>
							<div class="col-md-6">{{$quiz->percentage}}%</div>
						</div>
						<hr>
						<!-- <p><span>{{$quiz->right_answer}}</span> of <span>{{$quiz->total_questions}}</span> questions answered correctly</p>
						<p class="mb-0">Your time</p>
						<div class="digi-time">{{$quiz->time_efficiency}}</div>
						<p class="mt-4">You have reached {{$quiz->right_answer}} of {{$quiz->total_questions}} points, (<span>{{$quiz->percentage}}%</span>)</p> -->
						<div class="row">
							<div class="col-md-6 text-right">
								<a href="{{route('getQuiz', $quiz->id)}}" class="buy">Re-Take</a>
							</div>
							<div class="col-md-6 text-left">
								<a href="{{route('quizResultViewQuestion', ['quizId' => $quiz->id, 'examId' => $quiz->examId])}}" class="buy gryb">View Answers</a>
							</div>
						</div>
						<div class="row mt-5">
							<!-- <div class="col-md-12 text-center">
								<img src="{{asset('front/assets/img/certificate.png')}}">
							</div> -->
							<div class="col-md-12 text-center mt-3">
								@if($quiz->download_status==1 && $quiz->certificate_url!='')
									<a href="{{$quiz->certificate_url}}" class="buy" target="_blank"><img src="{{asset('front/assets/img/download.svg')}}" width="16px; height:16px;"> Download</a>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
