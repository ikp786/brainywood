@extends('layouts.app')

@section('content')
    <style type="text/css">
        .dashboard-bx-pm{
            border-radius: 10px;
            margin-bottom: 10px;
            padding: 20px;
        }
    </style>

    {{--section for instructor--}}
    @can('users_manage')
        <!-- @include('admin.admin') -->
    @endcan
    {{--end section for instructor--}}


    {{--section for instructor--}}
    @can('instructor')
        <!-- @include('instructor.instructor') -->
    @endcan
    {{--end section for instructor--}}

    @can('dashboard')
    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_dashboard')
        </div>
        <div class="panel-body">
            <div class="row text-center">
                @can('users_manage')
                <div class="col-md-3">
                    <a href="{{route('admin.teachers')}}">
                        <div class="bg-info dashboard-bx-pm">
                            <h2><i class="fa fa-users"></i> {{$totalTeachers}}</h2>
                            <span>Teachers</span>
                        </div>
                    </a>
                </div>
                @endcan
                @can('users_manage')
                <div class="col-md-3">
                    <a href="{{route('admin.students')}}">
                        <div class="bg-primary dashboard-bx-pm">
                            <h2><i class="fa fa-users"></i> {{$totalStudents}}</h2>
                            <span>Students</span>
                        </div>
                    </a>
                </div>
                @endcan
                @can('course')
                <div class="col-md-3">
                    <a href="{{route('admin.AllCourses')}}">
                        <div class="bg-success dashboard-bx-pm">
                            <h2><i class="fa fa-list"></i> {{$totalCourses}}</h2>
                            <span>Courses</span>
                        </div>
                    </a>
                </div>
                @endcan
                @can('lession')
                <div class="col-md-3">
                    <a href="{{route('admin.AllLessions')}}">
                        <div class="bg-warning dashboard-bx-pm">
                            <h2><i class="fa fa-list"></i> {{$totalLessions}}</h2>
                            <span>Lessions</span>
                        </div>
                    </a>
                </div>
                @endcan
                @can('quiz')
                <div class="col-md-3">
                    <a href="{{route('admin.AllQuizs')}}">
                        <div class="bg-danger dashboard-bx-pm">
                            <h2><i class="fa fa-quora"></i> {{$totalQuizes}}</h2>
                            <span>Quizes</span>
                        </div>
                    </a>
                </div>
                @endcan
                @can('liveclasses')
                <div class="col-md-3">
                    <a href="{{route('admin.AllLiveclasses')}}">
                        <div class="bg-info dashboard-bx-pm">
                            <h2><i class="fa fa-video-camera"></i> {{$totalLiveClasses}}</h2>
                            <span>Live Classes</span>
                        </div>
                    </a>
                </div>
                @endcan
                @can('popular_video')
                <div class="col-md-3">
                    <a href="{{route('admin.AllPopularVideo')}}">
                        <div class="bg-primary dashboard-bx-pm">
                            <h2><i class="fa fa-video-camera"></i> {{$totalPopularvideos}}</h2>
                            <span>Popular Videos</span>
                        </div>
                    </a>
                </div>
                @endcan
                @can('question_answer')
                <div class="col-md-3">
                    <a href="{{route('admin.AllQuestionAnswer')}}">
                        <div class="bg-success dashboard-bx-pm">
                            <h2><i class="fa fa-quora"></i> {{$totalQuestionAsks}}</h2>
                            <span>Q & A</span>
                        </div>
                    </a>
                </div>
                @endcan
                @can('contact_us')
                <div class="col-md-3">
                    <a href="{{route('admin.AllContactus')}}">
                        <div class="bg-warning dashboard-bx-pm">
                            <h2><i class="fa fa-envelope-open-o"></i> {{$totalContactus}}</h2>
                            <span>Contact Us</span>
                        </div>
                    </a>
                </div>
                @endcan
                @can('user_subscription')
                <div class="col-md-3">
                    <a href="{{route('admin.AllUserSubscription')}}">
                        <div class="bg-danger dashboard-bx-pm">
                            <h2><i class="fa fa-money"></i> {{$totalUserSubscriptions}}</h2>
                            <span>User Subscriptions</span>
                        </div>
                    </a>
                </div>
                @endcan

            </div>
        </div>
    </div>
    @endcan

@endsection
