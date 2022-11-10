<!DOCTYPE html>
<html lang="en" >
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="description" content="BrainyWood"/>
	<meta name="author" content="BrainyWood">
	<meta name="robots" content="noindex, nofollow">

	<link rel="shortcut icon" href="{{asset('media/logos/favicon.ico')}}"/>

	<title>OTP Mail - BrainyWood</title>

	<link rel="canonical" href="{{route('home')}}">

	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="{{asset('front/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('front/css/font-awesome.min.css')}}">

	<!--begin::Css-->
	<link rel="stylesheet" href="{{asset('front/css/jquery-ui.min.css')}}">
	<link rel="stylesheet" href="{{asset('front/css/style.css')}}">

</head>
<body>
	<p>Hello {{$username}},</p>
	<p>You have been forgotton your password, don't worry, Please reset your password,</p>
	<p>You have got successfully your OTP: {{$OTP}}</p>
	<p>Best Wishes!</p>
	<p>BrainyWood</p>
</body>
</html>