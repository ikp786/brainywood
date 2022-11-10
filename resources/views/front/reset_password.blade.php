<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


@extends('layouts.front')
@section('meta_title')
{{$pagename}}
@endsection
@section('meta_description')
{{$pagename}}
@endsection

@section('hero_section')

<style type="text/css">
	.side_bars img{border-radius: 50%;}
</style>  
	
<!-- ======= Hero Section ======= -->
<!-- <section id="hero" class="d-flex align-items-center Learning">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 pt-5 order-2 order-lg-1 mb-3">
				<h1>{{$pagename}}</h1>
			</div>
		</div>
	</div>
</section> --><!-- End Hero -->
@endsection

@section('content')
<div class="accout_start reset_password mt-5">
	<div class="container">
		<div class="vertical-tabs">
			<div class="row">
				<div class="detail_section">
					<div class="tab-content">
						<div class="tab-pane active" id="pag2" role="tabpanel">
							<div class="sv-tab-panel two">
								<form action="{{route('resetPassword')}}" method="post">
									<input type="hidden" name="_token" value="{{ csrf_token() }}" />
									<input type="hidden" name="userId" value="{{$user->id}}">
									<h3>Change Password</h3>
									<div class="row">
										<div class="col-lg-12 col-md-12 form-line">
											<div class="form-group">
												<label for="new_pass">New Password</label>
												<input type="password" name="new_pass" class="form-control" placeholder="New Password">
											</div>  
											<div class="form-group">
												<label for="con_pass">Confirm Password</label>
												<input type="password" name="con_pass" class="form-control" placeholder="Confirm Password">
											</div>
										</div>
									</div>
									<button type="submit" class="btn btn-default submit"> Reset Password </button>
								</form>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

@endsection
