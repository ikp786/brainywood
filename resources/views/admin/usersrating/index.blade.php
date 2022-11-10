@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')
@section('javascript')
    <script>
        jQuery(document).ready(function($) {
            var dt = $('#courses').DataTable();
            var export_filename = 'Filename-' + tools.date( '%d-%M-%Y' );
            new $.fn.dataTable.Buttons( dt, {
                buttons: [
                    {
                        text: '<i class="fa fa-lg fa-print"></i> Print Assets',
                        extend: 'print',
                        className: 'btn btn-primary btn-sm m-5 width-140 assets-select-btn export-print'
                    }
                ]
            } );

            // Add the Print button to the toolbox
            dt.buttons( 1, null ).container().appendTo( '#anrbtn' );
        } );
    </script>
@endsection

@section('content')

    {{--section for instructor--}}
    @can('user_rating')

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">All Users Rating</div>
                    <div class="panel-body">
                        @if(Session::has('msg'))
                            <div class="alert alert-info">
                                <a class="close" data-dismiss="alert">×</a>
                                <strong>{!!Session::get('msg')!!}</strong>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form name="filterfrm" action="{{route('admin.AllUserRating')}}" method="GET">
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <select name="user" class="form-control select2">
                                        <option value="">-select user-</option>
                                        @if($users)
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}" @if($request->query('user')==$user->id)selected @endif>{{$user->name.' - '.$user->phone}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <select name="course" id="courseId" class="form-control select2">
                                        <option value="">-select course-</option>
                                        @if($courses)
                                        @foreach($courses as $course)
                                        <option value="{{$course->id}}" @if($request->query('course')==$course->id)selected @endif>{{$course->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <select name="lession" id="lessionId" class="form-control select2">
                                        <option value="">-select lession-</option>
                                        @if($lessions)
                                        @foreach($lessions as $lession)
                                        <option value="{{$lession->id}}" @if($request->query('lession')==$lession->id)selected @endif>{{$lession->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <select name="topic" id="topicId" class="form-control select2">
                                        <option value="">-select topic-</option>
                                        @if($topics)
                                        @foreach($topics as $topic)
                                        <option value="{{$topic->id}}" @if($request->query('topic')==$topic->id)selected @endif>{{$topic->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <select name="type" class="form-control select2">
                                        <option value="">-select type-</option>
                                        <option value="Sad" @if($request->query('type')=='Sad')selected @endif>Sad</option>
                                        <option value="Sceptic" @if($request->query('type')=='Sceptic')selected @endif>Sceptic</option>
                                        <option value="Happy" @if($request->query('type')=='Happy')selected @endif>Happy</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <input type="date" name="from" class="form-control" value="@if($request->query('from')){{$request->query('from')}}@endif">
                                </div>
                                <div class="form-group col-md-2">
                                    <input type="date" name="to" class="form-control" value="@if($request->query('to')){{$request->query('to')}}@endif">
                                </div>
                                <div class="form-group col-md-2">
                                    <a href="{{route('admin.AllUserRating')}}" class="btn btn-warning">RESET</a>
                                    <button class="btn btn-info">GET</button>
                                </div>
                            </div>
                        </form>

                        <div class="box-default text-right">
                            <!-- <a class="btn btn-bitbucket float-right" href="{{route('admin.createCoupon')}}">Add New</a> -->
                        </div>
                        <p></p>
                        <table class="table table-bordered table-striped dt-select {{ count($data) > 0 ? 'datatable' : '' }}" id="courses">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>Course</th>
                                    <th>Lession</th>
                                    <th>Topic</th>
                                    <th>Rating Type</th>
                                    <th>Rating Message</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; ?>
                            @foreach($data as $val)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>@if($val->userId>0){{$val->user->name.' - '.$val->user->phone}}@endif</td>
                                    <td>@if($val->courseId>0){{$val->course->name}}@endif</td>
                                    <td>@if($val->lessionId>0){{$val->lession->name}}@endif</td>
                                    <td>@if($val->topicId>0){{$val->topic->name}}@endif</td>
                                    <td>{{$val->ratingType}}</td>
                                    <td>{{$val->ratingMessage}}</td>
                                    <td>
                                        <?php if($val->status==1) { ?><a href="<?php echo url('admin/usersratings/updateStatus') ?>/<?php echo $val->id; ?>/0" class="label label-success">Viewed</a> <?php } else { ?><a href="<?php echo url('admin/usersratings/updateStatus') ?>/<?php echo $val->id; ?>/1" class="label label-danger">Not Viewed</a> <?php } ?>
                                    </td>
                                    <td>
                                        <a href="{{route('admin.showUserRating',['id'=> $val->id])}}">View</a>
                                        <!-- <a href="{{route('admin.editUserRating',['id'=> $val->id])}}">Edit</a>
                                        <a href="{{route('admin.deleteUserRating',['id'=> $val->id])}}">Delete</a> -->
                                    </td>
                                </tr>
                                  <?php $i++; ?>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endcan
    {{--end section for instructor--}}

@endsection
