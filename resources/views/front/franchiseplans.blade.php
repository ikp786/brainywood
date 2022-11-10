@extends('layouts.front')
@section('meta_title')
{{$pagename}}
@endsection
@section('meta_description')
{{$pagename}}
@endsection
@section('head')


<!-- jQuery library -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
<script src="https://brainywoodindia.com/front/assets/vendor/jquery/jquery.min.js"></script>
<link rel="stylesheet" href="https://brainywoodindia.com/front/assets/css/font-awesome4.5.0.min.css">

<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">
<style type="text/css">
  .nav-menu>ul>li {
    color: white;
}
.back-to-top i {
    color: white;
}
#testimonials .hr-testimonials {
    border: 1px solid #222;
    width: 50%;
    margin: 0 auto 35px auto;
  font-family: 'Leckerli One', cursive;
}

#testimonials h3 {
    color: #353535;
    margin: 40px auto;
  font-family: 'Leckerli One', cursive;
}

#testimonials .carousel {
    float: none;
  margin: auto;
}
section#testimonials img.image-center {
    display: block;
}
section#testimonials p {
    margin-bottom: 70px;
    text-align: center;
    padding-top: 15px;
}
section#testimonials .carousel-inner {
    width: 60%;
    margin: 0 auto;
}

#testimonials .carousel-indicators li {
    border: 2px solid #182c39;
    background-color: #fff;
    height: 10px;
    width: 10px;
    border-radius: 50%;
}

#testimonials .carousel-indicators li.active {
    border-color: #fff;
    background-color: #182c39;
}



#testimonials .carousel-item h4 {
    line-height: 1.6em;
    font-weight: 500;
    padding-bottom: 20px;
    margin-bottom: 10px;
    position: relative;
    font-size: 16px;
    text-align: center;
    color: #000000;
}

#testimonials .carousel-item h5 {
    font-size: 15px;
    font-weight: 500;
    margin-bottom: 80px;
  color: #555;
}



.content {
  width: 80%;
  padding: 0;
  margin: 0 auto;
}

.centerplease {
  margin: 0 auto;
  max-width: 270px;
  font-size: 40px;
}

/*Question*/
.question {
  position: relative;
  background: #f9f9f9;
  margin: 0;
  padding: 10px 10px 10px 50px;
  display: block;
  width:100%;
  cursor: pointer;
}
/*Answer*/
.answers {
  padding: 0px 15px;
  margin: 5px 0;
  width:100%!important;
  height: 0;
  overflow: hidden;
  z-index: -1;
  position: relative;
  opacity: 0;
  -webkit-transition: .3s ease;
  -moz-transition: .3s ease;
  -o-transition: .3s ease;
  transition: .3s ease;
}

.questions:checked ~ .answers{
  height: auto;
  opacity: 1;
  padding: 15px;
  
}

/*FAQ Toggle*/
.plus {
  position: absolute;
  margin-left: 10px;
  z-index: 5;
  font-size: 2em;
  line-height: 100%;
  -webkit-user-select: none;    
  -moz-user-select: none;
  -ms-user-select: none;
  -o-user-select: none;
  user-select: none;
  -webkit-transition: .3s ease;
  -moz-transition: .3s ease;
  -o-transition: .3s ease;
  transition: .3s ease;

}

.questions:checked ~ .plus {
  -webkit-transform: rotate(45deg);
  -moz-transform: rotate(45deg);
  -o-transform: rotate(45deg);
  transform: rotate(45deg);

}

.questions {
  display: none;
  
}
.panel-title > a:before {
    float: right !important;
    font-family: FontAwesome;
    content: '\f078';
    color: #333333;
    padding-right: 5px;
    transform: rotate( 
180deg
 );
  font-weight: bolder;
    font-size: 20px;
}
.panel-title > a.collapsed:before {
       float: right !important;
     content: '\f078';
    color: #333333;
    transform: rotate(
360deg
);
        font-weight: bolder;
    font-size: 20px;
}
section#testimonials {
    margin-top: 70px;
}

.fre_part {
    padding-top: 70px;
}

.panel-title > a:hover, 
.panel-title > a:active, 
.panel-title > a:focus  {
    text-decoration:none;
}
.panel-heading {
    padding: 20px 15px;
    border-bottom: 1px solid transparent;
    border-top-right-radius: 3px;
    border-top-left-radius: 3px;
}
.panel {
    margin-bottom: 20px !important;
    background-color: #ffffff;
    border: 1px solid transparent;
    -webkit-box-shadow: 0 1px 1px rgb(0 0 0 / 5%);
    box-shadow: 15px 16px 13px 8px rgb(4 4 4 / 5%);
}
.jumbotron {
    padding-top: 30px;
    padding-bottom: 30px;
    margin-bottom: 30px;
    color: inherit;
    background-color: #00bcd4;
    text-align: center;
    color: #fff;
}
.header-section-space-form-1 {
    margin-top: -1px;
}






</style>

<title>Welcome to Brainywood - Venture of Vedic Brain Solutions, India</title>
    <!-- FAVICON LINK -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
    <!-- BOOTSTRAP -->
    <link href="https://brainywoodindia.com/front/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://brainywoodindia.com/front/assets/css/style.css" rel="stylesheet">

    <!-- FONT AWESOME LINK -->
    <link rel="stylesheet" type="text/css" href="https://brainywoodindia.com/front/assets/css/font-awesome.min.css">

    <!-- IMAGE OVERLAY STYLE LINK  -->
    <link rel="stylesheet" type="text/css" href="css/vendor/overlay/style.css">
     <link rel="stylesheet" type="text/css" href="https://brainywoodindia.com/front/assets/css/style_sec.css">
    <!-- LIGHTBOX STYLE LINK -->
    <link rel="stylesheet" type="text/css" href="https://brainywoodindia.com/front/assets/css/ekko-style.css">

    <!-- CAROUSEL STYLE LINK  -->
    <link rel="stylesheet" type="text/css" href="https://brainywoodindia.com/front/assets/css/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="https://brainywoodindia.com/front/assets/css/owl.theme.css">
    <link rel="stylesheet" type="text/css" href="https://brainywoodindia.com/front/assets/css/carousel.css">
    

<!-- <link rel="stylesheet" type="text/css" href="css/vendor/owl-carousel/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="css/vendor/owl-carousel/owl.theme.css">
<link rel="stylesheet" type="text/css" href="css/vendor/owl-carousel/carousel.css"> -->
    
    <!-- CUSTOM CSS -->
   <!--  <link href="https://brainywoodindia.com/front/assets/css/style.css" rel="stylesheet"> -->
    <link rel="stylesheet" type="text/css" href="https://brainywoodindia.com/front/assets/css/style_blue.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
    <!-- Facebook Pixel Code -->

    <!-- Whatsapp Button -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<!-- <a href="https://api.whatsapp.com/send?phone=917878309045&text=Hello%21%20I%20wish%20%20to%20know%20about%20Brainwood%20Franchise." class="float" target="_blank">
<i class="fa fa-whatsapp my-float"></i> -->
</a> 
<!-- Whatsapp button close --> 
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '222045719518399');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=222045719518399&ev=PageView&noscript=1"
/></noscript>


@endsection


@section('hero_section')
<!-- ======= Hero Section ======= -->
<!-- <div class="service_part" class="d-flex align-items-center Learning">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h1>Franchise Plans</h1>
			</div>
		</div>
	</div>
</div> --><!-- End Hero -->
@endsection

@section('content')

<body>
   
    <!--================================= NAVIGATION START =============================================-->
    <!-- <nav class="navbar navbar-default navbar-fixed-top menu-bg" id="top-nav">
        <div class="container">
            <div class="navigation-tb">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div>
                        <a href="#"> <img src="images/logo.png" alt="logo" />
                        </a>
                    </div>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right no-margin" id="menu-list">
                        <li class="menu-fs menu-underline"><a href="#home" class="pagescroll">home</a>
                        </li>
                        <li class="menu-fs menu-underline"><a href="#partner" class="pagescroll">our partner advantage</a>
                        </li>
                        <li class="menu-fs menu-underline"><a href="#about" class="pagescroll">about us</a>
                        </li>
                        <li class="menu-fs menu-underline"><a href="#investment" class="pagescroll">investment requirement</a>
                        </li>
                        <li class="menu-fs menu-underline"><a href="#contact" class="pagescroll">contact</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav> -->
    <!--================================= NAVIGATION END =============================================-->

    <!--================================= HEADER-FORM-2 START =============================================-->
    <div class="container-fluid header-form-bgimage-2 bgimage-property parallax  header-section-space-form-1" id="home">
        <div class="container">
            <div class="col-md-12 column-center no-padding white-text">
                <div class="row">
                    <div class="col-md-7 col-md-push-5">
                        <div class="header-form-heading-top res-header-heading-bottom">
                            <p class="left header-head1 header-head1-bottom"><span style="color:#FF9900">India’s Most Innovative Education Franchise</span></p>

                            <p class="left header-text-bottom ls">Start your own Brainywood Franchise at your place. Join hands with India’s first learning platform equipped with Brain Science.</p>

                            <div class="left">
                                <a href="#">
                                    <div class="header-btn">Contact us Now: <font size="+1"><span style="color:#FF9900">+91 78783-09045</span></font></div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5 col-md-pull-7">
                        <div class="contact-div header-contact-form header-contact-bg">
                            <form class="contact-form" method="POST">
                                <div class="clearfix">
                                    <div class="header-form-heading-bg">
                                        <h4 class="center">register today to get Exciting Offers</h4>
                                    </div>
                                    <div class="header-contact-bg-pad">
                                        <p class="left header-form-text ls">You are just one step away to start your own Franchise</p>
                                        <!--================= NAME INPUT BOX HERE ====================-->
                                        <div class="form-div form-bottom-1">
                                            <i class="fa fa-user"></i>
                                            <input class="form-control form-text" type="text" name="name" value="" placeholder="Please Enter Name" required />
                                        </div>
                    
                    <!--================= OCCUPATION INPUT BOX HERE ====================-->
                                        <div class="form-div form-bottom-1">
                                            <i class="fa fa-briefcase"></i>
                                            <input class="form-control form-text" type="text" name="occupation" value="" placeholder="Your Occupation" required />
                                        </div>
                                       
                                        <!--================= PHONE-NUMBER INPUT BOX HERE ====================-->
                                        <div class="form-div phoneno-bottom error-div">
                                            <i class="fa fa-phone" aria-hidden="true"></i>
                                            <input class="form-control form-text phoneno" name="phoneno" placeholder="Contact Number" autocomplete="off" type="text" onKeyPress="return isNumber(event)" maxlength="10" required />
                                        </div>
                    
                    <!--================= CITY INPUT BOX HERE ====================-->
                                        <div class="form-div phoneno-bottom error-div">
                                            <i class="fa fa-city" aria-hidden="true"></i>
                                            <input class="form-control form-text" name="city" placeholder="Please Enter City" required autocomplete="off" type="text" maxlength="15">
                                        </div>

                    <!--================= INVESTMENT INPUT BOX HERE ====================-->
                                        <div class="form-div phoneno-bottom error-div">
                                            <i class="fa fa-rupee-sign" aria-hidden="true"></i>
                                            <input class="form-control form-text" name="invest" placeholder="Will you invest min Rs. 40000?" required autocomplete="off" type="text" maxlength="3">
                                        </div>
                    
                    <!--================= INTEREST INPUT BOX HERE ====================-->
                                        <div class="form-div phoneno-bottom error-div">
                                            <i class="fa fa-computer" aria-hidden="true"></i>
                                            <input class="form-control form-text" name="interest" placeholder="Interested in Online Education Business?" required autocomplete="off" type="text" maxlength="3">
                                        </div>
                    
                    <!--================= EMAIL INPUT BOX HERE ====================-->
                                        <div class="form-div form-bottom-1">
                                            <i class="fa fa-envelope"></i>
                                            <input class="form-control form-text" type="email" name="email" value="" placeholder="Please Enter Email" required />
                                        </div>
                    
                    
                                        <p class="left note-text ls">*Note: Conditions Apply</p>

                                        <!--============= SUCESSS AND FAILURE MESSAGE DISPLAY HERE ========-->
                                        <div class="left form-error-top"> <span class="form-success sucessMessage"> </span> <span class="form-failure failMessage"> </span>
                                        </div>
                                    </div>

                                    <!--================= SUBMIT BUTTON HERE ====================-->
                                    <div>
                                        <input type="submit" class="submit-btn contact-form-submit" name="submit" value="REGISTER NOW">
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--================================= HEADER-FORM-2 END =============================================-->

   
    <!--================================= OUR AWESOME SERVICES START =============================================-->
    <section class="container-fluid section-space section-bg-1">
        <div class="container" id="partner">
            <h1 class="center">our partner advantage</h1>
            <div class="row">
                <!--=============== COLUMN-1 ==================-->
                <div class="col-md-4 res-services-center common-res-bottom common-res-bottom-1">
                    <div class="services-row-space">
                        <div class="right image-bottom res-text-center-single">
                            <img src="{{asset('front/assets/img/innovative.jpg')}}" alt="icon" />
                        </div>
                        <h3 class="right h3-bottom"><a href="#">innovative concept</a></h3>
                        <p class="right">Brainywood is the only organisation in India which provides courses based on 4th Dimension of Education. </p>
                    </div>

                    <div class="services-row-space">
                        <div class="right image-bottom res-text-center-single">
                            <img src="{{asset('front/assets/img/training.jpg')}}" alt="icon" />
                        </div>
                        <h3 class="right h3-bottom"><a href="#">training support</a></h3>
                        <p class="right">Brainywood provides complete 15 days in depth training about the services it offers and on its Brain Science concept.</p>
                    </div>

                    <div class="services-row-space">
                        <div class="right image-bottom res-text-center-single">
                            <img src="{{asset('front/assets/img/crm.jpg')}}" alt="icon" />
                        </div>
                        <h3 class="right h3-bottom"><a href="#">24 X 7 CRM support</a></h3>
                        <p class="right">A Dedicated Franchise Relationship Manager is allocated to each franchise for instant support.</p>
                    </div>
                </div>


                <!--=============== COLUMN-2 ==================-->
                <div class="col-md-4 common-res-bottom common-res-bottom-1">
                    <div class="center">
                        <img src="{{asset('front/assets/img/app-image.jpg')}}" alt="Brainywood's Learning App" class="img-responsive image-center image-grow" />
                    </div>
                </div>

                <!--=============== COLUMN-3 ==================-->
                <div class="col-md-4 res-services-center">
                    <div class="services-row-space">
                        <div class="left image-bottom res-text-center-single">
                            <img src="{{asset('front/assets/img/business.jpg')}}" alt="icon" />
                        </div>
                        <h3 class="left h3-bottom"><a href="#">Business Management Model</a></h3>
                        <p class="left">A unique, flexible model is created for each franchise to open multiple sources of income.</p>
                    </div>

                    <div class="services-row-space">
                        <div class="left image-bottom res-text-center-single">
                            <img src="{{asset('front/assets/img/development.jpg')}}" alt="icon" />
                        </div>
                        <h3 class="left h3-bottom"><a href="#">Regular Development Session</a></h3>
                        <p class="left">Every franchise gets RDS, PDS, Start-up Plan and a dedicated mentor to expand the franchise business.</p>
                    </div>

                    <div class="services-row-space">
                        <div class="left image-bottom res-text-center-single">
                            <img src="{{asset('front/assets/img/development.jpg')}}" alt="icon" />
                        </div>
                        <h3 class="left h3-bottom"><a href="#">branding</a></h3>
                        <p class="left">Each Franchise gets the utmost advantage of branding of Brainywood which helps to build a strong goodwill in the market.  </p>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--================================= OUR AWESOME SERVICES END =============================================-->


    <!--================================= COUNTER START =============================================-->
    <div class="container-fluid counter-bgimage bgimage-property parallax  counter-section-space">
        <div class="container">
            <div class="row white-text">
                <div class="col-md-3 col-sm-3 col-xs-6 counter-res-bottom common-full-1">
                    <div class="center image-bottom">
                        <img src="{{asset('front/assets/img/franchise.jpg')}}" alt="icon" />
                    </div>
                    <p class="center counter-num count ls">200</p>
                    <p class="center counter-sub ls">+ FRANCHISEES </p>
                </div>

                <div class="col-md-3 col-sm-3 col-xs-6 counter-res-bottom common-full-1">
                    <div class="center image-bottom">
                        <img src="{{asset('front/assets/img/rnd.jpg')}}" alt="icon" />
                    </div>
                    <p class="center counter-num count ls">14</p>
                    <p class="center counter-sub ls">YEARS R&D</p>
                </div>

                <div class="col-md-3 col-sm-3 col-xs-6 common-full-1 counter-res-bottom-1">
                    <div class="center image-bottom">
                        <img src="{{asset('front/assets/img/training.jpg')}}" alt="icon" />
                    </div>
                    <p class="center counter-num count ls">2000 </p>
                    <p class="center counter-sub ls">+ SEMINARS & WORKSHOPS</p>
                </div>

                <div class="col-md-3 col-sm-3 col-xs-6 common-full-1">
                    <div class="center image-bottom">
                        <img src="{{asset('front/assets/img/audience.jpg')}}" alt="icon" />
                    </div>
                    <p class="center counter-num count ls">10 </p>
                    <p class="center counter-sub ls">LAKHS+ AUDIENCE TRAINED </p>
                </div>
            </div>
        </div>
    </div>
    <!--================================= COUNTER END =============================================-->
  
  <!--================================= PROMOTIONAL VIDEO START =============================================-->
    <section class="container-fluid section-space section-bg-1">
        <div class="container">
            <div class="row">
                <div class="col-md-10 column-center no-padding">
                    <div class="col-md-6 col-md-push-6 res-image-bottom res-image-bottom-1">
                        <div class="embed-responsive embed-responsive-16by9">
              <iframe width="917" height="516" src="https://www.youtube.com/embed/INZIQMEK-dk" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
              <!--
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/watch?v=INZIQMEK-dk"></iframe>
              -->
                        </div>
                    </div>

                    <div class="col-md-6 col-md-pull-6">
                        <h2 class="left h2-bottom"><a href="#">who are we?</a></h2>
                        <p class="left p-bottom">Brainywood is an Ed-tech company engaged in research & development in the field of innovative learning and brain science having it’s headquarter in Rajasthan, India.</p>
                        <p class="left">We are introducing Fourth Dimension of Education i.e. Science of Recollection. Our research & training programs have already benefited more than 5 lacks families and over 10 lacks audience across the nation by seminars, workshops, institutes, and franchise training models.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--================================= PROMOTIONAL VIDEO END =============================================-->
   <!--================================= ABOUT US START =============================================-->
    <section class="container-fluid section-space section-bg-2" id="about">
        <div class="container">
            <h1 class="center">about us</h1>
            <div id="grid" class="row effects">
                <figure class="col-sm-4 col-xs-6 gallery-image-lr gallery-row-bottom light-box">
                    <div class="img">
                        <img alt="portfolio-2" src="{{asset('front/assets/img/gallery1.jpg')}}" />
                        <div class="overlay">
                            <div class="outer">
                                <div class="middle">
                                    <div class="inner">
                                        <ul class="center no-padding no-margin">
                                            <li>
                                                <a href="{{asset('front/assets/img/gallery1.jpg')}}" class="expand extend-icon" data-title="Portfolio One" data-toggle="lightbox" data-gallery="navigateTo"><i class="fa fa-search gallery-fa"></i></a>
                                                <a href="#" class="expand extend-icon-two"><i class="fa fa-chain-broken gallery-fa gallery-fa-pad-left"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </figure>

                <figure class="col-sm-4 col-xs-6 gallery-image-lr gallery-row-bottom light-box">
                    <div class="img">
                        <img alt="portfolio-2" src="{{asset('front/assets/img/gallery6.jpg')}}" />
                        <div class="overlay">
                            <div class="outer">
                                <div class="middle">
                                    <div class="inner">
                                        <ul class="center no-padding no-margin">
                                            <li>
                                                <a href="{{asset('front/assets/img/gallery6.jpg')}}" class="expand extend-icon" data-title="Portfolio Two" data-toggle="lightbox" data-gallery="navigateTo"><i class="fa fa-search gallery-fa"></i></a>
                                                <a href="#" class="expand extend-icon-two"><i class="fa fa-chain-broken gallery-fa gallery-fa-pad-left"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </figure>

                <figure class="col-sm-4 col-xs-6 gallery-image-lr gallery-row-bottom light-box">
                    <div class="img">
                        <img alt="portfolio-2" src="{{asset('front/assets/img/gallery2.jpg')}}" />
                        <div class="overlay">
                            <div class="outer">
                                <div class="middle">
                                    <div class="inner">
                                        <ul class="center no-padding no-margin">
                                            <li>
                                                <a href="{{asset('front/assets/img/gallery2.jpg')}}" class="expand extend-icon" data-title="Portfolio Three" data-toggle="lightbox" data-gallery="navigateTo"><i class="fa fa-search gallery-fa"></i></a>
                                                <a href="#" class="expand extend-icon-two"><i class="fa fa-chain-broken gallery-fa gallery-fa-pad-left"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </figure>

                <figure class="col-sm-4 col-xs-6 gallery-image-lr res-gallery-row-bottom light-box">
                    <div class="img">
                        <img alt="portfolio-2" src="{{asset('front/assets/img/gallery3.jpg')}}" />
                        <div class="overlay">
                            <div class="outer">
                                <div class="middle">
                                    <div class="inner">
                                        <ul class="center no-padding no-margin">
                                            <li>
                                                <a href="{{asset('front/assets/img/gallery3.jpg')}}" class="expand extend-icon" data-title="Portfolio Four" data-toggle="lightbox" data-gallery="navigateTo"><i class="fa fa-search gallery-fa"></i></a>
                                                <a href="#" class="expand extend-icon-two"><i class="fa fa-chain-broken gallery-fa gallery-fa-pad-left"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </figure>

                <figure class="col-sm-4 col-xs-6 gallery-image-lr light-box res-gallery-bottom">
                    <div class="img">
                        <img alt="portfolio-2" src="{{asset('front/assets/img/gallery4.jpg')}}" />
                        <div class="overlay">
                            <div class="outer">
                                <div class="middle">
                                    <div class="inner">
                                        <ul class="center no-padding no-margin">
                                            <li>
                                                <a href="{{asset('front/assets/img/gallery4.jpg')}}" class="expand extend-icon" data-title="Portfolio Five" data-toggle="lightbox" data-gallery="navigateTo"><i class="fa fa-search gallery-fa"></i></a>
                                                <a href="#" class="expand extend-icon-two"><i class="fa fa-chain-broken gallery-fa gallery-fa-pad-left"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </figure>

                <figure class="col-sm-4 col-xs-6 gallery-image-lr light-box">
                    <div class="img">
                        <img alt="portfolio-2" src="{{asset('front/assets/img/gallery5.jpg')}}" />
                        <div class="overlay">
                            <div class="outer">
                                <div class="middle">
                                    <div class="inner">
                                        <ul class="center no-padding no-margin">
                                            <li>
                                                <a href="{{asset('front/assets/img/gallery5.jpg')}}" class="expand extend-icon" data-title="Portfolio Six" data-toggle="lightbox" data-gallery="navigateTo"><i class="fa fa-search gallery-fa"></i></a>
                                                <a href="#" class="expand extend-icon-two"><i class="fa fa-chain-broken gallery-fa gallery-fa-pad-left"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </figure>

            </div>
        </div>
    </section>
    <!--================================= ABOUT US / GALLERY END =============================================-->
  
     <!--================================= FRANCHISEE PLAN TABLE START =============================================-->
    <section class="container-fluid section-space section-bg-2" id="investment">
        <div class="container">
            <h1 class="center">franchisee plans</h1>
            <div class="row">
                <!--=============== COLUMN-1 ==================-->
                <div class="col-md-3 col-sm-3 price-fixed price-res-bottom">
        
                    <div class="pricig-br price-bgcolor-1">
                        <h3 class="center price-head-pad">distributor franchise rights </h3>
                        <div class="price-pos-rel">
                            <div class="pricig-uline">
                            </div>
                            <div class="pricig-uline price-pos-abs"></div>
                        </div>
            <!--
            <div class="pricig-br price-bgcolor-2 white-text">
                        <h3 class="center price-head-pad">Distributor Franchise Rights</h3>
                        <div class="price-pos-rel">
                            <div class="pricig-uline pricig-uline-white">
                            </div>
                            <div class="pricig-uline pricig-uline-white price-pos-abs"></div>
                        </div>
            -->
                        <div class="price-body-pad">
                            <p class="center price-tag"><span class="month">Starts Rs.</span>40000
                            </p>
              <p>An Opportunity to become the authorised Brainywood distributor of online software. Suitable for initial start at very low investment.</p>
                            <!-- Features are hidden
                            <div class="price-list-bottom">
                                <p class="center ls">Lorem ipsum dolor elit </p>
                                <p class="center ls">Consectetur adipiscing ipsum </p>
                                <p class="center ls">Nam pharetra efficitur </p>
                                <p class="center ls">vel sagittis ipsum nisi</p>
                                <p class="center ls">Curabitur eleifend</p>
                            </div>
              Features ends -->
                        </div>
                    </div>
                </div>
        
        <!--=============== EXTRA COLUMN ==================-->
                <div class="col-md-3 col-sm-3  price-fixed price-res-bottom">
        
            <div class="pricig-br price-bgcolor-2 white-text">
                        <h3 class="center price-head-pad">Trainer Franchise Rights</h3>
                        <div class="price-pos-rel">
                            <div class="pricig-uline pricig-uline-white">
                            </div>
                            <div class="pricig-uline pricig-uline-white price-pos-abs"></div>
                        </div>
            
        <!--
                    <div class="pricig-br price-bgcolor-1">
                        <h3 class="center price-head-pad">Trainer Franchise Rights</h3>
                        <div class="price-pos-rel">
                            <div class="pricig-uline">
                            </div>
                            <div class="pricig-uline price-pos-abs"></div>
                        </div>
        -->
                        <div class="price-body-pad">
                           <!-- <p class="center price-tag"><span class="month">Reach us for </span>Pricing -->
              <p class="center price-tag"><span class="month">Rs.</span>70000
                            </p>
              <p>Explore the opportunity of Brain Science and get the exclusive training as well as distributor rights. Also do enjoy the Exclusive Monopoly Rights.</p>
                            <!-- Features are hidden
                            <div class="price-list-bottom">
                                <p class="center ls">Lorem ipsum dolor elit </p>
                                <p class="center ls">Consectetur adipiscing ipsum </p>
                                <p class="center ls">Nam pharetra efficitur </p>
                                <p class="center ls">vel sagittis ipsum nisi</p>
                                <p class="center ls">Curabitur eleifend</p>
                            </div>
              Features ends -->

                        </div>
                    </div>
                </div>

                <!--=============== COLUMN-2 ==================-->
                <div class="col-md-3 col-sm-3  price-fixed price-res-bottom">
        <!--
                    <div class="pricig-br price-bgcolor-2 white-text">
                        <h3 class="center price-head-pad">City Franchise Rights</h3>
                        <div class="price-pos-rel">
                            <div class="pricig-uline pricig-uline-white">
                            </div>
                            <div class="pricig-uline pricig-uline-white price-pos-abs"></div>
                        </div>
            -->
            <div class="pricig-br price-bgcolor-1">
                        <h3 class="center price-head-pad">City franchise <br />rights </h3>
                        <div class="price-pos-rel">
                            <div class="pricig-uline">
                            </div>
                            <div class="pricig-uline price-pos-abs"></div>
                        </div>

                        <div class="price-body-pad">
               
              <p class="center price-tag"><span class="month">Rs.</span>150000
                            </p>
              <p>Get the Exclusive City Franchise Rights with tons of other advantages- distributor rights, trainer rights, Franchisee Appointment rights, Branch development rights of your loved city. </p>
              <!-- Features are hidden
                            <div class="price-list-bottom">
                                <p class="center ls">Lorem ipsum dolor elit </p>
                                <p class="center ls">Consectetur adipiscing ipsum </p>
                                <p class="center ls">Nam pharetra efficitur </p>
                                <p class="center ls">vel sagittis ipsum nisi</p>
                                <p class="center ls">Curabitur eleifend</p>
                            </div>
              Features ends -->
                        </div>
                    </div>
                </div>

                <!--=============== COLUMN-3 ==================-->
                <div class="col-md-3 col-sm-3 price-fixed">
                    <div class="pricig-br price-bgcolor-1">
                        <h3 class="center price-head-pad">District Franchise Rights </h3>
                        <div class="price-pos-rel">
                            <div class="pricig-uline">
                            </div>
                            <div class="pricig-uline price-pos-abs"></div>
                        </div>
                        <div class="price-body-pad">
                            <p class="center price-tag"><span class="month">Rs.</span>300000
                            </p>
              <p>
              Get the Exclusive District Rights and get the extra royalty from the city, trainer, distributor franchise working under you with tons of other advantages- software rights, trainer rights, Franchisee Appointment rights, Branch development rights of your loved district. </p>
                            <!-- Features are hidden
                            <div class="price-list-bottom">
                                <p class="center ls">Lorem ipsum dolor elit </p>
                                <p class="center ls">Consectetur adipiscing ipsum </p>
                                <p class="center ls">Nam pharetra efficitur </p>
                                <p class="center ls">vel sagittis ipsum nisi</p>
                                <p class="center ls">Curabitur eleifend</p>
                            </div>
              Features ends -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="center btn-top">
                <a href="#">
                    <div class="btn-1">GST as applicable will be additional</div>
                </a>
            </div>
        </div>
    </section>
    <!--================================= PRICE TABLE END =============================================-->
  
     <!--================================= FREQUENTLY ASKED QUESTIONS START =============================================-->

<!-- <div class="container">
    <div class="row">
        <div class="col-md-6">
<div class="content">
<div>
  <input type="checkbox" id="question1" name="q"  class="questions">
  <div class="plus">+</div>
  <label for="question1" class="question">
    This is the question that will be asked?
  </label>
  <div class="answers">
This is the answer of the question.. keep it short.</div>
</div>

<div>
  <input type="checkbox" id="question2" name="q" class="questions">
  <div class="plus">+</div>
  <label for="question2" class="question">
    Short?
  </label>
  <div class="answers">
    short!
  </div>
</div>
  
<div>
  <input type="checkbox" id="question3" name="q" class="questions">
  <div class="plus">+</div>
  <label for="question3" class="question">
    Keep answers short. But in case of...If the question is long, the text wraps.  
  </label>
  <div class="answers">
    This is the answer!
  </div>
</div>
</div>

    </div>
    <div class="col-md-6">
<div class="content">
<div>
  <input type="checkbox" id="question5" name="q"  class="questions">
  <div class="plus">+</div>
  <label for="question5" class="question">
    This is the question that will be asked?
  </label>
  <div class="answers">
This is the answer of the question.. keep it short.</div>
</div>

<div>
  <input type="checkbox" id="question6" name="q" class="questions">
  <div class="plus">+</div>
  <label for="question6" class="question">
    Short?
  </label>
  <div class="answers">
    short!
  </div>
</div>
  
<div>
  <input type="checkbox" id="question7" name="q" class="questions">
  <div class="plus">+</div>
  <label for="question7" class="question">
    Keep answers short. But in case of...If the question is long, the text wraps.  
  </label>
  <div class="answers">
    This is the answer!
  </div>
</div>
</div>

    </div>
</div>
</div> -->


  <div class="fre_part">
<div class="container mt-5">
  <h1 class="center">frequently asked questions</h1>
  <div class="row">
<div class="col-md-6">
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

<div class="panel panel-default">
<div class="panel-heading" role="tab" id="headingTwo">
<h4 class="panel-title">
<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
Do I Require Any Office Space To Operate?
</a>
</h4>

</div>
<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
<div class="panel-body">Preferred location of franchise outlet can be either Home, Office, Training Center, other workstation. We work Online so no mandatory requirement to setup complete corporate office.
</div>
</div>
</div>
<div class="panel panel-default">
<div class="panel-heading" role="tab" id="headingThree">
<h4 class="panel-title">
<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
Can I See The Demo Videos Related To Brain Science?
</a>
</h4>

</div>
<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
<div class="panel-body">Yes, you can see the free videos hosted on Brainywood Website. You can also free sign up and explore all the free content available on platform.
</div>
</div>
</div>

<div class="panel panel-default">
<div class="panel-heading" role="tab" id="headingthree">
<h4 class="panel-title">
<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsethree" aria-expanded="false" aria-controls="collapsethree">
Where The Training And Development Sessions Will Be Conducted? 
</a>
</h4>

</div>
<div id="collapsethree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingthree">
<div class="panel-body"> Due to Covid-19, all training and RDS are conducted online. It can be done either on company own LMS or Zoom Call. 
</div>
</div>
</div>

</div>
</div>


<div class="col-md-6">
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

<div class="panel panel-default">
<div class="panel-heading" role="tab" id="headingfour">
<h4 class="panel-title">
<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsefour" aria-expanded="false" aria-controls="collapsefour">
Will There Be Any Franchise Agreement?
</a>
</h4>

</div>
<div id="collapsefour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingfour">
<div class="panel-body">Yes there will be a franchise agreement which will be done online due to Covid-19. The procedure and formalities will be shared to each franchisee once ready to start the franchised business.


</div>
</div>
</div>
<div class="panel panel-default">
<div class="panel-heading" role="tab" id="headingfive">
<h4 class="panel-title">
<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsefive" aria-expanded="false" aria-controls="collapsefive">
How Long The Tenure Of Franchise Agreement?
</a>
</h4>

</div>
<div id="collapsefive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingfive">
<div class="panel-body"> The tenure of franchisee agreement depends upon the type of franchise. Normally it ranges between 2.5-3 years. Once the tenure expired, it is easily renewable without any further fee upon the terms and conditions mentioned in the agreement.


</div>
</div>
</div>

<div class="panel panel-default">
<div class="panel-heading" role="tab" id="headingfive">
<h4 class="panel-title">
<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsesix" aria-expanded="false" aria-controls="collapsesix">
What Is The Anticipated Percentage Return On Investment?
</a>
</h4>

</div>
<div id="collapsesix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingsix">
<div class="panel-body"> The ROI depends upon various factors. But normally, it is seen with the working of 200+ franchisee that one can expect min 250% return on its investment in 4-8 months time.


</div>
</div>
</div>

</div>
</div>


</div>
  </div>
</div>

    <!-- <section class="container-fluid section-space section-bg-1">
        <div class="container">
            <h1 class="center">frequently asked questions</h1>
            <div class="row faq-row faq-white-text">
                <div class="col-md-6 col-sm-6 faq-res-bottom">
                    <div class="faq-col">
                        <div class="faq-row-bottom">
                            <div class="faq-title faq-bg">
                                <div class="distab faq-bg-width">
                                    <h3 class="faq-heading distab-cell-middle">Do I require any office space to operate?
                  </h3>
                                    <p class="down-arrow down-arrow-left distab-cell-middle"></p>
                                </div>
                            </div>
                            <p class="faq-ans faq-answer-pad faq-answer-bg">Preferred location of franchise outlet can be either Home, Office, Training Center, other workstation. We work Online so no mandatory requirement to setup complete corporate office. 
                            </p>
                        </div>

                        <div class="faq-row-bottom">
                            <div class="faq-title faq-bg">
                                <div class="distab faq-bg-width">
                                    <h3 class="faq-heading distab-cell-middle">Where the Training and Development sessions will be conducted?
                  </h3>
                                    <p class="down-arrow down-arrow-left distab-cell-middle"></p>
                                </div>
                            </div>
                            <p class="faq-ans faq-answer-pad faq-answer-bg">Due to Covid-19, all training and RDS are conducted online. It can be done either on company own LMS or Zoom Call.
                            </p>
                        </div>

                        <div class="faq-row-bottom">
                            <div class="faq-title faq-bg">
                                <div class="distab faq-bg-width">
                                    <h3 class="faq-heading distab-cell-middle">Can I see the demo videos related to Brain Science?
                  </h3>
                                    <p class="down-arrow down-arrow-left distab-cell-middle"></p>
                                </div>
                            </div>
                            <p class="faq-ans faq-answer-pad faq-answer-bg">Yes, you can see the free videos hosted on <a href="https://www.brainywoodindia.com" target="_blank"><span style="color:#0033CC"> Brainywood Website</span></a>. You can also free sign up and explore all the free content available on platform.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-6">
                    <div class="faq-col">
                        <div class="faq-row-bottom">
                            <div class="faq-title faq-bg">
                                <div class="distab faq-bg-width">
                                    <h3 class="faq-heading distab-cell-middle">Will there be any Franchise Agreement? 
                  </h3>
                                    <p class="down-arrow down-arrow-left distab-cell-middle"></p>
                                </div>
                            </div>
                            <p class="faq-ans faq-answer-pad faq-answer-bg">Yes there will be a franchise agreement which will be done online due to Covid-19. The procedure and formalities will be shared to each franchisee once ready to start the franchised business.
                            </p>
                        </div>

                        <div class="faq-row-bottom">
                            <div class="faq-title faq-bg">
                                <div class="distab faq-bg-width">
                                    <h3 class="faq-heading distab-cell-middle">How long the tenure of Franchise Agreement?
                  </h3>
                                    <p class="down-arrow down-arrow-left distab-cell-middle"></p>
                                </div>
                            </div>
                            <p class="faq-ans faq-answer-pad faq-answer-bg">The tenure of franchisee agreement depends upon the type of franchise. Normally it ranges between 2.5-3 years. Once the tenure expired, it is easily renewable without any further fee upon the terms and conditions mentioned in the agreement.
                            </p>
                        </div>

                        <div class="faq-row-bottom">
                            <div class="faq-title faq-bg">
                                <div class="distab faq-bg-width">
                                    <h3 class="faq-heading distab-cell-middle">What is the anticipated percentage return on investment?
                  </h3>
                                    <p class="down-arrow down-arrow-left distab-cell-middle"></p>
                                </div>
                            </div>
                            <p class="faq-ans faq-answer-pad faq-answer-bg">The ROI depends upon various factors. But normally, it is seen with the working of 200+ franchisee that one can expect min 250% return on its investment in 4-8 months time. 
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section> -->
    <!--================================= FREQUENTLY ASKED QUESTIONS END =============================================-->

   <!--================================= TESTIMONIAL START =============================================-->
   <section class="bg-testimonials" id="testimonials">
        <div class="container">
             <h1 class="center">testimonials</h1>
            <!-- <hr class="hr-testimonials"> -->
            <div class="row">    
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ul class="carousel-indicators">
                      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                      <li data-target="#myCarousel" data-slide-to="1"></li>
                      <li data-target="#myCarousel" data-slide-to="2"></li>
                      <li data-target="#myCarousel" data-slide-to="3"></li>
                      <li data-target="#myCarousel" data-slide-to="4"></li>
                      <li data-target="#myCarousel" data-slide-to="5"></li>
                    </ul>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                    <img src="{{asset('front/assets/img/quote.png')}}" alt="quote" class="image-center">
                    <h4>Dr. Vinod Sharma offers children hints to better memory, study scientifically. Taught how Mnemonic science helps to recall the memory so that students can face examinations with confidence.</h4>
                    <img src="{{asset('front/assets/img/toi.jpg')}}" alt="image" class="image-center">
                    <p class="">The Times of India</p>
                    </div>

                      <div class="carousel-item">
                       <img src="{{asset('front/assets/img/quote.png')}}" alt="quote" class="image-center">
                    <h4>Dr. Vinod Sharma offers children hints to better memory, study scientifically. Taught how Mnemonic science helps to recall the memory so that students can face examinations with confidence.</h4>
                    <img src="{{asset('front/assets/img/bhaskar.jpg')}}" alt="image" class="image-center">
                    <p class="">Dainik Bhaskar</p>
                      </div>
                    
                      <div class="carousel-item">
                       <img src="{{asset('front/assets/img/quote.png')}}" alt="quote" class="image-center">
                    <h4>Dr. Vinod Sharma offers children hints to better memory, study scientifically. Taught how Mnemonic science helps to recall the memory so that students can face examinations with confidence.</h4>
                    <img src="{{asset('front/assets/img/patrika.jpg')}}" alt="image" class="image-center">
                    <p class="">Rajasthan Patrika</p>
                      </div>

                      <div class="carousel-item">
                       <img src="{{asset('front/assets/img/quote.png')}}" alt="quote" class="image-center">
                    <h4>Dr. Vinod Sharma offers children hints to better memory, study scientifically. Taught how Mnemonic science helps to recall the memory so that students can face examinations with confidence.</h4>
                    <img src="{{asset('front/assets/img/indianexpress.jpg')}}" alt="image" class="image-center">
                    <p class="">The Indian Express</p>
                      </div>

                      <div class="carousel-item">
                       <img src="{{asset('front/assets/img/quote.png')}}" alt="quote" class="image-center">
                    <h4>Dr. Vinod Sharma offers children hints to better memory, study scientifically. Taught how Mnemonic science helps to recall the memory so that students can face examinations with confidence.</h4>
                    <img src="{{asset('front/assets/img/shatrughan.jpg')}}" alt="image" class="image-center">
                    <p class="">Shatrughan Sinha</p>
                      </div>

                      <div class="carousel-item">
                       <img src="{{asset('front/assets/img/quote.png')}}" alt="quote" class="image-center">
                    <h4>Dr. Vinod Sharma offers children hints to better memory, study scientifically. Taught how Mnemonic science helps to recall the memory so that students can face examinations with confidence.</h4>
                    <img src="{{asset('front/assets/img/kumar-vishwas.jpg')}}" alt="image" class="image-center">
                    <p class="">Kumar Vishwas</p>
                      </div>
                    </div>

                    <!-- Left and right controls -->
                    <a class="carousel-control-prev" href="#myCarousel" data-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </a>
                    <a class="carousel-control-next" href="#myCarousel" data-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </a>
                </div>
            </div>
        </div>       
    </section>





  <!--   <section class="container-fluid section-space section-bg-1 testimonial-indicator">
        <div class="container">
            <h1 class="center">testimonials</h1>
            <div id="owl-demo1" class="owl-carousel owl-theme no-margin no-padding">
                <div class="item">
                    <div class="center quote-bottom">
                        <img src="{{asset('front/assets/img/quote.png')}}" alt="quote" class="image-center" />
                    </div>
                    <div class="col-md-8 column-center no-padding">
                        <p class="center p-bottom testimonial-text ls">Brainywood Learning is of Different Kind- Mnemonic is a Science which enables faster and more accurate recollection of facts. Brainywood Learning is of Different Kind- Mnemonic is a Science which enables faster and more accurate recollection of facts.</p>
                    </div>
                    <div class="distab image-center">
                        <div class="distab-cell-middle">
                            <img src="{{asset('front/assets/img/toi.jpg')}}" alt="image" class="image-center" />
                        </div>
                        <div class="distab-cell-middle testimonial-author-pad">
                            <p class="left testimonial-author ls">The Times of India</p>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <div class="center quote-bottom">
                        <img src="{{asset('front/assets/img/quote.png')}}" alt="quote" class="image-center" />
                    </div>
                    <div class="col-md-8 column-center no-padding">
                        <p class="center p-bottom testimonial-text ls">Brainywood is Reducing the Mental Stress of students in Nation.</p>
                    </div>
                    <div class="distab image-center">
                        <div class="distab-cell-middle">
                            <img src="{{asset('front/assets/img/patrika.jpg')}}" alt="image" class="image-center" />
                        </div>
                        <div class="distab-cell-middle testimonial-author-pad">
                            <p class="left testimonial-author ls">Rajasthan Patrika</p>
                        </div>
                    </div>
                </div>


                <div class="item">
                    <div class="center quote-bottom">
                        <img src="{{asset('front/assets/img/quote.png')}}" alt="quote" class="image-center" />
                    </div>
                    <div class="col-md-8 column-center no-padding">
                        <p class="center p-bottom testimonial-text ls">Brainywood Science of Learning is the key to achieve success in life.</p>
                    </div>
                    <div class="distab image-center">
                        <div class="distab-cell-middle">
                            <img src="{{asset('front/assets/img/bhaskar.jpg')}}" alt="image" class="image-center" />
                        </div>
                        <div class="distab-cell-middle testimonial-author-pad">
                            <p class="left testimonial-author ls">Dainik Bhaskar</p>
                        </div>
                    </div>
                </div>
        
        <div class="item">
                    <div class="center quote-bottom">
                        <img src="{{asset('front/assets/img/quote.png')}}" alt="quote" class="image-center" />
                    </div>
                    <div class="col-md-8 column-center no-padding">
                        <p class="center p-bottom testimonial-text ls">Dr. Vinod Sharma offers children hints to better memory, study scientifically. Taught how Mnemonic science helps to recall the memory so that students can face examinations with confidence.</p>
                    </div>
                    <div class="distab image-center">
                        <div class="distab-cell-middle">
                            <img src="{{asset('front/assets/img/indianexpress.jpg')}}" alt="image" class="image-center" />
                        </div>
                        <div class="distab-cell-middle testimonial-author-pad">
                            <p class="left testimonial-author ls">The Indian Express</p>
                        </div>
                    </div>
                </div>
        
        <div class="item">
                    <div class="center quote-bottom">
                        <img src="{{asset('front/assets/img/quote.png')}}" alt="quote" class="image-center" />
                    </div>
                    <div class="col-md-8 column-center no-padding">
                        <p class="center p-bottom testimonial-text ls">Brainywood techniques will not only help enhancing their memory but will also make them a better person.</p>
                    </div>
                    <div class="distab image-center">
                        <div class="distab-cell-middle">
                            <img src="{{asset('front/assets/img/naseeruddin.jpg')}}" alt="image" class="image-center" />
                        </div>
                        <div class="distab-cell-middle testimonial-author-pad">
                            <p class="left testimonial-author ls">Naseeruddin Shah</p>
                        </div>
                    </div>
                </div>
        
        <div class="item">
                    <div class="center quote-bottom">
                        <img src="{{asset('front/assets/img/quote.png')}}" alt="quote" class="image-center" />
                    </div>
                    <div class="col-md-8 column-center no-padding">
                        <p class="center p-bottom testimonial-text ls">Superb and innovative concept for upcoming generations.</p>
                    </div>
                    <div class="distab image-center">
                        <div class="distab-cell-middle">
                            <img src="{{asset('front/assets/img/shailesh-lodha.png')}}" alt="image" class="image-center" />
                        </div>
                        <div class="distab-cell-middle testimonial-author-pad">
                            <p class="left testimonial-author ls">Shailesh Lodha</p>
                        </div>
                    </div>
                </div>
        
        <div class="item">
                    <div class="center quote-bottom">
                        <img src="{{asset('front/assets/img/quote.png')}}" alt="quote" class="image-center" />
                    </div>
                    <div class="col-md-8 column-center no-padding">
                        <p class="center p-bottom testimonial-text ls">For success either you be better of the best or different from the rest. Being different from the rest is very innovative. All the good wishes to Brainywood Team.</p>
                    </div>
                    <div class="distab image-center">
                        <div class="distab-cell-middle">
                            <img src="{{asset('front/assets/img/shatrughan.jpg')}}" alt="image" class="image-center" />
                        </div>
                        <div class="distab-cell-middle testimonial-author-pad">
                            <p class="left testimonial-author ls">Shatrughan Sinha</p>
                        </div>
                    </div>
                </div>
        
        <div class="item">
                    <div class="center quote-bottom">
                        <img src="{{asset('front/assets/img/quote.png')}}" alt="quote" class="image-center" />
                    </div>
                    <div class="col-md-8 column-center no-padding">
                        <p class="center p-bottom testimonial-text ls">Thinking of this type is much needed today; this is a beautiful combination of philosophy and science.</p>
                    </div>
                    <div class="distab image-center">
                        <div class="distab-cell-middle">
                          <img src="{{asset('front/assets/img/kumar-vishwas.jpg')}}" alt="image" class="image-center" />
                        </div>
                        <div class="distab-cell-middle testimonial-author-pad">
                            <p class="left testimonial-author ls">Kumar Vishwas</p>
                        </div>
                    </div>
                </div>
        
        <div class="item">
                    <div class="center quote-bottom">
                        <img src="{{asset('front/assets/img/quote.png')}}" alt="quote" class="image-center" />
                    </div>
                    <div class="col-md-8 column-center no-padding">
                        <p class="center p-bottom testimonial-text ls">Dr. Vinod Sharma techniques are practical guide on brain science-mnemonics. I hope his techniques will be very helpful for students to reduce their stress and study time.</p>
                    </div>
                    <div class="distab image-center">
                        <div class="distab-cell-middle">
                            <img src="{{asset('front/assets/img/manish.jpg')}}" alt="image" class="image-center" />
                        </div>
                        <div class="distab-cell-middle testimonial-author-pad">
                            <p class="left testimonial-author ls">Mr. Manish Sisodia</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section> -->
    <!--================================= TESTIMONIAL END =============================================-->


 
    <!--================================= FOOTER-MAP START =============================================-->
    <!-- <section class="container-fluid section-space section-bg-2" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-6 common-res-bottom-1">
          <iframe class="venue-map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3605.8527751044035!2d74.62616331501242!3d25.342720883828726!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3968c32788f7444f%3A0xb762f7f1da1adfac!2sBrainywood!5e0!3m2!1sen!2sin!4v1610349199914!5m2!1sen!2sin" width="600" height="600" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                </div>

                <div class="col-md-4 col-sm-6">
                    <h3 class="center h3-bottom">address</h3>
                    <p class="center ls adress-line-bottom">Near 9 No. Petrol Pump, Nasirabad Road, Gopalganj, Nagra,</p>
                    <p class="center footer-row-space ls">Ajmer (Raj.) 305001 INDIA</p>

                    <h3 class="center h3-bottom">Email </h3>
                    <p class="center footer-row-space ls"> <a href="#">crm.brainywood@gmail.com</a><br /><a href="#">vedicbrainsolutions@gmail.com</a>
                    </p>

                    <h3 class="center h3-bottom">phone nos.</h3>
                    <p class="center footer-row-space ls">+91-78783-09045, <br />+91-99503-68500</p>

                    <h3 class="center follow-heading-bottom">follow us</h3>
                    <div class="center">
                        <ul class="no-padding no-margin footer-icon footer-left-pad">
                            <li>
                                <a href="https://www.facebook.com/Brainywoodofficial">
                                    <img src="{{asset('front/assets/img/48x48x5.png')}}" alt="icon" />
                                </a>
                            </li>

                            <li>
                                <a href="https://instagram.com/brainywoodofficial">
                                  <img src="{{asset('front/assets/img/48x48xinsta.png')}}" alt="icon" />
                                </a>
                            </li>

                            <li>
                            <a href="https://www.linkedin.com/company/brainywoodofficial">
                            <img src="{{asset('front/assets/img/48x48x8.png')}}" alt="icon" />
                                </a>
                            </li>
              
              <li>
                                <a href="https://wa.me/917878309045">
                                    <img src="{{asset('front/assets/img/whatsapp.png')}}" alt="icon" />
                                </a>
                            </li>
              
                        </ul>
                    </div>
                </div>
            </div>
      <div class="footer-br footer-br-bottom"></div>
            <p class="center ls">&copy; Vedic Brain Solutions P Ltd. 2021, All Rights Reserved</p>
        </div>
    </section> -->
    <!--================================= FOOTER-MAP END =============================================-->

  
    <!-- JQUERY LIBRARY -->
    <script type="text/javascript" src="js/vendor/jquery.min.js"></script>
    <!-- BOOTSTRAP -->
    <script type="text/javascript" src="js/vendor/bootstrap.min.js"></script>

    <!-- SUBSCRIBE MAILCHIMP -->
    <script type="text/javascript" src="js/vendor/subscribe/subscribe_validate.js"></script>

    <!-- VALIDATION  -->
    <script type="text/javascript" src="js/vendor/validate/jquery.validate.min.js"></script>


    <!-- SLIDER JS FILES -->
    <script type="text/javascript" src="js/vendor/slider/owl.carousel.min.js"></script>
    <script type="text/javascript" src="js/vendor/slider/carousel.js"></script>

   <script src="https://brainywoodindia.com/front/assets/js/owl.carousel.min.js"></script>
    <script type="text/javascript" src="https://brainywoodindia.com/front/assets/js/carousel.js"></script>

    <!-- SUBSCRIBE MAILCHIMP -->
    <script type="text/javascript" src="js/vendor/subscribe/subscribe_validate.js"></script>

    <!-- IMAGE OVERLAY JS FILE -->
  <!--   <script type="text/javascript" src="js/vendor/img-overlay/modernizr.js"></script>
    <script type="text/javascript" src="js/vendor/img-overlay/overlay.js"></script> -->

  <script type="text/javascript" src="https://brainywoodindia.com/front/assets/js/overlay.js"></script>
  <script type="text/javascript" src="https://brainywoodindia.com/front/assets/js/modernizr.js"></script>
    

    <!-- LIGHT BOX GALLERY -->
    <script type="text/javascript" src="https://brainywoodindia.com/front/assets/js/ekko-lightbox.js"></script>
    <script type="text/javascript" src="https://brainywoodindia.com/front/assets/js/lightbox.js"></script>

    <!-- VIDEO -->
    <script type="text/javascript" src="js/vendor/video/video.js"></script>

    <!-- COUNTER JS FILES -->
    <script type="text/javascript" src="js/vendor/counter/counter-lib.js"></script>
    <script type="text/javascript" src="js/vendor/counter/jquery.counterup.min.js"></script>
 
    <!-- PHONE_NUMBER VALIDATION JS -->
    <script type="text/javascript" src="js/vendor/phone_number/phone_number.js"></script>


    <!-- THEME JS -->
    <script type="text/javascript" src="https://brainywoodindia.com/front/assets/js/custom.js"></script>

</body>

@endsection