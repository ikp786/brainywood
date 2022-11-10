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
		<!-- <ul class="nav nav-tabs" role="tablist">
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#home">Ask Question</a>
			</li>
			<li class="nav-item">
				<a class="nav-link active" data-toggle="tab" href="#menu1">Latest Question</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#menu2">My Question</a>
			</li>
		</ul> -->

		<!-- Tab panes -->
		<div class="tab-content">
			<!-- <div id="home" class="container tab-pane"><br>
				<div class="ask_secton">
					<div class="row bar-sec">
						<div class="col-md-2">
						</div>
						<div class="form-group col-md-4">
							<select class="" id="sel1" name="country">
								<option>Select Course</option>
								<option value="1">Haryana</option>
							</select>
						</div>
						<div class="form-group col-md-4">
							<select class="" id="sel1" name="country">
								<option>Select Subject</option>
								<option value="1">Haryana</option>
							</select>
						</div>
						<div class="col-md-2">
						</div>
					</div>

					<div class="form-group descrip mt-3 mb-3">
						<textarea class="form-control" type="textarea" id="message" placeholder="Write your question here or tap on camera icon to upload image of your question" maxlength="140" rows="7"></textarea>                   
					</div>

					<h4>Suggested Questions</h4>
					<ul>
						<li>
							<a href="#"> It is a long established distracte its layout. ? </a>
						</li>
						<li>
							<a href="#"> Content of a page when looking at its ? </a>
						</li>
						<li>
							<a href="#"> It is a long established distracte its layout. ? </a>
						</li>
					</ul>
					<a class="sub_mit" href="#"> Submit </a>
				</div>
			</div> -->

			<div id="menu1" class="container tab-pane active"><br>
				<div class="readering pb-5">
					<div class="readable read">
						@if($askedQuestion->user_id>0 && $askedQuestion->user->image!='')
						<!-- <img src="{{asset('upload/profile') . '/' . $askedQuestion->user->image}}" onerror="this.onerror=null;this.src='{{asset('front/assets/img/anu.svg')}}';"> -->
						<img src="{{asset('upload/profile') . '/' . $askedQuestion->user->image}}">
						@endif
						<h5>By @if($askedQuestion->user_id>0){{$askedQuestion->user->name}}@endif <br><span>{{$courseLessionTopicName}}  |  {{$askedQuestion->created_at->diffForHumans()}}</span> </h5>
						<p>{!!$askedQuestion->question!!}</p>
						@if($askedQuestion->image)
						@php
						$images = explode(',', $askedQuestion->image);
						if(empty($images)){
							$images = array();
						}
						@endphp
						@foreach($images as $image)
						<img class="mt-3" src="{{asset('upload/questionask/thumb') . '/' . $image}}">
						@endforeach
						<hr>
						@endif
						<h6>{{count($answers)}} Answers</h6>
					</div>
					@if($answers)
					@foreach($answers as $key => $answer)
					<div class="Anuradhaa dev mt-4">
						<div class="readable">
							@if($answer->user_id>0 && $answer->user->image!='')
							<!-- <img src="{{asset('upload/profile') . '/' . $answer->user->image}}" onerror="this.onerror=null;this.src='{{asset('front/assets/img/anu.svg')}}';"> -->
							<img src="{{asset('upload/profile') . '/' . $answer->user->image}}">
							@endif
							<h5>By @if($answer->user_id>0){{$answer->user->name}}@endif <br><span> {{$answer->created_at->diffForHumans()}}</span> </h5>
						</div>
						<p>{!!$answer->answer!!}</p>
						@if($answer->image)
						@php
						$ansimages = explode(',', $answer->image);
						if(empty($ansimages)){
							$ansimages = array();
						}
						@endphp
						@foreach($ansimages as $ansimage)
						<img class="ans_pht mt-3" src="{{asset('upload/questionask/thumb') . '/' . $ansimage}}">
						@endforeach
						<hr>
						@endif
						<div class="areaed mt-3">
							<ul>
								<li><a href="javascript:;" onclick="$('#answerLike{{$answer->id}}').submit();"> Like ({{$answer->ans_like}}) |</a></li>
								<li><a href="javascript:;" class="notifate" onclick="$('#answerUnLike{{$answer->id}}').submit();"> Dislike({{$answer->ans_unlike}}) </a></li>
							</ul>
						</div>    
					</div>
					{!! Form::open(['route' => 'answerLike', 'style' => 'display:none;', 'id' => 'answerLike'.$answer->id]) !!}
					<input type="hidden" name="answerId" value="{{$answer->id}}">
					<button type="submit">Like</button>
					{!! Form::close() !!}
					{!! Form::open(['route' => 'answerUnLike', 'style' => 'display:none;', 'id' => 'answerUnLike'.$answer->id]) !!}
					<input type="hidden" name="answerId" value="{{$answer->id}}">
					<button type="submit">Dislike</button>
					{!! Form::close() !!}
					@endforeach
					@endif
				</div>
			</div>

			<!-- <div id="menu2" class="container tab-pane fade"><br>
				<h3>Menu 2</h3>
				<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
			</div> -->

		</div>
	</div>
</div>

@endsection


@section('javascript')

<script type="text/javascript">
	//$(document).ready(function () {

	  var body = document.body;
	  body.classList.add("live_call");

	//});
</script>
<script type="text/javascript">
	AOS.init({
  duration: 0,
})

</script>

@endsection
