@inject('request', 'Illuminate\Http\Request')
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<ul class="sidebar-menu">

			@can('instructor')
			<li class="{{ $request->segment(1) == 'instructor' ? 'active' : '' }}">
				<a href="{{ url('/admin/instructor/dashboard') }}">
					<i class="fa fa-wrench"></i>
					<span class="title">@lang('global.app_dashboard')</span>
				</a>
			</li>
			<li class="{{ $request->segment(2) == 'report' ? 'active' : '' }}">
				<a href="{{ url('/admin/instructor/report') }}">
					<i class="fa fa-bar-chart"></i>
					<span class="title">Report</span>
				</a>
			</li>
			<li class="{{ $request->segment(2) == 'report' ? 'active' : '' }}">
				<a href="{{ route('admin.insHelpDash') }}">
					<i class="fa fa-question"></i>
					<span class="title">Help Desk</span>
				</a>
			</li>

			@elsecan('director')
			<li class="{{ $request->segment(2) == 'dashboard' ? 'active' : '' }}">
				<a href="{{ url('/admin/director/dashboard') }}">
					<i class="fa fa-wrench"></i>
					<span class="title">@lang('global.app_dashboard')</span>
				</a>
			</li>
			<li class="{{ $request->segment(2) == 'report' ? 'active' : '' }}">
				<a href="{{ url('/admin/director/report') }}">
					<i class="fa fa-bar-chart"></i>
					<span class="title">Report</span>
				</a>
			</li>
			@elsecan('course_builder')
			<li class="{{ $request->segment(1) == 'home' ? 'active' : '' }}">
				<a href="{{ url('/admin/course_builder/dashboard') }}">
					<i class="fa fa-wrench"></i>
					<span class="title">@lang('global.app_dashboard')</span>
				</a>
			</li>
			<li class="{{ $request->segment(1) == 'home' ? 'active' : '' }}">
				<a href="{{ url('/admin/course_builder/report') }}">
					<i class="fa fa-bar-chart"></i>
					<span class="title">Report</span>
				</a>
			</li>
			@endcan



			
			@can('dashboard')
			<li class="{{ $request->segment(1) == 'home' ? 'active' : '' }}">
				<a href="{{ url('/admin/home') }}">
					<i class="fa fa-wrench"></i>
					<span class="title">@lang('global.app_dashboard')</span>
				</a>
			</li>
    		@endcan
			
			@can('users_manage')
			<li class="treeview">
				<a href="#">
					<i class="fa fa-users"></i>
					<span class="title">@lang('global.user-management.title')</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					@can('Permission')
					<li class="{{ $request->segment(2) == 'permissions' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.permissions.index') }}">
							<i class="fa fa-briefcase"></i>
							<span class="title">
								@lang('global.permissions.title')
							</span>
						</a>
					</li>
					@endcan

					@can('role')
					<li class="{{ $request->segment(2) == 'roles' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.roles.index') }}">
							<i class="fa fa-briefcase"></i>
							<span class="title">
								@lang('global.roles.title')
							</span>
						</a>
					</li>
					@endcan
					<li class="{{ $request->segment(2) == 'users' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.users.index') }}">
							<i class="fa fa-user"></i>
							<span class="title">
								Administrator @lang('global.users.title')
							</span>
						</a>
					</li>
					<li class="{{ $request->segment(2) == 'teachers' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.teachers') }}">
							<i class="fa fa-user"></i>
							<span class="title">
								Teacher @lang('global.users.title')
							</span>
						</a>
					</li>
					<li class="{{ $request->segment(2) == 'students' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.students') }}">
							<i class="fa fa-user"></i>
							<span class="title">
								Student @lang('global.users.title')
							</span>
						</a>
					</li>
					<li class="{{ $request->segment(2) == 'deleted-users' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.deletedUsers') }}">
							<i class="fa fa-user"></i>
							<span class="title">
								Deleted @lang('global.users.title')
							</span>
						</a>
					</li>
				</ul>
			</li>
			@endcan


			@can('course')
			<li class="treeview">
				<a href="#">
					<i class="fa fa-graduation-cap"></i>
					<span class="title">@lang('global.course-management.title')</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="{{ $request->segment(2).$request->segment(3) == 'coursescreate' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.createCourseRoute') }}">
							<i class="fa fa-plus"></i>
							<span class="title">
								@lang('global.course-management-create.title')
							</span>
						</a>
					</li>
					<li class="{{ $request->segment(2).$request->segment(3) == 'courses' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.AllCourses') }}">
							<i class="fa fa-graduation-cap"></i>
							<span class="title">
								@lang('global.course-management.title')
							</span>
						</a>
					</li>
					<li class="{{ $request->segment(2).$request->segment(3) == 'coursesconvertVideo' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.convertVideoCourses') }}">
							<i class="fa fa-graduation-cap"></i>
							<span class="title">
								@lang('global.course-management.title') Convert Video
							</span>
						</a>
					</li>
				</ul>
			</li>
			@endcan

			@can('lession')
			<li class="treeview">
				<a href="#">
					<i class="fa fa-graduation-cap"></i>
					<span class="title">Lessions</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="{{ $request->segment(2).$request->segment(3) == 'lessioncreate' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.createLessionRoute') }}">
							<i class="fa fa-plus"></i>
							<span class="title">
								Add Lession
							</span>
						</a>
					</li>
					<li class="{{ $request->segment(2).$request->segment(3) == 'lession' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.AllLessions') }}">
							<i class="fa fa-graduation-cap"></i>
							<span class="title">
								Lessions
							</span>
						</a>
					</li>
					<li class="{{ $request->segment(2).$request->segment(3) == 'lessionconvertVideo' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.convertVideoLessions') }}">
							<i class="fa fa-graduation-cap"></i>
							<span class="title">
								Lessions Convert Video
							</span>
						</a>
					</li>
				</ul>
			</li>
			@endcan
			
			@can('topic')
			<li class="treeview">
				<a href="#">
					<i class="fa fa-graduation-cap"></i>
					<span class="title">Topics</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="{{ $request->segment(2).$request->segment(3) == 'lession-chaptercreate' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.createLessionChapter') }}">
							<i class="fa fa-plus"></i>
							<span class="title">
								Add Topic
							</span>
						</a>
					</li>
					<li class="{{ $request->segment(2).$request->segment(3) == 'lession-chapter' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.AllLessionChapters') }}">
							<i class="fa fa-graduation-cap"></i>
							<span class="title">
								Topics
							</span>
						</a>
					</li>
					<li class="{{ $request->segment(2).$request->segment(3) == 'lession-chapterconvertVideo' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.convertVideoLessionChapters') }}">
							<i class="fa fa-graduation-cap"></i>
							<span class="title">
								Topics Convert Video
							</span>
						</a>
					</li>
				</ul>
			</li>
			@endcan
			
			@can('assignment')
			<li class="treeview">
				<a href="#">
					<i class="fa fa-graduation-cap"></i>
					<span class="title">Assignments</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="{{ $request->segment(2).$request->segment(3) == 'assignmentscreate' ? 'active active-sub' : '' }}">
						<a href="#">
							<i class="fa fa-plus"></i>
							<span class="title">
								Add Assignment
							</span>
						</a>
					</li>
					<li class="{{ $request->segment(2).$request->segment(3) == 'assignments' ? 'active active-sub' : '' }}">
						<a href="#">
							<i class="fa fa-graduation-cap"></i>
							<span class="title">
								Assignments
							</span>
						</a>
					</li>
				</ul>
			</li>
			@endcan
			
			@can('quiz')
			<li class="treeview">
				<a href="#">
					<i class="fa fa-graduation-cap"></i>
					<span class="title">Quizes</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="{{ $request->segment(2).$request->segment(3) == 'quizscreate' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.createQuizRoute') }}">
							<i class="fa fa-plus"></i>
							<span class="title">
								Add Quiz
							</span>
						</a>
					</li>
					<li class="{{ $request->segment(2).$request->segment(3) == 'quizs' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.AllQuizs') }}">
							<i class="fa fa-graduation-cap"></i>
							<span class="title">
								Quizes
							</span>
						</a>
					</li>
				</ul>
			</li>
			@endcan
			
			@can('liveclasses')
			<li class="treeview">
				<a href="#">
					<i class="fa fa-graduation-cap"></i>
					<span class="title">Live Classes</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="{{ $request->segment(2).$request->segment(3) == 'liveclassescreate' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.createLiveclass') }}">
							<i class="fa fa-plus"></i>
							<span class="title">
								Add Live Class
							</span>
						</a>
					</li>
					<li class="{{ $request->segment(2).$request->segment(3) == 'liveclasses' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.AllLiveclasses') }}">
							<i class="fa fa-graduation-cap"></i>
							<span class="title">
								Live Classes
							</span>
						</a>
					</li>
					<li class="{{ $request->segment(2).$request->segment(3) == 'liveclassesconvertVideo' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.convertVideoLiveclasses') }}">
							<i class="fa fa-graduation-cap"></i>
							<span class="title">
								Live Classes Convert Video
							</span>
						</a>
					</li>
					<li class="{{ $request->segment(2).$request->segment(3) == 'liveclassesnotify' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.NotifyLiveclasses') }}">
							<i class="fa fa-graduation-cap"></i>
							<span class="title">
								Live Classes Notify Requests
							</span>
						</a>
					</li>
				</ul>
			</li>
			@endcan
			
			@can('popular_video')
			<li class="treeview">
				<a href="#">
					<i class="fa fa-graduation-cap"></i>
					<span class="title">Popular Videos</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="{{ $request->segment(2).$request->segment(3) == 'popularvideoscreate' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.createPopularVideo') }}">
							<i class="fa fa-plus"></i>
							<span class="title">
								Add Popular Video
							</span>
						</a>
					</li>
					<li class="{{ $request->segment(2).$request->segment(3) == 'popularvideos' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.AllPopularVideo') }}">
							<i class="fa fa-graduation-cap"></i>
							<span class="title">
								Popular Videos
							</span>
						</a>
					</li>
					<li class="{{ $request->segment(2).$request->segment(3) == 'popularvideosconvertVideo' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.convertVideoPopularVideo') }}">
							<i class="fa fa-graduation-cap"></i>
							<span class="title">
								Popular Videos Convert Video
							</span>
						</a>
					</li>
				</ul>
			</li>
			@endcan
			
			@can('concept_video')
			<li class="treeview">
				<a href="#">
					<i class="fa fa-graduation-cap"></i>
					<span class="title">Concept Videos</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="{{ $request->segment(2).$request->segment(3) == 'conceptvideoscreate' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.createConceptVideo') }}">
							<i class="fa fa-plus"></i>
							<span class="title">
								Add Concept Video
							</span>
						</a>
					</li>
					<li class="{{ $request->segment(2).$request->segment(3) == 'conceptvideos' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.AllConceptVideo') }}">
							<i class="fa fa-graduation-cap"></i>
							<span class="title">
								Concept Videos
							</span>
						</a>
					</li>
					<!-- <li class="{{ $request->segment(2).$request->segment(3) == 'conceptvideosconvertVideo' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.convertVideoConceptVideo') }}">
							<i class="fa fa-graduation-cap"></i>
							<span class="title">
								Concept Videos Convert Video
							</span>
						</a>
					</li> -->
				</ul>
			</li>
			@endcan
			
			@can('question_answer')
			<li class="{{ $request->segment(2).$request->segment(3) == 'questionanswers' ? 'active active-sub' : '' }}">
				<a href="{{ route('admin.AllQuestionAnswer') }}">
					<i class="fa fa-graduation-cap"></i>
					<span class="title">
						Q & A
					</span>
				</a>
			</li>
			@endcan
			
			@can('user_rating')
			<li class="{{ $request->segment(2).$request->segment(3) == 'usersratings' ? 'active active-sub' : '' }}">
				<a href="{{ route('admin.AllUserRating') }}">
					<i class="fa fa-graduation-cap"></i>
					<span class="title">
						Users Ratings
					</span>
				</a>
			</li>
			@endcan

			@can('enquiry_lead')
			<li class="{{ $request->segment(2).$request->segment(3) == 'enquiries' ? 'active active-sub' : '' }}">
				<a href="{{ route('admin.AllEnquiry') }}">
					<i class="fa fa-graduation-cap"></i>
					<span class="title">
						Enquiries
					</span>
				</a>
			</li>
			@endcan

			@can('contact_us')
			<li class="{{ $request->segment(1) == 'contactus' ? 'active' : '' }}">
				<a href="{{ route('admin.AllContactus') }}">
					<i class="fa fa-graduation-cap"></i>
					<span class="title">Contact Us</span>
				</a>
			</li>
			@endcan
			
			@can('coupon_code')
			<li class="treeview">
				<a href="#">
					<i class="fa fa-graduation-cap"></i>
					<span class="title">Coupon Codes</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="{{ $request->segment(2).$request->segment(3) == 'couponcodescreate' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.createCoupon') }}">
							<i class="fa fa-plus"></i>
							<span class="title">
								Add Coupon Code
							</span>
						</a>
					</li>
					<li class="{{ $request->segment(2).$request->segment(3) == 'couponcodes' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.AllCoupon') }}">
							<i class="fa fa-graduation-cap"></i>
							<span class="title">
								Coupon Codes
							</span>
						</a>
					</li>
				</ul>
			</li>
			@endcan

			@can('user_subscription')
			<li class="{{ $request->segment(2).$request->segment(3) == 'usersubscriptions' ? 'active' : '' }}">
				<a href="{{ route('admin.AllUserSubscription') }}">
					<i class="fa fa-graduation-cap"></i>
					<span class="title">User Subscriptions</span>
				</a>
			</li>
			@endcan
			
			@can('subscription')
			<li class="treeview">
				<a href="#">
					<i class="fa fa-graduation-cap"></i>
					<span class="title">Subscription Plans</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="{{ $request->segment(2).$request->segment(3) == 'subscriptionscreate' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.createSubscription') }}">
							<i class="fa fa-plus"></i>
							<span class="title">
								Add Subscription Plan
							</span>
						</a>
					</li>
					<li class="{{ $request->segment(2).$request->segment(3) == 'subscriptions' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.AllSubscription') }}">
							<i class="fa fa-graduation-cap"></i>
							<span class="title">
								Subscription Plans
							</span>
						</a>
					</li>
				</ul>
			</li>
			@endcan
			
			@can('notification')
			<li class="treeview">
				<a href="#">
					<i class="fa fa-graduation-cap"></i>
					<span class="title">Notifications</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="{{ $request->segment(2).$request->segment(3) == 'notificationscreate' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.createNotification') }}">
							<i class="fa fa-plus"></i>
							<span class="title">
								Add Notification
							</span>
						</a>
					</li>
					<li class="{{ $request->segment(2).$request->segment(3) == 'notifications' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.AllNotification') }}">
							<i class="fa fa-graduation-cap"></i>
							<span class="title">
								Notifications
							</span>
						</a>
					</li>
				</ul>
			</li>
			@endcan
			
			@can('page')
			<li class="treeview">
				<a href="#">
					<i class="fa fa-graduation-cap"></i>
					<span class="title">Pages</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="{{ $request->segment(2).$request->segment(3) == 'pagescreate' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.createPage') }}">
							<i class="fa fa-plus"></i>
							<span class="title">
								Add Page
							</span>
						</a>
					</li>
					<li class="{{ $request->segment(2).$request->segment(3) == 'pages' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.AllPage') }}">
							<i class="fa fa-graduation-cap"></i>
							<span class="title">
								Pages
							</span>
						</a>
					</li>
				</ul>
			</li>
			@endcan
			
			@can('page')
			<li class="{{ $request->segment(1) == 'aboutus' ? 'active' : '' }}">
				<a href="{{ route('admin.AllAboutUs') }}">
					<i class="fa fa-graduation-cap"></i>
					<span class="title">About Us</span>
				</a>
			</li>
			@endcan
			
			@can('page')
			<li class="treeview">
				<a href="#">
					<i class="fa fa-graduation-cap"></i>
					<span class="title">Portfolios</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="{{ $request->segment(2).$request->segment(3) == 'portfolioscreate' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.createPortfolio') }}">
							<i class="fa fa-plus"></i>
							<span class="title">
								Add Portfolio
							</span>
						</a>
					</li>
					<li class="{{ $request->segment(2).$request->segment(3) == 'portfolios' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.AllPortfolio') }}">
							<i class="fa fa-graduation-cap"></i>
							<span class="title">
								Portfolios
							</span>
						</a>
					</li>
				</ul>
			</li>
			@endcan
			
			@can('blog')
			<!-- <li class="treeview">
				<a href="#">
					<i class="fa fa-graduation-cap"></i>
					<span class="title">Blogs</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="{{ $request->segment(2).$request->segment(3) == 'blogscreate' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.createBlog') }}">
							<i class="fa fa-plus"></i>
							<span class="title">
								Add Blog
							</span>
						</a>
					</li>
					<li class="{{ $request->segment(2).$request->segment(3) == 'blogs' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.AllBlog') }}">
							<i class="fa fa-graduation-cap"></i>
							<span class="title">
								Blogs
							</span>
						</a>
					</li>
				</ul>
			</li> -->
			@endcan
			
			@can('testimonial')
			<li class="treeview">
				<a href="#">
					<i class="fa fa-graduation-cap"></i>
					<span class="title">Testimonials</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="{{ $request->segment(2).$request->segment(3) == 'testimonialscreate' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.createTestimonial') }}">
							<i class="fa fa-plus"></i>
							<span class="title">
								Add Testimonial
							</span>
						</a>
					</li>
					<li class="{{ $request->segment(2).$request->segment(3) == 'testimonials' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.AllTestimonial') }}">
							<i class="fa fa-graduation-cap"></i>
							<span class="title">
								Testimonials
							</span>
						</a>
					</li>
				</ul>
			</li>
			@endcan
			
			@can('team_member')
			<li class="treeview">
				<a href="#">
					<i class="fa fa-graduation-cap"></i>
					<span class="title">Team Members</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="{{ $request->segment(2).$request->segment(3) == 'teamscreate' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.createTeam') }}">
							<i class="fa fa-plus"></i>
							<span class="title">
								Add Team Member
							</span>
						</a>
					</li>
					<li class="{{ $request->segment(2).$request->segment(3) == 'teams' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.AllTeam') }}">
							<i class="fa fa-graduation-cap"></i>
							<span class="title">
								Team Members
							</span>
						</a>
					</li>
				</ul>
			</li>
			@endcan
			
			@can('student_class')
			<li class="treeview">
				<a href="#">
					<i class="fa fa-graduation-cap"></i>
					<span class="title">Student Classes</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="{{ $request->segment(2).$request->segment(3) == 'classescreate' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.createStudentClass') }}">
							<i class="fa fa-plus"></i>
							<span class="title">
								Add Student Class
							</span>
						</a>
					</li>
					<li class="{{ $request->segment(2).$request->segment(3) == 'classes' ? 'active active-sub' : '' }}">
						<a href="{{ route('admin.AllStudentClass') }}">
							<i class="fa fa-graduation-cap"></i>
							<span class="title">
								Student Classes
							</span>
						</a>
					</li>
				</ul>
			</li>
			@endcan

			<li class="{{ $request->segment(1) == 'change_password' ? 'active' : '' }}">
				<a href="{{ route('auth.change_password') }}">
					<i class="fa fa-key"></i>
					<span class="title">Change password</span>
				</a>
			</li>

			<li>
				<a href="{{url('/admin/profile')}}">
					<i class="fa fa-user"></i>
					<span class="title">View Profile</span>
				</a>
			</li>
			<li>
				<a href="#logout" onclick="$('#logout').submit();">
					<i class="fa fa-arrow-left"></i>
					<span class="title">@lang('global.app_logout')</span>
				</a>
			</li>

		</ul>
	</section>
</aside>
{!! Form::open(['route' => 'auth.logout', 'style' => 'display:none;', 'id' => 'logout']) !!}
<button type="submit">@lang('global.logout')</button>
{!! Form::close() !!}
