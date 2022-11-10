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
	<div class="ask_question">
		<div class="container mt-5">
			<ul class="nav nav-tabs" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" data-toggle="tab" href="#home">All</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#menu1">Attempted ({{$total_attemped}})</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#menu2">Unattempted</a>
				</li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
				<div id="home" class="container tab-pane active"><br>
					<div class="well ques_all">
						<table class="table">
							<thead>
								<tr>
									<th>Question</th>
									<th class="text-right">Status</th>
								</tr>
							</thead>
							<tbody>
								@if($examQuestions)
								@foreach($examQuestions as $key => $examQues)
								@php
									$studentAns = \App\StudentExamAnswer::where("exam_id", $examId)->where("ques_id", $examQues->id)->first();
									$attemp = isset($studentAns->attemp) ? $studentAns->attemp : 2;
									if($attemp==0){
										$atmpImg = 'check-mark.svg';
									}elseif($attemp==1){
										$atmpImg = 'check-marks.svg';
									}else{
										$atmpImg = 'check-mark_s.svg';
									}
								@endphp
								<tr>
									<td>{{$key+1}}</td>
									<td class="text-right"> <img src="{{asset('front/assets/img/'.$atmpImg)}}"> </td>
								</tr>
								@endforeach
								@endif
							</tbody>
						</table>
					</div>
				</div>

				<div id="menu1" class="container tab-pane fade"><br>
					<div class="well ques_all">
						<table class="table">
							<thead>
								<tr>
									<th>Question</th>
									<th class="text-right">Status</th>
								</tr>
							</thead>
							<tbody>
								@if($examQuestions)
								@foreach($examQuestions as $key => $examQues)
								@php
									$studentAns = \App\StudentExamAnswer::where("exam_id", $examId)->where("ques_id", $examQues->id)->first();
									$attemp = isset($studentAns->attemp) ? $studentAns->attemp : 2;
									if($attemp==0){
										$atmpImg = 'check-mark.svg';
									}elseif($attemp==1){
										$atmpImg = 'check-marks.svg';
									}else{
										$atmpImg = 'check-mark_s.svg';
									}
								@endphp
								@if($attemp < 2)
								<tr>
									<td>{{$key+1}}</td>
									<td class="text-right"> <img src="{{asset('front/assets/img/'.$atmpImg)}}"> </td>
								</tr>
								@endif
								@endforeach
								@endif
							</tbody>
						</table>
					</div>
				</div>

				<div id="menu2" class="container tab-pane fade"><br>
					<div class="well ques_all">
						<table class="table">
							<thead>
								<tr>
									<th>Question</th>
									<th class="text-right">Status</th>
								</tr>
							</thead>
							<tbody>
								@if($examQuestions)
								@foreach($examQuestions as $key => $examQues)
								@php
									$studentAns = \App\StudentExamAnswer::where("exam_id", $examId)->where("ques_id", $examQues->id)->first();
									$attemp = isset($studentAns->attemp) ? $studentAns->attemp : 2;
									if($attemp==0){
										$atmpImg = 'check-mark.svg';
									}elseif($attemp==1){
										$atmpImg = 'check-marks.svg';
									}else{
										$atmpImg = 'check-mark_s.svg';
									}
								@endphp
								@if($attemp == 2)
								<tr>
									<td>{{$key+1}}</td>
									<td class="text-right"> <img src="{{asset('front/assets/img/'.$atmpImg)}}"> </td>
								</tr>
								@endif
								@endforeach
								@endif
							</tbody>
						</table>
					</div>
				</div>

			</div>
			<div class="col-md-12 text-center mt-3">
				<a href="{{route('quizResult', ['quizId' => $quizId, 'examId' => $examId])}}" class="btn btn-warning buy"> View Result</a>
			</div>
		</div>
	</div>
</div>

@endsection
