@extends('layouts.front')
@section('meta_title')
{{$page->meta_title}}
@endsection
@section('meta_description')
{{$page->meta_description}}
@endsection

<style type="text/css">
	.text_srt div {
    overflow: hidden;
}
</style>

@section('hero_section')
<!-- ======= Hero Section ======= -->
<div class="innovative" class="d-flex align-items-center Learning">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 pt-5 order-2 order-lg-1 mb-3">
				<h1>{{$page->title}}</h1>
				<h2>BrainyWood</h2>
			</div>
		</div>
	</div>
</div><!-- End Hero -->
@endsection

@section('content')
<div class="membership_plan mt-5" data-aos="fade-up">
	<div class="container text_srt">
		<!-- <h2>{{$page->title}}</h2> -->
		<div class="row">
			<div class="col-md-12">
			<div>{!!$page->content!!}</div>
		</div>
	</div>
	</div>
</div>

@endsection