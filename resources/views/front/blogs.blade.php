@extends('layouts.front')
@section('meta_title')
{{$pagename}}
@endsection
@section('meta_description')
{{$pagename}}
@endsection
@section('head')
<style>
	.boxc{ 
		position: relative;
		height: 360px!important;
		border-radius: 1rem!important;
		-o-object-fit: cover!important;
		object-fit: cover!important;
		overflow: hidden!important;
		width: 100%!important;
		box-shadow: 0px 0px 10px #c5c5c5;
	}
	.contentc {
		position: absolute;
		bottom: 0;
		left: 0;
		right: 0;
		z-index: 9;
		text-align: center;
		/*padding-bottom: 10px;*/
		padding: 10px;
	}
	.contentc a {
		color: #ffffff;
		background: #ff7a17;
		padding: 6px 30px;
		border-radius: 22px;
	}
	.contentc h5, .contentc h6 { 
		/*color: #fff;*/
		margin-bottom: .5rem;
		font-weight: 500;
		line-height: 1.2;
	}
	.contentc h5 {
		font-size: 1.25rem;
	}
	.contentc h6 {
		font-size: 1rem;
		margin-top: 90px;
	}
</style>
@endsection
@section('hero_section')
<!-- ======= Hero Section ======= -->
<div class="innovative" class="d-flex align-items-center Learning">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h1>Blogs</h1>
				<!-- <h2>Brainywood is an Ed-tech company engaged in research & development in the field of innovative learning and brain <br> science having it’s headquarter in Rajasthan, India.</h2> -->
			</div>
		</div>
	</div>
</div><!-- End Hero -->
@endsection

@section('content')
<!-- <div class="container">
	<div class="row">
		<div id="custom-search-input">
			<form name="srchfrm" action="{{route('blogs')}}" method="GET">
				<div class="input-group col-md-12">
					<input type="text" name="search" class="search-query form-control" placeholder="Search Blogs" value="{{$search}}" />
					<button type="button" class="btn btn-danger">
						Search
					</button>
				</div>
			</form>
		</div>
	</div>
</div> -->

<div class="our_vid" data-aos="zoom-in" data-aos-delay="100">
	<div class="container">
		@if(count($blogs)>0)
		<div class="row">
			@foreach($blogs as $key => $blog)
			<div class="col-md-6 col-lg-3 mb-4">
				<div class="boxc">
					<div class="contentc">
						<h5>{{$blog->title}}</h5>
						<p>
							<!-- {{ \App\Http\Controllers\Front\FrontController::get_excerpt($blog->description) }} -->
							@if(strlen($blog->description) > 150){!!substr(strip_tags($blog->description),0,150)!!}... @else{!!$blog->description!!}@endif
						</p>
						<h6>
							<span class="pull-left"><i class="fa fa-user"></i> {{$blog->author}}</span>
							<span class="pull-right"><i class="fa fa-calendar"></i> {{date('F d, Y', strtotime($blog->created_at))}}</span>
						</h6>
						<br>
						<a href="{{route('blogDetails', $blog->slug_url)}}" class="btn-get-started">Read More</a>
					</div>
					<!-- <img src="{{asset('upload/blogs') . '/' . $blog->image}}" class="img-fluid boxc" alt="blog img"> -->
				</div> 
			</div>
			@endforeach
		</div>
		@else
		<div class="mt-5 text-center">Blog not available!</div>
		@endif
	</div>
</div>

<br>
<br>

<div class="container back_one">
	<div class="row">
		<div class="col-md-2">
			<img src="{{asset('front/assets/img/web-logo.png')}}">
		</div>
		<div class="col-md-6">
			<h2>Download the Brainywood App!!</h2>
		</div>
		<div class="col-md-4">
			<div class="d-lg-flex dwnld-btns">
				<a href="https://play.google.com/store/apps/details?id=com.sharad.brainywood" target="_blank">
					<img class="img-fluid" src="{{asset('front/assets/img/google-play.svg')}}" alt="">
				</a>
				<a href="#" class="">
					<img class="img-fluid" src="{{asset('front/assets/img/app-store.svg')}}" alt="">
				</a>
			</div>
		</div>
	</div>
</div>

@endsection

@section('javascript')

@endsection