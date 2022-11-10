<?php

  //  Route::post('/login','Api\ApiController@login')->name('login');

//Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.'], function () {

Route::prefix('v1')->group(function () {
	/*Route::post('/login', function () {
	   echo "string";die;
	});*/
	Route::post('/login','Api\ApiController@login')->name('login');
	Route::get('/get-student-class','Api\ApiController@getStudentClass')->name('getStudentClass');
	Route::get('/get-state','Api\ApiController@getStates')->name('getStates');
	Route::post('/register','Api\ApiController@register')->name('register');
	Route::post('/otpmatch','Api\ApiController@otpMatch')->name('otpMatch');
	Route::post('/resendotp','Api\ApiController@resendOtp')->name('resendOtp');
	Route::post('/forgetpassword','Api\ApiController@forgetpassword')->name('forgetpassword');
	Route::post('/reset-password','Api\ApiController@resetPassword')->name('resetPassword');
	Route::post('/check-user-token','Api\ApiController@checkUserToken')->name('checkUserToken');
	Route::post('/test-email','Api\ApiController@testemail')->name('testemail');
		
		//Route::post('/homepage','Api\ApiController@userHomepage')->middleware('checkAuth');
	Route::group(['middleware' => 'auth:api'], function () {
	//Route::group(['middleware' => 'checkAuth'], function () {
		Route::post('/about-us','Api\ApiController@getAboutUsDetails')->name('getAboutUsDetails');
		Route::post('/homepage','Api\ApiController@userHomepage')->name('userHomepage');
		Route::get('/popular-videos','Api\ApiController@allPopularVideos')->name('allPopularVideos');
		Route::post('/our-courses','Api\ApiController@ourCourses')->name('ourCourses');
		Route::post('/course-details','Api\ApiController@getCourseDetails')->name('getCourseDetails');
		Route::post('/lession-details','Api\ApiController@getLessionDetails')->name('getLessionDetails');
		Route::get('/rating-types','Api\ApiController@getRatingTypes')->name('getRatingTypes');
		Route::get('/rating-messages','Api\ApiController@getRatingMessages')->name('getRatingMessages');
		Route::post('/save-ratings','Api\ApiController@saveRatingsbyUser')->name('saveRatingsbyUser');
		Route::post('/post-continue-study','Api\ApiController@postContinueStudy')->name('postContinueStudy');
		Route::post('/get-continue-study-history','Api\ApiController@userContinueStudyHistory')->name('userContinueStudyHistory');
		Route::post('/quiz-guideline','Api\ApiController@quizGuideline')->name('quizGuideline');
		Route::post('/start-quiz','Api\ApiController@letStartQuiz')->name('letStartQuiz');
		Route::post('/pause-quiz','Api\ApiController@pauseQuiz')->name('pauseQuiz');
		Route::post('/next-quiz','Api\ApiController@nextQuiz')->name('nextQuiz');
		Route::post('/end-quiz','Api\ApiController@endQuiz')->name('endQuiz');
		Route::post('/cancel-quiz','Api\ApiController@cancelQuiz')->name('cancelQuiz');
		Route::post('/attemped-quiz','Api\ApiController@attempedQuiz')->name('attempedQuiz');
		Route::post('/get-all-attemped-quiz','Api\ApiController@getAllAttempedQuiz')->name('getAllAttempedQuiz');
		Route::post('/get-quiz-history','Api\ApiController@getQuizHistory')->name('getQuizHistory');
		Route::post('/get-quiz-result','Api\ApiController@getQuizResult')->name('getQuizResult');
		Route::post('/get-quiz-result-details','Api\ApiController@getQuizResultDetails')->name('getQuizResultDetails');
		Route::post('/get-live-classes','Api\ApiController@liveClasses')->name('liveClasses');
		Route::post('/past-upcoming-classes','Api\ApiController@pastUpcomingClasses')->name('pastUpcomingClasses');
		Route::post('/add-notify-class','Api\ApiController@notifyClass')->name('notifyClass');
		Route::post('/get-courses','Api\ApiController@getCourses')->name('getCourses');
		Route::post('/get-lession-bycourse','Api\ApiController@getLessionsBycourse')->name('getLessionsBycourse');
		Route::post('/get-topics-bylession','Api\ApiController@getTopicsByLession')->name('getTopicsByLession');
		Route::post('/ask-question','Api\ApiController@askQuestion')->name('askQuestion');
		Route::post('/latest-question','Api\ApiController@latestQuestion')->name('latestQuestion');
		Route::post('/my-question','Api\ApiController@myQuestion')->name('myQuestion');
		Route::post('/answer-a-question','Api\ApiController@answerAQuestion')->name('answerAQuestion');
		Route::post('/view-answers','Api\ApiController@viewAnswers')->name('viewAnswers');
		Route::post('/like-answer','Api\ApiController@likeAnswer')->name('likeAnswer');
		Route::post('/unlike-answer','Api\ApiController@unlikeAnswer')->name('unlikeAnswer');
		Route::post('/user-detail','Api\ApiController@userDetail')->name('userDetail');
		Route::post('/update-profile','Api\ApiController@updateProfile')->name('updateProfile');
		Route::post('/update-phone-email','Api\ApiController@updatePhoneEmail')->name('updatePhoneEmail');
		Route::post('/phone-email-resendotp','Api\ApiController@phoneEmailResendOtp')->name('phoneEmailResendOtp');
		Route::post('/change-password','Api\ApiController@changePassword')->name('changePassword');
		Route::post('/get-subscriptions','Api\ApiController@getSubscriptions')->name('getSubscriptions');
		Route::post('/apply-couponcode','Api\ApiController@applyCoupon')->name('applyCoupon');
		Route::post('/razorpay-orderid','Api\ApiController@getRazorpayOrderid')->name('getRazorpayOrderid');
		Route::post('/take-subscription','Api\ApiController@takeSubscription')->name('takeSubscription');
		Route::post('/get-notifications','Api\ApiController@getNotifications')->name('getNotifications');
		Route::post('/contact-us','Api\ApiController@contactUs')->name('contactUs');
	});
});
