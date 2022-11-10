<!DOCTYPE html>
<html lang="en" >
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Forgot Password - Brainywood</title>
	<meta name="description" content="Brainywood"/>
	<meta name="author" content="Brainywood">
	<meta name="robots" content="noindex, nofollow">

	<!-- Favicons -->
	<link href="{{asset('front/assets/img/favicon.png')}}" rel="icon">
	<link href="{{asset('front/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">


	<link rel="canonical" href="{{route('home')}}">

	<!-- Vendor CSS Files -->
	<link href="{{asset('front/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{asset('front/assets/vendor/icofont/icofont.min.css')}}" rel="stylesheet">
	<link href="{{asset('front/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
	<link href="{{asset('front/assets/vendor/owl.carousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
	<link href="{{asset('front/assets/vendor/aos/aos.css')}}" rel="stylesheet">

	<!-- Template Main CSS File -->
	<link href="{{asset('front/assets/css/style.css')}}" rel="stylesheet">

</head>
<body>
	<p>Hello {{$username}},</p>
	<p>You have been forgotton your password, don't worry, Please reset your password <a href="{{route('resetPassword', $remember_token)}}">click here</a> </p>
	<p>Best Wishes!</p>
	<p>Brainywood</p>
</body>
</html>