<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="http://sample.jploftsolutions.in/brainywood/public/front/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<title>PDF</title>
	<style type="text/css">
		body {
			font-family: "roboto";
		} 
		h2 {
			font-family: "roboto";
		}
		h1 {
			font-family: "roboto";
		}
		p {
			font-family: "roboto";
		}
	</style>
</head>
<body style="background: white;">
	<div class="" style="width: 100%;">
		<div class="row">
			<div class="col-md-12" style="background-color: #003997; border-radius: 25px;height: 63%;">
				<img style="text-align: center;width:150px;margin-top:10px;margin-left: -15px;padding-left: 0px;" src="{{asset('front/assets/img/corn1.png')}}">
				<h2 style="font-weight: 900;font-family:roboto; border-radius: 5px;margin-top:-70px;line-height: 33px; letter-spacing:5px;font-size: 45px;text-align: center;margin-bottom: 0px;color: #fff;padding-bottom: 0px;">CERTIFICATE <br> <span style="font-size: 22px;"> OF APPRECIATION </span> </h2>
				<hr style="color: white; width: 20%;margin-top: 0px;padding-bottom: 0px;border-color: white !important;">
				<h4 style="line-height: 15px;text-align: center;display: block; color: #fff;font-size: 22px;line-height: 0px;margin-top: 30px;"> PROUDLY PRESENTED </h4>
				<br>
				<br> 
				<h1 style="font-weight: bold; line-height: 45px;text-align: center;display: block; color: #ffdc55;font-size: 45px;margin: 0px;font-style: italic;"> {{$username}}  </h1>
				<br>  
				<p style="color: white; line-height: 26px;width: 100%;text-align: center;margin: 0 auto;font-family:roboto;">{{$content}}</p>

				<br><br>
				<br><br>
				<br><br>

				<div class="main_sec" style="display: inline-flex; width: 100% !important;
				position: relative;">
				<div class="first" style="width: 40%;display: block;">
					<h4 style="font-weight: 400;text-align: center;font-size: 22px;color: #fff;">{{$date}}
						<hr style="width: 150px;border:1px solid #fff;">
						Date 
					</h4>
				</div>

				<div class="second" style="width: 20%;display: block;margin:0 auto;text-align: center;">
					<img style="text-align: center;width: 100px;margin:20px auto 20px;display: block;" src="{{asset('front/assets/img/pre.png')}}">
				</div>

				<div class="third" style="width: 40%;margin:0 auto;text-align: center; position: absolute;right: 0px;display: block;">
					<h4 style="font-weight: 400;text-align: center;font-size: 22px;color: #fff; margin: 0 auto;display: block;">

						<img style="width: 60px;" src="{{asset('front/assets/img/sig1.png')}}"> 
						<hr style="width: 150px;border:1px solid #fff;">
						Signature 
					</h4>
				</div> 
			</div> 

			<img style="float: right;transform: rotate(180deg); width:150px;padding-right: -15px !important; margin-left:50px;margin-top: 25px;" src="{{asset('front/assets/img/corn1.png')}}">

		</div>  
	</div>
</div>

</body>
</html>