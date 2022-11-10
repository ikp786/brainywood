@extends('layouts.front')
@section('meta_title')
{{$pagename}}
@endsection
@section('meta_description')
{{$pagename}}
@endsection
@section('head')
<style type="text/css">
</style>
@endsection

@section('hero_section')
<div class="cors-det-lgn">
	<!-- ======= Hero Section ======= -->
	<!-- <div class="innovative" class="d-flex">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 pt-5 order-2 order-lg-1 mb-3">
					<h1></h1>
				</div>
			</div>
		</div>
	</div> --><!-- End Hero -->
@endsection

@section('content')

	<div class="sec_del mt-3" data-aos="fade-right">
		<div class="container text-center mt-3" style="position: relative;">
			@if($blog->image)
			<img src="{{asset('upload/blogs') . '/' . $blog->image}}" class="img-fluid" alt="blog img">
			@endif
		</div>
	</div> 

	<div class="container">
		<div class="text-prt">
			<h2>{{$blog->title}}</h2>
			<div class="cntnt-csdet">
				<p>{!!$blog->description!!}</p>
			</div>
		</div>
	</div>
</div>

@endsection
@section('javascript')

@endsection