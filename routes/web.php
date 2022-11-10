<?php
//Route::get('/', function () { return redirect('/admin/home'); });
Route::get('/admin', function () { return redirect('/admin/home'); });

Route::get('/', 'Front\FrontController@index')->name('home');
Route::post('enquiry', 'Front\FrontController@saveLead')->name('saveLead');
Route::get('about-us', 'Front\FrontController@aboutUs')->name('aboutUs');
Route::get('our-team', 'Front\FrontController@ourTeam')->name('ourTeam');
Route::get('services', 'Front\FrontController@services')->name('services');
Route::get('franchiseplans', 'Front\FrontController@franchiseplans')->name('franchiseplans');
Route::get('pricing', 'Front\FrontController@pricing')->name('pricing');
Route::get('plan-detail/{id}', 'Front\FrontController@planDetails')->name('planDetails');
Route::post('apply_coupon_code', 'Front\FrontController@apply_coupon_code')->name('apply_coupon_code');
Route::get('contact-us', 'Front\FrontController@contactUs')->name('contactUs');
Route::post('contact-us', 'Front\FrontController@postContact')->name('postContact');
Route::any('frontlogin','Front\FrontController@login')->name('frontlogin');
Route::any('frontlogout','Front\FrontController@logout')->name('frontlogout');
Route::post('frontregister', 'Front\FrontController@register')->name('frontregister');
Route::get('verify-account/{token}', 'Front\FrontController@verifyAccount')->name('verifyAccount');
Route::post('verify-otp', 'Front\FrontController@verifyAccountByOtp')->name('verifyAccountByOtp');
Route::get('close-verification', 'Front\FrontController@closeVerification')->name('closeVerification');
Route::post('resend-otp', 'Front\FrontController@resendOtp')->name('resendOtp');
Route::post('forgot-password', 'Front\FrontController@forgotPassword')->name('forgotPassword');
Route::post('forgot-password-otp', 'Front\FrontController@forgotPasswordByOtp')->name('forgotPasswordByOtp');
Route::post('forgot-resent-otp', 'Front\FrontController@forgotResendOtp')->name('forgotResendOtp');
Route::get('reset-password/{token}', 'Front\FrontController@passwordToken')->name('passwordToken');
Route::post('reset-password', 'Front\FrontController@resetPassword')->name('resetPassword');
Route::get('my-profile', 'Front\FrontController@myProfile')->name('myProfile');
Route::get('my-account', 'Front\FrontController@myAccount')->name('myAccount');
Route::post('upload-profile', 'Front\FrontController@uploadProfile')->name('uploadProfile');
Route::post('update-account', 'Front\FrontController@updateAccount')->name('updateAccount');
Route::post('mobileUpdate', 'Front\FrontController@mobileUpdate')->name('mobileUpdate');
Route::post('mobileOtpSend', 'Front\FrontController@mobileOtpSend')->name('mobileOtpSend');
Route::post('emailUpdate', 'Front\FrontController@emailUpdate')->name('emailUpdate');
Route::post('emailOtpSend', 'Front\FrontController@emailOtpSend')->name('emailOtpSend');
Route::post('change-password', 'Front\FrontController@changePassword')->name('changePassword');
Route::post('update-info', 'Front\FrontController@updateInfo')->name('updateInfo');
Route::post('get_cities_by_state', 'Front\FrontController@getCitiesByState')->name('getCitiesByState');
Route::get('our-courses', 'Front\FrontController@ourCourses')->name('ourCourses');
Route::get('course-detail/{id}', 'Front\FrontController@courseDetails')->name('courseDetails');
Route::get('lession-detail/{id}', 'Front\FrontController@lessionDetails')->name('lessionDetails');
Route::get('topic-detail/{id}', 'Front\FrontController@topicDetails')->name('topicDetails');
Route::post('rate-by-user', 'Front\FrontController@rateByUser')->name('rateByUser');
Route::get('live-classes', 'Front\FrontController@liveClasses')->name('liveClasses');
Route::post('notify_me', 'Front\FrontController@notify_me')->name('notify_me');
Route::get('quiz/{id}', 'Front\FrontController@getQuiz')->name('getQuiz');
Route::post('pause_quiz', 'Front\FrontController@pauseQuiz')->name('pauseQuiz');
Route::post('submit_quiz_answer', 'Front\FrontController@nextQuiz')->name('nextQuiz');
Route::post('end_quiz_answer', 'Front\FrontController@endQuiz')->name('endQuiz');
Route::post('auto_end_quiz', 'Front\FrontController@autoEndQuiz')->name('autoEndQuiz');
Route::get('quiz-list/{quizId}/{examId}', 'Front\FrontController@quizList')->name('quizList');
Route::get('quiz-result/{quizId}/{examId}', 'Front\FrontController@quizResult')->name('quizResult');
Route::get('quiz-result-view-question/{quizId}/{examId}', 'Front\FrontController@quizResultViewQuestion')->name('quizResultViewQuestion');
Route::get('qa', 'Front\FrontController@questionAnswer')->name('questionAnswer');
Route::get('qa-view-answer/{id}', 'Front\FrontController@questionAnswerView')->name('questionAnswerView');
Route::post('get_lessions_by_course', 'Front\FrontController@getLessionsBycourse')->name('getLessionsBycourse');
Route::post('get_topics_by_lession', 'Front\FrontController@getTopicsByLession')->name('getTopicsByLession');
Route::post('get_questions_by_lession', 'Front\FrontController@getQuestionsBylession')->name('getQuestionsBylession');
Route::post('save-question', 'Front\FrontController@saveQuestion')->name('saveQuestion');
Route::post('answer-a-question', 'Front\FrontController@answerAQuestion')->name('answerAQuestion');
Route::post('like-answer', 'Front\FrontController@answerLike')->name('answerLike');
Route::post('unlike-answer', 'Front\FrontController@answerUnLike')->name('answerUnLike');

// Get Route For Show Payment Form
Route::get('paywithrazorpay', 'Front\FrontController@razorpay')->name('razorpay');
// Post Route For Make Payment Request
Route::post('razorpaypayment/{id}', 'Front\FrontController@payment')->name('payment');

Route::get('blogs', 'Front\FrontController@blogs')->name('blogs');
Route::get('blog/{slug_url}', 'Front\FrontController@blogDetails')->name('blogDetails');

Route::get('generate-pdf','Front\FrontController@generatePDF')->name('generatePDF');

Route::get('pi','Front\FrontController@pi')->name('pi');

//cron job
Route::get('liveclass-second-notify','Front\FrontController@sendLiveClassSecondNotification')->name('sendLiveClassSecondNotification');
Route::get('liveclass-third-notify','Front\FrontController@sendLiveClassThirdNotification')->name('sendLiveClassThirdNotification');
Route::get('liveclass-fourth-notify','Front\FrontController@sendLiveClassFourthNotification')->name('sendLiveClassFourthNotification');
Route::get('convert-video','Front\FrontController@convertVideoOneByOne')->name('convertVideo');
Route::get('membership-expiry','Front\FrontController@membershipExpiry')->name('membershipExpiry');




// Authentication Routes...
Auth::routes();
$this->get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
$this->post('login', 'Auth\LoginController@login')->name('auth.login');
$this->post('logout', 'Auth\LoginController@logout')->name('auth.logout');

// Change Password Routes...
$this->get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
$this->patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');


Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
	Route::get('/home', 'HomeController@index');
	Route::resource('permissions', 'Admin\PermissionsController');
	Route::post('permissions_mass_destroy', ['uses' => 'Admin\PermissionsController@massDestroy', 'as' => 'permissions.mass_destroy']);
	Route::resource('roles', 'Admin\RolesController');
	Route::post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
	Route::resource('users', 'Admin\UsersController');
	Route::get('teachers', 'Admin\UsersController@teachers')->name('teachers');
	Route::get('users/{id}/teacher/edit', 'Admin\UsersController@teacherEdit')->name('teacherEdit');
	Route::get('students', 'Admin\UsersController@students')->name('students');
	Route::get('students/create', 'Admin\UsersController@studentCreate')->name('createStudent');
	Route::get('users/{id}/student/edit', 'Admin\UsersController@studentEdit')->name('studentEdit');
	Route::get('users/updateStatus/{id}/{status}','Admin\UsersController@updateStatus')->name('updateStatusUsers');
	Route::post('users_mass_destroy', ['uses' => 'Admin\UsersController@massDestroy', 'as' => 'users.mass_destroy']);
	Route::get('users/{id}/view', 'Admin\UsersController@show')->name('usersView');
	Route::get('deleted-users', 'Admin\UsersController@deletedUsers')->name('deletedUsers');
	Route::get('restore-users/{id}','Admin\UsersController@restoreUsers')->name('restoreUsers');
	Route::post('get_cities_by_state', 'Admin\UsersController@getCitiesByStateName')->name('getCitiesByStateName');
	Route::get('/assigntocourse',function (){
		  $siteTitle = "Assign to course builder";
		 return view('admin.assign');
	});
	Route::get('/mail_template',function (){
		 return view('admin.email_template');
	});
	Route::get('/email_notification',function (){
		 return view('admin.email_notification');
	});

	//admin work

	Route::get('/admin_report','CourseRequestController@adminReport')->name('admin_report');
	Route::post('assignCourseBuilder/{id}','CourseRequestController@assignCourseBuilder')->name('assignCourseBuilder');
	Route::post('assignCourseBuilderTo/{id}','CourseRequestController@assignCourseBuilderTo')->name('assignCourseBuilderTo');
	Route::get('/mail_teemplate','AdminController@adminEmail')->name('adminEmailTemplate');
	Route::get('/admin/helpDesk', 'HelpDeskController@adminHelpDesk')->name('adminHelpDesk');
	Route::get('/admin/helpDesk/view/{id}', 'HelpDeskController@adminHelpView')->name('adminHelpView');


	//admin work

	//add courses
	Route::get('/courses','CoursesController@index')->name('AllCourses');
	Route::get('/courses/create', 'CoursesController@create')->name('createCourseRoute');
	Route::post('/courses/create','CoursesController@store')->name('courseStore');
	Route::get('/courses/edit/{id}','CoursesController@edit')->name('editCourse');
	Route::get('/courses/delete/{id}','CoursesController@delete')->name('deleteCourse');
	Route::post('/courses/update/{id}','CoursesController@update')->name('courseUpdate');
	Route::get('/courses/updateStatus/{id}/{status}','CoursesController@updateStatus')->name('updateStatus');
	Route::get('/courses/up/{id}/{sort_id}','CoursesController@sortUp')->name('coursesortUp');
	Route::get('/courses/down/{id}/{sort_id}','CoursesController@sortDown')->name('coursesortDown');
	Route::get('/courses/convertVideo','CoursesController@convertVideo')->name('convertVideoCourses');
	Route::get('/courses/approveVideo/{id}','CoursesController@approveVideo')->name('approveVideoCourse');
	Route::get('/courses/imgremove/{id}','CoursesController@imgremove')->name('imgremoveCourse');
	Route::get('/courses/vidremove/{id}','CoursesController@vidremove')->name('vidremoveCourse');
	Route::get('/courses/pdfremove/{id}','CoursesController@pdfremove')->name('pdfremoveCourse');
	//end of courses

	//add lession
	Route::get('/lession','LessionController@index')->name('AllLessions');
	Route::get('/lession/create', 'LessionController@create')->name('createLessionRoute');
	Route::post('/lession/create','LessionController@store')->name('lessionStore');
	Route::get('/lession/edit/{id}','LessionController@edit')->name('editLession');
	Route::get('/lession/delete/{id}','LessionController@delete')->name('deleteLession');
	Route::post('/lession/update/{id}','LessionController@update')->name('lessionUpdate');
	Route::get('/lession/updateStatus/{id}/{status}','LessionController@updateStatus')->name('updateStatus');
	Route::get('/lession/up/{id}/{sort_id}','LessionController@sortUp')->name('lessionsortUp');
	Route::get('/lession/down/{id}/{sort_id}','LessionController@sortDown')->name('lessionsortDown');
	Route::get('/lession/convertVideo','LessionController@convertVideo')->name('convertVideoLessions');
	Route::get('/lession/approveVideo/{id}','LessionController@approveVideo')->name('approveVideoLession');
	Route::get('/lession/imgremove/{id}','LessionController@imgremove')->name('imgremoveLession');
	Route::get('/lession/vidremove/{id}','LessionController@vidremove')->name('vidremoveLession');
	Route::get('/lession/pdfremove/{id}','LessionController@pdfremove')->name('pdfremoveLession');
	Route::post('/lession/getcourselession','LessionController@getcourselession')->name('getlession');
	Route::post('/lession/getlessiontopic','LessionController@getlessiontopic')->name('gettopic');
	//end of lession

	//add lession-chapter
	Route::get('/lession-chapter','LessionChapterController@index')->name('AllLessionChapters');
	Route::get('/lession-chapter/create', 'LessionChapterController@create')->name('createLessionChapter');
	Route::post('/lession-chapter/create','LessionChapterController@store')->name('storeLessionChapter');
	Route::get('/lession-chapter/edit/{id}','LessionChapterController@edit')->name('editLessionChapter');
	Route::post('/lession-chapter/update/{id}','LessionChapterController@update')->name('updateLessionChapter');
	Route::get('/lession-chapter/updateStatus/{id}/{status}','LessionChapterController@updateStatus')->name('updateStatusLessionChapter');
	Route::get('/lession-chapter/delete/{id}','LessionChapterController@delete')->name('deleteLessionChapter');
	Route::get('/lession-chapter/up/{id}/{sort_id}','LessionChapterController@sortUp')->name('sortUpLessionChapter');
	Route::get('/lession-chapter/down/{id}/{sort_id}','LessionChapterController@sortDown')->name('sortDownLessionChapter');
	Route::post('/lession-chapter/getchapterbylession','LessionChapterController@getchapterbylession')->name('getchapterbylession');
	Route::get('/lession-chapter/convertVideo','LessionChapterController@convertVideo')->name('convertVideoLessionChapters');
	Route::get('/lession-chapter/approveVideo/{id}','LessionChapterController@approveVideo')->name('approveVideoLessionChapter');
	Route::get('/lession-chapter/imgremove/{id}','LessionChapterController@imgremove')->name('imgremoveLessionChapter');
	Route::get('/lession-chapter/vidremove/{id}','LessionChapterController@vidremove')->name('vidremoveLessionChapter');
	Route::get('/lession-chapter/pdfremove/{id}','LessionChapterController@pdfremove')->name('pdfremoveLessionChapter');
	//end of lession-chapter

	//add quizs
	Route::get('/quizs','QuizController@index')->name('AllQuizs');
	Route::get('/quizs/create', 'QuizController@create')->name('createQuizRoute');
	Route::post('/quizs/create','QuizController@store')->name('quizStore');
	Route::get('/quizs/edit/{id}','QuizController@edit')->name('editQuiz');
	Route::get('/quizs/delete/{id}','QuizController@delete')->name('deleteQuiz');
	Route::post('/quizs/update/{id}','QuizController@update')->name('quizUpdate');
	Route::get('/quizs/updateStatus/{id}/{status}','QuizController@updateStatus')->name('updateStatus');
	Route::post('/quizs/deleteOption','QuizController@deleteOption')->name('deleteOption');
	//end of quizs

	//add live classes
	Route::get('/liveclasses','LiveclassesController@index')->name('AllLiveclasses');
	Route::get('/liveclasses/create', 'LiveclassesController@create')->name('createLiveclass');
	Route::post('/liveclasses/create','LiveclassesController@store')->name('storeLiveclass');
	Route::get('/liveclasses/edit/{id}','LiveclassesController@edit')->name('editLiveclass');
	Route::post('/liveclasses/update/{id}','LiveclassesController@update')->name('updateLiveclass');
	Route::get('/liveclasses/updateStatus/{id}/{status}','LiveclassesController@updateStatus')->name('updateStatusLiveclass');
	Route::get('/liveclasses/delete/{id}','LiveclassesController@delete')->name('deleteLiveclass');
	Route::get('/liveclasses/notify','LiveclassesController@notify')->name('NotifyLiveclasses');
	Route::get('/liveclasses/notify/send/{id}','LiveclassesController@sendLiveclass')->name('sendLiveclass');
	Route::get('/liveclasses/convertVideo','LiveclassesController@convertVideo')->name('convertVideoLiveclasses');
	Route::get('/liveclasses/approveVideo/{id}','LiveclassesController@approveVideo')->name('approveVideoLiveclass');
	Route::get('/liveclasses/imgremove/{id}','LiveclassesController@imgremove')->name('imgremoveLiveclass');
	Route::get('/liveclasses/vidremove/{id}','LiveclassesController@vidremove')->name('vidremoveLiveclass');
	//end of live classes

	//add popular videos
	Route::get('/popularvideos','PopularVideoController@index')->name('AllPopularVideo');
	Route::get('/popularvideos/create', 'PopularVideoController@create')->name('createPopularVideo');
	Route::post('/popularvideos/create','PopularVideoController@store')->name('storePopularVideo');
	Route::get('/popularvideos/edit/{id}','PopularVideoController@edit')->name('editPopularVideo');
	Route::post('/popularvideos/update/{id}','PopularVideoController@update')->name('updatePopularVideo');
	Route::get('/popularvideos/updateStatus/{id}/{status}','PopularVideoController@updateStatus')->name('updateStatusPopularVideo');
	Route::get('/popularvideos/delete/{id}','PopularVideoController@delete')->name('deletePopularVideo');
	Route::get('/popularvideos/up/{id}/{sort_id}','PopularVideoController@sortUp')->name('sortUpPopularVideo');
	Route::get('/popularvideos/down/{id}/{sort_id}','PopularVideoController@sortDown')->name('sortDownPopularVideo');
	Route::get('/popularvideos/convertVideo','PopularVideoController@convertVideo')->name('convertVideoPopularVideo');
	Route::get('/popularvideos/approveVideo/{id}','PopularVideoController@approveVideo')->name('approveVideoPopularVideo');
	Route::get('/popularvideos/imgremove/{id}','PopularVideoController@imgremove')->name('imgremovePopularVideo');
	Route::get('/popularvideos/vidremove/{id}','PopularVideoController@vidremove')->name('vidremovePopularVideo');
	//end of popular videos

	//add concept videos
	Route::get('/conceptvideos','ConceptVideoController@index')->name('AllConceptVideo');
	Route::get('/conceptvideos/create', 'ConceptVideoController@create')->name('createConceptVideo');
	Route::post('/conceptvideos/create','ConceptVideoController@store')->name('storeConceptVideo');
	Route::get('/conceptvideos/edit/{id}','ConceptVideoController@edit')->name('editConceptVideo');
	Route::post('/conceptvideos/update/{id}','ConceptVideoController@update')->name('updateConceptVideo');
	Route::get('/conceptvideos/updateStatus/{id}/{status}','ConceptVideoController@updateStatus')->name('updateStatusConceptVideo');
	Route::get('/conceptvideos/delete/{id}','ConceptVideoController@delete')->name('deleteConceptVideo');
	Route::get('/conceptvideos/up/{id}/{sort_id}','ConceptVideoController@sortUp')->name('sortUpConceptVideo');
	Route::get('/conceptvideos/down/{id}/{sort_id}','ConceptVideoController@sortDown')->name('sortDownConceptVideo');
	Route::get('/conceptvideos/convertVideo','ConceptVideoController@convertVideo')->name('convertVideoConceptVideo');
	Route::get('/conceptvideos/approveVideo/{id}','ConceptVideoController@approveVideo')->name('approveVideoConceptVideo');
	Route::get('/conceptvideos/imgremove/{id}','ConceptVideoController@imgremove')->name('imgremoveConceptVideo');
	Route::get('/conceptvideos/vidremove/{id}','ConceptVideoController@vidremove')->name('vidremoveConceptVideo');
	//end of concept videos

	//add question answers
	Route::get('/questionanswers','QuestionAnswerController@index')->name('AllQuestionAnswer');
	Route::get('/questionanswers/create', 'QuestionAnswerController@create')->name('createQuestionAnswer');
	Route::post('/questionanswers/create','QuestionAnswerController@store')->name('storeQuestionAnswer');
	Route::get('/questionanswers/view/{id}','QuestionAnswerController@show')->name('viewQuestionAnswer');
	Route::get('/questionanswers/edit/{id}','QuestionAnswerController@edit')->name('editQuestionAnswer');
	Route::post('/questionanswers/update/{id}','QuestionAnswerController@update')->name('updateQuestionAnswer');
	Route::get('/questionanswers/updateStatus/{id}/{status}','QuestionAnswerController@updateStatus')->name('updateStatusQuestionAnswer');
	Route::get('/questionanswers/delete/{id}','QuestionAnswerController@delete')->name('deleteQuestionAnswer');
	Route::get('/qanswer/delete/{id}','QuestionAnswerController@deleteAnswer')->name('deleteAnswer');
	Route::post('get_lessions_by_course', 'QuestionAnswerController@getLessionsBycourse')->name('lessionsBycourse');
	Route::post('get_topics_by_lession', 'QuestionAnswerController@getTopicsByLession')->name('topicsByLession');
	//end of question answers

	//add usersratings
	Route::get('/usersratings','UserRatingController@index')->name('AllUserRating');
	Route::get('/usersratings/create', 'UserRatingController@create')->name('createUserRating');
	Route::post('/usersratings/create','UserRatingController@store')->name('storeUserRating');
	Route::get('/usersratings/view/{id}','UserRatingController@show')->name('showUserRating');
	Route::get('/usersratings/edit/{id}','UserRatingController@edit')->name('editUserRating');
	Route::post('/usersratings/update/{id}','UserRatingController@update')->name('updateUserRating');
	Route::get('/usersratings/updateStatus/{id}/{status}','UserRatingController@updateStatus')->name('updateStatusUserRating');
	Route::get('/usersratings/delete/{id}','UserRatingController@delete')->name('deleteUserRating');
	//end of usersratings

	//add notifications
	Route::get('/notifications','NotificationController@index')->name('AllNotification');
	Route::get('/notifications/create', 'NotificationController@create')->name('createNotification');
	Route::post('/notifications/create','NotificationController@store')->name('storeNotification');
	Route::get('/notifications/edit/{id}','NotificationController@edit')->name('editNotification');
	Route::post('/notifications/update/{id}','NotificationController@update')->name('updateNotification');
	Route::get('/notifications/updateStatus/{id}/{status}','NotificationController@updateStatus')->name('updateStatusNotification');
	Route::get('/notifications/delete/{id}','NotificationController@delete')->name('deleteNotification');
	//end of notifications

	//add contact us
	Route::get('/contactus','ContactusController@index')->name('AllContactus');
	Route::get('/contactus/create', 'ContactusController@create')->name('createContactus');
	Route::post('/contactus/create','ContactusController@store')->name('storeContactus');
	Route::get('/contactus/edit/{id}','ContactusController@edit')->name('editContactus');
	Route::post('/contactus/update/{id}','ContactusController@update')->name('updateContactus');
	Route::get('/contactus/updateStatus/{id}/{status}','ContactusController@updateStatus')->name('updateStatusContactus');
	Route::get('/contactus/delete/{id}','ContactusController@delete')->name('deleteContactus');
	//end of contactus

	//add enquiries
	Route::get('/enquiries','EnquiryController@index')->name('AllEnquiry');
	Route::get('/enquiries/updateStatus/{id}/{status}','EnquiryController@updateStatus')->name('updateStatusEnquiry');
	Route::get('/enquiries/delete/{id}','EnquiryController@delete')->name('deleteEnquiry');
	//end of enquiries

	//add couponcodes
	Route::get('/couponcodes','CouponController@index')->name('AllCoupon');
	Route::get('/couponcodes/create', 'CouponController@create')->name('createCoupon');
	Route::post('/couponcodes/create','CouponController@store')->name('storeCoupon');
	Route::get('/couponcodes/edit/{id}','CouponController@edit')->name('editCoupon');
	Route::post('/couponcodes/update/{id}','CouponController@update')->name('updateCoupon');
	Route::get('/couponcodes/updateStatus/{id}/{status}','CouponController@updateStatus')->name('updateStatusCoupon');
	Route::get('/couponcodes/delete/{id}','CouponController@delete')->name('deleteCoupon');
	Route::post('/couponcodes/getcouponcode','CouponController@getcouponcode')->name('getcouponcode');
	//end of couponcodes

	//add usersubscriptions
	Route::get('/usersubscriptions','UserSubscriptionController@index')->name('AllUserSubscription');
	Route::get('/usersubscriptions/create', 'UserSubscriptionController@create')->name('createUserSubscription');
	Route::post('/usersubscriptions/create','UserSubscriptionController@store')->name('storeUserSubscription');
	Route::get('/usersubscriptions/edit/{id}','UserSubscriptionController@edit')->name('editUserSubscription');
	Route::post('/usersubscriptions/update/{id}','UserSubscriptionController@update')->name('updateUserSubscription');
	/*Route::get('/usersubscriptions/updateStatus/{id}/{status}','UserSubscriptionController@updateStatus')->name('updateStatusUserSubscription');
	Route::get('/usersubscriptions/delete/{id}','UserSubscriptionController@delete')->name('deleteUserSubscription');*/
	//end of usersubscriptions

	//add subscriptions plan
	Route::get('/subscriptions','SubscriptionController@index')->name('AllSubscription');
	Route::get('/subscriptions/create', 'SubscriptionController@create')->name('createSubscription');
	Route::post('/subscriptions/create','SubscriptionController@store')->name('storeSubscription');
	Route::get('/subscriptions/edit/{id}','SubscriptionController@edit')->name('editSubscription');
	Route::post('/subscriptions/update/{id}','SubscriptionController@update')->name('updateSubscription');
	Route::get('/subscriptions/updateStatus/{id}/{status}','SubscriptionController@updateStatus')->name('updateStatusSubscription');
	Route::get('/subscriptions/delete/{id}','SubscriptionController@delete')->name('deleteSubscription');
	//end of subscriptions

	//add testimonials plan
	Route::get('/testimonials','TestimonialController@index')->name('AllTestimonial');
	Route::get('/testimonials/create', 'TestimonialController@create')->name('createTestimonial');
	Route::post('/testimonials/create','TestimonialController@store')->name('storeTestimonial');
	Route::get('/testimonials/edit/{id}','TestimonialController@edit')->name('editTestimonial');
	Route::post('/testimonials/update/{id}','TestimonialController@update')->name('updateTestimonial');
	Route::get('/testimonials/updateStatus/{id}/{status}','TestimonialController@updateStatus')->name('updateStatusTestimonial');
	Route::get('/testimonials/delete/{id}','TestimonialController@delete')->name('deleteTestimonial');
	Route::get('/testimonials/up/{id}/{sort_id}','TestimonialController@sortUp')->name('testimonialsortUp');
	Route::get('/testimonials/down/{id}/{sort_id}','TestimonialController@sortDown')->name('testimonialsortDown');
	//end of testimonials

	//add classes
	Route::get('/classes','StudentClassController@index')->name('AllStudentClass');
	Route::get('/classes/create', 'StudentClassController@create')->name('createStudentClass');
	Route::post('/classes/create','StudentClassController@store')->name('storeStudentClass');
	Route::get('/classes/edit/{id}','StudentClassController@edit')->name('editStudentClass');
	Route::post('/classes/update/{id}','StudentClassController@update')->name('updateStudentClass');
	Route::get('/classes/updateStatus/{id}/{status}','StudentClassController@updateStatus')->name('updateStatusStudentClass');
	Route::get('/classes/delete/{id}','StudentClassController@delete')->name('deleteStudentClass');
	//end of classes

	//add teams member
	Route::get('/teams','TeamController@index')->name('AllTeam');
	Route::get('/teams/create', 'TeamController@create')->name('createTeam');
	Route::post('/teams/create','TeamController@store')->name('storeTeam');
	Route::get('/teams/edit/{id}','TeamController@edit')->name('editTeam');
	Route::post('/teams/update/{id}','TeamController@update')->name('updateTeam');
	Route::get('/teams/updateStatus/{id}/{status}','TeamController@updateStatus')->name('updateStatusTeam');
	Route::get('/teams/delete/{id}','TeamController@delete')->name('deleteTeam');
	//end of teams member

	//add pages
	Route::get('/pages','PageController@index')->name('AllPage');
	Route::get('/pages/create', 'PageController@create')->name('createPage');
	Route::post('/pages/create','PageController@store')->name('storePage');
	Route::get('/pages/edit/{id}','PageController@edit')->name('editPage');
	Route::post('/pages/update/{id}','PageController@update')->name('updatePage');
	Route::get('/pages/updateStatus/{id}/{status}','PageController@updateStatus')->name('updateStatusPage');
	Route::get('/pages/delete/{id}','PageController@delete')->name('deletePage');
	//end of pages

	//add aboutus
	Route::get('/aboutus','AboutUsController@index')->name('AllAboutUs');
	Route::get('/aboutus/edit/{id}','AboutUsController@edit')->name('editAboutUs');
	Route::post('/aboutus/update/{id}','AboutUsController@update')->name('updateAboutUs');
	//end of aboutus

	//add portfolios
	Route::get('/portfolios','PortfolioController@index')->name('AllPortfolio');
	Route::get('/portfolios/create', 'PortfolioController@create')->name('createPortfolio');
	Route::post('/portfolios/create','PortfolioController@store')->name('storePortfolio');
	Route::get('/portfolios/edit/{id}','PortfolioController@edit')->name('editPortfolio');
	Route::post('/portfolios/update/{id}','PortfolioController@update')->name('updatePortfolio');
	Route::get('/portfolios/updateStatus/{id}/{status}','PortfolioController@updateStatus')->name('updateStatusPortfolio');
	Route::get('/portfolios/delete/{id}','PortfolioController@delete')->name('deletePortfolio');
	//end of portfolios

	//add blogs
	Route::get('/blogs','BlogController@index')->name('AllBlog');
	Route::get('/blogs/create', 'BlogController@create')->name('createBlog');
	Route::post('/blogs/create','BlogController@store')->name('storeBlog');
	Route::get('/blogs/edit/{id}','BlogController@edit')->name('editBlog');
	Route::post('/blogs/update/{id}','BlogController@update')->name('updateBlog');
	Route::get('/blogs/updateStatus/{id}/{status}','BlogController@updateStatus')->name('updateStatusBlog');
	Route::get('/blogs/delete/{id}','BlogController@delete')->name('deleteBlog');
	Route::get('/blogs/imgremove/{id}','BlogController@imgremove')->name('imgremoveBlog');
	//end of blogs










	//add workshop
	  Route::get('/workshops/create', 'WorkshopController@create')->name('createWorkshopRoute');
	  Route::get('/workshops','WorkshopController@index')->name('AllWorkshops');
	  Route::get('/workshops/edit/{id}','WorkshopController@edit')->name('workshopEdit');
	  Route::get('/workshops/show/{id}','WorkshopController@show')->name('workshopShow');
	  Route::post('/workshops/update/{id}','WorkshopController@update')->name('workshopUpadate');
	  Route::post('/workshops/create','WorkshopController@store')->name('workshopStore');
	//end of workshop
	//add course request
	  Route::get('/ecourserequest', 'CourseRequestController@create')->name('ecourseRequestRoute');
	  Route::post('/ecourserequest','CourseRequestController@store')->name('ecourseRequestRouteCreate');

	//end of workshop

	//instructor Dashboard
		Route::get('/instructor/dashboard', 'CourseRequestController@instructorDashboard')->name('insDash');
		Route::get('/instructor/report', 'CourseRequestController@instructorReport')->name('instructorReport');
		Route::get('/instructor/helpDesk', 'HelpDeskController@index')->name('insHelpDash');
		Route::get('/instructor/helpDesk/create', 'HelpDeskController@create')->name('insHelpCreate');
		Route::post('/instructor/helpDesk/create', 'HelpDeskController@store')->name('insHelpStore');
		Route::post('/reactive_request/{id}','CourseRequestController@ecourseRequestReactive')->name('ecourseRequestReactive');
		Route::post('/instructor/edit_request/{id}', 'CourseRequestController@course_edit_instructor')->name('editRequestByInstructor');
	//end instructor dashboard
	//course builder Dashboard
		Route::get('/course_builder/dashboard', 'CourseRequestController@course_builderDashboard')->name('course_builderDashboard');
		Route::post('/course_builder/assigto/{id}', 'CourseRequestController@course_builderAssignTo')->name('course_builderAssignTo');
		Route::post('/course_builder/assigto', 'CourseRequestController@course_builderCourseActivate')->name('course_builderCourseActivate');
		Route::get('/course_builder/report', 'CourseRequestController@course_builderReport')->name('course_builderReport');
	//course builder  dashboard
	//director stuff
	Route::get('/director/dashboard', 'CourseRequestController@directorDashboard')->name('directorDashboard');
	Route::get('/director/report', 'CourseRequestController@directorReport')->name('directorReport');
	Route::post('/director/request/view/{id}', 'CourseRequestController@viewCourseDirector')->name('viewCourseDirector');
	////end off director stuff

	//other stuff
	Route::get('/profile','AdminController@viewProfile');
	Route::post('/profile/edit','AdminController@updateProfile')->name('updateProfile');


	//year semester
	Route::get('/courses/years','YearController@index')->name('courseYear');
	Route::post('/courses/years/edit/{id}','YearController@editYear')->name('yearEdit');
	Route::post('/courses/years/update/{id}','YearController@updateYear')->name('yearUpdate');
	Route::post('/courses/semester/add','YearController@addSemester')->name('semesterAdd');
	Route::post('/courses/semester/edit/{id}','YearController@editSemester')->name('semesterEdit');
	Route::post('/courses/semester/update/{id}','YearController@updateSemester')->name('semesterUpdate');
	Route::post('/courses/semester/{id}','YearController@deleteSemester')->name('semeterDelete');
	Route::post('/courses/year/add','YearController@addYear')->name('yearAdd');
	Route::post('/courses/year/{id}','YearController@deleteYear')->name('yearDelete');
});

Route::get('/test','CoursesController@test');

//front static page route
Route::get('{slug_url}', 'Front\FrontController@staticPage')->name('staticPage');
